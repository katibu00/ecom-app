@extends('layouts.app')
@section('PageTitle', 'Schools')

@section('css')
<link rel="stylesheet" href="/vendor/select2/css/select2.min.css">
<link href="/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Schools</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Add New School</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
  
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Register a New School</h5>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <ul id="error_list"></ul>
                            <form id="new_school_form" method="POST" enctype="multipart/form-data">

                                <div class="mb-3 row">
                                    <div class="col-md-12">
                                        <div class="profile-img-edit">
                                            <img class="profile-pic" width="150" height="150" src="/uploads/no-image.jpg" alt="school logo">
                                            <div class="p-image">
                                            <i class="fa fa-pencil  upload-button"></i>
                                            <input class="file-upload" type="file" accept="image/*" name="logo" />
                                            </div>
                                        </div>
                                    </div>
                                 </div>


                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">School Name <span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" placeholder="School Name">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Username<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Motto</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="motto" placeholder="Motto">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">State<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <select
                                            onchange="toggleLGA(this);"
                                            name="state"
                                            id="state"
                                            class="form-select"
                                            >
                                            <option value="" selected="selected">- Select State-</option>
                                            <option value="Abia" {{ @$application->state == "Abia"? 'selected':'' }}>Abia</option>
                                            <option value="Adamawa" {{ @$application->state == "Adamawa"? 'selected':'' }}>Adamawa</option>
                                            <option value="AkwaIbom" {{ @$application->state == "AkwaIbom"? 'selected':'' }}>AkwaIbom</option>
                                            <option value="Anambra" {{ @$application->state == "Anambra"? 'selected':'' }}>Anambra</option>
                                            <option value="Bauchi" {{ @$application->state == "Bauchi"? 'selected':'' }}>Bauchi</option>
                                            <option value="Bayelsa" {{ @$application->state == "Bayelsa"? 'selected':'' }}>Bayelsa</option>
                                            <option value="Benue" {{ @$application->state == "Benue"? 'selected':'' }}>Benue</option>
                                            <option value="Borno" {{ @$application->state == "Borno"? 'selected':'' }}>Borno</option>
                                            <option value="Cross River" {{ @$application->state == "Cross River"? 'selected':'' }}>Cross River</option>
                                            <option value="Delta" {{ @$application->state == "Delta"? 'selected':'' }}>Delta</option>
                                            <option value="Ebonyi" {{ @$application->state == "Ebonyi"? 'selected':'' }}>Ebonyi</option>
                                            <option value="Edo" {{ @$application->state == "Edo"? 'selected':'' }}>Edo</option>
                                            <option value="Ekiti" {{ @$application->state == "Ekiti"? 'selected':'' }}>Ekiti</option>
                                            <option value="Enugu" {{ @$application->state == "Enugu"? 'selected':'' }}>Enugu</option>
                                            <option value="FCT" {{ @$application->state == "FCT"? 'selected':'' }}>FCT</option>
                                            <option value="Gombe" {{ @$application->state == "Gombe"? 'selected':'' }}>Gombe</option>
                                            <option value="Imo" {{ @$application->state == "Imo"? 'selected':'' }}>Imo</option>
                                            <option value="Jigawa" {{ @$application->state == "Jigawa"? 'selected':'' }}>Jigawa</option>
                                            <option value="Kaduna" {{ @$application->state == "Kaduna"? 'selected':'' }}>Kaduna</option>
                                            <option value="Kano" {{ @$application->state == "Kano"? 'selected':'' }}>Kano</option>
                                            <option value="Katsina" {{ @$application->state == "Katsina"? 'selected':'' }}>Katsina</option>
                                            <option value="Kebbi" {{ @$application->state == "Kebbi"? 'selected':'' }}>Kebbi</option>
                                            <option value="Kogi" {{ @$application->state == "Kogi"? 'selected':'' }}>Kogi</option>
                                            <option value="Kwara" {{ @$application->state == "Kwara"? 'selected':'' }}>Kwara</option>
                                            <option value="Lagos" {{ @$application->state == "Lagos"? 'selected':'' }}>Lagos</option>
                                            <option value="Nasarawa" {{ @$application->state == "Nasarawa"? 'selected':'' }}>Nasarawa</option>
                                            <option value="Niger" {{ @$application->state == "Niger"? 'selected':'' }}>Niger</option>
                                            <option value="Ogun" {{ @$application->state == "Ogun"? 'selected':'' }}>Ogun</option>
                                            <option value="Ondo" {{ @$application->state == "Ondo"? 'selected':'' }}>Ondo</option>
                                            <option value="Osun" {{ @$application->state == "Osun"? 'selected':'' }}>Osun</option>
                                            <option value="Oyo" {{ @$application->state == "Oyo"? 'selected':'' }}>Oyo</option>
                                            <option value="Plateau" {{ @$application->state == "Plateau"? 'selected':'' }}>Plateau</option>
                                            <option value="Rivers" {{ @$application->state == "Rivers"? 'selected':'' }}>Rivers</option>
                                            <option value="Sokoto" {{ @$application->state == "Sokoto"? 'selected':'' }}>Sokoto</option>
                                            <option value="Taraba" {{ @$application->state == "Taraba"? 'selected':'' }}>Taraba</option>
                                            <option value="Yobe" {{ @$application->state == "Yobe"? 'selected':'' }}>Yobe</option>
                                            <option value="Zamfara" {{ @$application->state == "Zamfara"? 'selected':'' }}>Zamafara</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">LGA<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <select name="lga" id="lga" class="form-select select-lga"></select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Address<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="address" placeholder="Full Address">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">School Email<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="school_email" placeholder="School Email">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Phone Number<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="tel" class="form-control" name="school_phone" placeholder="School Mobile Phone Number">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Alternate Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="tel" class="form-control" name="alternate_phone" placeholder="Alternate Phone Number">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Web Address<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="website" placeholder="Web Address">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Service Fee/Student<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="service_fee" placeholder="Negociated Service Fee/Student">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Heading<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <select class="default-select form-control wide mb-3" name="heading">
											<option></option>
											<option value="h1">H1</option>
											<option value="h2">H2</option>
											<option value="h3">H3</option>
											<option value="h4">H4</option>
											<option value="h5">H5</option>
											<option value="h6">H6</option>
										</select>
                                    </div>
                                </div>


                                <h5>School Admin</h5>

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Title<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <select class="default-select form-control wide mb-3" name="title">
											<option value="Mr.">Mr.</option>
											<option value="Alh.">Alh.</option>
											<option value="Dr.">Dr.</option>
											<option value="Prof.">Prof.</option>
											<option value="Rev.">Rev.</option>
											<option value="Mall.">Mall.</option>
											<option value="Pastor">Pastor</option>
											<option value="Uncle">Uncle</option>
										</select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Surname<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="surname" placeholder="Surname">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Other Names<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="othernames" placeholder="Other Names">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Rank<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <select class="default-select form-control wide mb-3" name="rank">
											<option></option>
											<option value="Principal">Principal</option>
											<option value="Director">Director</option>
											<option value="ICT Admin">ICT Admin</option>
											<option value="Proprietor">Proprietor</option>
										</select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Email<span class="text-danger"> *</span></label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="admin_email" placeholder="Active Email">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Phone number</label>
                                    <div class="col-sm-9">
                                        <input type="tel" class="form-control" name="admin_phone" placeholder="Phone Number">
                                    </div>
                                </div>

                              

                                <div class="mb-3 row">
                                    <div class="col-sm-10">
                                        <button type="submit" id="submit_btn" class="btn btn-primary d-block">Register School</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
  
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="/vendor/select2/js/select2.full.min.js"></script>
<script src="/js/plugins-init/select2-init.js"></script>
<script src="/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="/lga/lga.min.js"></script>
<script>
    $(document).ready(function() {
    
        
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function (e) {
                    $('.profile-pic').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        
    
        $(".file-upload").on('change', function(){
            readURL(this);
        });
        
        $(".upload-button").on('click', function() {
           $(".file-upload").click();
        });
    
    
        $(document).on('submit', '#new_school_form', function(e){
            e.preventDefault();
            
            let formData = new FormData($('#new_school_form')[0]);
    
            spinner = '<div class="spinner-border" style="height: 20px; width: 20px;" role="status"><span class="sr-only">Loading...</span></div> Submitting . . .'
                     $('#submit_btn').html(spinner);
                     $('#submit_btn').attr("disabled", true);
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                type: "POST",
                url: "{{ route('school.admin.create') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                  
                    if(response.status == 400){
                            $('#error_list').html("");
                            $('#error_list').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err){
                                $('#error_list').append('<li>'+err+'</li>');
                            });
                            $('#submit_btn').text("Register School");
                            $('#submit_btn').attr("disabled", false);
                            Command: toastr["error"]("Some Fields are required. Please check your input and try again.")
    
                            toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                            }
                        }
    
                        if(response.status == 201){
                            Command: toastr["success"](response.message)
                            toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                            }
                            window.location.replace('{{ route('schools.index') }}'); 
                        }
                }
            })
    
        })
    
    
    });
    </script>

@endsection