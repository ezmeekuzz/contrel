$(document).ready(function () {
    let table = $('#productmasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/productmasterlist/getData",
            "type": "POST"
        },
        "columns": [
            { 
                "data": "product_name",
                "render": function(data, type, row) {
                    return data || '-';
                }
            },
            { 
                "data": "order_code",
                "render": function(data, type, row) {
                    return data || '-';
                }
            },
            { 
                "data": "qty_per_package",
                "render": function(data, type, row) {
                    return data || '1';
                }
            },
            { 
                "data": "weight_kg",
                "render": function(data, type, row) {
                    return data ? data + ' kg' : '-';
                }
            },
            { 
                "data": "package_length_mm",
                "render": function(data, type, row) {
                    return data ? data + ' mm' : '-';
                }
            },
            { 
                "data": "package_width_mm",
                "render": function(data, type, row) {
                    return data ? data + ' mm' : '-';
                }
            },
            { 
                "data": "package_height_mm",
                "render": function(data, type, row) {
                    return data ? data + ' mm' : '-';
                }
            },
            { 
                "data": "volume_cm3",
                "render": function(data, type, row) {
                    return data ? data + ' cm³' : '-';
                }
            },
            { 
                "data": "barcode_ean13",
                "render": function(data, type, row) {
                    return data || '-';
                }
            },
            { 
                "data": "hs_code",
                "render": function(data, type, row) {
                    return data || '-';
                }
            },
            {
                "data": null,
                "render": function (data, type, row) {
                    let statusBadge = '';
                    if (row.publish_status === 'Yes') {
                        statusBadge = '<span class="badge badge-success ml-2">Published</span>';
                    } else {
                        statusBadge = '<span class="badge badge-secondary ml-2">Draft</span>';
                    }
                    
                    return `${statusBadge}`;
                },
                "orderable": false
            },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `<a href="/admin/edit-product/${row.product_id}" title="Edit" class="edit-btn" data-id="${row.product_id}" style="color: blue;"><i class="ti ti-pencil" style="font-size: 18px;"></i></a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.product_id}" style="color: red;"><i class="ti ti-trash" style="font-size: 18px;"></i></a>`;
                },
                "orderable": false
            }
        ],
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data.product_id);
            if (data.publish_status !== 'Yes') {
                $(row).addClass('table-secondary');
            }
        },
        "order": [[0, 'asc']],
        "language": {
            "emptyTable": "No products found",
            "processing": "Loading products..."
        },
        "initComplete": function (settings, json) {
            $(this).trigger('dt-init-complete');
        }
    });

    // Enhanced delete button handler
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let productName = $(this).data('name');
        let row = $(this).closest('tr');
        
        // Get product details for confirmation
        $.ajax({
            url: '/admin/productmasterlist/getProductDetails/' + id,
            method: 'GET',
            beforeSend: function() {
                // Show loading state on delete button
                $(e.target).html('<i class="ti ti-loader spinner"></i> Loading...');
                $(e.target).prop('disabled', true);
            },
            success: function(response) {
                // Restore delete button
                $(e.target).html('<i class="ti ti-trash"></i> Delete');
                $(e.target).prop('disabled', false);
                
                if (response.status === 'success') {
                    showDeleteConfirmation(response.product, id, row);
                } else {
                    // Fallback to simple confirmation
                    showSimpleConfirmation(productName, id, row);
                }
            },
            error: function() {
                // Restore delete button
                $(e.target).html('<i class="ti ti-trash"></i> Delete');
                $(e.target).prop('disabled', false);
                
                // Fallback to simple confirmation
                showSimpleConfirmation(productName, id, row);
            }
        });
    });

    function showDeleteConfirmation(product, id, row) {
        let filesList = '';
        if (product.files && product.files.length > 0) {
            filesList = '<div class="mt-3"><strong>Files to be deleted:</strong><ul class="mt-2">';
            product.files.forEach(function(file) {
                filesList += `<li>${file.label} (${file.size})</li>`;
            });
            if (product.image_count > 0) {
                filesList += `<li>${product.image_count} additional image(s)</li>`;
            }
            filesList += '</ul></div>';
        }
        
        Swal.fire({
            title: 'Delete Product?',
            html: `
                <div class="text-left">
                    <p>You are about to delete the product:</p>
                    <div class="alert alert-danger">
                        <strong>${product.product_name}</strong><br>
                        <small>Order Code: ${product.order_code}</small>
                    </div>
                    ${filesList}
                    <p class="text-danger mt-3">
                        <i class="fa fa-exclamation-triangle"></i> This action cannot be undone. All product data and files will be permanently deleted.
                    </p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete permanently',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: '/admin/productmasterlist/delete/' + id,
                    method: 'DELETE'
                }).then(function(response) {
                    if (response.status !== 'success') {
                        throw new Error(response.message || 'Failed to delete product');
                    }
                    return response;
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    throw new Error('Network error: ' + textStatus);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                table.row(row).remove().draw(false);
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Product and all related files have been deleted.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        }).catch((error) => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Failed to delete product',
                confirmButtonText: 'OK'
            });
        });
    }

    function showSimpleConfirmation(productName, id, row) {
        Swal.fire({
            title: 'Delete Product?',
            html: `
                <div class="text-left">
                    <p>You are about to delete:</p>
                    <div class="alert alert-danger">
                        <strong>${productName}</strong>
                    </div>
                    <p class="text-danger">
                        <i class="fa fa-exclamation-triangle"></i> This will delete the product and all related files permanently.
                    </p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state on delete button
                const deleteBtn = $(row).find('.delete-btn');
                deleteBtn.html('<i class="ti ti-loader spinner"></i> Deleting...');
                deleteBtn.prop('disabled', true);
                
                $.ajax({
                    url: '/admin/productmasterlist/delete/' + id,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.status === 'success') {
                            table.row(row).remove().draw(false);
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Product has been deleted.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            // Restore delete button
                            deleteBtn.html('<i class="ti ti-trash"></i> Delete');
                            deleteBtn.prop('disabled', false);
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to delete product'
                            });
                        }
                    },
                    error: function() {
                        // Restore delete button
                        deleteBtn.html('<i class="ti ti-trash"></i> Delete');
                        deleteBtn.prop('disabled', false);
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Network error. Please try again.'
                        });
                    }
                });
            }
        });
    }
    
    // Add search functionality enhancement
    $('#productmasterlist_filter input').addClass('form-control form-control-sm');
    $('#productmasterlist_filter input').attr('placeholder', 'Search products...');
    
    // Add custom styles for better UI
    if (!$('#product-masterlist-styles').length) {
        $('head').append(`
            <style id="product-masterlist-styles">
                .btn-group .btn-sm {
                    padding: 0.25rem 0.5rem;
                    font-size: 0.875rem;
                }
                .btn-group .btn-primary {
                    border-top-right-radius: 0;
                    border-bottom-right-radius: 0;
                }
                .btn-group .btn-danger {
                    border-top-left-radius: 0;
                    border-bottom-left-radius: 0;
                }
                .badge {
                    font-size: 0.75rem;
                    vertical-align: middle;
                }
                .table-secondary {
                    background-color: rgba(0,0,0,0.02) !important;
                }
                .dataTables_wrapper .dataTables_filter input {
                    margin-left: 0.5em;
                    width: 250px;
                }
                .ti-loader.spinner {
                    animation: spin 1s linear infinite;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
        `);
    }
    
    // Refresh table every 30 seconds (optional)
    setInterval(function() {
        if (!$.fn.DataTable.isDataTable('#productmasterlist')) return;
        table.ajax.reload(null, false);
    }, 30000);
});