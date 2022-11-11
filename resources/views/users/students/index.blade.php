@extends('layouts.app')
@section('PageTitle', 'Students')

@section('css')
<link rel="stylesheet" href="/vendor/select2/css/select2.min.css">
<link href="/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
@endsection

@section('content')

<div class="content-body">
    <div class="container-fluid">

        <div class="card-header d-sm-flex d-block border-0 pb-0 mb-3">
            <div class="d-flex align-items-center">
                <div class="mb-2">
                    <select class="form-control">
                        <option>Bulk Action</option>
                        <option>Delete</option>
                        <option>Graduate</option>
                        <option>Suspend</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm mb-2 mx-2">Apply</button>
                <div class="mb-2 mx-sm-3">
                    <input type="text" placeholder="Search" class="form-control"/>
                </div>
            </div>

            <select class="default-select dashboard-select" id="select_class">
                <option value="All" value="all">All Active</option>
                @foreach ($classes as $class)
                <option data-display="{{ $class->name }}" value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
                <option value="Suspended" value="Suspended">Suspended</option>
                <option value="Transferred" value="Transferred">Transferred</option>
                <option value="Graduated" value="Graduated">Graduated</option>
            </select>
            <a href="{{ route('users.students.create') }}" class="btn btn-outline-primary mx-3">+ Add New Student(s)</a>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            @include('users.students.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('users.students.details_modal')
        @include('users.students.sno_modal')

    </div>
</div>
@endsection

@section('js')
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="/vendor/select2/js/select2.full.min.js"></script>
<script src="/js/plugins-init/select2-init.js"></script>
@include('users.students.script')
@endsection