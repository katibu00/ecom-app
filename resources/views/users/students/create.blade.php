@extends('layouts.app')
@section('PageTitle', 'Schools')

@section('css')
<link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ route('users.students.index') }}">Students</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Register new Students</a></li>
            </ol>
        </div>
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
                                            <div class="col-lg-4">
                                                <select class="form-control wide mb-3" name="class_id" required>
                                                    <option value="">--Select Class--</option>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-2 row">
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control input-default" name="first_name[]" placeholder="First Name" required>
                                            </div>
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control input-default" name="middle_name[]" placeholder="Middle Name">     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control input-default" name="last_name[]" placeholder="Last Name" required>     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control input-default" name="roll_number[]" placeholder="Role number" required>     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <select class="default-select form-control wide mb-3" name="gender[]" required>
                                                    <option value="m">Male</option>
                                                    <option value="f">Female</option>
                                                </select>     
                                            </div>                                 
                                            <div class="col-lg-2">
                                                <span class="btn btn-success btn-sm addeventmore "><i class="fa fa-plus-circle"></i></span>
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
                                        <input type="text" class="form-control input-default" name="first_name[]" placeholder="First Name" required>
                                    </div>
                                    <div class="col-lg-2 mb-2">
                                        <input type="text" class="form-control input-default" name="middle_name[]" placeholder="Middle Name">     
                                    </div>                                 
                                    <div class="col-lg-2 mb-2">
                                        <input type="text" class="form-control input-default" name="last_name[]" placeholder="Last Name" required>     
                                    </div>                                 
                                    <div class="col-lg-2 mb-2">
                                        <input type="text" class="form-control input-default" name="roll_number[]" placeholder="Role number" required>     
                                    </div>                                 
                                    <div class="col-lg-2 mb-2">
                                        <select class="default-select form-control wide mb-3" name="gender[]" required>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>     
                                    </div>                
                                    <div class="col-lg-2 mb-2 d-flex">
                                        <span class="btn btn-success btn-sm addeventmore m-2"><i class="fa fa-plus-circle"></i></span>
                                        <span class="btn btn-danger btn-sm removeeventmore m-2"><i class="fa fa-minus-circle"></i></span>
                                    </div>
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