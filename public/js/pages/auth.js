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
                        window.location.replace('http://localhost:8000/intellisas/home');
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
                        //    window.location.replace('{{ route('login') }}');
                    }, 2000);
                }
            },
        });
    });
});
