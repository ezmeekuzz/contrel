$(document).ready(function() {
    $('#addproduct').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Get form data
        let fullname = $('#fullname').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let usertype = $('#usertype').val();

        // Perform client-side validation
        if (fullname.trim() === '' || email.trim() === '' || password.trim() === '' || usertype.trim() === '') {
            // Show error using SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in the required fields!',
            });
            return;
        }

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: '/admin/addproduct/insert',
            data: $('#addproduct').serialize(), // Serialize form data
            dataType: 'json',
            beforeSend: function() {
                // Show loading effect
                Swal.fire({
                    title: 'Saving...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if (response.success) {
                    // Redirect upon successful login
                    $('#addproduct')[0].reset();
                    $('#usertype').trigger('chosen:updated');
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Save',
                        text: response.message,
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred while logging in. Please try again later.',
                });
                console.error(xhr.responseText);
            }
        });
    });    
    
    // Media Manager Button
    $('#mediaManagerBtn').click(function() {
        Swal.fire({
            title: 'Media Library',
            html: `
                <div class="text-center p-4">
                    <i class="fa fa-image fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Media library integration will be available soon.</p>
                    <button class="btn btn-primary mt-3" onclick="uploadNewMedia()">
                        <i class="fa fa-upload"></i> Upload Media
                    </button>
                </div>
            `,
            showConfirmButton: false,
            showCloseButton: true,
            width: '600px'
        });
    });

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
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150']
    });
});
