@extends('layouts.app')
@section('PageTitle', 'Fee Categories')
@section('content')

<div class="content-body">
<!-- row -->
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center mb-3">
            <div class="mb-3 me-auto">
            </div>
            <a href="" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-outline-primary mb-3">+ Fee Category(s)</a>
        </div>

       {{-- content --}}

       <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Fee Categories</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('settings.fee_category.table')
                </div>
            </div>
        </div>
    </div>
        
        @include('settings.fee_category.addModal')
        @include('settings.fee_category.editModal')
    </div>
</div>
@endsection

@section('js')
<script src="/js/sweetalert.min.js"></script>
@include('settings.fee_category.script')
@endsection