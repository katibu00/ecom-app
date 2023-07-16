@extends('layouts.app')
@section('PageTitle', 'Psychomotor Grade')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-header header-elements">
                            <span class="me-2">{{ ($type == 1) ? 'Psychomotor Skills' : (($type == 2) ? 'Affective Trait' : '') }} for {{ $class->name }}</span>

                            <div class="card-header-elements ms-auto">
                                <a href="{{ route('psychomotor.index') }}" class="btn btn-danger"><- Back to List</a>
                            </div>
                        </div>

                        @include('psychomotor.viewTable')

                    </div>
                </div>
                @include('psychomotor.editModal')
            </div>
        </div>
    </div>
@endsection

@section('js')

<script>
    $(document).ready(function() {
        $('.editItem').click(function() {
            var studentName = $(this).data('student-name');
            var gradeName = $(this).data('grade-name');
            var score = $(this).data('score');
            var rowId = $(this).data('id'); 

            $('#studentName').text(studentName);
            $('#gradeName').text(gradeName);
            $('#score').val(score);

            $('#saveScore').click(function() {
                var newScore = $('#score').val();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('psychomotor.update') }}',
                    type: 'POST',
                    data: {
                        rowId: rowId,
                        newScore: newScore
                    },
                    success: function(response) {
                        // Handle the success response
                        console.log('Score updated successfully');
                        // Close the modal
                        $('#editModal').modal('hide');
                        // Refresh the page or update the necessary elements
                        // location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error('Score update failed');
                        // Optionally, you can display an error message or perform any error handling
                    }
                });
            });
        });
    });
</script>

    
@endsection
