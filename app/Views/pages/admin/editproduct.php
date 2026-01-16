<?=$this->include('templates/admin/header');?>
<style>
/* Ensure the button is properly hidden by default and shown on hover */
.image-item .delete-image-btn {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-item .card:hover .delete-image-btn {
    opacity: 1;
}

.image-item .card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Make sure the card has relative positioning */
.image-item .card {
    position: relative;
    transition: box-shadow 0.3s ease;
}
</style>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fa fa-product-hunt"></i> Edit Product</h4>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="/admin/products">Products</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Edit Product
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <form id="editproduct" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                <input type="hidden" id="deleted_images" name="deleted_images" value="">
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <div class="card-heading">
                                    <h4 class="card-title float-left"><i class="ti ti-map"></i> Product Details</h4>
                                    <div class="float-right d-flex align-items-center">
                                        <!-- Publish Switch -->
                                        <div class="form-group m-0">
                                            <div class="checkbox checbox-switch switch-success">
                                                <label>
                                                    <input type="checkbox" value="Yes" name="publishstatus" <?= $product['publish_status'] === 'Yes' ? 'checked' : ''; ?> />
                                                    <span></span>
                                                    Publish
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="productname">Product Name *</label>
                                            <input type="text" name="productname" id="productname" class="form-control" 
                                                   value="<?= htmlspecialchars($product['product_name']); ?>" 
                                                   placeholder="Enter Product Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_code">Order Code *</label>
                                            <input type="text" name="order_code" id="order_code" class="form-control" 
                                                   value="<?= htmlspecialchars($product['order_code']); ?>" 
                                                   placeholder="e.g., PRD-001" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" id="short_description" class="form-control" rows="5" 
                                              placeholder="Enter Short Description"><?= htmlspecialchars($product['short_description'] ?? ''); ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Description *</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" 
                                              placeholder="Enter Product Description" required><?= htmlspecialchars($product['description']); ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="backgroundimage">Main Product Image</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?php if ($product['main_image']): ?>
                                                <div class="current-image mb-3">
                                                    <img src="<?= base_url('uploads/products/' . $product['main_image']); ?>" 
                                                         class="img-fluid rounded border" 
                                                         style="max-height: 150px;">
                                                    <div class="mt-2">
                                                        <small class="text-muted">Current Image</small>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="backgroundimage">
                                                    <?= $product['main_image'] ? 'Change Image' : 'Choose main image'; ?>
                                                </label>
                                                <input type="file" class="custom-file-input" id="backgroundimage" 
                                                       name="backgroundimage" accept="image/png, image/gif, image/jpeg, image/webp">
                                            </div>
                                            <small class="form-text text-muted">Leave empty to keep current image</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Specifications Card -->
                        <div class="card card-statistics mt-4">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fa fa-cube"></i> Product Specifications</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="weight">Weight (kg)</label>
                                            <input type="number" step="0.01" name="weight" id="weight" 
                                                   class="form-control" placeholder="0.00"
                                                   value="<?= $product['weight_kg'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="qty_per_package">Qty per Package</label>
                                            <input type="number" name="qty_per_package" id="qty_per_package" 
                                                   class="form-control" placeholder="1"
                                                   value="<?= $product['qty_per_package'] ?? 1; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="hs_code">HS Code</label>
                                            <input type="text" name="hs_code" id="hs_code" class="form-control" 
                                                   placeholder="e.g., 8504.40"
                                                   value="<?= htmlspecialchars($product['hs_code'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="package_length">Package Length (mm)</label>
                                            <input type="number" name="package_length" id="package_length" 
                                                   class="form-control" placeholder="Length"
                                                   value="<?= $product['package_length_mm'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="package_width">Package Width (mm)</label>
                                            <input type="number" name="package_width" id="package_width" 
                                                   class="form-control" placeholder="Width"
                                                   value="<?= $product['package_width_mm'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="package_height">Package Height (mm)</label>
                                            <input type="number" name="package_height" id="package_height" 
                                                   class="form-control" placeholder="Height"
                                                   value="<?= $product['package_height_mm'] ?? ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="volume_cm3">Volume (cm³)</label>
                                            <input type="number" step="0.01" name="volume_cm3" id="volume_cm3" 
                                                   class="form-control" placeholder="0.00" readonly
                                                   value="<?= $product['volume_cm3'] ?? ''; ?>">
                                            <small class="form-text text-muted">Calculated from dimensions</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="barcode_ean13">Barcode (EAN-13)</label>
                                            <input type="text" name="barcode_ean13" id="barcode_ean13" 
                                                   class="form-control" placeholder="13-digit barcode"
                                                   value="<?= htmlspecialchars($product['barcode_ean13'] ?? ''); ?>">
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-1" id="generateBarcode">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Current Additional Images -->
                        <?php if (!empty($additionalImages)): ?>
                        <div class="card card-statistics mt-4">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fas fa-images"></i> Current Additional Images</h4>
                            </div>
                            <div class="card-body">
                                <div class="row" id="currentImagesContainer">
                                    <?php foreach ($additionalImages as $index => $image): ?>
                                    <div class="col-md-3 mb-3 image-item" data-id="<?= $image['product_image_id']; ?>">
                                        <div class="card position-relative">
                                            <!-- Delete Button - Top Right Corner -->
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm delete-image-btn position-absolute" 
                                                    data-id="<?= $image['product_image_id']; ?>"
                                                    style="top: 8px; right: 8px; z-index: 10; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                                <i class="fa fa-trash" style="font-size: 14px;"></i>
                                            </button>
                                            
                                            <!-- Image -->
                                            <img src="<?= base_url('uploads/products/' . $image['image_path']); ?>" 
                                                class="card-img-top" 
                                                style="height: 150px; object-fit: cover;">
                                            
                                            <div class="card-body p-2">
                                                <!-- Image Number Badge -->
                                                <div class="d-flex justify-content-center">
                                                    <span class="badge badge-light">#<?= $index + 1; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Drag and drop images to reorder them
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Product Documents Card -->
                        <div class="card card-statistics mt-4">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fa fa-file"></i> Product Documents & Media</h4>
                            </div>
                            <div class="card-body">
                                <!-- Data Sheet -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="data_sheet">Data Sheet (PDF)</label>
                                            <?php if ($product['data_sheet']): ?>
                                            <div class="current-file mb-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-file-pdf text-danger mr-2"></i>
                                                    <span class="text-truncate"><?= basename($product['data_sheet']); ?></span>
                                                    <a href="<?= base_url('uploads/products/' . $product['data_sheet']); ?>" 
                                                       target="_blank" class="btn btn-sm btn-link ml-2">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="data_sheet">
                                                    <?= $product['data_sheet'] ? 'Change File' : 'Choose PDF file'; ?>
                                                </label>
                                                <input type="file" class="custom-file-input" id="data_sheet" 
                                                       name="data_sheet" accept=".pdf">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="wiring_diagram">Wiring Diagram (PDF/Image)</label>
                                            <?php if ($product['wiring_diagram']): ?>
                                            <div class="current-file mb-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-file <?= strpos($product['wiring_diagram'], '.pdf') !== false ? 'text-danger' : 'text-primary'; ?> mr-2"></i>
                                                    <span class="text-truncate"><?= basename($product['wiring_diagram']); ?></span>
                                                    <a href="<?= base_url('uploads/products/' . $product['wiring_diagram']); ?>" 
                                                       target="_blank" class="btn btn-sm btn-link ml-2">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="wiring_diagram">
                                                    <?= $product['wiring_diagram'] ? 'Change File' : 'Choose file'; ?>
                                                </label>
                                                <input type="file" class="custom-file-input" id="wiring_diagram" 
                                                       name="wiring_diagram" accept=".pdf, image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Images -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dimensions_image">Dimensions Image</label>
                                            <?php if ($product['dimensions_image']): ?>
                                            <div class="current-image mb-2">
                                                <img src="<?= base_url('uploads/products/' . $product['dimensions_image']); ?>" 
                                                     class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                            <?php endif; ?>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="dimensions_image">
                                                    <?= $product['dimensions_image'] ? 'Change Image' : 'Choose image'; ?>
                                                </label>
                                                <input type="file" class="custom-file-input" id="dimensions_image" 
                                                       name="dimensions_image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="view_360_image">360° View Image</label>
                                            <?php if ($product['view_360_image']): ?>
                                            <div class="current-image mb-2">
                                                <img src="<?= base_url('uploads/products/' . $product['view_360_image']); ?>" 
                                                     class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                            <?php endif; ?>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="view_360_image">
                                                    <?= $product['view_360_image'] ? 'Change Image' : 'Choose panoramic image'; ?>
                                                </label>
                                                <input type="file" class="custom-file-input" id="view_360_image" 
                                                       name="view_360_image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Additional Images -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Add More Images</label>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="additional_images">Choose multiple images</label>
                                                <input type="file" class="custom-file-input" id="additional_images" 
                                                       name="additional_images[]" multiple accept="image/*">
                                            </div>
                                            <small class="form-text text-muted">You can select multiple images for gallery</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Update Product
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="previewBtn">
                                        <i class="fa fa-eye"></i> Preview
                                    </button>
                                    <a href="/admin/products" class="btn btn-outline-danger">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side Column for Categories -->
                    <div class="col-lg-4">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fa fa-tags"></i> Product Categories</h4>
                            </div>
                            <div class="card-body">
                                <!-- Add New Category Section -->
                                <div class="form-group mb-4">
                                    <label for="categoryname">Add New Category</label>
                                    <div class="input-group">
                                        <input type="hidden" id="selected_categories_json" name="selected_categories_json" 
                                               value="<?= htmlspecialchars(json_encode($selectedCategories)); ?>">
                                        <input type="text" id="categoryname" name="categoryname" class="form-control" 
                                               placeholder="Enter category name">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="addCategoryBtn">
                                                <i class="fa fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <small id="categoryHelp" class="form-text text-danger" style="display: none;"></small>
                                </div>
                                
                                <!-- Categories List -->
                                <div class="form-group">
                                    <label>Select Categories</label>
                                    <div id="categoriesList" style="max-height: 300px; overflow-y: auto;">
                                        <!-- Categories will be loaded here -->
                                        <div class="text-center py-3">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <span class="ml-2">Loading categories...</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Selected Categories -->
                                <div class="form-group">
                                    <label>Selected Categories</label>
                                    <div id="selectedCategories" class="selected-categories-container">
                                        <?php if (empty($selectedCategories)): ?>
                                        <div class="alert alert-light border text-muted py-2 mb-0">
                                            No categories selected
                                        </div>
                                        <?php else: ?>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php 
                                            foreach ($selectedCategories as $catId):
                                                $categoryName = '';
                                                foreach ($categories as $cat) {
                                                    if ($cat['category_id'] == $catId) {
                                                        $categoryName = $cat['categoryname'];
                                                        break;
                                                    }
                                                }
                                            ?>
                                            <span class="badge badge-primary py-2 px-3 d-flex align-items-center m-1">
                                                <?= htmlspecialchars($categoryName); ?>
                                                <button type="button" class="btn btn-sm btn-link text-white ml-2 p-0" 
                                                        onclick="unselectCategory(<?= $catId; ?>)">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </span>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?=$this->include('templates/admin/footer');?>
<script src="<?=base_url();?>assets/js/admin/editproduct.js"></script>