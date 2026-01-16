<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\ProductCategoriesModel;
use App\Models\ProductImagesModel;

class EditProductController extends SessionController
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
    
    public function index($productId = null)
    {
        if (!$productId) {
            return redirect()->to('/admin/products')->with('error', 'Product ID is required');
        }

        $productsModel = new ProductsModel();
        $product = $productsModel->find($productId);
        
        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        // Get product categories
        $productCategoriesModel = new ProductCategoriesModel();
        $categoriesModel = new CategoriesModel();
        
        $productCategories = $productCategoriesModel->where('product_id', $productId)->findAll();
        $selectedCategories = array_column($productCategories, 'category_id');
        
        // Get all categories
        $categories = $categoriesModel->findAll();
        
        // Get product images
        $productImagesModel = new ProductImagesModel();
        $additionalImages = $productImagesModel->where('product_id', $productId)->orderBy('sort_order', 'ASC')->findAll();

        $data = [
            'title' => 'Contrel | Edit Product',
            'currentpage' => 'productmasterlist',
            'product' => $product,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
            'additionalImages' => $additionalImages
        ];

        return view('pages/admin/editproduct', $data);
    }

    public function update($productId = null)
    {
        try {
            if (!$productId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Product ID is required'
                ]);
            }

            $productsModel = new ProductsModel();
            $product = $productsModel->find($productId);
            
            if (!$product) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Product not found'
                ]);
            }

            // Validate required fields
            $validationRules = [
                'productname' => 'required|min_length[2]|max_length[255]',
                'order_code' => 'required',
                'description' => 'required'
            ];
            
            // Only validate backgroundimage if it's being uploaded
            if ($this->request->getFile('backgroundimage')->isValid()) {
                $validationRules['backgroundimage'] = 'max_size[backgroundimage,5120]|mime_in[backgroundimage,' . implode(',', $this->allowedImageTypes) . ']|ext_in[backgroundimage,jpg,jpeg,png,gif,webp]';
            }
            
            if (!$this->validate($validationRules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => implode('<br>', $this->validator->getErrors())
                ]);
            }
            
            // Check if order code already exists (excluding current product)
            $orderCode = $this->request->getPost('order_code');
            $existingProduct = $productsModel->where('order_code', $orderCode)->where('product_id !=', $productId)->first();
            
            if ($existingProduct) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Order code already exists. Please use a different order code.'
                ]);
            }
            
            // Handle file uploads
            $uploadedFiles = $this->handleFileUploads($product);
            if (!$uploadedFiles['success']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $uploadedFiles['message']
                ]);
            }

            // Generate new slug if product name changed
            if ($product['product_name'] != $this->request->getPost('productname')) {
                $slug = $this->generateSlug($this->request->getPost('productname'), $productId);
            } else {
                $slug = $product['slug'];
            }
            
            // Prepare product data
            $productData = [
                'product_id' => $productId,
                'product_name' => $this->request->getPost('productname'),
                'slug' => $slug,
                'order_code' => $orderCode,
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
                'publish_status' => $this->request->getPost('publishstatus') === 'Yes' ? 'Yes' : 'No'
            ];
            
            // Add uploaded file paths to product data
            if (isset($uploadedFiles['data']['backgroundimage'])) {
                // Delete old main image if exists
                if ($product['main_image']) {
                    $oldImagePath = $this->uploadPath . $product['main_image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $productData['main_image'] = $uploadedFiles['data']['backgroundimage'];
            }
            
            if (isset($uploadedFiles['data']['data_sheet'])) {
                // Delete old data sheet if exists
                if ($product['data_sheet']) {
                    $oldDocPath = $this->uploadPath . $product['data_sheet'];
                    if (file_exists($oldDocPath)) {
                        unlink($oldDocPath);
                    }
                }
                $productData['data_sheet'] = $uploadedFiles['data']['data_sheet'];
            }
            
            if (isset($uploadedFiles['data']['wiring_diagram'])) {
                // Delete old wiring diagram if exists
                if ($product['wiring_diagram']) {
                    $oldWiringPath = $this->uploadPath . $product['wiring_diagram'];
                    if (file_exists($oldWiringPath)) {
                        unlink($oldWiringPath);
                    }
                }
                $productData['wiring_diagram'] = $uploadedFiles['data']['wiring_diagram'];
            }
            
            if (isset($uploadedFiles['data']['dimensions_image'])) {
                // Delete old dimensions image if exists
                if ($product['dimensions_image']) {
                    $oldDimPath = $this->uploadPath . $product['dimensions_image'];
                    if (file_exists($oldDimPath)) {
                        unlink($oldDimPath);
                    }
                }
                $productData['dimensions_image'] = $uploadedFiles['data']['dimensions_image'];
            }
            
            if (isset($uploadedFiles['data']['view_360_image'])) {
                // Delete old 360 image if exists
                if ($product['view_360_image']) {
                    $old360Path = $this->uploadPath . $product['view_360_image'];
                    if (file_exists($old360Path)) {
                        unlink($old360Path);
                    }
                }
                $productData['view_360_image'] = $uploadedFiles['data']['view_360_image'];
            }
            
            // Update product
            if ($productsModel->save($productData)) {
                // Handle categories
                $this->handleCategories($productId);
                
                // Handle additional images
                $this->handleAdditionalImages($productId, $uploadedFiles['additional_images']);
                
                // Handle image deletions
                $this->handleImageDeletions($productId);
                
                // Generate dynamic routes after successful update
                $this->dynamicRoutes();
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Product updated successfully',
                    'product_id' => $productId
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update product in database'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Product Update Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating product: ' . $e->getMessage()
            ]);
        }
    }

    private function handleFileUploads($existingProduct = null)
    {
        $uploadedData = [
            'success' => true,
            'message' => '',
            'data' => [],
            'additional_images' => []
        ];
        
        // Handle main image (backgroundimage) - optional for update
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
        
        $productCategoriesModel = new ProductCategoriesModel();
        
        // Remove any existing categories for this product first
        $productCategoriesModel->where('product_id', $productId)->delete();
        
        if ($categories && is_array($categories)) {
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

    private function handleAdditionalImages($productId, $newImages)
    {
        if (!empty($newImages)) {
            $productImagesModel = new ProductImagesModel();
            
            // Get current max sort order
            $currentImages = $productImagesModel->where('product_id', $productId)->findAll();
            $sortOrder = count($currentImages) + 1;
            
            foreach ($newImages as $imageData) {
                $productImagesModel->insert([
                    'product_id' => $productId,
                    'image_path' => $imageData['path'],
                    'thumbnail_path' => $imageData['path'],
                    'sort_order' => $sortOrder++
                ]);
            }
        }
    }

    private function handleImageDeletions($productId)
    {
        $deletedImages = $this->request->getPost('deleted_images');
        
        if ($deletedImages) {
            $deletedIds = json_decode($deletedImages, true);
            
            if (is_array($deletedIds) && !empty($deletedIds)) {
                $productImagesModel = new ProductImagesModel();
                
                foreach ($deletedIds as $imageId) {
                    $image = $productImagesModel->find($imageId);
                    
                    if ($image && $image['product_id'] == $productId) {
                        // Delete file from server
                        $imagePath = $this->uploadPath . $image['image_path'];
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                        
                        // Delete from database
                        $productImagesModel->delete($imageId);
                    }
                }
                
                // Reorder remaining images
                $this->reorderImages($productId);
            }
        }
    }

    private function reorderImages($productId)
    {
        $productImagesModel = new ProductImagesModel();
        $images = $productImagesModel->where('product_id', $productId)->orderBy('sort_order', 'ASC')->findAll();
        
        $sortOrder = 1;
        foreach ($images as $image) {
            $productImagesModel->update($image['product_image_id'], ['sort_order' => $sortOrder++]);
        }
    }

    public function updateImageOrder()
    {
        try {
            $productId = $this->request->getPost('product_id');
            $imageOrder = $this->request->getPost('image_order');
            
            if (!$productId || !$imageOrder) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid request'
                ]);
            }
            
            $productImagesModel = new ProductImagesModel();
            $imageOrder = json_decode($imageOrder, true);
            
            foreach ($imageOrder as $order => $imageId) {
                $productImagesModel->update($imageId, ['sort_order' => $order + 1]);
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Image order updated successfully'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating image order: ' . $e->getMessage()
            ]);
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
    
    private function generateSlug($text, $excludeProductId = null)
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
        
        $query = $productsModel->where('slug', $slug);
        if ($excludeProductId) {
            $query->where('product_id !=', $excludeProductId);
        }
        
        while ($query->first()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = $productsModel->where('slug', $slug);
            if ($excludeProductId) {
                $query->where('product_id !=', $excludeProductId);
            }
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
    
    public function deleteImage($imageId)
    {
        try {
            $productImagesModel = new ProductImagesModel();
            $image = $productImagesModel->find($imageId);
            
            if (!$image) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Image not found'
                ]);
            }
            
            // Delete file from server
            $imagePath = $this->uploadPath . $image['image_path'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            // Delete from database
            $deleted = $productImagesModel->delete($imageId);
            
            if ($deleted) {
                // Reorder remaining images
                $this->reorderImages($image['product_id']);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Image deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete image'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error deleting image: ' . $e->getMessage()
            ]);
        }
    }
}