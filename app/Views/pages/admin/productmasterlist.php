<?=$this->include('templates/admin/header');?>
<style>
/* Add to your admin CSS file */

/* Product masterlist specific styles */
.table-secondary {
    background-color: #f8f9fa !important;
}

.product-checkbox {
    margin-right: 8px;
}

.dataTables_wrapper .dataTables_length {
    display: flex;
    align-items: center;
}

.dataTables_wrapper .dataTables_length .form-check {
    margin-right: 15px;
    margin-bottom: 0;
}

.badge-success {
    background-color: #28a745;
}

.badge-secondary {
    background-color: #6c757d;
}

/* SweetAlert custom styles */
.swal2-popup .swal2-content {
    text-align: left !important;
}

.swal2-popup ul {
    padding-left: 20px;
    margin-bottom: 10px;
}

.swal2-popup .alert {
    margin-bottom: 15px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dataTables_wrapper .dataTables_length {
        flex-wrap: wrap;
    }
    
    .dataTables_wrapper .dataTables_length .form-check,
    .dataTables_wrapper .dataTables_length #bulkDeleteBtn {
        margin-top: 5px;
        margin-bottom: 5px;
    }
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
                            <h1><i class="fas fa-archive"></i> Product Masterlist</h1>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Product Masterlist</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header d-flex align-items-center">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="fas fa-archive"></i> Products</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper table-responsive">
                                <table id="productmasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Order Code</th>
                                            <th>Quantity</th>
                                            <th>Weight (Kg)</th>
                                            <th>Length (mm)</th>
                                            <th>Width (mm)</th>
                                            <th>Height (mm)</th>
                                            <th>Volume (cm3)</th>
                                            <th>Barcode EAN13</th>
                                            <th>HS Code</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <!-- The table body will be dynamically filled by usermasterlist.js -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?=$this->include('templates/admin/footer');?>
<script src="<?=base_url();?>assets/js/admin/productmasterlist.js"></script>
