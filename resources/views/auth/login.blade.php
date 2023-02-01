<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/"
  data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <meta name="csrf-token" content="{{ csrf_token() }}">
   
    <title>Login | IntelS</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.lico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    {{-- <link rel="stylesheet" href="/assets/vendor/fonts/fontawesome.css" /> --}}
    <link rel="stylesheet" href="/assets/vendor/fonts/tabler-icons.css" />
    {{-- <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" /> --}}

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    {{-- <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" /> --}}
    <!-- Vendor -->
    {{-- <link rel="stylesheet" href="/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" /> --}}

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <script src="/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <!-- Login -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-4 mt-2">
                <a href="index.html" class="app-brand-link gap-2">
                  {{-- <span class="app-brand-logo demo">
                    JSR
                  </span> --}}
                  <span class="app-brand-text demo text-body fw-bold ms-1">IntelS</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1 pt-2">Welcome to IntelS! 👋</h4>
              {{-- <p class="mb-4">Please sign-in to your account and start the adventure</p> --}}
              <ul id="error_list"></ul>
              <form id="login_form" class="mb-3">
                <div class="mb-3">
                  <label for="email" class="form-label">Email or Login ID</label>
                  <input
                    type="text"
                    class="form-control"
                    id="login"
                    name="login"
                    placeholder="Enter your email or Login ID"
                    autofocus
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <a href="#">
                      <small>Forgot Password?</small>
                    </a>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" />
                    <label class="form-check-label" for="remember"> Remember Me </label>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100 login_btn" type="submit">Sign in</button>
                </div>
              </form>

              {{-- <p class="text-center">
                <span>New on our platform?</span>
                <a href="#">
                  <span>Create an account</span>
                </a>
              </p> --}}
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    {{-- <script src="/assets/vendor/libs/popper/popper.js"></script> --}}
    <script src="/assets/vendor/js/bootstrap.js"></script>
    {{-- <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script> --}}
    {{-- <script src="/assets/vendor/libs/node-waves/node-waves.js"></script> --}}

    {{-- <script src="/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script> --}}

    <script src="/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    {{-- <script src="/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script> --}}

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/pages-auth.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on("submit", "#login_form", function(e) {
                e.preventDefault();
                var data = {
                    login: $("#login").val(),
                    password: $("#password").val(),
                    remember: $("#remember").prop("checked") == true ? 1 : 0,
                };
                spinner =
                    '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only"></span></div>';
                $(".login_btn").html(spinner);
                $(".login_btn").attr("disabled", true);

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                $.ajax({
                    type: "POST",
                    url: "/login",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $("#error_list").html("");
                            $("#error_list").addClass("alert alert-danger");
                            $.each(response.errors, function(key, err) {
                                $("#error_list").append("<li>" + err + "</li>");
                            });
                            $(".login_btn").text("Login");
                            $(".login_btn").attr("disabled", false);
                        }
                        if (response.status == 401) {
                            $("#error_list").html("");
                            $("#error_list").addClass("alert alert-danger");
                            $("#error_list").append("<li>" + response.message + "</li>");
                            $(".login_btn").text("Login");
                            $(".login_btn").attr("disabled", false);
                        }
                        if (response.status == 200) {
                            $("#error_list").html("");
                            $("#error_list").removeClass("alert alert-danger");
                            $("#error_list").addClass("alert alert-success");
                            $("#error_list").append(
                                "<li>Login Successful. Redirecting to Dashboard. . .</li>"
                            );

                           
                            if (response.user == 'admin') {
                                window.location.replace('{{ route('admin.home') }}');
                            }
                            if (response.user == 'intellisas') {
                                window.location.replace('{{ route('intellisas.home') }}');
                            }
                           

                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        if (xhr.status === 419) {
                            Command: toastr["error"](
                                "Session expired. please login again."
                            );
                            toastr.options = {
                                closeButton: false,
                                debug: false,
                                newestOnTop: false,
                                progressBar: false,
                                positionClass: "toast-top-right",
                                preventDuplicates: false,
                                onclick: null,
                                showDuration: "300",
                                hideDuration: "1000",
                                timeOut: "5000",
                                extendedTimeOut: "1000",
                                showEasing: "swing",
                                hideEasing: "linear",
                                showMethod: "fadeIn",
                                hideMethod: "fadeOut",
                            };

                            setTimeout(() => {
                                window.location.replace('{{ route('login') }}');
                            }, 2000);
                        }
                    },
                });
            });
        });
    </script>
  </body>
</html>
