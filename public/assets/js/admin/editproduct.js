$(document).ready(function() {
    // Initialize Summernote
    $('#description').summernote({
        toolbar: [
            ['style', ['style']],
            ['fontsize', ['fontsize']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['picture', 'hr']],
            ['table', ['table']],
            ['view', ['codeview']]
        ],
        tabsize: 2,
        height: 250,
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150'],
        followingToolbar: false
    });

    // Initialize with existing categories
    initializeCategories();

    // Handle category addition
    $('#addCategoryBtn').click(function() {
        addCategory();
    });

    // Allow Enter key to add category
    $('#categoryname').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            addCategory();
        }
    });

    // Main form submission
    $('#editproduct').submit(function(event) {
        event.preventDefault();
        updateProduct();
    });

    // Calculate volume when dimensions change
    $('#package_length, #package_width, #package_height').on('input', calculateVolume);

    // Generate barcode
    $('#generateBarcode').click(generateBarcode);

    // Make images sortable
    if ($('#currentImagesContainer').length) {
        $('#currentImagesContainer').sortable({
            handle: '.card',
            update: function(event, ui) {
                updateImageOrder();
            }
        });
    }

    // Delete image button
    $(document).on('click', '.delete-image-btn', function() {
        const imageId = $(this).data('id');
        deleteImage(imageId);
    });

    $(document).on('click', '.delete-category-btn', function () {
        let id = $(this).data('id');
        let categoryName = $(this).data('name');

        Swal.fire({
            title: 'Delete Category',
            text: `Are you sure you want to delete "${categoryName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/editproduct/deleteCategory/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            getCategories();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong with the request!'
                        });
                    }
                });
            }
        });
    });

    // Initialize volume calculation
    calculateVolume();
});

// Initialize categories from hidden input
function initializeCategories() {
    const selectedCategoriesJson = $('#selected_categories_json').val();
    let selectedCategories = [];
    
    if (selectedCategoriesJson) {
        try {
            selectedCategories = JSON.parse(selectedCategoriesJson);
        } catch (e) {
            console.error('Error parsing categories JSON:', e);
        }
    }
    
    // Load all categories
    getCategories(selectedCategories);
}

// Function to load categories
function getCategories(selectedCategories = []) {
    $.ajax({
        type: 'GET',
        url: '/admin/editproduct/getCategories',
        dataType: 'json',
        beforeSend: function() {
            $('#categoriesList').html(`
                <div class="text-center py-3">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span class="ml-2">Loading categories...</span>
                </div>
            `);
        },
        success: function(response) {
            if (response.success && response.categories) {
                renderCategories(response.categories, selectedCategories);
            } else {
                $('#categoriesList').html(`
                    <div class="alert alert-warning">
                        No categories found
                    </div>
                `);
            }
        },
        error: function(xhr, status, error) {
            $('#categoriesList').html(`
                <div class="alert alert-danger">
                    Error loading categories
                </div>
            `);
            console.error(xhr.responseText);
        }
    });
}

// Function to render categories with preselected ones
function renderCategories(categories, selectedCategories = []) {
    if (categories.length === 0) {
        $('#categoriesList').html(`
            <div class="alert alert-info">
                No categories available. Add a new category to get started.
            </div>
        `);
        return;
    }

    let html = '';
    categories.forEach(function(category) {
        const isSelected = selectedCategories.includes(parseInt(category.category_id));
        html += `
            <div class="d-flex align-items-center justify-content-between mb-2 p-2 border rounded">
                <div class="form-check m-0">
                    <input class="form-check-input category-checkbox" type="checkbox" 
                        name="categories[]" id="category_${category.category_id}" 
                        value="${category.category_id}" ${isSelected ? 'checked' : ''}>
                    <label class="form-check-label ml-2" for="category_${category.category_id}">
                        ${category.categoryname}
                    </label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger delete-category-btn" 
                        data-id="${category.category_id}" data-name="${category.categoryname}">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
    });

    $('#categoriesList').html(html);
    
    // Add event listener to checkboxes
    $('.category-checkbox').change(function() {
        updateSelectedCategories();
    });
}

// Function to add new category
function addCategory() {
    const categoryName = $('#categoryname').val().trim();
    const categoryHelp = $('#categoryHelp');
    
    // Validation
    if (!categoryName) {
        categoryHelp.text('Please enter a category name').show();
        $('#categoryname').focus();
        return;
    }
    
    if (categoryName.length < 2) {
        categoryHelp.text('Category name must be at least 2 characters').show();
        $('#categoryname').focus();
        return;
    }
    
    categoryHelp.hide();
    
    $.ajax({
        type: 'POST',
        url: '/admin/editproduct/addCategory',
        data: {
            category_name: categoryName
        },
        dataType: 'json',
        beforeSend: function() {
            $('#addCategoryBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');
        },
        success: function(response) {
            if (response.success) {
                // Clear input
                $('#categoryname').val('');
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Reload categories with current selections
                const selectedCategories = getCurrentSelectedCategories();
                getCategories(selectedCategories);
                
                // Automatically select the newly added category
                setTimeout(function() {
                    $(`#category_${response.category.category_id}`).prop('checked', true).trigger('change');
                }, 100);
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding category'
            });
            console.error(xhr.responseText);
        },
        complete: function() {
            $('#addCategoryBtn').prop('disabled', false).html('<i class="fa fa-plus"></i> Add');
        }
    });
}

// Function to get current selected categories
function getCurrentSelectedCategories() {
    const selectedCategories = [];
    $('.category-checkbox:checked').each(function() {
        selectedCategories.push(parseInt($(this).val()));
    });
    return selectedCategories;
}

// Function to update selected categories display
function updateSelectedCategories() {
    const selectedCategories = getCurrentSelectedCategories();
    
    const container = $('#selectedCategories');
    
    if (selectedCategories.length === 0) {
        container.html(`
            <div class="alert alert-light border text-muted py-2 mb-0">
                No categories selected
            </div>
        `);
        // Update the hidden input
        $('#selected_categories_json').val(JSON.stringify(selectedCategories));
        return;
    }
    
    // Get category names
    let html = '<div class="d-flex flex-wrap gap-2">';
    $('.category-checkbox:checked').each(function() {
        const categoryId = $(this).val();
        const categoryName = $(this).next('label').text().trim();
        html += `
            <span class="badge badge-primary py-2 px-3 d-flex align-items-center m-1">
                ${categoryName}
                <button type="button" class="btn btn-sm btn-link text-white ml-2 p-0" 
                        onclick="unselectCategory(${categoryId})">
                    <i class="fa fa-times"></i>
                </button>
            </span>
        `;
    });
    html += '</div>';
    
    container.html(html);
    
    // Update the hidden input
    $('#selected_categories_json').val(JSON.stringify(selectedCategories));
}

// Function to unselect a category
function unselectCategory(categoryId) {
    $(`#category_${categoryId}`).prop('checked', false).trigger('change');
}

// Function to calculate volume
function calculateVolume() {
    const length = parseFloat($('#package_length').val()) || 0;
    const width = parseFloat($('#package_width').val()) || 0;
    const height = parseFloat($('#package_height').val()) || 0;
    
    if (length > 0 && width > 0 && height > 0) {
        const volume = (length * width * height) / 1000; // Convert to cm³
        $('#volume_cm3').val(volume.toFixed(2));
    } else {
        $('#volume_cm3').val('');
    }
}

// Function to generate barcode
function generateBarcode() {
    // Generate a random 13-digit barcode
    let barcode = '';
    for (let i = 0; i < 13; i++) {
        barcode += Math.floor(Math.random() * 10);
    }
    $('#barcode_ean13').val(barcode);
}

// Function to delete image
function deleteImage(imageId) {
    Swal.fire({
        title: 'Delete Image',
        text: 'Are you sure you want to delete this image?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/editproduct/deleteImage/' + imageId,
                method: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Remove from UI
                        $(`.image-item[data-id="${imageId}"]`).remove();
                        
                        // Add to deleted images list
                        let deletedImages = $('#deleted_images').val();
                        let deletedArray = [];
                        
                        if (deletedImages) {
                            try {
                                deletedArray = JSON.parse(deletedImages);
                            } catch (e) {
                                console.error(e);
                            }
                        }
                        
                        deletedArray.push(imageId);
                        $('#deleted_images').val(JSON.stringify(deletedArray));
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete image'
                    });
                }
            });
        }
    });
}

// Function to update image order
function updateImageOrder() {
    const productId = $('input[name="product_id"]').val();
    const imageOrder = [];
    
    $('#currentImagesContainer .image-item').each(function(index) {
        const imageId = $(this).data('id');
        imageOrder.push(imageId);
    });
    
    $.ajax({
        type: 'POST',
        url: '/admin/editproduct/updateImageOrder',
        data: {
            product_id: productId,
            image_order: JSON.stringify(imageOrder)
        },
        dataType: 'json',
        success: function(response) {
            if (!response.success) {
                console.error('Failed to update image order:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating image order:', error);
        }
    });
}

// Function to update product
function updateProduct() {
    // Get the selected categories from hidden input
    const selectedCategoriesJson = $('#selected_categories_json').val();
    let selectedCategories = [];
    
    if (selectedCategoriesJson) {
        try {
            selectedCategories = JSON.parse(selectedCategoriesJson);
        } catch (e) {
            console.error('Error parsing categories JSON:', e);
        }
    }
    
    // Create FormData object
    const formData = new FormData($('#editproduct')[0]);
    
    // Clear any existing categories from formData
    formData.delete('categories[]');
    
    // Add the categories as individual form data entries
    selectedCategories.forEach(categoryId => {
        formData.append('categories[]', categoryId);
    });
    
    // Validate required fields
    if (!formData.get('productname') || !formData.get('order_code') || !formData.get('description')) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill in all required fields!',
        });
        return;
    }

    const productId = formData.get('product_id');
    
    // Send AJAX request
    $.ajax({
        type: 'POST',
        url: '/admin/editproduct/update/' + productId,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                title: 'Updating...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            Swal.close();
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Optional: Redirect to product list or stay on page
                        window.location.href = '/admin/product-masterlist';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An error occurred while updating product. Please try again later.',
            });
            console.error(xhr.responseText);
        }
    });
}

// File input label update
$(document).on('change', '.custom-file-input', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});

// Preview button
$('#previewBtn').click(function() {
    const productId = $('input[name="product_id"]').val();
    if (productId) {
        window.open('/product-preview/' + productId, '_blank');
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Cannot Preview',
            text: 'Please save the product first to preview it.'
        });
    }
});