<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title;?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="We have on-site capabilities to tweak as needed or to aid in assembly. These services can also be quoted a la' carte for your existing parts. Contact us for details." />
    <meta content="Rustom Codilan" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<link rel="icon" href="<?=base_url();?>images/logo.png" type="image/x-icon">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ruda:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/vendors.css" />
    <link href="<?=base_url();?>assets/css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .chosen-container-single .chosen-single {
            height: 40px; /* Adjust the height as needed */
        }
        .chosen-container-single .chosen-single div b {
            top: 60%;
            transform: translateY(0%);
        }

        @media (max-width: 767px) {
            .file-container {
                margin-bottom: 150px;
            }
            .file-icon {
                max-width: 60%;
            }
        }
        .is-invalid {
            border-color: red;
        }
        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            padding: 20px;
        }

        .upload-area h2 {
            margin: 0;
        }

        .upload-area p {
            margin: 10px 0;
        }

        .upload-area button {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .upload-area button:hover {
            background-color: #0056b3;
        }

        #fileList {
            margin-top: 20px;
        }

        .file-item {
            margin-bottom: 10px;
        }
        canvas {
            display: block; 
        }
        .file-icon {
            max-width: 100%;
        }
        @media (min-width: 768px) {
            .file-container {
                margin-bottom: 150px;
            }
            .file-icon {
                max-width: 60%;
            }
        }

        @media (max-width: 767px) {
            .file-container {
                margin-bottom: 150px;
            }
            .file-icon {
                max-width: 60%;
            }
        }
        .delete-image-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px; /* Adjust size as needed */
            height: 40px; /* Adjust size as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px; /* Adjust size as needed */
            cursor: pointer;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .carousel-item:hover .delete-image-btn {
            opacity: 1;
        }

        .file-wrapper:hover .delete-btn-preview {
            display: block;
        }

        .img-preview {
            max-width: 100px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        .delete-btn-preview {
            position: absolute;
            top: 0;
            right: 0;
            display: none;
            background-color: red;
            color: white;
            padding: 2px 8px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
        }
        .file-order {
            display: block;
            text-align: center;
            margin-top: 5px;
            font-weight: bold;
        }
        .file-wrapper {
            position: relative;
            display: inline-block;
            margin: 10px;
        }

        .file-wrapper img.img-preview {
            display: block;
            max-width: 100px; /* Adjust as needed */
            max-height: 100px; /* Adjust as needed */
        }

        .file-wrapper input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
    </style>
</head>

<body class="dark-sidebar">
    <div class="app">
        <div class="app-wrap">
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="<?=base_url();?>assets/img/loader/loader.gif" alt="loader">
                    </div>
                </div>
            </div>
            <header class="app-header top-bar">
                <nav class="navbar navbar-expand-md">
                    <div class="navbar-header d-flex align-items-center">
                        <a href="javascript:void:(0)" class="mobile-toggle"><i class="ti ti-align-right"></i></a>
                        <a class="navbar-brand" href="/">
                            <img src="<?=base_url();?>images/logo.png" class="img-fluid logo-desktop"  alt="logo" style="width: 70%;" />
                            <img src="<?=base_url();?>images/logo.png" class="img-fluid logo-mobile" alt="logo" />
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti ti-align-left"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="navigation d-flex">
                            <ul class="navbar-nav nav-left">
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link sidebar-toggle">
                                        <i class="ti ti-align-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>