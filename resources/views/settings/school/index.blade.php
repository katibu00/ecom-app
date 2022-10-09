@extends('layouts.app')
@section('PageTitle', 'School Settings')

@section('css')
<link rel="stylesheet" href="/vendor/select2/css/select2.min.css">
<link href="/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
@endsection

@section('content')

  <div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center mb-3">
            <div class="mb-3 me-auto">
                <div class="card-tabs style-1 mt-3 mt-sm-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);" data-bs-toggle="tab" id="transaction-tab" data-bs-target="#AllTransaction" role="tab">Basic Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="tab" id="Completed-tab" data-bs-target="#Completed" role="tab">Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="tab" id="Pending-tab" data-bs-target="#Pending" role="tab">Result</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="tab" id="Canceled-tab" data-bs-target="#Canceled" role="tab">Admission</a>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- <a href="javascript:void(0);" class="btn btn-outline-primary mb-3"><i class="fa fa-calendar me-3 scale3"></i>Filter Date</a> --}}
        </div>
        <div class="row">
            <div class="col-xl-12 tab-content">
                <div class="tab-pane fade show active" id="AllTransaction" role="tabpanel" aria-labelledby="transaction-tab">
                    
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Basic School Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <ul id="error_list"></ul>
                                    <form id="edit_school_form" method="POST" enctype="multipart/form-data">
        
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
                                                <input type="text" class="form-control" name="name" value="{{ $school->name }}" placeholder="School Name">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Username</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="username" value="{{ $school->username }}" placeholder="Username" disabled>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Motto</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="motto" value="{{ $school->motto }}" placeholder="Motto">
                                            </div>
                                        </div>
                                       
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Address<span class="text-danger"> *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="address" value="{{ $school->address }}" placeholder="Full Address">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">School Email<span class="text-danger"> *</span></label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="school_email" value="{{ $school->email }}" placeholder="School Email">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Phone Number<span class="text-danger"> *</span></label>
                                            <div class="col-sm-9">
                                                <input type="tel" class="form-control" name="school_phone" value="{{ $school->phone_first }}" placeholder="School Mobile Phone Number">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Alternate Phone Number</label>
                                            <div class="col-sm-9">
                                                <input type="tel" class="form-control" name="alternate_phone" value="{{ $school->phone_second }}" placeholder="Alternate Phone Number">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Web Address<span class="text-danger"> *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="website" value="{{ $school->website }}" placeholder="Web Address">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Session<span class="text-danger"> *</span><a href=""><small class="text-danger"><cite title="Create a new session"> Create a new session</cite></small></a></label>
                                            <div class="col-sm-9">
                                                <select class="default-select form-control wide mb-3" name="session_id">
                                                    <option></option>
                                                    @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}" {{$school->session_id == $session->id ? 'selected' : ''}}>{{ $session->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Term<span class="text-danger"> *</span></label>
                                            <div class="col-sm-9">
                                                <select class="default-select form-control wide mb-3" name="term">
                                                    <option></option>
                                                    <option value="first" {{$school->term == 'first' ? 'selected' : ''}}>First</option>
                                                    <option value="second" {{$school->term == 'second' ? 'selected' : ''}}>Second</option>
                                                    <option value="third" {{$school->term == 'third' ? 'selected' : ''}}>Third</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Service Fee/Student</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="service_fee" value="{{ $school->service_fee }}" placeholder="Negociated Service Fee/Student" disabled>
                                            </div>
                                        </div>
        
                                      
        
                                        <div class="mb-3 row">
                                            <div class="col-sm-10">
                                                <button type="submit" id="submit_btn" class="btn btn-primary d-block">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
               
                </div>


                <div class="tab-pane fade" id="Completed" role="tabpanel" aria-labelledby="Completed-tab">
                   
                </div>
                <div class="tab-pane fade" id="Pending" role="tabpanel" aria-labelledby="Pending-tab">
                 
                </div>
                <div class="tab-pane fade" id="Canceled" role="tabpanel" aria-labelledby="Canceled-tab">
                   
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
@include('settings.school.script')
@endsection