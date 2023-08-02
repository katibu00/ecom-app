<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="/assets/" data-template="horizontal-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Signup your School | IntelPS</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->

            <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-xxl">
                    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                        <a href="https://intelps.cloud" class="app-brand-link gap-2">
                            <img src="/logos/v1.png" width="100" alt="intellisas logo">
                        </a>

                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                            <i class="ti ti-x ti-sm align-middle"></i>
                        </a>
                    </div>

                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ti ti-menu-2 ti-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">


                            <!-- Search -->
                            <li class="nav-item navbar-search-wrapper me-2 me-xl-0">
                                <a class="nav-link search-toggler" href="javascript:void(0);">
                                    <i class="ti ti-search ti-md"></i>
                                </a>
                            </li>
                            <!-- /Search -->

                            <!-- Style Switcher -->
                            <li class="nav-item me-2 me-xl-0">
                                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                                    <i class="ti ti-md"></i>
                                </a>
                            </li>
                            <!--/ Style Switcher -->

                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
                        <input type="text" class="form-control search-input border-0" placeholder="Search..."
                            aria-label="Search..." />
                        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
                    </div>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">


                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Default -->
                        <div class="row">

                            <!-- Default Wizard -->
                            <div class="col-12 mb-4">
                                <div class="bs-stepper wizard-numbered mt-2">
                                    <div class="bs-stepper-header">
                                        <!-- Step 1: School Information -->
                                        <div class="step" data-target="#school-information">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">School Information</span>
                                                    <span class="bs-stepper-subtitle">Enter School Details</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="line">
                                            <i class="ti ti-chevron-right"></i>
                                        </div>
                                        <!-- Step 2: Administrator Details -->
                                        <div class="step" data-target="#administrator-details">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">Administrator Details</span>
                                                    <span class="bs-stepper-subtitle">Enter Admin Info</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="line">
                                            <i class="ti ti-chevron-right"></i>
                                        </div>
                                        <!-- Step 3: Account Setup -->
                                        <div class="step" data-target="#legal-agreements">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-circle">3</span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">Legal Agreements</span>
                                                    <span class="bs-stepper-subtitle">Review and Accept Legal
                                                        Agreements</span>
                                                </span>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="bs-stepper-content">

                                        <div class="alert alert-danger d-none" id="error-container">
                                            <ul class="mb-0"></ul>
                                        </div>
                                        <form id="signupForm" method="post">
                                            <!-- Step 1: School Information -->
                                            <div id="school-information" class="content">
                                                <div class="content-header mb-3">
                                                    <h6 class="mb-0">School Information</h6>
                                                    <small>Enter Your School Details.</small>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="school_name">School
                                                            Name</label>
                                                        <input type="text" id="school_name" name="school_name"
                                                            class="form-control" placeholder="Enter school name" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="school_address">School
                                                            Address</label>
                                                        <input type="text" id="school_address"
                                                            name="school_address" class="form-control"
                                                            placeholder="Enter school address" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="school_username">School
                                                            Username</label>
                                                        <small class="form-text text-muted">unique username to access
                                                            your school portal. Example: username.intelps.cloud</small>
                                                        <input type="text" id="school_username"
                                                            name="school_username" class="form-control"
                                                            placeholder="Enter school username" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="school_website">School
                                                            URL</label>
                                                        <input type="text" id="school_website"
                                                            name="school_website" class="form-control"
                                                            placeholder="Enter school website (optional)" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="school_phone">School Phone
                                                            Number</label>
                                                        <input type="text" id="school_phone" name="school_phone"
                                                            class="form-control"
                                                            placeholder="Enter school phone number" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="school_email">School
                                                            Email</label>
                                                        <input type="text" id="school_email" name="school_email"
                                                            class="form-control" placeholder="Enter school Email" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="country">Country</label>
                                                        <select class="form-select" id="country" name="country">
                                                            <option value=""></option>
                                                            <option value="Nigeria">Nigeria</option>
                                                            <option value="Ghana">Ghana</option>
                                                            <option value="Benin">Benin</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label"
                                                            for="state">State/Province</label>
                                                        <input type="text" id="state" class="form-control"
                                                            placeholder="Enter state/province" />
                                                    </div>
                                                    <!-- Add more school information fields here -->
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <button type="button"
                                                            class="btn btn-label-secondary btn-prev">
                                                            <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                                            <span
                                                                class="align-middle d-sm-inline-block d-none">Previous</span>
                                                        </button>
                                                        <button type="button" class="btn btn-primary btn-next">
                                                            <span
                                                                class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                            <i class="ti ti-arrow-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Step 2: Administrator Details -->
                                            <div id="administrator-details" class="content">
                                                <div class="content-header mb-3">
                                                    <h6 class="mb-0">Administrator Details</h6>
                                                    <small>Enter Your Admin Info.</small>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="first_name">First Name</label>
                                                        <input type="text" id="first_name" name="first_name"
                                                            class="form-control" placeholder="Enter first name" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="last_name">Last Name</label>
                                                        <input type="text" id="last_name" name="last_name"
                                                            class="form-control" placeholder="Enter last name" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="email">Email Address</label>
                                                        <input type="email" id="email" name="email"
                                                            class="form-control" placeholder="Enter email address" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="phone">Phone Number</label>
                                                        <input type="text" id="phone" name="phone"
                                                            class="form-control" placeholder="Enter phone number" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="password">Password</label>
                                                        <input type="password" id="password" name="password"
                                                            class="form-control" placeholder="Enter password" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="confirm_password">Confirm
                                                            Password</label>
                                                        <input type="password" id="confirm_password"
                                                            name="confirm-password" class="form-control"
                                                            placeholder="Confirm password" />
                                                    </div>
                                                    <!-- Add more administrator details fields here -->
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <button type="button"
                                                            class="btn btn-label-secondary btn-prev">
                                                            <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                                            <span
                                                                class="align-middle d-sm-inline-block d-none">Previous</span>
                                                        </button>
                                                        <button type="button" class="btn btn-primary btn-next">
                                                            <span class="align-middle">Next</span>
                                                            <i class="ti ti-arrow-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Step 3: Account Setup -->
                                            <div id="legal-agreements" class="content">
                                                <div class="content-header mb-3">
                                                    <h6 class="mb-0">Legal Agreements</h6>
                                                    <small>Review and Accept Legal Agreements.</small>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-sm-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="agree_terms" name="agree_terms" />
                                                            <label class="form-check-label" for="agree_terms">
                                                                I agree to the <a href="#">Legal Terms</a> and <a
                                                                    href="#">Terms of Use</a>.
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- Add the additional checkbox here -->
                                                    <div class="col-sm-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="decision_on_behalf" name="decision_on_behalf" />
                                                            <label class="form-check-label" for="decision_on_behalf">
                                                                I am making this decision on behalf of my school, and
                                                                the entire school will adopt and use the software.
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <button type="button"
                                                            class="btn btn-label-secondary btn-prev">
                                                            <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                                            <span
                                                                class="align-middle d-sm-inline-block d-none">Previous</span>
                                                        </button>
                                                        <button type="submit"
                                                            class="btn btn-success btn-submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>



                            <!-- /Default Wizard -->




                        </div>
                        <hr class="container-m-nx mb-5" />

                    </div>
                    <!--/ Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                                <div>
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    <a href="#" target="_blank" class="fw-semibold">IntelliSAS limited</a>
                                </div>
                                <div>
                                    <a href="#" class="footer-link me-4" target="_blank">Terms of Use</a>
                                    <a href="#" target="_blank" class="footer-link me-4">Privacy Policy</a>

                                    <a href="https://help.intelps.cloud" target="_blank"
                                        class="footer-link me-4">Knowledge Base</a>

                                    <a href="#" target="_blank"
                                        class="footer-link d-none d-sm-inline-block">Support</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/bs-stepper/bs-stepper.js"></script>

    <script src="/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->

    <script src="/assets/js/form-wizard-numbered.js"></script>

    <!-- Include the Toastify library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            // Form submission via AJAX
            $("#signupForm").on("submit", function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                $.ajax({
                    url: "signup", // Replace with your backend URL
                    type: "POST",
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                    },
                    success: function(response) {

                        Toastify({
                            text: "Registration successful",
                            duration: 2000, // 2 seconds
                            close: true,
                            gravity: "top", // Position on the top
                            backgroundColor: "green",
                        }).showToast();

                        // Redirect after 2 seconds
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.home') }}";
                        }, 2000);

                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        // For example, display validation errors on the frontend
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            // Clear any existing error messages
                            $("#error-container ul").empty();

                            // Remove the "is-invalid" class from all form control elements
                            $(".form-control").removeClass("is-invalid");

                            $.each(errors, function(field, messages) {
                                var formControl = $("#" +
                                    field
                                    ); // Make sure 'field' matches the IDs in the HTML
                                formControl.addClass("is-invalid");

                                // Append each error message to the error container
                                $.each(messages, function(index, message) {
                                    $("#error-container ul").append("<li>" +
                                        message + "</li>");
                                });
                            });

                            // Show the error container
                            $("#error-container").removeClass("d-none");
                        }
                    },
                });
            });

            // Custom logic to append username.intelps.cloud to the school URL field
            $("#school-username").on("change", function() {
                var schoolUsername = $(this).val();
                var schoolURLField = $("#school-website");
                if (schoolUsername) {
                    var schoolURL = "https://" + schoolUsername + ".intelps.cloud";
                    schoolURLField.val(schoolURL);
                } else {
                    schoolURLField.val("");
                }
            });
        });
    </script>


</body>

</html>
