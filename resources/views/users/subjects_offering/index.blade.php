@extends('layouts.app')
@section('PageTitle', 'Subjects Offfering')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">

            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('get-subjects_offering') }}" method="post">
                            @csrf
                            <div class="d-flex4 align-items-center">
                                <div class="row">
                                    <div class="col-md-4 mb-2" id="class">
                                        <label for="class_id">Class</label>
                                        <select class="form-select form-select-sm mb-2" id="class_id" name="class_id"
                                            required>
                                            <option value=""></option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}" {{ @$class_id == $class->id ? 'selected':'' }}>
                                                    {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <div class="col-md-4 mt-md-3">
                                        <button type="submit" class="btn btn-sm btn-primary">Fetch Optional Subjects</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if(@$students)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('save-subjects_offering') }}" method="post" target="_blank">
                            @csrf
                            <div>
                                <div class="table-responsive">
                                    <table class="table table-striped border-top">
                                      <thead>
                                        <tr>
                                          <th class="text-nowrap" colspan="1">S/N</th>
                                          <th class="text-nowrap" colspan="1">Students</th>
                                          <th class="text-nowrap text-center" colspan="{{ count($subjects)+1 }}">Optional Subjects</th>
                                        </tr>
                                        <tr>
                                          <td></td>
                                          <td class="text-nowrap"></td>
                                          @foreach ($subjects as $subject)
                                            <td class="text-nowrap text-center">{{ @$subject->subject->name }}</td>
                                          @endforeach
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($students as $key => $student)
                                        
                                        <tr>
                                          <td>{{ $key+1 }}</td>
                                          <td class="text-nowrap">{{ $student->first_name.' '.$student->middle_name.' '.$student->last_name }}</td>
                                          @foreach ($subjects as $subject)
                                          <td>
                                            @php
                                              $offering = App\Models\SubjectOffering::select('offering')
                                              ->where('student_id', $student->id)
                                              ->where('subject_id', $subject->subject->id)
                                              ->first();
                                            @endphp 
                                            <div class="form-check d-flex justify-content-center">
                                              <input class="form-check-input subject" type="checkbox" data-subject_id="{{ $subject->subject->id }}" data-student_id="{{ $student->id }}" id="subject{{ $subject->subject->id }}" name="subject_id[]" {{ @$offering->offering == 1? 'checked':'' }}>
                                            </div>
                                          </td>
                                          @endforeach
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  
                                  </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
@section('js')
@include('users.subjects_offering.script')
@endsection
