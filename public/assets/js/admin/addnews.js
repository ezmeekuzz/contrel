$(document).ready(function() {
    // Initialize Summernote
    $('#content').summernote({
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

    // Load categories on page load
    getCategories();

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
    $('#addnews').submit(function(event) {
        event.preventDefault();
        saveProduct();
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
                    url: '/admin/addnews/deleteCategory/' + id,
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
});

// Function to load categories
function getCategories() {
    $.ajax({
        type: 'GET',
        url: '/admin/addnews/getCategories',
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
                renderCategories(response.categories);
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

// Function to render categories
function renderCategories(categories) {
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
        html += `
            <div class="d-flex align-items-center justify-content-between mb-2 p-2 border rounded">
                <div class="form-check m-0">
                    <input class="form-check-input category-checkbox" type="checkbox" 
                        name="categories[]" id="category_${category.category_id}" 
                        value="${category.category_id}">
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
        url: '/admin/addnews/addCategory',
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
                
                // Reload categories
                getCategories();
                
                // Automatically select the newly added category
                setTimeout(function() {
                    $(`#category_${response.category.id}`).prop('checked', true).trigger('change');
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

// Function to update selected categories display
function updateSelectedCategories() {
    const selectedCategories = [];
    
    $('.category-checkbox:checked').each(function() {
        const categoryId = $(this).val();
        const categoryName = $(this).next('label').text().trim();
        selectedCategories.push({
            id: categoryId,
            name: categoryName
        });
    });
    
    const container = $('#selectedCategories');
    
    if (selectedCategories.length === 0) {
        container.html(`
            <div class="alert alert-light border text-muted py-2 mb-0">
                No categories selected
            </div>
        `);
        // Clear the hidden input
        $('#selected_categories_json').val('');
        return;
    }
    
    let html = '<div class="d-flex flex-wrap gap-2">';
    selectedCategories.forEach(function(category) {
        html += `
            <span class="badge badge-primary py-2 px-3 d-flex align-items-center m-1">
                ${category.name}
                <button type="button" class="btn btn-sm btn-link text-white ml-2 p-0" 
                        onclick="unselectCategory(${category.id})">
                    <i class="fa fa-times"></i>
                </button>
            </span>
        `;
    });
    html += '</div>';
    
    container.html(html);
    
    // Store selected categories as JSON in hidden input
    const categoryIds = selectedCategories.map(cat => cat.id);
    $('#selected_categories_json').val(JSON.stringify(categoryIds));
}

// Function to unselect a category
function unselectCategory(categoryId) {
    $(`#category_${categoryId}`).prop('checked', false).trigger('change');
}

// Function to save product
function saveProduct() {
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
    const formData = new FormData($('#addnews')[0]);
    
    // Clear any existing categories from formData
    formData.delete('categories[]');
    
    // Add the categories as individual form data entries
    selectedCategories.forEach(categoryId => {
        formData.append('categories[]', categoryId);
    });
    
    // Validate required fields
    if (!formData.get('title') || !formData.get('short_description') || !formData.get('content')) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill in all required fields!',
        });
        return;
    }

    // Send AJAX request
    $.ajax({
        type: 'POST',
        url: '/admin/addnews/insert',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                title: 'Saving...',
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
                        $('#addnews')[0].reset();
                        $("#tags").val('');
                        updateSelectedCategories();
                        getCategories();
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
                text: 'An error occurred while saving product. Please try again later.',
            });
            console.error(xhr.responseText);
        }
    });
}