@extends('layouts.app')
@section('PageTitle', 'Personalized Answer Sheets')


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title header-elements  d-flex">
                            <h5 class="m-0 me-2 d-none d-md-block">Personalized Answer Sheets</h5>
                        </div>
                        <form class="form" action="{{ route('answer_sheets.generate') }}" id="generateForm" method="POST" target="_blank">
                            <div class="row">
                                @csrf
                                <div class="col-sm-3 mb-1">
                                    <select class="form-select mb-2" id="class_id" name="class_id" required>
                                        <option value="">--Select Class--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label"></label>
                                    <button type="submit" id="generateButton" class="btn btn-primary">Generate</button>
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
{{-- <script>
    $(document).ready(function () {
        // Change the form ID to reportForm
        $('#generateForm').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            var submitButton = form.find('button[type="submit"]');
            var originalButtonText = submitButton.html();

            if ($('#class_id').val() == '') {
                toastr.error('Class Field is required');
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
                success: function (response) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'id_cards.pdf';
                    link.click();
                    toastr.success('ID Cards Generated Successfully.');
                },
                error: function () {
                    toastr.error('Failed to retrieve data.');
                },
                complete: function () {
                    submitButton.html(originalButtonText).removeAttr('disabled');
                }
            });
        });
    });
</script> --}}
@endsection



