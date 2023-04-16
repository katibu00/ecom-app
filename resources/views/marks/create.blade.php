@extends('layouts.app')
@section('PageTitle', 'Marks Entry')


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row mb-5">

            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements  d-flex fle4x-row">
                            <h5 class="m-0 me-2 d-none d-md-block">Marks Entry</h5>

                            <div class="card-title-elements ms-auto">
                                @if(isset($students))
                                <div >
                                    <div class="d-flex justify-content-between align-items-center fw-bolder mb-0">
                                        <span><span id="marked">{{ @$marked? $marked : 0}}</span> of {{ $students->count() }} Students</span>
                                        <span style="font-size: 12px; font-weight: normal;" id="remaining">{{ $students->count() - @$marked}} remaining</span>
                                    </div>
                                    <div class="progress mb-50" style="height: 8px">
                                        <div class="progress-bar progress-animated" role="progressbar" style="width: {{ @$marked/@$students->count()*100 }}%" aria-valuenow="6" aria-valuemax="100" aria-valuemin="0"></div>
                                    </div>
                                    
                                </div>
                                <input type="hidden" id="total_students" value="{{$students->count()}}">
                                <input type="hidden" id="initial" value="{{ @$initial }}">
                                @endif
                            </div>
                        </div>


                        <form class="form" action="{{ route('marks.create.fetch')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 mb-1">
                                    <select class="form-select form-select-sm mb-3" id="assign_id" name="assign_id">
                                        <option value="">--select subject--</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{$subject->id == @$assign_id? 'selected':''}}>{{ @$subject->subject->name }} - {{ @$subject->class->name }} - {{ $subject->designation == 1? 'Compulsory': 'Optional' }}</option>
                                        @endforeach
                                    </select>
                                    @error('assign_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-4 mb-1">
                                    <select id="marks_category" class="form-select form-select-sm mb-3" name="marks_category">
                                        <option value="">--Select Marks Category--</option>
                                        @foreach ($cas as $ca)
                                            <option value="{{ $ca->code }}" {{@$marks_category == $ca->code? 'selected':''}}>{{ $ca->code .' ('.$ca->desc.')'}}</option>
                                        @endforeach
                                            <option value="exam" {{@$marks_category == 'exam'? 'selected':''}}>Exam</option>
                                    </select>
                                    @error('marks_category')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label" for=""></label>
                                    <button type="submit" class="btn btn-primary">Search Students</button>
                                </div>
                            </div>
                        </form>

                    
                        @if(isset($students))
                        <form id="main_form">
                            <div class="marks_table ">
                                <div class="table-responsive mt-2">
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">S/N</th>
                                                <th>Roll Number</th>
                                                <th> Name</th>
                                                <th style="width: 5%">Absent</th>
                                                <th>Marks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $key => $student)
                                                <tr>
                                                    <td>{{ $key + 1}}</td>
                                                    <td>{{ @$student->login?$student->login:@$student->student->login }}</td>
                                                    <td>{{ @$student->first_name.' '.@$student->middle_name.' '.@$student->last_name }} {{ @$student->student->first_name.' '.@$student->student->middle_name.' '.@$student->student->last_name }}</td>
                                                  <td>
                                                    <div class="form-check custom-checkbox mb-3 checkbox-danger">
                                                        <input type="checkbox" class="form-check-input absent"  {{ @$student->absent == 'abs'? 'checked':'' }} data-user_id="{{ @$student->student_id }}" data-class_id="{{ @$student->class_id }}" data-roll_number="{{ @$student->student->login }}" data-marks="{{ @$student->marks == 0 ? '': $student->marks }}">
                                                    </div>
                                                  </td>
                                                    <td><input type="hidden" name="user_id[]" value="{{ @$student->id }}"><input type="{{ @$student->absent == 'abs'? 'text':'number' }}"  max="60" class="form-control input-rounded" id="marks" name="marks" data-user_id="{{ @$student->student_id }}" value="{{ @$student->absent == 'abs'? 'absent': @$student->marks }}"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    <input type="hidden" id="max_mark" name="max_mark" value="{{ @$max_mark }}">
                                    <input type="hidden" id="subject_id_send" name="subject_id" value="{{ @$subject_id }}">
                                    <input type="hidden" id="class_id_send" name="class_id" value="{{ @$class_id }}">
                                    <input type="hidden" id="marks_category_send" name="marks_category" value="{{ @$marks_category }}">
                                    <input type="hidden" id="submitted" value="{{ @$submitted }}">
                                </div>

                                <div class="col-12 text-center mt-1">
                                    
                                    <button type="submit" class="btn btn-outline-danger initialize_btn d-none">Initialize</button>
                                    
                                    <button type="submit" class="btn btn-secondary submit_btn d-none">Submit</button>
                                    
                                </div>
                            </div>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('js')
    @include('marks.scripts')
    <script src="/js/sweetalert.min.js"></script>
    {!! Toastr::message() !!}
@endsection
