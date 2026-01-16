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
                                    <label for="categoryname">Add New Category</label>
                                    <div class="input-group">
                                        <input type="hidden" id="selected_categories_json" name="selected_categories_json" value="">
                                        <input type="text" id="categoryname" name="categoryname" class="form-control" placeholder="Enter category name">
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
                                        <div class="alert alert-light border text-muted py-2 mb-0">
                                            No categories selected
                                        </div>
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