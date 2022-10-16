@extends('layouts.app')
@section('PageTitle', 'Termly Report')
@section('css')
{{-- <link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet"> --}}
<link href="/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- Clockpicker -->
<link href="/vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
<!-- asColorpicker -->
<link href="/vendor/jquery-asColorPicker/css/asColorPicker.min.css" rel="stylesheet">
<!-- Material color picker -->
<link href="/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
<link rel="stylesheet" href="/vendor/pickadate/themes/default.css">
<link rel="stylesheet" href="/vendor/pickadate/themes/default.date.css">
<link rel="stylesheet" href="/vendor/pickadate/themes/default.css">
<link rel="stylesheet" href="/vendor/pickadate/themes/default.date.css">
<link href="/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
@endsection
@section('content')    
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Termly Report</h4>
                        
                    </div>
                    <div class="card-body my-1 py-50">
                        <form class="form" action="{{ route('result.termly.index')}}" method="POST" target="_blank">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3 mb-1">
                                    <select class="default-select form-control wide mb-3" name="session_id">
                                        <option value="">--select Session--</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}" {{ $session->id == @$school->session_id ? 'selected':''}}>{{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('session_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="default-select form-control wide mb-3" name="class_id">
                                        <option value="">--Select Class--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3 mb-1">
                                    <select class="default-select form-control wide mb-3" name="term">
                                        <option value="">--Select Term--</option>
                                        <option value="first" {{ $school->term == 'first' ? 'selected':''}}>First</option>
                                        <option value="second" {{ $school->term == 'second' ? 'selected':''}}>Second</option>
                                        <option value="third" {{ $school->term == 'third' ? 'selected':''}}>Thirs</option>
                                    </select>
                                    @error('term')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label" for=""></label>
                                    <button type="submit" class="btn btn-primary">Search Records</button>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="comments">Comments
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input"  name="psychomotor">Psychomotor
                                    </label>
                                </div>
                               
                                <div class="form-check form-check-inline ">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="next_term" name="next_term">Next Term
                                    </label>
                                </div>
                                <div class="d-none" id="next_term_date">
                                    <div class="form-check form-check-inline">
                                        <input type="text" class="form-control" placeholder="2017-06-04" id="mdate" name="date">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
             
@endsection

@section('js')
    {{-- @include('marks.scripts') --}}
    {{-- <script src="/js/sweetalert.min.js"></script> --}}
    <script src="/vendor/moment/moment.min.js"></script>
    <script src="/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/vendor/pickadate/picker.js"></script>
    <script src="/vendor/pickadate/picker.time.js"></script>
    <script src="/vendor/pickadate/picker.date.js"></script>
<script src="/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="/js/plugins-init/material-date-picker-init.js"></script>
<!-- Pickdate -->
<script src="/js/plugins-init/pickadate-init.js"></script>

<script src="/js/plugins-init/pickadate-init.js"></script>
    {!! Toastr::message() !!}

    <script>
    $(document).on("click", "#next_term", function() { 

        if($(this).prop("checked") == true)
        {
            $('#next_term_date').removeClass('d-none');
        }else{
            $('#next_term_date').addClass('d-none');
        }
    });
    </script>
@endsection
