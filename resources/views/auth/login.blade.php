<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Dompet : Payment Admin Template" />
	<meta property="og:title" content="Dompet : Payment Admin Template" />
	<meta property="og:description" content="Dompet : Payment Admin Template" />
	<meta property="og:image" content="https://dompet.dexignlab.com/xhtml/social-image.png" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE -->
	<title>IntelliSAS : Login</title>
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <link href="./css/style.css" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="index.html"><img src="images/logo-full.png" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <ul id="error_list"></ul>
                                    <form action="">
                                        <div class="mb-3">
                                            <label class="mb-1" for="login"><strong>Email/Login ID</strong></label>
                                            <input type="email" class="form-control" id="login" placeholder="Enter your Email/Login ID">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1" for="password"><strong>Password</strong></label>
                                            <input type="password" class="form-control" id="password" placeholder="******">
                                        </div>
                                        <div class="row d-flex justify-content-between mt-4 mb-2">
                                            <div class="mb-3">
                                               <div class="form-check custom-checkbox ms-1">
													<input type="checkbox" class="form-check-input" id="remember">
													<label class="form-check-label" for="remember">Remember me</label>
												</div>
                                            </div>
                                            <div class="mb-3">
                                                <a href="#">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block login_btn">Sign Me In</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="#">Sign up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/custom.min.js"></script>
    <script src="./js/dlabnav-init.js"></script>
    {{-- <script src="./js/pages/auth.js"></script> --}}
    <script>
        $(document).ready(function () {
    $(document).on("click", ".login_btn", function (e) {
        e.preventDefault();
        var data = {
            login: $("#login").val(),
            password: $("#password").val(),
            remember: $("#remember").prop("checked") == true ? 1 : 0,
        };
        spinner =
            '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only">Loading...</span></div>';
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
            success: function (response) {
                if (response.status == 400) {
                    $("#error_list").html("");
                    $("#error_list").addClass("alert alert-danger");
                    $.each(response.errors, function (key, err) {
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

                    if(response.user == 'intellisas'){
                        window.location.replace('{{ route('intellisas.home') }}');
                    }
                    if(response.user == 'admin'){
                        window.location.replace('{{ route('admin.home') }}');
                    }
                    
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
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