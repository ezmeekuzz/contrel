$(document).ready(function() {
    $('#sendnewsletter').submit(function(event) {
        event.preventDefault();

        let subject = $('#subject').val();
        let content = $('#content').val();

        if (subject.trim() === '' || content.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in the required fields!',
            });
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/admin/sendnewsletter/sendMessage',
            data: $('#sendnewsletter').serialize(),
            dataType: 'json',
            beforeSend: function() {
                let progress = 0;
                Swal.fire({
                    title: 'Preparing to send...',
                    html: `
                        <div style="width:100%; background:#eee; border-radius:6px; margin-top:10px;">
                            <div id="progress-bar" style="width:0%; height:12px; background:#3085d6; border-radius:6px;"></div>
                        </div>
                        <p id="progress-text" style="margin-top:8px;">Sending... Please wait</p>
                    `,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();

                        let interval = setInterval(() => {
                            progress += 10;
                            if (progress > 100) progress = 100;

                            $('#progress-bar').css('width', progress + '%');
                            $('#progress-text').text(`Sending... ${progress}%`);

                            if (progress === 100) {
                                clearInterval(interval);
                            }
                        }, 300); // update every 0.3s
                    }
                });
            },
            success: function(response) {
                Swal.close(); // close loading modal first

                if (response.success) {
                    $('#sendnewsletter')[0].reset();
                    $("#content").summernote('reset');

                    Swal.fire({
                        icon: 'success',
                        title: 'Newsletter Sent!',
                        text: response.message,
                        showConfirmButton: true
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred while sending the newsletter. Please try again later.',
                });
                console.error(xhr.responseText);
            }
        });
    });

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
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150']
    });
});
