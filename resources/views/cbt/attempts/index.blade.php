@extends('layouts.app')
@section('PageTitle', 'CBT Exams Attempts')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                        <div class="d-flex flex-column flex-md-row align-items-md-center">
                            <h3 class="card-title mb-2 mb-md-0">CBT Assessments Attempts</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" method="post" action="{{ route('cbt.attempts.fetch_records') }}">
                            @csrf
                            <div class="col-auto">
                                <label for="exam_id" class="col-form-label">Select Exam:</label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" name="exam_id" id="exam_id">
                                    @foreach($exams as $exam)
                                        <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Fetch Records</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($studentsWithAttempts))
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">
                            <h4>Exam Results</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Answered</th>
                                            <th>Attempts</th>
                                            <th>Score</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($studentsWithAttempts as $studentWithAttempts)
                                            <tr>
                                                <td>{{ $studentWithAttempts['student']->first_name.' '.$studentWithAttempts['student']->middle_name.' '.$studentWithAttempts['student']->last_name }}</td>
                                                <td>{{ $studentWithAttempts['attempted_questions_count'] }}</td>
                                                <td>{{ $studentWithAttempts['attempt_count'] }}</td>
                                                <td>{{ $studentWithAttempts['score'] }} / {{ $exam->num_questions }}</td>
                                                <td>
                                                    <a href="{{ route('cbt.attempts.show', ['examId' => $exam->id, 'studentId' => $studentWithAttempts['student']->id]) }}" class="btn btn-sm btn-primary">Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')

@endsection
