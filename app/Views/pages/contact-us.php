<?=$this->include('templates/header');?>
    <section class="highlights py-5">
        <div class="container">
            <div class="row g-5 align-items-start">

                <!-- Contact Information Column -->
                <div class="col-12 col-lg-6">
                    <div class="mb-4 pb-2">
                        <h3 class="display-5 fw-bold mb-4">
                            How can we help you?
                        </h3>
                        <div class="mb-4">
                            <img src="images/contact-img.png" alt="Contact" class="w-100 rounded-3 shadow-sm">
                        </div>
                        <p class="fs-6 lh-lg mb-4">
                            From technical support to comprehensive customer services, we take care of your business and individual needs. We will provide you with assistance anytime, wherever you are. Here you can get timely help - our experts are on hand to provide you with help and advice over the phone.
                        </p>
                    </div>

                    <!-- Contact Details -->
                    <div class="row g-4">
                        <!-- Telephones -->
                        <div class="col-12 col-md-6">
                            <div class="border-start border-3 border-warning ps-3 py-2">
                                <h5 class="fw-bold text-dark mb-2">Telephones</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-1">(+39) 0371 30207</li>
                                    <li class="mb-1">(+39) 0371 30761</li>
                                    <li class="mb-1">(+39) 0371 34126</li>
                                    <li>(+39) 0371 35386</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="col-12 col-md-6">
                            <div class="border-start border-3 border-warning ps-3 py-2">
                                <h5 class="fw-bold text-dark mb-2">Working Hours</h5>
                                <p class="mb-0">Mon-Fri<br>8:30 am - 12:30 pm<br>1:30 pm - 6 pm</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-12 col-md-6">
                            <div class="border-start border-3 border-warning ps-3 py-2">
                                <h5 class="fw-bold text-dark mb-2">Email</h5>
                                <a href="mailto:contrel@contrel.eu" class="text-decoration-none">contrel@contrel.eu</a>
                            </div>
                        </div>

                        <!-- Office -->
                        <div class="col-12 col-md-6">
                            <div class="border-start border-3 border-warning ps-3 py-2">
                                <h5 class="fw-bold text-dark mb-2">Office</h5>
                                <p class="mb-0">via San Fereolo 9,<br>Lodi, 26900 ITALY</p>
                            </div>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="mt-4 pt-3">
                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2806.0473261661828!2d9.4865494!3d45.307469600000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47812c3971975bd1%3A0xccc9c74ec0beac9!2sVia%20S.%20Fereolo%2C%209%2C%2026900%20Lodi%20LO%2C%20Italy!5e0!3m2!1sen!2sph!4v1767004978076!5m2!1sen!2sph" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Company Profile Column -->
                <div class="col-12 col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="fs-3 fw-bold mb-4">
                            What are you inquiring about?
                        </h4>

                        <!-- Radio Button Group -->
                        <div class="mb-4">
                            <fieldset class="p-1 border border-2 border-black">
                                <div class="d-flex align-items-center">
                                    <div class="btn-group w-100" role="group" aria-label="Inquiry type">
                                        <input type="radio" class="btn-check" name="inquiry-type" id="general" checked>
                                        <label class="btn btn-outline-dark rounded-0 px-4 py-3" for="general">GENERAL</label>
                                        
                                        <input type="radio" class="btn-check" name="inquiry-type" id="part-request">
                                        <label class="btn btn-outline-dark rounded-0 px-4 py-3" for="part-request">PART REQUEST</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <!-- Form Fields -->
                        <form class="needs-validation" novalidate>
                            <div class="row g-3 g-lg-4">
                                <!-- First Row -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname" class="form-label fw-medium">First Name*</label>
                                        <input type="text" class="form-control border-0 border-bottom rounded-0 px-0 py-2" 
                                            name="firstname" id="firstname" required>
                                        <div class="invalid-feedback">
                                            Please provide your first name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname" class="form-label fw-medium">Last Name*</label>
                                        <input type="text" class="form-control border-0 border-bottom rounded-0 px-0 py-2" 
                                            name="lastname" id="lastname" required>
                                        <div class="invalid-feedback">
                                            Please provide your last name.
                                        </div>
                                    </div>
                                </div>

                                <!-- Second Row -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label fw-medium">Email*</label>
                                        <input type="email" class="form-control border-0 border-bottom rounded-0 px-0 py-2" 
                                            name="email" id="email" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid email address.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label fw-medium">Phone*</label>
                                        <input type="tel" class="form-control border-0 border-bottom rounded-0 px-0 py-2" 
                                            name="phone" id="phone" required>
                                        <div class="invalid-feedback">
                                            Please provide your phone number.
                                        </div>
                                    </div>
                                </div>

                                <!-- Third Row -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject" class="form-label fw-medium">Subject*</label>
                                        <input type="text" class="form-control border-0 border-bottom rounded-0 px-0 py-2" 
                                            name="subject" id="subject" required>
                                        <div class="invalid-feedback">
                                            Please provide a subject.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="region" class="form-label fw-medium">Region*</label>
                                        <select class="form-select border-0 border-bottom rounded-0 px-0 py-2" 
                                                name="region" id="region" required>
                                            <option value="" selected disabled>Select Region</option>
                                            <option value="eu">Europe</option>
                                            <option value="na">North America</option>
                                            <option value="sa">South America</option>
                                            <option value="asia">Asia</option>
                                            <option value="africa">Africa</option>
                                            <option value="oceania">Oceania</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a region.
                                        </div>
                                    </div>
                                </div>

                                <!-- Purpose Textarea -->
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label for="purpose" class="form-label fw-medium">How can we help you?*</label>
                                        <textarea class="form-control border-0 border-bottom rounded-0 px-0 py-2" 
                                                name="purpose" id="purpose" rows="4" required></textarea>
                                        <div class="invalid-feedback">
                                            Please describe how we can help you.
                                        </div>
                                    </div>
                                </div>

                                <!-- Drag & Drop Section -->
                                <div class="col-12">
                                    <div class="drag-drop-section mb-4">
                                        <label class="form-label fw-medium mb-3">Attach Files (Optional)</label>
                                        <div class="border-2 border-dashed border-secondary rounded-3 p-4 text-center drag-drop-area" 
                                            id="dragDropArea">
                                            <div class="py-4">
                                                <i class="fas fa-cloud-upload-alt fs-1 text-muted mb-3"></i>
                                                <h5 class="mb-2">Drag & Drop Files Here</h5>
                                                <p class="text-muted mb-3">or</p>
                                                <button type="button" class="btn btn-outline-dark rounded-0 px-4" 
                                                        onclick="document.getElementById('fileInput').click()">
                                                    Browse Files
                                                </button>
                                                <p class="small text-muted mt-3 mb-0">
                                                    Supported formats: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)
                                                </p>
                                            </div>
                                            <input type="file" class="d-none" id="fileInput" multiple>
                                        </div>
                                        <div class="file-list mt-3" id="fileList"></div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn bg-warning w-100 py-3 rounded-0 fw-bold">
                                        SUBMIT YOUR MESSAGE
                                    </button>
                                    <p class="text-center text-muted mt-3 small">
                                        **By submitting, the data provided will be used to perform your request according to the Privacy Policy
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?=$this->include('templates/footer');?>