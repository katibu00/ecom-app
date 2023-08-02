@extends('layouts.app')
@section('PageTitle', 'CBT Exams')
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">

                <div class="card">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-header d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                        <!-- Title and Filter (Left Side) -->
                        <div class="d-flex flex-column flex-md-row align-items-md-center">
                            <h3 class="card-title mb-2 mb-md-0">Assessments</h3>
                            {{-- <div class="card-header-filter ms-md-2 mb-2">
                                <select class="form-select">
                                    <option value="">All</option>
                                    <option value="exam">Exams</option>
                                    <option value="test">Tests</option>
                                    <option value="homework">Homework</option>
                                </select>
                            </div> --}}
                        </div>

                        <div class="card-header-actions">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAssessmentModal">Add
                                New Assessment</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            @include('cbt.admin.assessments_table')
                        </div>
                    </div>
                </div>


                @include('cbt.admin.new_assessment_modal')
                @include('cbt.admin.schedule_modal')
                @include('cbt.admin.assessment_details_modal')

            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="/assets/js/forms-selects.js"></script>

    <script src="/assets/vendor/libs/select2/select2.js"></script>

    <script>
        $(document).ready(function() {
            $('.schedule-btn').click(function() {
                var examId = $(this).data('exam-id');
                $('#examIdInput').val(examId);
                $.ajax({
                    type: 'GET',
                    url: '{{ route('cbt.schedule.get') }}',
                    data: {
                        examId: examId
                    },
                    success: function(response) {
                        $('#start_date').val(response.start_date);
                        $('#start_time').val(response.start_time);
                        $('#end_date').val(response.end_date);
                        $('#end_time').val(response.end_time);

                        $('#scheduleModal').modal('show');
                    },
                    error: function(error) {
                        console.error('Failed to fetch schedule:', error.responseJSON);
                    }
                });
            });
        });


        function saveSchedule() {
            var examId = $('#examIdInput').val();
            var startDate = $('#start_date').val();
            var startTime = $('#start_time').val();
            var endDate = $('#end_date').val();
            var endTime = $('#end_time').val();

            var formData = {
                examId: examId,
                startDate: startDate,
                startTime: startTime,
                endDate: endDate,
                endTime: endTime,
                // You can add more data to send if needed
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('cbt.schedule.save') }}',
                data: formData,
                success: function(response) {
                    $('.assessments_table').load(location.href + ' .assessments_table');
                    $('#scheduleModal').modal('hide');
                },
                error: function(error) {
                    // Handle error and display Toastr message
                    if (error.responseJSON) {
                        if (error.responseJSON.error) {
                            // Show the custom error message
                            toastr.error(error.responseJSON.error);
                        } else if (error.responseJSON.message) {
                            // Show the validation error or custom message
                            toastr.error(error.responseJSON.message);
                        } else if (error.responseJSON.errors) {
                            // Show the validation errors
                            var errorMessages = Object.values(error.responseJSON.errors).flat();
                            toastr.error(errorMessages.join('<br>'));
                        } else {
                            // Generic error message
                            toastr.error('An error occurred. Please try again.');
                        }
                    } else {
                        // Generic error message if no error response is available
                        toastr.error('An error occurred. Please try again.');
                    }
                }

            });
        }

        $('#saveScheduleBtn').on('click', saveSchedule);
    </script>

    <script>
        $(document).ready(function() {
            $('.details-btn').click(function() {
                var examId = $(this).data('exam-id');

                $('#examDetailsModal').modal('show');

                $.ajax({
                    type: 'GET',
                    url: '{{ route('cbt.assessments.details') }}',
                    data: {
                        examId: examId
                    },
                    success: function(response) {
                        var examDetailsHtml = '<p><strong>Title:</strong> ' + response.title +
                            '</p>';
                        examDetailsHtml += '<p><strong>Subject:</strong> ' + response.subject +
                            '</p>';
                        examDetailsHtml += '<p><strong>Category:</strong> ' + response
                            .category + '</p>';
                        examDetailsHtml += '<p><strong>Mark Percentage:</strong> ' + response
                            .markPercentage + '%</p>';
                        examDetailsHtml += '<p><strong>Duration:</strong> ' + response
                            .duration + ' minutes</p>';
                        examDetailsHtml += '<p><strong>Classes:</strong> ' + response.classes +
                            '</p>';
                        examDetailsHtml += '<p><strong>Status:</strong> ' + response.status +
                            '</p>';
                        examDetailsHtml += '<p><strong>Number of Questions:</strong> ' +
                            response.numQuestions + '</p>';
                        examDetailsHtml += '<p><strong>Attempt Limit:</strong> ' + response
                            .attemptLimit + '</p>';
                        examDetailsHtml += '<p><strong>Show Result:</strong> ' + response
                            .showResult + '</p>';
                        examDetailsHtml += '<p><strong>Start Date:</strong> ' + (response
                            .startDate ? response.startDate : 'Not scheduled') + '</p>';
                        examDetailsHtml += '<p><strong>End Date:</strong> ' + (response
                            .endDate ? response.endDate : 'Not scheduled') + '</p>';

                        $('#examDetailsContent').html(examDetailsHtml);
                        $('#examDetailsLoader').hide();
                        $('#examDetailsContent').show();
                    },
                    error: function(error) {
                        console.error('Failed to fetch exam details:', error.responseJSON);
                        $('#examDetailsLoader').hide();
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.delete-exam').click(function(event) {
                event.preventDefault(); // Prevent the link from navigating to the href

                var examId = $(this).data('exam-id');

                // Show the SweetAlert confirm dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If the user clicks "Yes", proceed with the deletion
                        deleteExam(examId);
                    }
                });
            });

            // Function to handle exam deletion
            function deleteExam(examId) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('cbt.assessments.delete') }}',
                    data: {
                        examId: examId
                    },
                    success: function(response) {
                        // Handle success response here, such as showing a success message
                        Swal.fire(
                            'Deleted!',
                            'The exam has been deleted.',
                            'success'
                        );

                        // Optionally, you can refresh the page or update the exams list after deletion
                        location.reload();
                    },
                    error: function(error) {
                        // Handle error response here, such as showing an error message
                        Swal.fire(
                            'Error!',
                            'Failed to delete the exam.',
                            'error'
                        );
                    }
                });
            }
        });
    </script>



@endsection
