@extends('layouts.app')
@section('PageTitle', 'Result Analysis')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements d-flex">
                            <h5 class="m-0 me-2 d-none d-md-block">Result Analysis</h5>
                        </div>

                        <form class="form" id="analysis-form" action="{{ route('result.analysis.generate') }}"
                            method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="session_id" id="session_id">
                                        <option value="">--select Session--</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}"
                                                {{ $session->id == @$school->session_id ? 'selected' : '' }}>
                                                {{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="class_id" id="class_id">
                                        <option value="">--Select Class--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="term" id="term">
                                        <option value="">--Select Term--</option>
                                        <option value="first" {{ $school->term == 'first' ? 'selected' : '' }}>First</option>
                                        <option value="second" {{ $school->term == 'second' ? 'selected' : '' }}>Second
                                        </option>
                                        <option value="third" {{ $school->term == 'third' ? 'selected' : '' }}>Third</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="report" id="report">
                                        <option value="">--Select Report--</option>
                                        <option value="class_wise">Class-wise Performance</option>
                                        <option value="subject_wise">Subject-wise Performance</option>
                                        <option value="term_wise">Term-wise Performance</option>
                                        <option value="grade_summary">Grade Summary</option>
                                        <option value="comparative">Comparative Performance</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="limit" id="limit">
                                        <option value="">--Select Limit--</option>
                                        <option value="1">1</option>
                                        <option value="3">3</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label" for=""></label>
                                    <button type="submit" class="btn btn-primary">Fetch</button>
                                </div>
                            </div>
                        </form>


                        <div class="row">
                            <div class="col-md">
                                <div id="report-container"></div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Submit form using AJAX
            $('#analysis-form').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();

                // Make AJAX request
                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    beforeSend: function() {
                        // Show loading spinner or any other indicator
                        $('#report-container').html(
                        '<div class="text-center">Loading...</div>');
                    },
                    success: function(response) {
                        // Clear previous report data
                        $('#report-container').empty();

                        // Check if class-wise report data exists
                        if (response.classWiseReport.length > 0) {
                            // Loop through the class-wise report data
                            $.each(response.classWiseReport, function(index, item) {
                                var subject = item.subject;
                                var topStudents = item.top_students;

                                // Create a container for the subject
                                var subjectContainer = $('<div>').addClass(
                                    'subject-container');

                                // Display the subject (bold heading)
                                subjectContainer.append($('<h4>').css('font-weight',
                                    'bold').text(subject));

                                // Check if there are top students
                                if (topStudents.length > 0) {
                                    // Create a container for the top students
                                    var topStudentsContainer = $('<div>').addClass(
                                        'top-students-container');

                                    // Loop through the top students
                                    $.each(topStudents, function(index, student) {
                                        var studentId = student.student_id;
                                        var firstName = student.first_name;
                                        var lastName = student.last_name;
                                        var marks = student.max_marks;

                                        // Create a container for the student
                                        var studentContainer = $('<div>')
                                            .addClass('student-container');

                                        studentContainer.append($('<p>').css(
                                            'font-weight', 'bold').text(
                                            'Name: ' + firstName + ' ' +
                                            lastName));
                                        studentContainer.append($('<p>').css(
                                            'font-weight', 'bold').text(
                                            'Marks: ' + marks));

                                        // Append the student container to the top students container
                                        topStudentsContainer.append(
                                            studentContainer);
                                    });

                                    // Append the top students container to the subject container
                                    subjectContainer.append(topStudentsContainer);
                                } else {
                                    // Display a message if there are no top students
                                    subjectContainer.append($('<p>').css('font-weight',
                                        'bold').text('No top students found.'));
                                }

                                // Append the subject container to the report container
                                $('#report-container').append(subjectContainer);
                            });
                        } else {
                            // Display a message if there is no class-wise report data
                            $('#report-container').html(
                                '<p class="font-weight-bold">No class-wise report data found.</p>'
                                );
                        }

                        // Display overall best student
                        var overallBestStudent = response.overallBestStudent;
                        if (overallBestStudent) {
                            var bestStudentTotal = overallBestStudent.total;
                            var bestStudentFirstName = overallBestStudent.first_name;
                            var bestStudentLastName = overallBestStudent.last_name;

                            var bestStudentInfo =
                                '<h4 class="font-weight-bold">Overall Best Student:</h4>' +
                                '<p class="font-weight-bold">Name: ' + bestStudentFirstName +
                                ' ' + bestStudentLastName + '</p>' +
                                '<p class="font-weight-bold">Total: ' + bestStudentTotal +
                                '</p>';

                            $('#report-container').append(bestStudentInfo);
                        }

                        // Display overall worst student
                        var overallWorstStudent = response.overallWorstStudent;
                        if (overallWorstStudent) {
                            var worstStudentTotal = overallWorstStudent.total;
                            var worstStudentFirstName = overallWorstStudent.first_name;
                            var worstStudentLastName = overallWorstStudent.last_name;

                            var worstStudentInfo =
                                '<h4 class="font-weight-bold">Overall Worst Student:</h4>' +
                                '<p class="font-weight-bold">Name: ' + worstStudentFirstName +
                                ' ' + worstStudentLastName + '</p>' +
                                '<p class="font-weight-bold">Total: ' + worstStudentTotal +
                                '</p>';

                            $('#report-container').append(worstStudentInfo);
                        }

                        // Display average marks
                        var averageMarks = response.averageMarks;
                        $('#report-container').append(
                            '<p class="font-weight-bold">Average Marks: ' + averageMarks +
                            '</p>');
                    },

                    error: function(xhr, status, error) {
                        console.log("AJAX Request Error:", status, error);
                    }
                });
            });
        });
    </script>
@endsection
