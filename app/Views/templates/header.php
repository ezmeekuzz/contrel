<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <section class="hero position-relative" style="background: url('<?=$banner;?>') center/cover no-repeat;">
        <div class="container py-4 position-relative">
            <!-- Navigation -->
            <nav class="navbar navbar-expand-lg rounded-4 navbar-custom">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        <img src="/images/logo.png" alt="Logo" class="w-75">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mx-auto text-center">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#">Company+</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#">Products+</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#">Documentations+</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#">News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#">Support+</a>
                            </li>
                        </ul>
                    </div>
                    <div class="radio-slider-container">
                        <div class="radio-slider">
                            <input type="radio" id="it-option" name="region" checked>
                            <label for="it-option" class="radio-slider-option active">IT</label>
                            
                            <input type="radio" id="br-option" name="region">
                            <label for="br-option" class="radio-slider-option">EN</label>
                            
                            <div class="radio-slider-slider"></div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="row mt-5 py-4">
                <div class="<?=$columnSize;?>">
                    <h1 class="display-4 text-light fw-semibold"><?=$h1Tag;?></h1>
                    <p class="text-light">In-house hardware and firmware development Reliable solutions for industrial applications</p>
                    <div class="extra-btn py-5 border border-2 border-top-0 border-start-0 border-end-0">
                        <a href="#" class="float-start text-light text-decoration-none fw-semibold">Explore How <i class="fas fa-arrow-down"></i></a>
                        <a href="#" class="float-end text-light text-decoration-none fw-semibold">See Products <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-7 position-relative d-none d-lg-block" style="min-height: 500px; <?=$dnone;?>">
                    <!-- Carousel Container with Custom Navigation -->
                    <div class="owl-carousel-container position-absolute bottom-0 end-0" style="width: 80%; max-width: 600px;">
                        <div class="owl-carousel owl-theme">
                            <div class="item active">
                                <img src="/images/carousel-1.png" alt="">
                            </div>
                            <div class="item">
                                <img src="/images/carousel-2.png" alt="">
                            </div>
                            <div class="item">
                                <img src="/images/carousel-3.png" alt="">
                            </div>
                        </div>
                        <div class="custom-carousel-nav d-flex align-items-center mt-3">
                            <button class="custom-prev btn btn-outline-light rounded-circle py-2 me-2">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <button class="custom-next btn btn-outline-light rounded-circle py-2">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="news-section bg-warning p-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="news-container text-center">
                    News: ELR-3BN Type-B earth leakage relay. Sensitivity range from 0,03 to 10A. RS485 Modbus. Events log.
                </div>
            </div>
        </div>
    </section>