@extends('layouts.app')
@section('PageTitle', 'Edit Assessment')
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                        <div class="d-flex flex-column flex-md-row align-items-md-center">
                            <h3 class="card-title mb-2 mb-md-0">Edit Assessment</h3>
                        </div>
                        <div class="card-header-actions">
                            <a href="{{ route('cbt.assessments.index') }}" class="btn btn-primary">Go back to List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cbt.assessments.update', ['examId' => $exam->id]) }}" method="post">
                            @csrf
                            @method('PUT')

                            <!-- Exam editing fields -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" value="{{ old('title', $exam->title) }}">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <select id="subject" class="select2 form-select @error('subject') is-invalid @enderror"
                                    data-allow-clear="true" name="subject">
                                    <option value=""></option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ old('subject', $exam->subject_id) == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="caCategory" class="form-label">Category</label>
                                <select id="caCategory"
                                    class="select2 form-select @error('caCategory') is-invalid @enderror"
                                    data-allow-clear="true" name="caCategory">
                                    <option value="">Select CA Category</option>
                                    <option value="Exam"
                                        {{ old('caCategory', $exam->category) == 'Exam' ? 'selected' : '' }}>Exam</option>
                                    <option value="Mock"
                                        {{ old('caCategory', $exam->category) == 'Mock' ? 'selected' : '' }}>Mock</option>
                                    <option value="Homework"
                                        {{ old('caCategory', $exam->category) == 'Homework' ? 'selected' : '' }}>Homework</option>
                                </select>
                                @error('caCategory')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="classes" class="form-label">Classes</label>
                                <select class="select2 form-select @error('classes') is-invalid @enderror"
                                    id="classes" name="classes[]" multiple>
                                    <option value=""></option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ in_array($class->id, old('classes', explode(',', $exam->classes))) ? 'selected' : '' }}>
                                            {{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('classes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="numQuestions" class="form-label">Number of Questions</label>
                                <select id="numQuestions"
                                    class="form-select @error('numQuestions') is-invalid @enderror"
                                    name="numQuestions">
                                    <option value=""></option>
                                    <option value="all" {{ old('numQuestions', $exam->num_questions) == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="10" {{ old('numQuestions', $exam->num_questions) == '10' ? 'selected' : '' }}>10</option>
                                    <option value="15" {{ old('numQuestions', $exam->num_questions) == '15' ? 'selected' : '' }}>15</option>
                                    <option value="20" {{ old('numQuestions', $exam->num_questions) == '20' ? 'selected' : '' }}>20</option>
                                    <option value="25" {{ old('numQuestions', $exam->num_questions) == '25' ? 'selected' : '' }}>25</option>
                                    <option value="30" {{ old('numQuestions', $exam->num_questions) == '30' ? 'selected' : '' }}>30</option>
                                    <option value="35" {{ old('numQuestions', $exam->num_questions) == '35' ? 'selected' : '' }}>35</option>
                                    <option value="40" {{ old('numQuestions', $exam->num_questions) == '40' ? 'selected' : '' }}>40</option>
                                    <option value="50" {{ old('numQuestions', $exam->num_questions) == '50' ? 'selected' : '' }}>50</option>
                                    <option value="60" {{ old('numQuestions', $exam->num_questions) == '60' ? 'selected' : '' }}>60</option>
                                    <option value="70" {{ old('numQuestions', $exam->num_questions) == '70' ? 'selected' : '' }}>70</option>
                                    <option value="100" {{ old('numQuestions', $exam->num_questions) == '100' ? 'selected' : '' }}>100</option>
                                </select>
                                @error('numQuestions')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attemptLimit" class="form-label">Attempt Limit</label>
                                <select id="attemptLimit"
                                    class="form-select @error('attemptLimit') is-invalid @enderror"
                                    name="attemptLimit">
                                    <option value=""></option>
                                    <option value="unlimited" {{ old('attemptLimit', $exam->attempt_limit) == 'unlimited' ? 'selected' : '' }}>Unlimited</option>
                                    <option value="1" {{ old('attemptLimit', $exam->attempt_limit) == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ old('attemptLimit', $exam->attempt_limit) == '2' ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ old('attemptLimit', $exam->attempt_limit) == '3' ? 'selected' : '' }}>3</option>
                                </select>
                                @error('attemptLimit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="showResult" class="form-label">Show Result Immediately</label>
                                <select id="showResult"
                                    class="form-select @error('showResult') is-invalid @enderror"
                                    name="showResult">
                                    <option value=""></option>
                                    <option value="yes" {{ old('showResult', $exam->show_result) == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ old('showResult', $exam->show_result) == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('showResult')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="markPercentage" class="form-label">Mark Percentage</label>
                                <select id="markPercentage"
                                    class="form-select @error('markPercentage') is-invalid @enderror"
                                    name="markPercentage">
                                    <option value=""></option>
                                    @foreach ($markPercentages as $percentage)
                                        <option value="{{ $percentage }}"
                                            {{ old('markPercentage', $exam->mark_percentage) == $percentage ? 'selected' : '' }}>
                                            {{ $percentage }}%</option>
                                    @endforeach
                                </select>
                                @error('markPercentage')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <select id="duration"
                                    class="form-select @error('duration') is-invalid @enderror"
                                    name="duration">
                                    <option value=""></option>
                                    @foreach ($durations as $durationValue => $durationLabel)
                                        <option value="{{ $durationValue }}"
                                            {{ old('duration', $exam->duration) == $durationValue ? 'selected' : '' }}>
                                            {{ $durationLabel }}</option>
                                    @endforeach
                                </select>
                                @error('duration')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            

                                <button type="button" class="btn btn-secondary" onclick="history.back()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Assessment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="/assets/js/forms-selects.js"></script>

<script src="/assets/vendor/libs/select2/select2.js"></script>
   
@endsection
