@extends('layouts.app')
@section('PageTitle', 'Result Settings')
@section('css')
    <link href="/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Result Settings</h4>

                        </div>
                        <div class="card-body my-1 py-50">
                            <form id="settings_form">

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Show Position</label>
                                    <div class="col-sm-9">
                                        <div class="form-check toggle-switch text-end form-switch me-4">
                                            <input class="form-check-input" {{ $settings->show_position == 1? 'checked': ''}} type="checkbox" id="show_position">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Show Attendance</label>
                                    <div class="col-sm-9">
                                        <div class="form-check toggle-switch text-end form-switch me-4">
                                            <input class="form-check-input"  {{ $settings->show_attendance == 1? 'checked': ''}} type="checkbox" id="show_attendance">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Show Passport</label>
                                    <div class="col-sm-9">
                                        <div class="form-check toggle-switch text-end form-switch me-4">
                                            <input class="form-check-input"  {{ $settings->show_passport == 1? 'checked': ''}} type="checkbox" id="show_passport">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Withhold Defaulter's Result</label>
                                    <div class="col-sm-9">
                                        <div class="form-check toggle-switch text-end form-switch me-4">
                                            <input class="form-check-input"  {{ $settings->withhold == 1? 'checked': ''}} type="checkbox" id="withhold">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row {{ $settings->withhold == 1? '': 'd-none'}}" id="minimun_amount_div">
                                    <label class="col-sm-3 col-form-label">Minimun Amount</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" value="{{ @$settings->minimun_amount }}" type="number" id="minimun_amount"
                                            placeholder="Amount Below which to hold Result">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Grading Style</label>
                                    <div class="col-sm-3">
                                        <select class="default-select  form-control wide" id="grading_style">
                                            <option value="waec"  {{ $settings->grading_style == 'waec'? 'selected': ''}}>WAEC</option>
                                            <option value="standard" {{ $settings->grading_style == 'standard'? 'selected': ''}}>Standard</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary submit_btn">Save Changes</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script src="/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    <script src="/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    {!! Toastr::message() !!}

    <script>
        $(document).ready(function() {

            //submit form
            $(document).on("submit", "#settings_form", function(e) {
                e.preventDefault();
                var data = {
                    show_position: $("#show_position").prop("checked") == true ? 1 : 0,
                    show_attendance: $("#show_attendance").prop("checked") == true ? 1 : 0,
                    show_passport: $("#show_passport").prop("checked") == true ? 1 : 0,
                    withhold: $("#withhold").prop("checked") == true ? 1 : 0,
                    minimun_amount: $("#minimun_amount").val(),
                    grading_style: $("#grading_style").val(),
                };
              
                spinner =
                    '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only">Loading...</span></div>Saving. . .';
                $(".submit_btn").html(spinner);
                $(".submit_btn").attr("disabled", true);

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('result.settings') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        
                        if (response.status == 200) {
                           
                            Command: toastr["success"](
                                response.message
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
                            $(".submit_btn").html("Save Changes");
                            $(".submit_btn").attr("disabled", false);
                           
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

            //click on withhold
            $(document).on("click", "#withhold", function() {

                if($(this).prop("checked") == true)
                {
                    $('#minimun_amount_div').removeClass('d-none');
                }else{
                    $('#minimun_amount_div').addClass('d-none');
                }
            
            });


        });
    </script>

@endsection
