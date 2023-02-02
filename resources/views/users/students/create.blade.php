@extends('layouts.app')
@section('PageTitle', 'Register New Students')



@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
       
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Register new Students</h4>
                    </div>
                    <div class="card-body">

                        <form id="create_data_form">
                            <ul id="error_list"></ul>
                            <div class="add_item">
                                <div class="row">
                                    <div class="col-xl-12">

                                        <div class="mb-2 row">
                                            <div class="col-lg-2">
                                                <select class="form-select form-select-sm" name="class_id" required>
                                                    <option value="">-- Class--</option>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <select class="form-select form-select-sm" name="class_section_id" required>
                                                    <option value="">-- Class Section--</option>
                                                    @foreach ($class_sections as $section)
                                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="first_name[]" placeholder="First Name" required>
                                            </div>
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="middle_name[]" placeholder="Middle Name">     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="last_name[]" placeholder="Last Name" required>     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="roll_number[]" placeholder="Role number" required>     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <select class="form-select form-select-sm" name="gender[]" required>
                                                    <option value="m">Male</option>
                                                    <option value="f">Female</option>
                                                </select>     
                                            </div>                                 
                                            <div class="col-lg-2">
                                                <span class="btn btn-success btn-sm addeventmore "><i class="tf-icon ti ti-plus me-2"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submit_btn" class="btn btn-primary">Submit</button>
                                </div>
                            </div> 
                        </form>
                       
                    </div>
                </div>
            </div>



            <div style="visibility: hidden;">
                <div class="whole_extra_item_add" id="whole_extra_item_add">
                    <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
            
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="mb-2 row">
                                    <div class="col-lg-2 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="first_name[]" placeholder="First Name" required>
                                    </div>
                                    <div class="col-lg-2 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="middle_name[]" placeholder="Middle Name">     
                                    </div>                                 
                                    <div class="col-lg-2 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="last_name[]" placeholder="Last Name" required>     
                                    </div>                                 
                                    <div class="col-lg-2 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="roll_number[]" placeholder="Role number" required>     
                                    </div>                                 
                                    <div class="col-lg-2 mb-2">
                                        <select class="form-select form-select-sm" name="gender[]" required>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>     
                                    </div>                
                                    <div class="col-lg-2 mb-2">
                                        <span class="btn btn-success btn-sm addeventmore"><i class="tf-icon ti ti-plus"></i></span>
                                        <span class="btn btn-danger btn-sm removeeventmore"><i class="tf-icon ti ti-minus"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                    </div>
                </div>
            
            </div>


          
        </div>
</div>
@endsection

@section('js')
@include('users.students.script')
@endsection