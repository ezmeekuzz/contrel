<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\ProductCategoriesModel;
use App\Models\ProductImagesModel;

class ProductMasterlistController extends SessionController
{
    private $uploadPath;
    
    public function __construct()
    {
        $this->uploadPath = FCPATH . 'uploads/products/';
    }
    
    public function index()
    {
        $data = [
            'title' => 'Contrel | Product Masterlist',
            'currentpage' => 'productmasterlist'
        ];
        return view('pages/admin/productmasterlist', $data);
    }
    
    public function getData()
    {
        return datatables('products')->make();
    }
    
    public function delete($id)
    {
        $productsModel = new ProductsModel();
        $productCategoriesModel = new ProductCategoriesModel();
        $productImagesModel = new ProductImagesModel();
    
        // Find the product by ID
        $product = $productsModel->find($id);
    
        if ($product) {
            try {
                // Delete all related files
                $this->deleteProductFiles($product);
                
                // Delete all product images from database and filesystem
                $this->deleteProductImages($id);
                
                // Delete all product-category relationships
                $productCategoriesModel->where('product_id', $id)->delete();
                
                // Delete the product record from the database
                $deleted = $productsModel->delete($id);
    
                if ($deleted) {
                    // Update dynamic routes after deletion
                    $this->updateDynamicRoutes();
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Product and all related files deleted successfully'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error', 
                        'message' => 'Failed to delete the product from the database'
                    ]);
                }
            } catch (\Exception $e) {
                log_message('error', 'Product deletion error: ' . $e->getMessage());
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Error deleting product: ' . $e->getMessage()
                ]);
            }
        }
    
        return $this->response->setJSON([
            'status' => 'error', 
            'message' => 'Product not found'
        ]);
    }
    
    /**
     * Delete all product files (main images, documents, etc.)
     */
    private function deleteProductFiles($product)
    {
        $fileFields = [
            'main_image',
            'data_sheet',
            'wiring_diagram',
            'dimensions_image',
            'view_360_image'
        ];
        
        foreach ($fileFields as $field) {
            if (!empty($product[$field])) {
                $filePath = $this->uploadPath . $product[$field];
                $this->deleteFile($filePath);
            }
        }
    }
    
    /**
     * Delete all additional product images
     */
    private function deleteProductImages($productId)
    {
        $productImagesModel = new ProductImagesModel();
        $images = $productImagesModel->where('product_id', $productId)->findAll();
        
        foreach ($images as $image) {
            // Delete image file
            if (!empty($image['image_path'])) {
                $filePath = $this->uploadPath . $image['image_path'];
                $this->deleteFile($filePath);
            }
            
            // Delete thumbnail file if different from main image
            if (!empty($image['thumbnail_path']) && $image['thumbnail_path'] != $image['image_path']) {
                $thumbPath = $this->uploadPath . $image['thumbnail_path'];
                $this->deleteFile($thumbPath);
            }
            
            // Delete from database
            $productImagesModel->delete($image['product_image_id']);
        }
    }
    
    /**
     * Delete a single file if it exists
     */
    private function deleteFile($filePath)
    {
        if (file_exists($filePath) && is_file($filePath)) {
            try {
                unlink($filePath);
                
                // Also try to delete empty parent directories
                $this->cleanupEmptyDirectories(dirname($filePath));
                
            } catch (\Exception $e) {
                log_message('error', 'Failed to delete file: ' . $filePath . ' - Error: ' . $e->getMessage());
            }
        }
    }
    
    /**
     * Clean up empty directories after file deletion
     */
    private function cleanupEmptyDirectories($directory)
    {
        // Only clean up within our uploads directory
        $uploadsRoot = realpath($this->uploadPath);
        $currentDir = realpath($directory);
        
        if (strpos($currentDir, $uploadsRoot) !== 0) {
            return; // Don't clean up outside our uploads directory
        }
        
        while ($currentDir !== $uploadsRoot && is_dir($currentDir)) {
            $isEmpty = $this->isDirectoryEmpty($currentDir);
            
            if ($isEmpty) {
                @rmdir($currentDir);
                $currentDir = dirname($currentDir);
            } else {
                break;
            }
        }
    }
    
    /**
     * Check if a directory is empty
     */
    private function isDirectoryEmpty($directory)
    {
        if (!is_dir($directory)) {
            return true;
        }
        
        $files = array_diff(scandir($directory), ['.', '..']);
        return empty($files);
    }
    
    /**
     * Update dynamic routes after product deletion
     */
    private function updateDynamicRoutes()
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
        $output .= '// Generated on: ' . date('Y-m-d H:i:s') . PHP_EOL;
        $output .= '// Updated after product deletion' . PHP_EOL . PHP_EOL;
        
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
    
    /**
     * Bulk delete products
     */
    public function bulkDelete()
    {
        $productIds = $this->request->getPost('product_ids');
        
        if (empty($productIds) || !is_array($productIds)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No products selected for deletion'
            ]);
        }
        
        $productsModel = new ProductsModel();
        $successCount = 0;
        $errorCount = 0;
        $errors = [];
        
        foreach ($productIds as $id) {
            $product = $productsModel->find($id);
            
            if ($product) {
                try {
                    // Delete all related files
                    $this->deleteProductFiles($product);
                    
                    // Delete all product images
                    $this->deleteProductImages($id);
                    
                    // Delete product-category relationships
                    $productCategoriesModel = new ProductCategoriesModel();
                    $productCategoriesModel->where('product_id', $id)->delete();
                    
                    // Delete the product record
                    if ($productsModel->delete($id)) {
                        $successCount++;
                    } else {
                        $errorCount++;
                        $errors[] = "Failed to delete product ID: $id from database";
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = "Error deleting product ID: $id - " . $e->getMessage();
                }
            } else {
                $errorCount++;
                $errors[] = "Product ID: $id not found";
            }
        }
        
        // Update dynamic routes after bulk deletion
        if ($successCount > 0) {
            $this->updateDynamicRoutes();
        }
        
        $message = "Deleted $successCount product(s) successfully.";
        if ($errorCount > 0) {
            $message .= " Failed to delete $errorCount product(s).";
        }
        
        return $this->response->setJSON([
            'status' => $errorCount === 0 ? 'success' : 'partial',
            'message' => $message,
            'success_count' => $successCount,
            'error_count' => $errorCount,
            'errors' => $errors
        ]);
    }
    
    /**
     * Get product details for confirmation before deletion
     */
    public function getProductDetails($id)
    {
        $productsModel = new ProductsModel();
        $productImagesModel = new ProductImagesModel();
        
        $product = $productsModel->find($id);
        
        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product not found'
            ]);
        }
        
        $imageCount = $productImagesModel->where('product_id', $id)->countAllResults();
        
        $files = [];
        $fileFields = [
            'main_image' => 'Main Image',
            'data_sheet' => 'Data Sheet',
            'wiring_diagram' => 'Wiring Diagram',
            'dimensions_image' => 'Dimensions Image',
            'view_360_image' => '360° View Image'
        ];
        
        foreach ($fileFields as $field => $label) {
            if (!empty($product[$field])) {
                $filePath = $this->uploadPath . $product[$field];
                if (file_exists($filePath)) {
                    $files[] = [
                        'label' => $label,
                        'path' => $product[$field],
                        'size' => $this->formatBytes(filesize($filePath))
                    ];
                }
            }
        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'product' => [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'order_code' => $product['order_code'],
                'image_count' => $imageCount,
                'files' => $files
            ]
        ]);
    }
    
    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}