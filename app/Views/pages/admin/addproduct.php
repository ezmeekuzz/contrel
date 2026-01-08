<?=$this->include('templates/admin/header');?>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fa fa-product-hunt"></i> Products</h4>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        Dashboard
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <form id="addproduct" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <div class="card-heading">
                                    <h4 class="card-title float-left"><i class="ti ti-map"></i> Product Details</h4>
                                    <div class="float-right d-flex align-items-center">
                                        <!-- Media Place Button -->
                                        <button type="button" class="btn btn-sm btn-info mr-3" id="mediaManagerBtn">
                                            <i class="fa fa-image"></i> Media
                                        </button>
                                        
                                        <!-- Publish Switch -->
                                        <div class="form-group m-0">
                                            <div class="checkbox checbox-switch switch-success">
                                                <label>
                                                    <input type="checkbox" value="Yes" name="publishstatus" />
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
                                            <input type="text" name="productname" id="productname" class="form-control" placeholder="Enter Product Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_code">Order Code *</label>
                                            <input type="text" name="order_code" id="order_code" class="form-control" placeholder="e.g., PRD-001" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" id="short_description" class="form-control" rows="5" placeholder="Enter Short Description"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Description *</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter Product Description" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="backgroundimage">Main Product Image *</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="backgroundimage">Choose main image</label>
                                        <input type="file" class="custom-file-input" id="backgroundimage" name="backgroundimage" accept="image/png, image/gif, image/jpeg, image/webp" required>
                                    </div>
                                    <small class="form-text text-muted">Main display image for the product</small>
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
                                            <input type="number" step="0.01" name="weight" id="weight" class="form-control" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="qty_per_package">Qty per Package</label>
                                            <input type="number" name="qty_per_package" id="qty_per_package" class="form-control" placeholder="1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="hs_code">HS Code</label>
                                            <input type="text" name="hs_code" id="hs_code" class="form-control" placeholder="e.g., 8504.40">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="package_length">Package Length (mm)</label>
                                            <input type="number" name="package_length" id="package_length" class="form-control" placeholder="Length">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="package_width">Package Width (mm)</label>
                                            <input type="number" name="package_width" id="package_width" class="form-control" placeholder="Width">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="package_height">Package Height (mm)</label>
                                            <input type="number" name="package_height" id="package_height" class="form-control" placeholder="Height">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="volume_cm3">Volume (cm³)</label>
                                            <input type="number" step="0.01" name="volume_cm3" id="volume_cm3" class="form-control" placeholder="0.00" readonly>
                                            <small class="form-text text-muted">Calculated from dimensions</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="barcode_ean13">Barcode (EAN-13)</label>
                                            <input type="text" name="barcode_ean13" id="barcode_ean13" class="form-control" placeholder="13-digit barcode">
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-1" id="generateBarcode">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Documents Card -->
                        <div class="card card-statistics mt-4">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fa fa-file"></i> Product Documents & Media</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="data_sheet">Data Sheet (PDF)</label>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="data_sheet">Choose PDF file</label>
                                                <input type="file" class="custom-file-input" id="data_sheet" name="data_sheet" accept=".pdf">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="wiring_diagram">Wiring Diagram (PDF/Image)</label>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="wiring_diagram">Choose file</label>
                                                <input type="file" class="custom-file-input" id="wiring_diagram" name="wiring_diagram" accept=".pdf, image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dimensions_image">Dimensions Image</label>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="dimensions_image">Choose image</label>
                                                <input type="file" class="custom-file-input" id="dimensions_image" name="dimensions_image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="view_360_image">360° View Image</label>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="view_360_image">Choose panoramic image</label>
                                                <input type="file" class="custom-file-input" id="view_360_image" name="view_360_image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Additional Images</label>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="additional_images">Choose multiple images</label>
                                                <input type="file" class="custom-file-input" id="additional_images" name="additional_images[]" multiple accept="image/*">
                                            </div>
                                            <small class="form-text text-muted">You can select multiple images for gallery</small>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Product
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="previewBtn">
                                    <i class="fa fa-eye"></i> Preview
                                </button>
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
                                    <label for="newCategory">Add New Category</label>
                                    <div class="input-group">
                                        <input type="text" id="newCategory" class="form-control" placeholder="Enter category name">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="addCategoryBtn">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Add new categories as needed</small>
                                </div>
                                
                                <!-- Category Checkboxes -->
                                <div class="form-group">
                                    <label>Select Categories</label>
                                    <div id="categoryCheckboxes" class="category-list" style="max-height: 400px; overflow-y: auto;">
                                        <?php if(isset($categories) && !empty($categories)): ?>
                                            <?php foreach($categories as $category): ?>
                                                <div class="custom-control custom-checkbox mb-2 category-item" id="category_item_<?=$category['id'];?>">
                                                    <input type="checkbox" class="custom-control-input category-checkbox" 
                                                        id="category_<?=$category['id'];?>" 
                                                        name="categories[]" 
                                                        value="<?=$category['id'];?>">
                                                    <label class="custom-control-label d-flex justify-content-between align-items-center" for="category_<?=$category['id'];?>">
                                                        <span><?=htmlspecialchars($category['name']);?></span>
                                                        <button type="button" class="btn btn-xs btn-outline-danger delete-category" data-id="<?=$category['id'];?>">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-muted text-center py-3">
                                                No categories yet. Add your first category above.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <small class="form-text text-muted">Check all categories this product belongs to</small>
                                </div>
                                
                                <!-- Quick Stats -->
                                <div class="border-top pt-3 mt-3">
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Total Categories:</small>
                                        <small class="font-weight-bold" id="totalCategories">
                                            <?=isset($categories) ? count($categories) : 0;?>
                                        </small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Selected:</small>
                                        <small class="font-weight-bold" id="selectedCategories">0</small>
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
<script src="<?=base_url();?>assets/js/admin/addproduct.js"></script>
<script>
$(document).ready(function() {
    let categoryCounter = <?=isset($categories) ? count($categories) : 0;?>;
    
    // Function to update category counters
    function updateCategoryCounters() {
        const totalCategories = $('.category-item').length;
        const selectedCategories = $('.category-checkbox:checked').length;
        
        $('#totalCategories').text(totalCategories);
        $('#selectedCategories').text(selectedCategories);
    }
    
    // Initialize counters
    updateCategoryCounters();
    
    // Add new category
    $('#addCategoryBtn').click(function() {
        const categoryName = $('#newCategory').val().trim();
        
        if (categoryName === '') {
            alert('Please enter a category name');
            return;
        }
        
        // Generate a temporary ID for new categories
        const tempId = -(++categoryCounter);
        
        // Create the new category checkbox
        const checkboxHtml = `
            <div class="custom-control custom-checkbox mb-2 category-item" id="category_item_${tempId}">
                <input type="checkbox" class="custom-control-input category-checkbox" 
                       id="category_${tempId}" 
                       name="categories[]" 
                       value="${tempId}" 
                       checked>
                <label class="custom-control-label d-flex justify-content-between align-items-center" for="category_${tempId}">
                    <span>${escapeHtml(categoryName)}</span>
                    <input type="hidden" name="new_categories[]" value="${escapeHtml(categoryName)}">
                    <button type="button" class="btn btn-xs btn-outline-danger delete-category" data-id="${tempId}">
                        <i class="fa fa-trash"></i>
                    </button>
                </label>
            </div>
        `;
        
        // Add to the top of the list
        $('#categoryCheckboxes').prepend(checkboxHtml);
        
        // Clear the input field
        $('#newCategory').val('');
        
        // Update counters
        updateCategoryCounters();
        
        // Scroll to show the new category
        $(`#category_item_${tempId}`)[0].scrollIntoView({behavior: 'smooth', block: 'nearest'});
    });
    
    // Delete category
    $(document).on('click', '.delete-category', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const categoryId = $(this).data('id');
        const categoryName = $(this).closest('label').find('span').text();
        
        if (categoryId < 0) {
            // For new categories (negative IDs), just remove from DOM
            $(`#category_item_${categoryId}`).remove();
            updateCategoryCounters();
        } else {
            // For existing categories from database
            if (confirm(`Are you sure you want to delete the category "${categoryName}"? This will remove it from all products.`)) {
                // Make AJAX call to delete category from database
                $.ajax({
                    url: '<?=base_url();?>admin/categories/delete',
                    type: 'POST',
                    data: { 
                        id: categoryId,
                        _token: '<?=csrf_token();?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            $(`#category_item_${categoryId}`).remove();
                            updateCategoryCounters();
                        } else {
                            alert('Error deleting category: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error deleting category. Please try again.');
                    }
                });
            }
        }
    });
    
    // Enter key to add category
    $('#newCategory').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#addCategoryBtn').click();
        }
    });
    
    // Update selected count when checkboxes change
    $(document).on('change', '.category-checkbox', function() {
        updateCategoryCounters();
    });
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
});
</script>