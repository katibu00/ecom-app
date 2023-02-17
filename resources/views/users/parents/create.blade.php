@extends('layouts.app')
@section('PageTitle', 'Register Staffs')

@section('css')
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
       
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Register new Staffs</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('users.parents.store') }}" method="POST">
                            @csrf
                            <div class="add_item">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="mb-2 row">
                                            <div class="col-lg-2 mb-2">
                                                <select class="form-select form-select-sm" name="title" required>
                                                    <option value="Mr.">Mr.</option>
                                                    <option value="Mrs.">Mrs.</option>
                                                    <option value="Alh.">Alh.</option>
                                                    <option value="Dr.">Dr.</option>
                                                    <option value="Prof.">Prof.</option>
                                                    <option value="Mal.">Mal.</option>
                                                    <option value="Pastor">Pastor</option>
                                                    <option value="Rev.">Rev.</option>
                                                </select>                                        
                                            </div>
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="first_name" placeholder="First Name">     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="last_name" placeholder="Last Name" required>     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="login" placeholder="Email/Phone Number" required>     
                                            </div>                                 
                                            <div class="col-lg-4 mb-2">
                                                <select class="form-select select2 form-select-sm" multiple name="children[]" required>
                                                    <option value=""></option>
                                                   @foreach ($students as $student)
                                                      <option value="{{ $student->id }}">{{ $student->first_name.' '.$student->middle_name.' '.$student->last_name.' - '.$student->class->name }}</option>
                                                   @endforeach
                                                </select>     
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
          
        </div>
</div>
@endsection

@section('js')
@include('users.staffs.script')
<script src="/assets/js/modal-edit-user.js"></script>
<script src="/assets/vendor/libs/select2/select2.js"></script>
@endsection