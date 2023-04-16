@extends('layouts.app')
@section('PageTitle', 'Result Settings')


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row mb-5">

            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements  d-flex flex-row">
                            <h5 class="m-0 me-2 d-none d-md-block">Result Settings</h5>
                        </div>


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
                                <label class="col-sm-3 col-form-label" for="show_scores">Show Highest, Lowest and Average Scores</label>
                                <div class="col-sm-9">
                                    <div class="form-check toggle-switch text-end form-switch me-4">
                                        <input class="form-check-input"  {{ $settings->show_scores == 1? 'checked': ''}} type="checkbox" id="show_scores">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label" for="break_ca">Break CA</label>
                                <div class="col-sm-9">
                                    <div class="form-check toggle-switch text-end form-switch me-4">
                                        <input class="form-check-input"  {{ $settings->break_ca == 1? 'checked': ''}} type="checkbox" id="break_ca">
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
                                    <select class="form-select" id="grading_style">
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

@endsection


@section('js')

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
                    show_scores: $("#show_scores").prop("checked") == true ? 1 : 0,
                    break_ca: $("#break_ca").prop("checked") == true ? 1 : 0,
                };
              
                spinner =
                    '<div class="spinner-border" style="height: 15px; width: 15px;" role="status"></div>&nbsp; Saving. . .';
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
