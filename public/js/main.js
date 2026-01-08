document.addEventListener('DOMContentLoaded', function() {
    const radioOptions = document.querySelectorAll('.radio-slider input[type="radio"]');
    const radioLabels = document.querySelectorAll('.radio-slider-option');
    
    radioOptions.forEach((radio, index) => {
        radio.addEventListener('change', function() {
            radioLabels.forEach(label => label.classList.remove('active'));
            radioLabels[index].classList.add('active');
            const selectedValue = this.id === 'it-option' ? 'IT' : 'EN';
            console.log(`Region changed to: ${selectedValue}`);
        });
    });
    
    const slider = document.querySelector('.radio-slider');
    slider.addEventListener('click', function() {
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 150);
    });

    // Hero carousel
    var heroOwl = $('.hero .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        center: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                center: false
            },
                        600: {
                items: 2,
                center: false
            },
            1000: {
                items: 3,
                center: true
            }
        },
        onInitialized: function() {
            equalizeHeights();
        },
        onResized: function() {
            equalizeHeights();
        }
    });

    $('.hero .custom-next').click(function() {
        heroOwl.trigger('next.owl.carousel');
    });

    $('.hero .custom-prev').click(function() {
        heroOwl.trigger('prev.owl.carousel');
    });

    // Hero carousel
    var productCatalogueOwl = $('.product-catalogue .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        center: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                center: false
            },
            600: {
                items: 3,
                center: false
            },
            1000: {
                items: 3,
                center: true
            }
        },
        onInitialized: function() {
            equalizeHeights();
        },
        onResized: function() {
            equalizeHeights();
        }
    });

    $('.product-catalogue .custom-next').click(function() {
        productCatalogueOwl.trigger('next.owl.carousel');
    });

    $('.product-catalogue .custom-prev').click(function() {
        productCatalogueOwl.trigger('prev.owl.carousel');
    });

    // Hero carousel
    var corporateLeafletsOwl = $('.corporate-leaflets .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        center: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                center: false
            },
            600: {
                items: 3,
                center: false
            },
            1000: {
                items: 3,
                center: true
            }
        },
        onInitialized: function() {
            equalizeHeights();
        },
        onResized: function() {
            equalizeHeights();
        }
    });

    $('.corporate-leaflets .custom-next').click(function() {
        corporateLeafletsOwl.trigger('next.owl.carousel');
    });

    $('.corporate-leaflets .custom-prev').click(function() {
        corporateLeafletsOwl.trigger('prev.owl.carousel');
    });

    var productDocumentationsOwl = $('.product-documentation .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        center: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                center: false
            },
            600: {
                items: 3,
                center: false
            },
            1000: {
                items: 3,
                center: true
            }
        },
        onInitialized: function() {
            equalizeHeights();
        },
        onResized: function() {
            equalizeHeights();
        }
    });

    $('.product-documentation .custom-next').click(function() {
        productDocumentationsOwl.trigger('next.owl.carousel');
    });

    $('.product-documentation .custom-prev').click(function() {
        productDocumentationsOwl.trigger('prev.owl.carousel');
    });

    var productLeafletsOwl = $('.product-leaflets .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        center: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                center: false
            },
            600: {
                items: 3,
                center: false
            },
            1000: {
                items: 3,
                center: true
            }
        },
        onInitialized: function() {
            equalizeHeights();
        },
        onResized: function() {
            equalizeHeights();
        }
    });

    $('.product-leaflets .custom-next').click(function() {
        productLeafletsOwl.trigger('next.owl.carousel');
    });

    $('.product-leaflets .custom-prev').click(function() {
        productLeafletsOwl.trigger('prev.owl.carousel');
    });

    var applicationNotesOwl = $('.application-notes .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        center: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                center: false
            },
            600: {
                items: 3,
                center: false
            },
            1000: {
                items: 3,
                center: true
            }
        },
        onInitialized: function() {
            equalizeHeights();
        },
        onResized: function() {
            equalizeHeights();
        }
    });

    $('.application-notes .custom-next').click(function() {
        applicationNotesOwl.trigger('next.owl.carousel');
    });

    $('.application-notes .custom-prev').click(function() {
        applicationNotesOwl.trigger('prev.owl.carousel');
    });

    // Product Range carousel
    var productRangeOwl = $('.product-range .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        center: true,
        autoplay: true,
        responsive: {
                0: {
                    items: 3,
                    center: true
                },
                576: {
                    items: 3,
                    center: true
                },
                768: {
                    items: 3,
                    center: true
                },
                992: {
                    items: 3,
                    center: true
                }
        },
        onInitialized: function() {
            equalizeHeights();
        },
        onResized: function() {
            equalizeHeights();
        }
    });

    $('.product-range .custom-next').click(function() {
        productRangeOwl.trigger('next.owl.carousel');
    });

    $('.product-range .custom-prev').click(function() {
        productRangeOwl.trigger('prev.owl.carousel');
    });

    // Latest News carousel
    var latestNewsOwl = $('.latest-news .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        center: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                center: false
            },
            600: {
                items: 2,
                center: false
            }
        },
        onInitialized: function() {
            equalizeHeights();
        },
        onResized: function() {
            equalizeHeights();
        }
    });

    $('.latest-news .custom-next').click(function() {
        latestNewsOwl.trigger('next.owl.carousel');
    });

    $('.latest-news .custom-prev').click(function() {
        latestNewsOwl.trigger('prev.owl.carousel');
    });

    // Latest News carousel
    var manufacturingInhouseDevelopmentOwl = $('.manufacturing-inhouse-development .owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        center: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                center: false
            }
        },
        onInitialized: function() {
            equalizeHeights();
        },
        onResized: function() {
            equalizeHeights();
        }
    });

    $('.manufacturing-inhouse-development .custom-next').click(function() {
        manufacturingInhouseDevelopmentOwl.trigger('next.owl.carousel');
    });

    $('.manufacturing-inhouse-development .custom-prev').click(function() {
        manufacturingInhouseDevelopmentOwl.trigger('prev.owl.carousel');
    });

    // Product Thumbnail Carousel
    var productThumbnailOwl;
    
    // Function to initialize thumbnail carousel
    function initializeThumbnailCarousel() {
        productThumbnailOwl = $('.product-thumbnails .owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            center: true,
            responsive: {
                0: {
                    items: 3,
                    center: true
                },
                576: {
                    items: 3,
                    center: true
                },
                768: {
                    items: 3,
                    center: true
                },
                992: {
                    items: 3,
                    center: true
                }
            },
            onInitialized: function() {
                // Set the center item as active initially
                setTimeout(() => {
                    updateCenterThumbnailAsActive();
                }, 100);
            },
            onChanged: function(event) {
                // When carousel changes, update the active thumbnail
                updateCenterThumbnailAsActive();
            },
            onTranslated: function(event) {
                // When translation completes, update the active thumbnail
                setTimeout(() => {
                    updateCenterThumbnailAsActive();
                }, 300);
            }
        });
        
        // Manually handle next/prev button clicks to ensure center thumbnail updates
        $('.thumbnail-carousel .owl-next').on('click', function() {
            setTimeout(() => {
                updateCenterThumbnailAsActive();
            }, 350);
        });
        
        $('.thumbnail-carousel .owl-prev').on('click', function() {
            setTimeout(() => {
                updateCenterThumbnailAsActive();
            }, 350);
        });
    }
            
    // Equalize heights function
    function equalizeHeights() {
        var maxHeight = 0;
                
        // Find the tallest slide
        $('.product-slide').each(function() {
            var height = $(this).outerHeight();
            if (height > maxHeight) {
                maxHeight = height;
            }
        });
                
        // Set all slides to the same height
        $('.product-slide').css('height', maxHeight + 'px');
    }

    // Function to update center thumbnail as active
    function updateCenterThumbnailAsActive() {
        console.log('Updating center thumbnail as active...');
        
        const thumbnailItems = document.querySelectorAll('.thumbnail-item');
        const mainProductImage = document.getElementById('mainProductImage');
        
        if (!thumbnailItems.length || !mainProductImage) {
            console.log('No thumbnails or main image found');
            return;
        }
        
        // Remove active class from all thumbnails
        thumbnailItems.forEach(item => {
            item.classList.remove('active');
        });
        
        // Find the center item - Owl Carousel adds 'center' class to the center item
        const centerItem = document.querySelector('.owl-item.center .thumbnail-item');
        
        if (centerItem) {
            console.log('Center item found:', centerItem);
            // Add active class to center item
            centerItem.classList.add('active');
            
            // Update main product image
            const imageUrl = centerItem.getAttribute('data-image');
            if (imageUrl) {
                console.log('Updating main image with:', imageUrl);
                mainProductImage.style.backgroundImage = `url('${imageUrl}')`;
                
                // Add a subtle animation
                mainProductImage.style.opacity = '0.8';
                setTimeout(() => {
                    mainProductImage.style.opacity = '1';
                }, 150);
            }
        } else {
            console.log('No center item found, looking for alternative...');
            // Fallback: find the middle item
            const visibleItems = Array.from(document.querySelectorAll('.owl-item:not(.cloned) .thumbnail-item'))
                .filter(item => item.offsetParent !== null);
            
            if (visibleItems.length > 0) {
                const middleIndex = Math.floor(visibleItems.length / 2);
                const middleItem = visibleItems[middleIndex];
                
                middleItem.classList.add('active');
                const imageUrl = middleItem.getAttribute('data-image');
                if (imageUrl) {
                    mainProductImage.style.backgroundImage = `url('${imageUrl}')`;
                }
            }
        }
    }
    
    // Click handler for thumbnails - when clicked, center that thumbnail
    function initializeThumbnailClickHandlers() {
        const thumbnailItems = document.querySelectorAll('.thumbnail-item');
        
        thumbnailItems.forEach((item) => {
            // Remove any existing click listeners
            item.removeEventListener('click', handleThumbnailClick);
            item.addEventListener('click', handleThumbnailClick);
        });
        
        function handleThumbnailClick(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Thumbnail clicked');
            
            // Get all non-cloned thumbnail items
            const nonClonedItems = Array.from(document.querySelectorAll('.owl-item:not(.cloned) .thumbnail-item'));
            const clickedIndex = nonClonedItems.indexOf(this);
            
            console.log('Clicked index:', clickedIndex, 'Total items:', nonClonedItems.length);
            
            if (clickedIndex !== -1 && productThumbnailOwl) {
                // Go to that item in the carousel
                productThumbnailOwl.trigger('to.owl.carousel', clickedIndex);
                
                // Update immediately for better UX
                setTimeout(() => {
                    updateCenterThumbnailAsActive();
                }, 100);
            }
        }
    }
    
    // Initialize everything
    setTimeout(() => {
        initializeThumbnailCarousel();
        initializeThumbnailClickHandlers();
        
        // Also update on window resize
        window.addEventListener('resize', () => {
            setTimeout(() => {
                updateCenterThumbnailAsActive();
            }, 200);
        });
    }, 100);
    
    // Add custom CSS for active thumbnail styling
    const style = document.createElement('style');
    style.textContent = `
        .thumbnail-item.active .thumbnail-container {
            border: 3px solid #ffc107 !important;
            box-shadow: 0 0 15px rgba(255, 193, 7, 0.4);
            transform: scale(1.05);
        }
        .thumbnail-item.active p {
            color: #ffc107;
            font-weight: bold;
        }
        .thumbnail-item.center .thumbnail-container {
            border-color: rgba(255, 193, 7, 0.3) !important;
        }
        .thumbnail-container {
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .thumbnail-container:hover {
            border-color: #ffc107 !important;
            transform: scale(1.03);
        }
        .thumbnail-carousel .owl-nav button {
            background-color: #ffc107 !important;
            color: #000 !important;
            width: 36px;
            height: 36px;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-size: 18px !important;
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        .thumbnail-carousel .owl-nav button:hover {
            background-color: #e0a800 !important;
            opacity: 1;
            transform: scale(1.1);
        }
        .thumbnail-carousel .owl-nav {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .thumbnail-carousel .owl-prev,
        .thumbnail-carousel .owl-next {
            position: static !important;
            transform: none !important;
        }
        #mainProductImage {
            border-radius: 8px;
            border: 2px solid #dee2e6;
            transition: background-image 0.3s ease, opacity 0.3s ease;
            background-color: #f8f9fa;
            min-height: 350px;
            opacity: 1;
        }
        
        /* Owl Carousel center item styling */
        .thumbnail-item.center {
            position: relative;
            z-index: 2;
        }
        
        /* Ensure all thumbnails have consistent size */
        .thumbnail-carousel .owl-item {
            padding: 5px;
            display: flex;
            justify-content: center;
        }
        
        /* Active thumbnail pulse effect */
        @keyframes pulseActive {
            0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(255, 193, 7, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
        }
        
        .thumbnail-item.active .thumbnail-container {
            animation: pulseActive 2s infinite;
        }
    `;
    document.head.appendChild(style);
});

document.addEventListener('DOMContentLoaded', function() {
    const listItems = document.querySelectorAll('.reliable-industrial-solutions .list-group-item');
    
    listItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active and border classes from all items
            listItems.forEach(li => {
                li.classList.remove('active');
                li.classList.remove('border-start', 'border-warning', 'border-3');

                // Add grey text classes to all items
                li.classList.add('text-secondary');
                li.querySelector('h5').classList.add('text-secondary');
                li.querySelector('p').classList.add('text-secondary');

                // Remove light text classes
                li.classList.remove('text-light');
                li.querySelector('h5').classList.remove('text-light');
                li.querySelector('p').classList.remove('text-light');
            });
    
            // Add active and border classes to clicked item
            this.classList.add('active');
            this.classList.add('border-start', 'border-warning', 'border-3');
            
            // Remove grey text and add light text to active item
            this.classList.remove('text-secondary');
            this.classList.add('text-light');
            this.querySelector('h5').classList.remove('text-secondary');
            this.querySelector('h5').classList.add('text-light');
            this.querySelector('p').classList.remove('text-secondary');
            this.querySelector('p').classList.add('text-light');
        });

        // Add cursor pointer for better UX
        item.style.cursor = 'pointer';
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const dragDropArea = document.getElementById('dragDropArea');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    
    // Drag & drop events
    dragDropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    dragDropArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });
    
    dragDropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });
    
    // File input change event
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });
    
    // Handle uploaded files
    function handleFiles(files) {
        if (!files.length) return;

        fileList.innerHTML = '';

        Array.from(files).forEach(file => {
            if (file.size > 10 * 1024 * 1024) { // 10MB limit
                alert(`File "${file.name}" exceeds 10MB limit.`);
                return;
            }
    
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            fileItem.innerHTML = `
                <div>
                    <i class="fas fa-file me-2"></i>
                    <span>${file.name}</span>
                    <small class="text-muted ms-2">(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            fileList.appendChild(fileItem);
        });

        // Reset file input
        fileInput.value = '';
    }
    
    // Form validation
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
});