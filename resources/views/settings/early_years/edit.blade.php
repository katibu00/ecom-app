@extends('layouts.app')
@section('PageTitle', 'Edit Learning Domain')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Learning Domain</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('learning_domains.update', $learning_domain->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="domain">Domain</label>
                    <input type="text" class="form-control" id="domain" name="domain" value="{{ $learning_domain->name }}">
                </div>
                <div class="form-group">
                    <label for="outcomes">Learning Outcomes</label>
                    @foreach ($learning_domain->learningOutcomes as $outcome)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="outcomes[]" value="{{ $outcome->name }}">
                            <div class="input-group-append">
                                <button class="btn btn-danger removeOutcomeBtn" type="button">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-success" id="addOutcomeBtn">Add Outcome</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Add Outcome button click event
        $('#addOutcomeBtn').click(function() {
            var lastOutcomeRow = $('.input-group:last');
            var newOutcomeRow = '<div class="input-group mb-2">' +
                '<input type="text" class="form-control" name="outcomes[]" value="">' +
                '<div class="input-group-append">' +
                '<button class="btn btn-danger removeOutcomeBtn" type="button">Remove</button>' +
                '</div>' +
                '</div>';

            lastOutcomeRow.after(newOutcomeRow);
        });

        // Remove Outcome button click event
        $(document).on('click', '.removeOutcomeBtn', function() {
            $(this).closest('.input-group').remove();
        });
    });
</script>
@endsection



