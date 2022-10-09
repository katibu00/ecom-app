@extends('layouts.app')
@section('PageTitle', 'Subjects')
@section('content')

<div class="content-body">
<!-- row -->
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center mb-3">
            <div class="mb-3 me-auto">
            </div>
            <a href="" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-outline-primary mb-3">+ Add New Subject(s)</a>
        </div>

       {{-- content --}}

       <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Subjects</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('settings.subjects.table')
                </div>
            </div>
        </div>
    </div>
        
        @include('settings.subjects.addModal')
        @include('settings.subjects.editModal')
    </div>
</div>
@endsection

@section('js')
<script src="/js/sweetalert.min.js"></script>
@include('settings.subjects.script')
@endsection