<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoriesModel;
use App\Models\NewsModel;
use App\Models\NewsCategoriesModel;
use App\Models\NewsImagesModel;

class AddNewsController extends SessionController
{
    private $uploadPath;
    private $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private $newsModel;
    private $categoriesModel;
    
    public function __construct()
    {
        
        $this->uploadPath = FCPATH . 'uploads/news/';
        
        // Create only the main upload directory
        $path = $this->uploadPath . 'main/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        
        // Initialize models
        $this->newsModel = new NewsModel();
        $this->categoriesModel = new CategoriesModel();
    }
    
    public function index()
    {
        $categories = $this->categoriesModel->findAll();

        $data = [
            'title' => 'Contrel | Add News',
            'currentpage' => 'addnews',
            'categories' => $categories
        ];

        return view('pages/admin/addnews', $data);
    }

    public function insert()
    {
        try {
            // Validate required fields
            $validationRules = [
                'title' => 'required|min_length[2]|max_length[255]',
                'short_description' => 'required',
                'content' => 'required',
                'backgroundimage' => 'uploaded[backgroundimage]|max_size[backgroundimage,5120]|mime_in[backgroundimage,' . implode(',', $this->allowedImageTypes) . ']|ext_in[backgroundimage,jpg,jpeg,png,gif,webp]'
            ];
            
            if (!$this->validate($validationRules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => implode('<br>', $this->validator->getErrors())
                ]);
            }
            
            // Handle file upload
            $backgroundImage = $this->request->getFile('backgroundimage');
            $backgroundImageName = null;
            
            if ($backgroundImage && $backgroundImage->isValid() && !$backgroundImage->hasMoved()) {
                if (in_array($backgroundImage->getMimeType(), $this->allowedImageTypes)) {
                    $newName = $backgroundImage->getRandomName();
                    $uploadPath = $this->uploadPath . 'main/';
                    
                    if ($backgroundImage->move($uploadPath, $newName)) {
                        $backgroundImageName = 'main/' . $newName;
                    } else {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Failed to upload main image'
                        ]);
                    }
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Invalid image type. Allowed types: JPEG, PNG, GIF, WEBP'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Main news image is required'
                ]);
            }

            // Generate unique slug
            $slug = $this->generateSlug($this->request->getPost('title'));
        
            // Prepare news data
            $newsData = [
                'title' => $this->request->getPost('title'),
                'slug' => $slug,
                'short_description' => $this->request->getPost('short_description'),
                'content' => $this->request->getPost('content'),
                'tags' => $this->request->getPost('tags'),
                'publish_status' => $this->request->getPost('publishstatus') === 'Yes' ? 'Yes' : 'No',
                'backgroundimage' => $backgroundImageName,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // Insert news
            if ($this->newsModel->save($newsData)) {
                $newsId = $this->newsModel->insertID();
                
                // Handle categories
                $this->handleCategories($newsId);
                
                // Generate dynamic routes after successful insert
                $this->dynamicRoutes();
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'News saved successfully',
                    'news_id' => $newsId
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save news to database'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'News Insert Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error saving news: ' . $e->getMessage()
            ]);
        }
    }

    private function handleCategories($newsId)
    {
        $categories = $this->request->getPost('categories');
        
        if ($categories && is_array($categories)) {
            $newsCategoriesModel = new NewsCategoriesModel();
            
            // Remove any existing categories for this news first
            $newsCategoriesModel->where('news_id', $newsId)->delete();
            
            foreach ($categories as $categoryId) {
                // Validate category exists
                $category = $this->categoriesModel->find($categoryId);
                
                if ($category) {
                    $newsCategoriesModel->insert([
                        'news_id' => $newsId,
                        'category_id' => $categoryId
                    ]);
                }
            }
        }
    }

    public function getCategories()
    {
        $categories = $this->categoriesModel->findAll();

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

            // Check if category already exists
            $existingCategory = $this->categoriesModel->where('categoryname', $categoryName)->first();
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

            $this->categoriesModel->insert($data);
            $newCategoryId = $this->categoriesModel->insertID();

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
            // Find the category by ID
            $category = $this->categoriesModel->find($id);
            
            if (!$category) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Category not found'
                ]);
            }
            
            // Check if category is used by any news
            $newsCategoriesModel = new NewsCategoriesModel();
            $usedCount = $newsCategoriesModel->where('category_id', $id)->countAllResults();
            
            if ($usedCount > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Cannot delete category. It is used by ' . $usedCount . ' news item(s).'
                ]);
            }
            
            // Delete the category record
            $deleted = $this->categoriesModel->delete($id);
            
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
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->newsModel->where('slug', $slug)->first()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    private function dynamicRoutes() 
    {
        $result = $this->newsModel->findAll();
        $data = [];

        if (count($result)) {
            foreach ($result as $route) {
                if (!empty($route['slug'])) {
                    $data[$route['slug']] = 'NewsController::view/' . $route['news_id'];
                }
            }
        }

        $output = '<?php' . PHP_EOL . PHP_EOL;
        $output .= '// Auto-generated news routes' . PHP_EOL;
        $output .= '// Generated on: ' . date('Y-m-d H:i:s') . PHP_EOL . PHP_EOL;
        
        foreach ($data as $slug => $controllerMethod) {
            $output .= '$routes->get(\'' . $slug . '\', \'' . $controllerMethod . '\');' . PHP_EOL;
        }

        $filePath = ROOTPATH . 'app/Config/NewsRoutes.php';
        
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