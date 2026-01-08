<?=$this->include('templates/header');?>
    <style>
        :root {
            --primary-blue: #1a237e;
            --accent-yellow: #ffc107;
            --dark-blue: #0d1b3e;
            --light-gray: #f8f9fa;
            --medium-gray: #6c757d;
            --border-color: #e0e0e0;
        }
        .policy-wrapper {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            position: relative;
            z-index: 10;
        }
        
        .policy-sidebar {
            background: linear-gradient(180deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: white;
            padding: 3rem 2rem;
            height: 100%;
        }
        
        .policy-sidebar h3 {
            color: var(--accent-yellow);
            font-weight: 600;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .policy-sidebar h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-yellow);
        }
        
        .policy-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .policy-nav li {
            margin-bottom: 1rem;
        }
        
        .policy-nav a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 400;
        }
        
        .policy-nav a:hover,
        .policy-nav a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .policy-nav i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        
        .policy-content {
            padding: 4rem 3rem;
        }
        
        .policy-header {
            border-bottom: 2px solid var(--accent-yellow);
            padding-bottom: 2rem;
            margin-bottom: 3rem;
        }
        
        .last-updated {
            display: inline-block;
            background: var(--light-gray);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.9rem;
            color: var(--medium-gray);
            margin-bottom: 1.5rem;
        }
        
        .policy-title {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
            line-height: 1.2;
        }
        
        .policy-intro {
            font-size: 1.2rem;
            color: var(--medium-gray);
            max-width: 800px;
        }
        
        .section-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2.5rem;
            margin-bottom: 2.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .section-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: var(--accent-yellow);
        }
        
        .section-title {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 12px;
            color: var(--accent-yellow);
            background: rgba(255, 193, 7, 0.1);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .section-content {
            color: #555;
            line-height: 1.8;
        }
        
        .section-content p {
            margin-bottom: 1.2rem;
        }
        
        .section-content ul {
            margin-bottom: 1.5rem;
            padding-left: 1.2rem;
        }
        
        .section-content li {
            margin-bottom: 0.8rem;
            position: relative;
            padding-left: 1.5rem;
        }
        
        .section-content li::before {
            content: '•';
            color: var(--accent-yellow);
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        
        .highlight-box {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.05) 0%, rgba(255, 193, 7, 0.02) 100%);
            border-left: 4px solid var(--accent-yellow);
            padding: 2rem;
            margin: 2rem 0;
            border-radius: 0 8px 8px 0;
        }
        
        .highlight-box h5 {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .cookie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .cookie-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .cookie-card:hover {
            border-color: var(--accent-yellow);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
        
        .cookie-card h6 {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }
        
        .cookie-card h6 i {
            margin-right: 10px;
            color: var(--accent-yellow);
        }
        
        .contact-pill {
            display: inline-flex;
            align-items: center;
            background: var(--light-gray);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            margin: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .contact-pill:hover {
            background: var(--accent-yellow);
            transform: translateY(-2px);
        }
        
        .contact-pill i {
            margin-right: 10px;
            color: var(--primary-blue);
        }
        
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary-blue);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.2rem;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(26, 35, 126, 0.3);
        }
        
        .back-to-top:hover {
            background: var(--dark-blue);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(26, 35, 126, 0.4);
        }
        
        .download-btn {
            background: var(--primary-blue);
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .download-btn:hover {
            background: var(--dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 35, 126, 0.2);
        }
        
        .download-btn i {
            margin-right: 10px;
        }
        
        @media (max-width: 992px) {
            .policy-wrapper {
                margin-top: -30px;
            }
            
            .policy-content {
                padding: 2rem 1.5rem;
            }
            
            .policy-title {
                font-size: 2rem;
            }
            
            .section-card {
                padding: 1.5rem;
            }
        }
    </style>
    <section class="privacy-policy-content py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="row">
                <!-- Policy Sidebar -->
                <div class="col-lg-3">
                    <div class="policy-sidebar rounded-4 mb-4 mb-lg-0">
                        <h3>Policy Navigation</h3>
                        <ul class="policy-nav">
                            <li><a href="#overview" class="active"><i class="fas fa-file-contract"></i> Overview</a></li>
                            <li><a href="#data-controller"><i class="fas fa-user-tie"></i> Data Controller</a></li>
                            <li><a href="#data-processor"><i class="fas fa-users-cog"></i> Data Processor</a></li>
                            <li><a href="#processing-purpose"><i class="fas fa-bullseye"></i> Processing Purpose</a></li>
                            <li><a href="#data-access"><i class="fas fa-shield-alt"></i> Data Access</a></li>
                            <li><a href="#data-transfer"><i class="fas fa-exchange-alt"></i> Data Transfer</a></li>
                            <li><a href="#processed-data"><i class="fas fa-database"></i> Processed Data</a></li>
                            <li><a href="#cookies"><i class="fas fa-cookie-bite"></i> Cookies Policy</a></li>
                            <li><a href="#data-rights"><i class="fas fa-balance-scale"></i> Your Rights</a></li>
                        </ul>
                        
                        <div class="mt-5 pt-4">
                            <h4 class="h5 mb-3" style="color: var(--accent-yellow);">Quick Contact</h4>
                            <div class="contact-pill">
                                <i class="fas fa-envelope"></i>
                                <span class="text-black">contrel@contrel.it</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Policy Content -->
                <div class="col-lg-9">
                    <div class="policy-wrapper">
                        <div class="policy-content">
                            <!-- Policy Header -->
                            <div class="policy-header">
                                <span class="last-updated">
                                    <i class="fas fa-calendar-alt me-2"></i>Last updated: January 2025
                                </span>
                                <h1 class="policy-title">Privacy & Data Protection Policy</h1>
                                <p class="policy-intro">
                                    This document outlines how Contrel Elettronica collects, uses, and protects your personal information in compliance with Articles 13 and 14 of EU Regulation 679/2016 (GDPR). We are committed to safeguarding your privacy and ensuring transparency in all data processing activities.
                                </p>
                            </div>
                            
                            <!-- Section 1: Data Controller -->
                            <div class="section-card" id="data-controller">
                                <div class="section-title">
                                    <i class="fas fa-user-tie"></i>
                                    <span>a) The Data Controller</span>
                                </div>
                                <div class="section-content">
                                    <p>The Data Controller responsible for the processing of your personal data is:</p>
                                    <div class="highlight-box">
                                        <h5>Contrel Elettronica S.r.l.</h5>
                                        <p class="mb-2"><i class="fas fa-map-marker-alt text-warning me-2"></i>Via San Fereolo n.9, 26900 Lodi (LO), Italy</p>
                                        <p class="mb-2"><i class="fas fa-user-tie text-warning me-2"></i>Represented by its pro tempore legal representative</p>
                                        <p class="mb-0"><i class="fas fa-envelope text-warning me-2"></i><strong>Contact:</strong> contrel@contrel.it</p>
                                    </div>
                                    <p>All communications regarding data protection matters should be directed to the above email address.</p>
                                </div>
                            </div>
                            
                            <!-- Section 2: Data Processor -->
                            <div class="section-card" id="data-processor">
                                <div class="section-title">
                                    <i class="fas fa-users-cog"></i>
                                    <span>b) The Data Processor</span>
                                </div>
                                <div class="section-content">
                                    <p>The Data Controller may appoint Data Processors to carry out specific processing activities. These processors operate under strict contractual agreements ensuring compliance with data protection regulations.</p>
                                    <p>The complete and updated list of Data Processors, appointed in accordance with Article 28 of EU Regulation 679/2016, is maintained at our registered office and available for consultation upon request.</p>
                                </div>
                            </div>
                            
                            <!-- Section 3: Purpose of Processing -->
                            <div class="section-card" id="processing-purpose">
                                <div class="section-title">
                                    <i class="fas fa-bullseye"></i>
                                    <span>c) Purpose of Data Processing</span>
                                </div>
                                <div class="section-content">
                                    <p>Personal data provided voluntarily through our website is processed exclusively for the following purposes:</p>
                                    <ul>
                                        <li><strong>Information Requests:</strong> Data submitted through our "Request for Information" forms is used solely to respond to your inquiries and provide requested information about our products and services.</li>
                                        <li><strong>Communications:</strong> With your consent, we may send email newsletters, commercial updates, and technical information about Contrel Elettronica's innovative solutions.</li>
                                    </ul>
                                    <div class="highlight-box">
                                        <h5><i class="fas fa-exclamation-circle me-2"></i>Important Notice</h5>
                                        <p class="mb-0">Should we intend to process your personal data for purposes beyond those initially specified, we will provide clear notification and obtain your explicit consent before proceeding with such additional processing.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 4: Data Access -->
                            <div class="section-card" id="data-access">
                                <div class="section-title">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>d) Parties Authorized to Access Data</span>
                                </div>
                                <div class="section-content">
                                    <p>Access to your personal data is strictly limited to:</p>
                                    <ul>
                                        <li>Authorized personnel of Contrel Elettronica who require access to fulfill their professional duties</li>
                                        <li>Specially appointed Data Processors operating under binding agreements</li>
                                        <li>Legal or regulatory authorities when required by law</li>
                                    </ul>
                                    <p>All individuals with access to personal data undergo regular data protection training and operate within clearly defined access protocols.</p>
                                </div>
                            </div>
                            
                            <!-- Section 5: Data Transfer -->
                            <div class="section-card" id="data-transfer">
                                <div class="section-title">
                                    <i class="fas fa-exchange-alt"></i>
                                    <span>e) Data Transfer & Disclosure</span>
                                </div>
                                <div class="section-content">
                                    <p>We maintain strict controls over data transfer and disclosure:</p>
                                    <ul>
                                        <li><strong>No International Transfers:</strong> Personal data is not transferred to third countries or international organizations outside the European Economic Area.</li>
                                        <li><strong>No Unauthorized Sharing:</strong> Data collected through our web services is not shared, sold, or disclosed to third parties for marketing purposes.</li>
                                        <li><strong>Professional Service Providers:</strong> We may engage trusted service providers for technical operations, all bound by strict data protection agreements.</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Section 6: Processed Data -->
                            <div class="section-card" id="processed-data">
                                <div class="section-title">
                                    <i class="fas fa-database"></i>
                                    <span>f) Categories of Processed Data</span>
                                </div>
                                <div class="section-content">
                                    <p>We process the following categories of personal data:</p>
                                    <ul>
                                        <li><strong>User-Provided Data:</strong> Information voluntarily submitted through registration forms, contact requests, or information inquiries.</li>
                                        <li><strong>Browsing Data:</strong> Technical information automatically collected during website usage, including IP addresses, browser types, and access times. This data is anonymized and used for statistical analysis and system optimization.</li>
                                        <li><strong>Communication Data:</strong> Correspondence exchanged through email, contact forms, or other communication channels.</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Section 7: Cookies Policy -->
                            <div class="section-card" id="cookies">
                                <div class="section-title">
                                    <i class="fas fa-cookie-bite"></i>
                                    <span>g) Cookies & Tracking Technologies</span>
                                </div>
                                <div class="section-content">
                                    <p>Cookies are small text files that enhance your browsing experience by remembering preferences and optimizing website performance.</p>
                                    
                                    <div class="cookie-grid">
                                        <div class="cookie-card">
                                            <h6><i class="fas fa-clock"></i> Session Cookies</h6>
                                            <p class="small mb-0">Temporary cookies essential for secure browsing, automatically deleted when you close your browser.</p>
                                        </div>
                                        <div class="cookie-card">
                                            <h6><i class="fas fa-save"></i> Persistent Cookies</h6>
                                            <p class="small mb-0">Stored on your device to remember preferences and improve future visits to our website.</p>
                                        </div>
                                        <div class="cookie-card">
                                            <h6><i class="fas fa-share-alt"></i> Third-Party Cookies</h6>
                                            <p class="small mb-0">Used for social media integration and content sharing features.</p>
                                        </div>
                                        <div class="cookie-card">
                                            <h6><i class="fas fa-chart-bar"></i> Analytics Cookies</h6>
                                            <p class="small mb-0">Help us understand website usage patterns to improve content and user experience.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="highlight-box mt-4">
                                        <h5><i class="fas fa-cog me-2"></i>Cookie Management</h5>
                                        <p class="mb-0">You can control cookie preferences through your browser settings. Please note that disabling essential cookies may impact website functionality and user experience.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 8: Additional Information -->
                            <div class="section-card">
                                <div class="section-title">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Additional Processing Information</span>
                                </div>
                                <div class="section-content">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-map-marker-alt text-warning me-2"></i>Processing Location</h6>
                                            <p>All data processing occurs at our headquarters in Lodi, Italy, utilizing secure infrastructure and controlled access environments.</p>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-shield-alt text-warning me-2"></i>Security Measures</h6>
                                            <p>We implement comprehensive technical and organizational measures including encryption, access controls, and regular security assessments.</p>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-calendar text-warning me-2"></i>Retention Period</h6>
                                            <p>Personal data is retained only as long as necessary for the specified purposes and in compliance with legal obligations.</p>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-robot text-warning me-2"></i>Automated Processing</h6>
                                            <p>We do not engage in automated decision-making or profiling activities that significantly affect individuals.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 9: Data Subject Rights -->
                            <div class="section-card" id="data-rights">
                                <div class="section-title">
                                    <i class="fas fa-balance-scale"></i>
                                    <span>h) Your Data Protection Rights</span>
                                </div>
                                <div class="section-content">
                                    <p>Under GDPR, you have the following rights regarding your personal data:</p>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-start mb-3">
                                                <i class="fas fa-eye text-warning mt-1 me-3"></i>
                                                <div>
                                                    <h6 class="fw-bold mb-1">Right of Access</h6>
                                                    <p class="small mb-0">Obtain confirmation and access to your personal data.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-start mb-3">
                                                <i class="fas fa-edit text-warning mt-1 me-3"></i>
                                                <div>
                                                    <h6 class="fw-bold mb-1">Right to Rectification</h6>
                                                    <p class="small mb-0">Request correction of inaccurate or incomplete data.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-start mb-3">
                                                <i class="fas fa-trash-alt text-warning mt-1 me-3"></i>
                                                <div>
                                                    <h6 class="fw-bold mb-1">Right to Erasure</h6>
                                                    <p class="small mb-0">Request deletion of your personal data under certain conditions.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-start mb-3">
                                                <i class="fas fa-pause-circle text-warning mt-1 me-3"></i>
                                                <div>
                                                    <h6 class="fw-bold mb-1">Right to Restriction</h6>
                                                    <p class="small mb-0">Limit the processing of your data in specific circumstances.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="highlight-box mt-4">
                                        <h5><i class="fas fa-exclamation-triangle me-2"></i>Exercising Your Rights</h5>
                                        <p class="mb-2">To exercise any of these rights, please contact us at <strong>contrel@contrel.it</strong>. We will respond to your request within 30 days.</p>
                                        <p class="mb-0">You also have the right to lodge a complaint with the Italian Data Protection Authority (Garante per la Protezione dei Dati Personali) or your local supervisory authority.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>
<?=$this->include('templates/footer');?>
    <script>
        // Smooth scrolling for navigation
        document.querySelectorAll('.policy-nav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                    
                    // Update active state
                    document.querySelectorAll('.policy-nav a').forEach(a => a.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
        
        // Back to top button
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });
        
        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Update active nav on scroll
        const sections = document.querySelectorAll('.section-card');
        const navLinks = document.querySelectorAll('.policy-nav a');
        
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollY >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
    </script>