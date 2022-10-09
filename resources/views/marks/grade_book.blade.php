@extends('layouts.app')
@section('PageTitle', 'Gradebook')
@section('content')


<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Gradebook</h4>
                    </div>

                    <div class="card-body my-1 py-50">

                        <form action="{{ route('marks.grade_book.index')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 mb-1">
                                    <select class="default-select form-control wide mb-3" id="class_id" name="class_id">
                                        <option value="">--select subject--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                @if ($class->id == @$class_id) selected @endif>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
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
                            <br />
                            <div class="row">
                                <div class="col-md-12">

                                    @foreach (@$students as $student)
                                        <table class="table table-sm table-hover">

                                            <thead>
                                                <caption>{{ $student->first_name }} {{ $student->middle_name }}
                                                    {{ $student->last_name }}</caption>
                                                <tr>
                                                    <th scope="col">S/N</th>
                                                    <th scope="col">Subject</th>
                                                    @php
                                                        $cas = App\Models\CAScheme::where('school_id', $school->id)->get();
                                                    @endphp
                                                    @foreach ($cas as $ca)
                                                        <th scope="col">{{ $ca->code }}/{{ $ca->marks }}</th>
                                                    @endforeach
                                                    <th scope="col">Exams</th>
                                                    <th scope="col">Total</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                   
                                                    $subjects = App\Models\AssignSubject::with('class','subject')->where('school_id', $school->id)
                                                        ->where('class_id', $class_id)
                                                        ->get(); 
                                                        $total_ca = 0;
                                                @endphp
                                                @foreach ($subjects as $key => $subject)
                                                    <tr>
                                                        <td scope="row">{{ $key + 1 }}</td>
                                                        <td>{{ $subject['subject']['name'] }}</td>

                                                        @foreach ($cas as $ca)
                                                            @php
                                                                
                                                                $score = App\Models\Mark::where('school_id', $school->id)
                                                                    ->where('session_id', $school->session_id)
                                                                    ->where('term', $school->term)
                                                                    ->where('type', $ca->code)
                                                                    ->where('student_id', $student->id)
                                                                    ->where('class_id', $student->class_id)
                                                                    ->where('subject_id', $subject->subject_id)
                                                                    ->first();
                                                                    $total_ca += @$score->marks;
                                                            @endphp
                                                            <td>{{ @$score->absent == 'abs'?'absent': @$score->marks }}</td>
                                                        @endforeach


                                                        @php

                                                            $exam = App\Models\Mark::where('school_id', $school->id)
                                                                ->where('session_id', $school->session_id)
                                                                ->where('term', $school->term)
                                                                ->where('type', 'exam')
                                                                ->where('student_id', $student->id)
                                                                ->where('class_id', $student->class_id)
                                                                ->where('subject_id', $subject->subject_id)
                                                                ->first();
                                                        @endphp

                                                        <td>{{ @$exam->absent == 'abs'?'absent': @$exam->marks }}</td>


                                                      
                                                        <td>
                                                            {{ $total_ca + @$exam->marks }}
                                                        </td>
                                                        @php
                                                            $total_ca = 0
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach

                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
{!! Toastr::message() !!}
@endsection
