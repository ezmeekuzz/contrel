<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title;?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Secure login portal for authorized personnel only." />
    <meta content="Rustom Codilan" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/vendors.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', 'Nunito', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/images/hero-bg.png') center/cover no-repeat;
            filter: blur(8px);
            opacity: 0.7;
            z-index: -1;
        }
        
        .logo-container {
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            text-align: center;
        }
        
        .logo-container img {
            height: 80px;
            width: auto;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            margin-top: 120px;
            animation: fadeIn 0.5s ease-out;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px 35px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0,0,0,0.35);
        }
        
        .welcome-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .welcome-header h1 {
            color: #2d3748;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .welcome-header p {
            color: #718096;
            font-size: 14px;
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group label {
            display: block;
            color: #4a5568;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            padding-left: 4px;
        }
        
        .input-field {
            width: 100%;
            padding: 16px 20px;
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #2d3748;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .input-field::placeholder {
            color: #a0aec0;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #718096;
            cursor: pointer;
            padding: 4px;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        
        .toggle-password:hover {
            color: #667eea;
        }
        
        .forgot-password {
            display: block;
            text-align: right;
            color: #667eea;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            margin-top: 8px;
            padding-right: 4px;
            transition: color 0.3s ease;
        }
        
        .forgot-password:hover {
            color: #5a67d8;
            text-decoration: underline;
        }
        
        .recaptcha-container {
            margin: 25px 0;
            display: flex;
            justify-content: center;
        }
        
        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Roboto', sans-serif;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .submit-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .submit-btn i {
            font-size: 18px;
        }
        
        .swal2-container {
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
        }
        
        .swal2-popup {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border-radius: 20px !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }
        
        .loading {
            animation: pulse 2s infinite;
        }
        
        /* Responsive Design */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px;
                margin: 0 15px;
            }
            
            .login-wrapper {
                margin-top: 100px;
            }
            
            .logo-container img {
                height: 60px;
            }
            
            .welcome-header h1 {
                font-size: 24px;
            }
        }
        
        @media (max-height: 700px) {
            .login-wrapper {
                margin-top: 80px;
            }
            
            .logo-container {
                top: 20px;
            }
            
            .logo-container img {
                height: 60px;
            }
        }
        
        .copyright {
            position: fixed;
            bottom: 20px;
            left: 0;
            width: 100%;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            z-index: 1;
        }
    </style>
</head>
<body>
    <!-- Logo positioned at top center -->
    <div class="logo-container">
        <img src="<?=base_url();?>images/logo.png" alt="Hero Mascot">
    </div>
    
    <div class="login-wrapper">
        <div class="login-card">
            <div class="welcome-header">
                <h1>Welcome Hero!</h1>
                <p>Sign in to access your dashboard</p>
            </div>
            
            <form id="signIn">
                <div class="form-group">
                    <label for="email">Email Address*</label>
                    <input type="email" class="input-field" name="email" id="email" placeholder="Enter your email" required />
                </div>
                
                <div class="form-group">
                    <label for="password">Password*</label>
                    <div class="password-wrapper">
                        <input type="password" class="input-field" name="password" id="password" placeholder="Enter your password" required />
                        <button type="button" class="toggle-password" id="togglePassword">👁️</button>
                    </div>
                    <a href="../forgot-password" class="forgot-password">Forgot Password?</a>
                </div>
                
                <div class="recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="6LeJO_ApAAAAAKjH-ats7ZeBaHnW7s3U2HFePpS1"></div>
                </div>
                
                <button type="submit" class="submit-btn" id="loginButton">
                    <span>Login Now</span>
                    <span>🚀</span>
                </button>
                
                <input type="hidden" name="redirect" id="redirect" value="">
            </form>
        </div>
    </div>
    
    <div class="copyright">
        &copy; <?=date('Y');?> All rights reserved.
    </div>
    
    <script src="<?=base_url();?>assets/js/vendors.js"></script>
    <script src="<?=base_url();?>assets/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Check if the current URL has the redirect parameter
            const urlParams = new URLSearchParams(window.location.search);
            $('#redirect').val(urlParams.get('redirect'));
            
            // Toggle password visibility
            $('#togglePassword').click(function() {
                const passwordInput = $('#password');
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).text(type === 'password' ? '👁️' : '👁️‍🗨️');
            });
            
            // Form submission handler
            $('#signIn').submit(function(event) {
                event.preventDefault();
                
                // Disable button and show loading state
                const loginButton = $('#loginButton');
                loginButton.prop('disabled', true).addClass('loading');
                loginButton.html('<span>Authenticating...</span><span>⏳</span>');
                
                // Check if reCAPTCHA is filled
                let captchaResponse = grecaptcha.getResponse();
                if (captchaResponse.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Security Check Required',
                        text: 'Please complete the reCAPTCHA verification!',
                        confirmButtonColor: '#667eea',
                    }).then(() => {
                        loginButton.prop('disabled', false).removeClass('loading');
                        loginButton.html('<span>Login Now</span><span>🚀</span>');
                    });
                    return;
                }
                
                // Get form data
                const email = $('#email').val().trim();
                const password = $('#password').val().trim();
                
                // Perform client-side validation
                if (!email || !password) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Information',
                        text: 'Please fill in all required fields!',
                        confirmButtonColor: '#667eea',
                    }).then(() => {
                        loginButton.prop('disabled', false).removeClass('loading');
                        loginButton.html('<span>Login Now</span><span>🚀</span>');
                    });
                    return;
                }
                
                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Email',
                        text: 'Please enter a valid email address!',
                        confirmButtonColor: '#667eea',
                    }).then(() => {
                        loginButton.prop('disabled', false).removeClass('loading');
                        loginButton.html('<span>Login Now</span><span>🚀</span>');
                        $('#email').focus();
                    });
                    return;
                }
                
                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('admin/authenticate'); ?>',
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        // Show loading modal
                        Swal.fire({
                            title: 'Authenticating...',
                            text: 'Please wait while we verify your credentials',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        Swal.close();
                        
                        if (response.success) {
                            // Successful login
                            Swal.fire({
                                icon: 'success',
                                title: 'Welcome Back!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                background: 'rgba(255, 255, 255, 0.98)',
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        } else {
                            // Failed login
                            loginButton.prop('disabled', false).removeClass('loading');
                            loginButton.html('<span>Login Now</span><span>🚀</span>');
                            
                            // Reset reCAPTCHA
                            grecaptcha.reset();
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: response.message || 'Invalid credentials. Please try again.',
                                confirmButtonColor: '#667eea',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        loginButton.prop('disabled', false).removeClass('loading');
                        loginButton.html('<span>Login Now</span><span>🚀</span>');
                        
                        // Reset reCAPTCHA
                        grecaptcha.reset();
                        
                        let errorMessage = 'An error occurred while logging in. Please try again later.';
                        
                        if (xhr.status === 0) {
                            errorMessage = 'Network error. Please check your internet connection.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Server error. Please contact support.';
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Connection Error',
                            text: errorMessage,
                            confirmButtonColor: '#667eea',
                        });
                        
                        console.error('Login Error:', xhr.responseText || error);
                    }
                });
            });
            
            // Add enter key support for better UX
            $('#email, #password').keypress(function(e) {
                if (e.which === 13) {
                    $('#signIn').submit();
                }
            });
            
            // Focus on email field on page load
            $('#email').focus();
        });
    </script>
</body>
</html>