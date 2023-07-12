@extends('layouts.app')
@section('PageTitle', 'Early Year Marks Entry')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Early Year Marks Entry</h5>
                    <div>
                        <p class="mb-0">Total Marked Students: <span id="totalMarkedStudents">0</span></p>
                        <p class="mb-0">Current Student Progress: <span id="currentStudentProgress">0%</span></p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <label for="classSelect">Select Class:</label>
                        <select class="form-select" id="classSelect">
                            <option value=""></option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="studentSelect">Select Student:</label>
                        <select class="form-select" id="studentSelect">
                        </select>
                    </div>
                    <div class="col-md-4 text-md-start text-center mt-3 mt-md-0">
                        <button class="btn btn-primary" id="goButton">Go</button>
                    </div>
                </div>

                <form id="marksForm" class="mt-3" action="{{ route('early_year_marks.store') }}" method="POST">
                    @csrf
                    <div id="students_body"></div>
                </form>

            </div>

        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Class selection change event
            $('#classSelect').change(function() {
                var classId = $(this).val();
                var studentSelect = $('#studentSelect');

                // Clear previous options
                studentSelect.empty();

                // Add loading option
                studentSelect.append($('<option></option>').text('Loading...'));

                // Fetch students for the selected class
                $.ajax({
                    url: '/marks/marks-entry/students-by-class/' + classId,
                    method: 'GET',
                    success: function(response) {
                        // Remove loading option
                        studentSelect.find('option:first').remove();

                        // Check if students are found
                        if (response.length > 0) {
                            // Populate student options
                            $.each(response, function(index, student) {
                                var fullName = student.first_name;
                                if (student.middle_name) {
                                    fullName += ' ' + student.middle_name;
                                }
                                fullName += ' ' + student.last_name;

                                studentSelect.append($('<option></option>').attr(
                                    'value', student.id).text(fullName));
                            });
                        } else {
                            // Display toastr message if no students found
                            toastr.info('No students found.');
                        }
                    },
                    error: function() {
                        // Remove loading option and display error message
                        studentSelect.find('option:first').remove();
                        studentSelect.append($('<option></option>').text(
                            'Error fetching students'));
                    }
                });
            });

            $('#studentSelect').change(function() {
                $('#students_body').empty();
            });

            $('#goButton').click(function() {
                var studentId = $('#studentSelect').val();

                // Validate if a student is selected
                if (!studentId) {
                    toastr.error('Please select a student.');
                    return;
                }

                // Get the marks and learning domains for the selected student via AJAX
                $.ajax({
                    url: '/marks/get-marks/' + studentId,
                    method: 'GET',
                    success: function(response) {
    // Clear existing fields before appending newly fetched data
    $('#students_body').empty();

    // Check if learning domains are found
    if (response.domains.length > 0) {
        // Iterate over the learning domains
        $.each(response.domains, function(index, domain) {
            var domainName = domain.name;
            var learningOutcomes = domain.learning_outcomes;

            // Create a container for the learning domain and its outcomes
            var domainContainer = $('<div class="domain-container"></div>');
            domainContainer.append('<h5>' + domainName + '</h5>');

            // Iterate over the learning outcomes
            $.each(learningOutcomes, function(index, outcome) {
                var outcomeId = outcome.id;
                var outcomeName = outcome.name;
                var outcomeGrade = response.marks ? response.marks[outcomeId] || '' : '';

                // Create a select field for the outcome grade
                var outcomeSelect = $('<select class="form-select mb-2" name="marks[' + outcomeId + ']" id="grade-' + outcomeId + '"></select>');
                outcomeSelect.append('<option value=""></option>');
                outcomeSelect.append('<option value="ex" ' + (outcomeGrade === 'ex' ? 'selected' : '') + '>Excellent</option>');
                outcomeSelect.append('<option value="vg" ' + (outcomeGrade === 'vg' ? 'selected' : '') + '>Very Good</option>');
                outcomeSelect.append('<option value="g" ' + (outcomeGrade === 'g' ? 'selected' : '') + '>Good</option>');
                outcomeSelect.append('<option value="ni" ' + (outcomeGrade === 'ni' ? 'selected' : '') + '>Needs Improvement</option>');
                outcomeSelect.append('<option value="na" ' + (outcomeGrade === 'na' ? 'selected' : '') + '>Not Assessed</option>');

                domainContainer.append('<div class="form-group mb-2 row">' +
                    '<label class="col-sm-3 col-form-label">' + outcomeName + '</label>' +
                    '<div class="col-sm-9">' +
                    outcomeSelect.prop('outerHTML') +
                    '</div></div>');
            });

            // Append the domain container to the card body
            $('#students_body').append(domainContainer);
        });

        var submitButton = $('<button type="submit" class="btn btn-primary" id="">Submit</button>');
        $('#students_body').append(submitButton);
    } else {
        toastr.info('No learning domains found.');
    }
},

                    error: function() {
                        toastr.error('Failed to retrieve learning domains.');
                    }
                });
            });


            $('#marksForm').submit(function(e) {
                e.preventDefault();
                // Perform AJAX submission of marks form
                var form = $(this);
                var studentId = $('#studentSelect').val();
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize() + '&student_id=' + studentId,
                    success: function(response) {
                        toastr.success('Marks submitted successfully.');
                    },
                    error: function() {
                        toastr.error('Failed to submit marks.');
                    }
                });
            });

        });
    </script>
@endsection
