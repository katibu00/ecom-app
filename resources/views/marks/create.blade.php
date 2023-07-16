@extends('layouts.app')
@section('PageTitle', 'Marks Entry')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-5">
        <div class="col-md">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Marks Entry</h5>
                    <div class="card-title-elements">
                        @if (isset($students))
                        <div>
                            <div class="d-flex justify-content-between align-items-center fw-bolder mb-0">
                                <span><span id="marked">{{ @$marked ? $marked : 0 }}</span> of
                                    {{ $students->count() }} Students</span>
                                <span style="font-size: 12px; font-weight: normal;" id="remaining">
                                    &nbsp;&nbsp;&nbsp;{{ $students->count() - @$marked }} Remaining&nbsp;&nbsp;
                                </span>
                                <span style="font-size: 12px; font-weight: normal;" id="max-marks">
                                    | Max Marks: {{ $max_mark }}
                                </span>
                            </div>
                            <div class="progress mb-50" style="height: 8px">
                                <div class="progress-bar progress-animated" role="progressbar"
                                    style="width: {{ (@$marked / @$students->count()) * 100 }}%" aria-valuenow="6"
                                    aria-valuemax="100" aria-valuemin="0"></div>
                            </div>
                        </div>
                        <input type="hidden" id="total_students" value="{{ $students->count() }}">
                        <input type="hidden" id="initial" value="{{ @$initial }}">
                        @endif
                    </div>
                </div>
                
                <div class="card-body">
                    <form class="form" action="{{ route('marks.create.fetch') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <select class="form-select form-select-sm" id="assign_id" name="assign_id">
                                    <option value="">-- Select subject --</option>
                                    @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ $subject->id == @$assign_id ? 'selected' : '' }}>
                                        {{ @$subject->subject->name }} - {{ @$subject->class->name }} -
                                        {{ $subject->designation == 1 ? 'Compulsory' : 'Optional' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('assign_id')
                                <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4 mb-3">
                                <select id="marks_category" class="form-select form-select-sm" name="marks_category">
                                    <option value="">-- Select Marks Category --</option>
                                    @if (isset($students))
                                    @if ($marks_category == 'exam')
                                    <option value="exam" selected>Exam</option>
                                    @endif
                                    @if (is_numeric($marks_category))
                                    @php
                                    $ca = App\Models\CAScheme::find($marks_category);
                                    @endphp
                                    <option value="{{ $ca->code }}" selected>{{ $ca->code.' - '.$ca->desc }}</option>
                                    @endif
                                    @endif
                                </select>
                                @error('marks_category')
                                <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-sm">Fetch Students</button>
                            </div>
                        </div>
                    </form>

                    @if (isset($students))
                    <form id="main_form">
                        <div class="marks_table">
                            <div class="table-responsive mt-2">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">S/N</th>
                                            <th>Roll Number</th>
                                            <th>Name</th>
                                            <th style="width: 5%">Absent</th>
                                            <th>Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $key => $student)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ @$student->login ? $student->login : @$student->student->login }}
                                            </td>
                                            <td>
                                                {{ @$student->first_name . ' ' . @$student->middle_name . ' ' . @$student->last_name }}
                                            </td>
                                            <td>
                                                <div class="form-check custom-checkbox mb-3 checkbox-danger">
                                                    <input type="checkbox" class="form-check-input absent"
                                                        {{ @$student->absent == 'abs' ? 'checked' : '' }}
                                                        data-user_id="{{ @$student->student_id }}"
                                                        data-class_id="{{ @$student->class_id }}"
                                                        data-roll_number="{{ @$student->student->login }}"
                                                        data-marks="{{ @$student->marks == 0 ? '' : $student->marks }}">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="hidden" name="user_id[]" value="{{ @$student->id }}">
                                                <input type="{{ @$student->absent == 'abs' ? 'text' : 'number' }}"
                                                    max="60" class="form-control input-rounded marks-input" id="marks"
                                                    name="marks" data-user_id="{{ @$student->student_id }}"
                                                    value="{{ @$student->absent == 'abs' ? 'Absent' : @$student->marks }}"
                                                    {{ @$student->absent == 'abs' ? 'disabled' : '' }}>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <input type="hidden" id="max_mark" name="max_mark" value="{{ @$max_mark }}">
                                <input type="hidden" id="subject_id_send" name="subject_id" value="{{ @$subject_id }}">
                                <input type="hidden" id="class_id_send" name="class_id" value="{{ @$class_id }}">
                                <input type="hidden" id="marks_category_send" name="marks_category"
                                    value="{{ @$marks_category }}">
                                <input type="hidden" id="submitted" value="{{ @$submitted }}">
                            </div>
                            <div class="col-12 text-center mt-1">
                                <button type="submit" class="btn btn-outline-danger initialize_btn d-none">Initialize
                                </button>
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

<script>
    $(document).ready(function() {
        $('#assign_id').change(function() {
            var subjectId = $(this).val();
            var marksCategorySelect = $('#marks_category');
            marksCategorySelect.html('<option value="">Loading...</option>');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('marks.create.fetch-cas') }}',
                method: 'POST',
                data: {
                    subject_id: subjectId
                },
                success: function(response) {
                    marksCategorySelect.empty();
                    marksCategorySelect.append('<option value="" selected>Loading...</option>');

                    if (response.ca_schemes) {
                        marksCategorySelect.empty();

                        response.ca_schemes.forEach(function(caScheme) {
                            marksCategorySelect.append('<option value="' + caScheme.id + '" {{ @$marks_category == ' + caScheme.id + ' ? 'selected' : '' }}>' +
                                caScheme.code + ' - ' + caScheme.desc + '</option>');
                        });

                        marksCategorySelect.append('<option value="exam" {{ @$marks_category == 'exam' ? 'selected' : '' }}>Exam</option>');
                    } else {
                        toastr.error('Invalid response format:', response);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error if any
                }
            });
        });
    });
</script>
@endsection
