@extends('layouts.app')
@section('PageTitle', 'Schools')

@section('css')
<link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="content-body">
<!-- row -->
    <div class="container-fluid">
    

        <div class="card-header d-sm-flex d-block border-0 pb-0 mb-3">
            <div class="me-auto mb-sm-0 mb-4">
               
            </div>
            <select class="default-select dashboard-select" id="select_class">
                <option value="All" value="all">All</option>
                @foreach ($classes as $class)
                <option data-display="{{ $class->name }}" value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('users.students.create') }}" class="btn btn-outline-primary mx-3">+ Add New Student(s)</a>
        </div>

        

       {{-- content --}}

       <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Registered Students</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                   @include('users.students.table')
                  
                </div>
            </div>
        </div>
    </div>

    @include('users.students.details_modal')

    </div>
</div>
@endsection

@section('js')
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/js/plugins-init/datatables.init.js"></script>
@include('users.students.script')
@endsection