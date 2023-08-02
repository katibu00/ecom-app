@extends('layouts.app')
@section('PageTitle', 'Students')
@section('content')

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                       <div class="iq-card-header d-flex justify-content-between">
                          <div class="iq-header-title">
                                <h4 class="card-title">Students</h4>
                            </div>
                            <a class="btn btn-info pull-right  btn-sm" href="{{ route('users.students.create') }}"><i
                                    class="fa fa-user"></i> New Student(s)</a>
                        </div>

                        

                        <div class="iq-card-body">  <hr/>
                            
                           
                             
                              
                        <div class="table-responsive">
                            <table  class="table  mt-2 table-borderless table-test">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Passport</th>
                                        <th>Roll Number</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Parent</th>
                                        <th>Status</th>
                                        <th style="width: 20%;">Action</th>
                                     </tr>
                                </thead>
                                <tbody>
                                        @foreach ($students as $key => $student)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td class="text-center"><img class="rounded-circle img-fluid avatar-40" @if($student->image == null) src="/uploads/default.png" @else src="/uploads/{{$school->username}}/{{ $student->image }}" @endif alt="profile"></td>
                                                <td>{{$student->login}}</td>
                                                <td>{{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}</td>
                                                <td>{{$student['class']['name']}}</td>
                                                <td>{{ @$student['parent']['first_name'] }} {{ @$student['parent']['middle_name'] }} {{ @$student['parent']['last_name']}}</td>
                                                <td><span class="badge iq-bg-primary">Active</span></td>

                                                <td>
                                                    <div class="flex align-items-center list-user-action">
                                                        <a class="iq-bg-primary" data-toggle="modal"
                                                            data-target="#edit{{ $student->id }}"><i
                                                                class="ri-pencil-line"></i></a>
                                                        <a class="iq-bg-primary"
                                                            href=""
                                                            target="__blank"><i class="ri-printer-line"></i></a>
                                                        <a class="iq-bg-primary" data-toggle="modal"
                                                            data-target="#password{{ $student->id }}"><i
                                                                class="ri-lock-line"></i></a>

                                                        <a class="iq-bg-primary" data-toggle="modal"
                                                            data-target="#delete{{ $student->id }}"><i
                                                                class="ri-delete-bin-line"></i></a>
                                                    </div>
                                                </td>
                                            </tr>


                                            <!--- Edit modal --->
                              <div class="modal fade bd-example-modal-lg" id="edit{{$student->id}}" tabindex="-1" role="dialog" aria-labelledby="edit{{$student->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                   <div class="modal-content">
                                      <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLabel">Edit {{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}'s Biodata</h5>
                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true">&times;</span>
                                         </button>
                                      </div>
                                      <div class="modal-body">

                                        <form class="form-horizontal" id="quickForm" method="POST"  action="{{ route('update.student',$student->id) }}" enctype="multipart/form-data">
                                                @csrf
                                        <div class="form-row">


                                            <div class="form-group col-md-3">
                                                <label>Profile Image</label>
                                                <img id="showImage{{$key}}"
                                                   @if($student->image == 'default.png') src="/uploads/default.png" @else src="/uploads/{{$school->username}}/{{ $student->image }}" @endif
                                                    style="width: 100px; height: 100px; margin-bottom: 5px;">
                                                <input name="image" id="image{{$key}}" type="file" accept="image/*" />
                                            </div>

                                        </div>

                                        <hr><div class="form-row">
                                                <div class="col-md-4">
                                                    <label>First Name</label>
                                                    <input type="text" name="first_name" class="form-control" style="height: calc(1.5em + .5rem + 2px); padding: .25rem .5rem;  font-size: .875rem; line-height: 1.5; border-radius: .2rem" student="{{$student->first_name}}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Middle Name</label>
                                                    <input type="text" name="middle_name" class="form-control" style="height: calc(1.5em + .5rem + 2px); padding: .25rem .5rem;  font-size: .875rem; line-height: 1.5; border-radius: .2rem" student="{{$student->middle_name}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Last Name</label>
                                                    <input type="text" name="last_name" class="form-control" style="height: calc(1.5em + .5rem + 2px); padding: .25rem .5rem;  font-size: .875rem; line-height: 1.5; border-radius: .2rem" student="{{$student->last_name}}" required>
                                                </div>
                                        </div>
                                        <hr><div class="form-row">
                                            <div class="col-md-4">
                                                <label>School Section</label>
                                                <select name="school_section_id" class="form-control form-control-sm" required>
                                                    <option student="">Select School Section</option>
                                                    @foreach ($school_sections as $section)
                                                        <option student="{{ $section->id }}" {{ $student->school_section_id == $section->id ? 'Selected' : '' }}>{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Class</label>
                                                <select name="class_id" class="form-control form-control-sm">
                                                    <option student="">Select Class</option>
                                                    @foreach ($classes as $class)
                                                        <option student="{{ $class->id }}" {{ $student->class_id == $class->id ? 'Selected' : '' }}>{{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Class Section</label>
                                                <select name="class_section_id" class="form-control form-control-sm" required>
                                                <option student="">Select Class Section</option>
                                                @foreach ($class_sections as $csection)
                                                    <option student="{{ $csection->id }}"{{ $student->class_section_id == $csection->id ? 'Selected' : '' }} >{{ $csection->name }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>

                                        <hr><div class="form-row">
                                            <div class="col-md-4">
                                                <label>Roll Number</label>
                                                <input type="text" name="roll_number" class="form-control" style="height: calc(1.5em + .5rem + 2px); padding: .25rem .5rem;  font-size: .875rem; line-height: 1.5; border-radius: .2rem" student="{{$student->roll_number}}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Gender</label>
                                                <select name="gender" class="form-control form-control-sm" required>
                                                    <option student="">Select Gender</option>
                                                    <option student="Male"{{ $student->gender == 'Male' ? 'Selected' : '' }} >Male</option>
                                                    <option student="Female"{{ $student->gender == 'Female' ? 'Selected' : '' }} >Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Religion</label>
                                                <select name="religion" class="form-control form-control-sm">
                                                    <option student="">Select Religion</option>
                                                    <option student="Christianity"{{ $student->religion == 'Christianity' ? 'Selected' : '' }} >Christianity</option>
                                                    <option student="Islam"{{ $student->religion == 'Islam' ? 'Selected' : '' }} >Islam</option>
                                                </select>
                                            </div>
                                        </div>

                                        <hr><div class="form-row">
                                            <div class="col-md-3">
                                                <label>Date of Birth</label>
                                                <input type="date" name="dob" class="form-control" style="height: calc(1.5em + .5rem + 2px); padding: .25rem .5rem;  font-size: .875rem; line-height: 1.5; border-radius: .2rem" student="{{$student->dob}}">
                                            </div>


                                            <div class="col-md-3">
                                                <label>Parent</label>
                                                <select name="parent_id" class="form-control form-control-sm">
                                                    <option student="">Select Parent</option>
                                                   @foreach ($parents as $parent)
                                                        <option student="{{ $parent->id }}"{{ $student->parent_id == $parent->id ? 'Selected' : '' }} >{{ $parent->first_name }} {{ $parent->middle_name }} {{ $parent->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="col-md-6">
                                                <label>Contact Address</label>
                                                <input type="text" name="address" class="form-control" style="height: calc(1.5em + .5rem + 2px); padding: .25rem .5rem;  font-size: .875rem; line-height: 1.5; border-radius: .2rem" student="{{$student->address}}">
                                            </div>
                                        </div>
                                      </div>

                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update Student</button>
                                        </form>
                                    </div>
                                      </div>
                                   </div>
                                </div>
                             </div>


                            <!--- Edit End modal --->


                            {{-- Change Password --}}

                            <div class="modal fade bd-example-modal-sm" id="password{{ $student->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="password{{ $student->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="exampleModalLabel">Change
                                                {{ $student->first_name }}'s Password</h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form class="form-horizontal" id="quickForm" method="POST"
                                                action="{{ route('user.password', $student->id) }}">
                                                @csrf


                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <label>New Password</label>
                                                        <input type="password" name="password"
                                                            class="form-control form-control-sm">
                                                    </div>

                                                </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Change Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Change Password --}}


                        {{-- Delete --}}

                        <div class="modal fade bd-example-modal-sm" id="delete{{ $student->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="delete{{ $student->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Delete {{ $student->first_name }}
                                            {{ $student->middle_name }} {{ $student->last_name }}</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>Are you Sure?</h5>
                                        <form class="form-horizontal" id="quickForm" method="POST"
                                            action="{{ route('user.delete', $student->id) }}">
                                            @csrf

                                            <input type="hidden" student="{{ $student->id }}">




                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Delete --}}
                    </tbody>
                    @endforeach
                    </table>
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
@foreach ($allData as $key => $student)
<script type="text/javascript">
    $(document).ready(function() {

        $('#image{{$key}}').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage{{$key}}').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>
@endforeach

@endsection
