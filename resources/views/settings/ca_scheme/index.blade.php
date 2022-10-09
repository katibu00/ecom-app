@extends('layouts.app')
@section('PageTitle', 'CA Scheme')
@section('content')

<div class="content-body">
<!-- row -->
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center mb-3">
            <div class="mb-3 me-auto">
            </div>
            <a href="" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-outline-primary mb-3">+ Add New CA Scheme(s)</a>
        </div>

       {{-- content --}}

       <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">CA Scheme</h4>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target=".instructions">Instructions</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('settings.ca_scheme.table')
                </div>
            </div>
        </div>
    </div>
        
        @include('settings.ca_scheme.addModal')
        @include('settings.ca_scheme.editModal')
        @include('settings.ca_scheme.instructions')
    </div>
</div>
@endsection

@section('js')
<script src="/js/sweetalert.min.js"></script>
@include('settings.ca_scheme.script')
@endsection