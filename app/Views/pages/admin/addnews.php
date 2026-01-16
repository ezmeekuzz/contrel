<?=$this->include('templates/admin/header');?>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fa fa-newspaper-o"></i> News</h4>
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

            <form id="addnews" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <div class="card-heading">
                                    <h4 class="card-title float-left"><i class="fas fa-newspaper"></i> News Content</h4>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title">Title *</label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" id="short_description" class="form-control" rows="5" placeholder="Enter Short Description"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="content">Description *</label>
                                    <textarea name="content" id="content" class="form-control" rows="4" placeholder="Enter Product Description" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save News
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
                                <h4 class="card-title"><i class="fa fa-tags"></i> News Categories</h4>
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
                                
                                <div class="form-group">
                                    <label for="backgroundimage">Main Image *</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="backgroundimage">Choose main image</label>
                                        <input type="file" class="custom-file-input" id="backgroundimage" name="backgroundimage" accept="image/png, image/gif, image/jpeg, image/webp" required>
                                    </div>
                                    <small class="form-text text-muted">Main display image for the news</small>
                                </div>
                                
                                <div class="form-group">
                                    <div class="selects-contant-boots">
                                        <label for="tags">Tags</label>
                                        <div class="form-group mb-2 bs-select-1">
                                            <input type="text" class="bs-input" name="tags" id="tags" data-role="tagsinput" />
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
<script src="<?=base_url();?>assets/js/admin/addnews.js"></script>