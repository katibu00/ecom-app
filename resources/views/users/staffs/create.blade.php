@extends('layouts.app')
@section('PageTitle', 'Register Staffs')



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

                        <form action="{{ route('users.staffs.store') }}" method="POST">
                            @csrf
                            <div class="add_item">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="mb-2 row">
                                            <div class="col-lg-2 mb-2">
                                                <select class="form-select form-select-sm" name="title[]" required>
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
                                                <input type="text" class="form-control form-control-sm" name="first_name[]" placeholder="First Name">     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="last_name[]" placeholder="Last Name" required>     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="login[]" placeholder="Email/Phone Number" required>     
                                            </div>                                 
                                            <div class="col-lg-2 mb-2">
                                                <select class="form-select form-select-sm" name="usertype[]" required>
                                                    <option value=""></option>
                                                    <option value="admin">Admin</option>
                                                    <option value="accountant">Accountant</option>
                                                    <option value="teacher">Teacher</option>
                                                    <option value="proprietor">Proprietor</option>
                                                    <option value="director">Director</option>
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
                                        <select class="form-select form-select-sm" name="title[]" required>
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
                                        <input type="text" class="form-control form-control-sm" name="first_name[]" placeholder="First Name">     
                                    </div>                                 
                                    <div class="col-lg-2 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="last_name[]" placeholder="Last Name" required>     
                                    </div>                                 
                                    <div class="col-lg-2 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="login[]" placeholder="Email/Phone Number" required>     
                                    </div>                                 
                                    <div class="col-lg-2 mb-2">
                                        <select class="form-select form-select-sm" name="usertype[]" required>
                                            <option value=""></option>
                                            <option value="admin">Admin</option>
                                            <option value="accountant">Accountant</option>
                                            <option value="teacher">Teacher</option>
                                            <option value="proprietor">Proprietor</option>
                                            <option value="director">Director</option>
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
@include('users.staffs.script')
@endsection