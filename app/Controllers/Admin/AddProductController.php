<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\ProductCategoriesModel;
use App\Models\ProductImagesModel;

class AddProductController extends SessionController
{
    private $uploadPath;
    private $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private $allowedDocTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'];
    
    public function __construct()
    {
        // Initialize without parent constructor to avoid errors
        $this->uploadPath = FCPATH . 'uploads/products/';
        
        // Create upload directories if they don't exist
        $directories = ['main', 'documents', 'additional'];
        
        foreach ($directories as $dir) {
            $path = $this->uploadPath . $dir . '/';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
        }
    }
    
    public function index()
    {
        $categoriesModel = new CategoriesModel();
        $categories = $categoriesModel->findAll();

        $data = [
            'title' => 'Contrel | Add Product',
            'currentpage' => 'addproduct',
            'categories' => $categories
        ];

        return view('pages/admin/addproduct', $data);
    }

    public function insert()
    {
        try {
            // Validate required fields
            $validationRules = [
                'productname' => 'required|min_length[2]|max_length[255]',
                'order_code' => 'required',
                'description' => 'required',
                'backgroundimage' => 'uploaded[backgroundimage]|max_size[backgroundimage,5120]|mime_in[backgroundimage,' . implode(',', $this->allowedImageTypes) . ']|ext_in[backgroundimage,jpg,jpeg,png,gif,webp]'
            ];
            
            if (!$this->validate($validationRules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => implode('<br>', $this->validator->getErrors())
                ]);
            }
            
            // Check if order code already exists
            $productsModel = new ProductsModel();
            $existingProduct = $productsModel->where('order_code', $this->request->getPost('order_code'))->first();
            if ($existingProduct) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Order code already exists. Please use a different order code.'
                ]);
            }
            
            // Handle file uploads
            $uploadedFiles = $this->handleFileUploads();
            if (!$uploadedFiles['success']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $uploadedFiles['message']
                ]);
            }

        // Generate unique slug
        $slug = $this->generateSlug($this->request->getPost('productname'));
        
            // Prepare product data according to your model
            $productData = [
                'product_name' => $this->request->getPost('productname'),
                'slug' => $slug,
                'order_code' => $this->request->getPost('order_code'),
                'short_description' => $this->request->getPost('short_description'),
                'description' => $this->request->getPost('description'),
                'weight_kg' => $this->request->getPost('weight') ? floatval($this->request->getPost('weight')) : null,
                'qty_per_package' => $this->request->getPost('qty_per_package') ? intval($this->request->getPost('qty_per_package')) : 1,
                'package_length_mm' => $this->request->getPost('package_length') ? intval($this->request->getPost('package_length')) : null,
                'package_width_mm' => $this->request->getPost('package_width') ? intval($this->request->getPost('package_width')) : null,
                'package_height_mm' => $this->request->getPost('package_height') ? intval($this->request->getPost('package_height')) : null,
                'volume_cm3' => $this->request->getPost('volume_cm3') ? floatval($this->request->getPost('volume_cm3')) : null,
                'barcode_ean13' => $this->request->getPost('barcode_ean13'),
                'hs_code' => $this->request->getPost('hs_code'),
                'publish_status' => $this->request->getPost('publishstatus') === 'Yes' ? 'Yes' : 'No',
                'product_status' => 'active',
                'stock_status' => 'in_stock'
            ];
            
            // Add uploaded file paths to product data
            if (isset($uploadedFiles['data']['backgroundimage'])) {
                $productData['main_image'] = $uploadedFiles['data']['backgroundimage'];
            }
            if (isset($uploadedFiles['data']['data_sheet'])) {
                $productData['data_sheet'] = $uploadedFiles['data']['data_sheet'];
            }
            if (isset($uploadedFiles['data']['wiring_diagram'])) {
                $productData['wiring_diagram'] = $uploadedFiles['data']['wiring_diagram'];
            }
            if (isset($uploadedFiles['data']['dimensions_image'])) {
                $productData['dimensions_image'] = $uploadedFiles['data']['dimensions_image'];
            }
            if (isset($uploadedFiles['data']['view_360_image'])) {
                $productData['view_360_image'] = $uploadedFiles['data']['view_360_image'];
            }
            
            // Insert product
            if ($productsModel->save($productData)) {
                $productId = $productsModel->insertID();
                
                // Handle categories
                $this->handleCategories($productId);
                
                // Handle additional images
                $this->handleAdditionalImages($productId, $uploadedFiles['additional_images']);
                
                // Generate dynamic routes after successful insert
                $this->dynamicRoutes();
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Product saved successfully',
                    'product_id' => $productId
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save product to database'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Product Insert Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error saving product: ' . $e->getMessage()
            ]);
        }
    }

    private function handleFileUploads()
    {
        $uploadedData = [
            'success' => true,
            'message' => '',
            'data' => [],
            'additional_images' => []
        ];
        
        // Handle main image (backgroundimage)
        $backgroundImage = $this->request->getFile('backgroundimage');
        if ($backgroundImage && $backgroundImage->isValid() && !$backgroundImage->hasMoved()) {
            if (in_array($backgroundImage->getMimeType(), $this->allowedImageTypes)) {
                $newName = $backgroundImage->getRandomName();
                $uploadPath = $this->uploadPath . 'main/';
                
                if ($backgroundImage->move($uploadPath, $newName)) {
                    $uploadedData['data']['backgroundimage'] = 'main/' . $newName;
                } else {
                    $uploadedData['success'] = false;
                    $uploadedData['message'] = 'Failed to upload main image';
                    return $uploadedData;
                }
            } else {
                $uploadedData['success'] = false;
                $uploadedData['message'] = 'Invalid image type for main image. Allowed types: JPEG, PNG, GIF, WEBP';
                return $uploadedData;
            }
        } else {
            $uploadedData['success'] = false;
            $uploadedData['message'] = 'Main product image is required and must be valid';
            return $uploadedData;
        }
        
        // Handle data sheet
        $dataSheet = $this->request->getFile('data_sheet');
        if ($dataSheet && $dataSheet->isValid() && !$dataSheet->hasMoved()) {
            if (in_array($dataSheet->getMimeType(), $this->allowedDocTypes)) {
                $newName = $dataSheet->getRandomName();
                $uploadPath = $this->uploadPath . 'documents/';
                if ($dataSheet->move($uploadPath, $newName)) {
                    $uploadedData['data']['data_sheet'] = 'documents/' . $newName;
                }
            }
        }
        
        // Handle wiring diagram
        $wiringDiagram = $this->request->getFile('wiring_diagram');
        if ($wiringDiagram && $wiringDiagram->isValid() && !$wiringDiagram->hasMoved()) {
            if (in_array($wiringDiagram->getMimeType(), $this->allowedDocTypes)) {
                $newName = $wiringDiagram->getRandomName();
                $uploadPath = $this->uploadPath . 'documents/';
                if ($wiringDiagram->move($uploadPath, $newName)) {
                    $uploadedData['data']['wiring_diagram'] = 'documents/' . $newName;
                }
            }
        }
        
        // Handle dimensions image
        $dimensionsImage = $this->request->getFile('dimensions_image');
        if ($dimensionsImage && $dimensionsImage->isValid() && !$dimensionsImage->hasMoved()) {
            if (in_array($dimensionsImage->getMimeType(), $this->allowedImageTypes)) {
                $newName = $dimensionsImage->getRandomName();
                $uploadPath = $this->uploadPath . 'main/';
                if ($dimensionsImage->move($uploadPath, $newName)) {
                    $uploadedData['data']['dimensions_image'] = 'main/' . $newName;
                }
            }
        }
        
        // Handle 360 view image
        $view360Image = $this->request->getFile('view_360_image');
        if ($view360Image && $view360Image->isValid() && !$view360Image->hasMoved()) {
            if (in_array($view360Image->getMimeType(), $this->allowedImageTypes)) {
                $newName = $view360Image->getRandomName();
                $uploadPath = $this->uploadPath . 'main/';
                if ($view360Image->move($uploadPath, $newName)) {
                    $uploadedData['data']['view_360_image'] = 'main/' . $newName;
                }
            }
        }
        
        // Handle additional images
        $additionalImages = $this->request->getFileMultiple('additional_images');
        if ($additionalImages) {
            foreach ($additionalImages as $image) {
                if ($image->isValid() && !$image->hasMoved()) {
                    if (in_array($image->getMimeType(), $this->allowedImageTypes)) {
                        $newName = $image->getRandomName();
                        $uploadPath = $this->uploadPath . 'additional/';
                        if ($image->move($uploadPath, $newName)) {
                            $uploadedData['additional_images'][] = [
                                'path' => 'additional/' . $newName,
                                'original_name' => $image->getClientName()
                            ];
                        }
                    }
                }
            }
        }
        
        return $uploadedData;
    }

    private function handleCategories($productId)
    {
        $categories = $this->request->getPost('categories');
        
        if ($categories && is_array($categories)) {
            $productCategoriesModel = new ProductCategoriesModel();
            
            // Remove any existing categories for this product first
            $productCategoriesModel->where('product_id', $productId)->delete();
            
            foreach ($categories as $categoryId) {
                // Validate category exists
                $categoriesModel = new CategoriesModel();
                $category = $categoriesModel->find($categoryId);
                
                if ($category) {
                    $productCategoriesModel->insert([
                        'product_id' => $productId,
                        'category_id' => $categoryId
                    ]);
                }
            }
        }
    }

    private function handleAdditionalImages($productId, $images)
    {
        if (!empty($images)) {
            $productImagesModel = new ProductImagesModel();
            
            $sortOrder = 1;
            foreach ($images as $index => $imageData) {
                $productImagesModel->insert([
                    'product_id' => $productId,
                    'image_path' => $imageData['path'],
                    'thumbnail_path' => $imageData['path'],
                    'sort_order' => $sortOrder++
                ]);
            }
        }
    }

    public function getCategories()
    {
        $categoriesModel = new CategoriesModel();
        $categories = $categoriesModel->findAll();

        return $this->response->setJSON(['success' => true, 'categories' => $categories]);
    }

    public function addCategory()
    {
        try {
            $categoryName = $this->request->getPost('category_name');
            
            if (empty($categoryName)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Category name is required'
                ]);
            }

            $categoriesModel = new CategoriesModel();
            
            // Check if category already exists
            $existingCategory = $categoriesModel->where('categoryname', $categoryName)->first();
            if ($existingCategory) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Category already exists'
                ]);
            }

            // Insert new category
            $data = [
                'categoryname' => $categoryName
            ];

            $categoriesModel->insert($data);
            $newCategoryId = $categoriesModel->insertID();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Category added successfully',
                'category' => [
                    'category_id' => $newCategoryId,
                    'categoryname' => $categoryName
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error adding category: ' . $e->getMessage()
            ]);
        }
    }
    
    public function deleteCategory($id)
    {
        try {
            $categoriesModel = new CategoriesModel();
            
            // Find the category by ID
            $category = $categoriesModel->find($id);
            
            if (!$category) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Category not found'
                ]);
            }
            
            // Check if category is used by any products
            $productCategoriesModel = new ProductCategoriesModel();
            $usedCount = $productCategoriesModel->where('category_id', $id)->countAllResults();
            
            if ($usedCount > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Cannot delete category. It is used by ' . $usedCount . ' product(s).'
                ]);
            }
            
            // Delete the category record
            $deleted = $categoriesModel->delete($id);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Category deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete the category'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error deleting category: ' . $e->getMessage()
            ]);
        }
    }
    
    private function generateSlug($text)
    {
        // Convert to lowercase and remove HTML tags
        $slug = strtolower(strip_tags($text));
        
        // Replace special characters
        $replacements = [
            ' ' => '-',
            '&' => 'and',
            '!' => '',
            ',' => '',
            '?' => '',
            ':' => '',
            ';' => '',
            '/' => '-',
            '&#039' => '',
            '&amp;' => 'and',
            "'" => '',
            '"' => '',
            '(' => '',
            ')' => '',
            '[' => '',
            ']' => '',
            '{' => '',
            '}' => ''
        ];
        
        $slug = str_replace(array_keys($replacements), array_values($replacements), $slug);
        
        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Remove any non-alphanumeric characters except hyphens
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
        
        // Trim hyphens from beginning and end
        $slug = trim($slug, '-');
        
        // Check for uniqueness
        $productsModel = new ProductsModel();
        $originalSlug = $slug;
        $counter = 1;
        
        while ($productsModel->where('slug', $slug)->first()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    private function dynamicRoutes() 
    {
        $model = new ProductsModel();
        $result = $model->findAll();
        $data = [];

        if (count($result)) {
            foreach ($result as $route) {
                if (!empty($route['slug'])) {
                    $data[$route['slug']] = 'ProductDetailsController::index/' . $route['product_id'];
                }
            }
        }

        $output = '<?php' . PHP_EOL . PHP_EOL;
        $output .= '// Auto-generated product routes' . PHP_EOL;
        $output .= '// Generated on: ' . date('Y-m-d H:i:s') . PHP_EOL . PHP_EOL;
        
        foreach ($data as $slug => $controllerMethod) {
            $output .= '$routes->get(\'' . $slug . '\', \'' . $controllerMethod . '\');' . PHP_EOL;
        }

        $filePath = ROOTPATH . 'app/Config/ProductsRoutes.php';
        
        // Ensure the directory exists
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        
        // Write to file
        if (file_put_contents($filePath, $output) === false) {
            log_message('error', 'Failed to write dynamic routes to file: ' . $filePath);
        }
    }
}