@extends('layouts.app')
@section('PageTitle', 'Early Years Report Form')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements d-flex">
                            <h5 class="m-0 me-2 d-none d-md-block">Early Years Report Form</h5>
                        </div>

                        <form id="reportForm" class="" action="{{ route('generate-early-year-report') }}" method="POST">
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
                                    @error('session_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="class_id" id="class_id">
                                        <option value="">--Select Class--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" name="term" id="term">
                                        <option value="">--Select Term--</option>
                                        <option value="first" {{ $school->term == 'first' ? 'selected' : '' }}>First</option>
                                        <option value="second" {{ $school->term == 'second' ? 'selected' : '' }}>Second
                                        </option>
                                        <option value="third" {{ $school->term == 'third' ? 'selected' : '' }}>Thirs
                                        </option>
                                    </select>
                                    @error('term')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label" for=""></label>
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                </div>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
       
       $(document).ready(function() {
    $('#reportForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        var originalButtonText = submitButton.html();

        if($('#session_id').val() == '' || $('#class_id').val() == '' || $('#term').val() == '')
        {
            toastr.error('All Fields are required');
            return;
        }

        submitButton.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Please Wait...')
            .attr('disabled', 'disabled');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'early_years_report.pdf';
                link.click();
                toastr.success('Result Generated Successfully.');

            },
            error: function() {
                toastr.error('Failed to retrieve data.');
            },
            complete: function() {
                submitButton.html(originalButtonText).removeAttr('disabled');
            }
        });
    });
});

    </script>
@endsection

