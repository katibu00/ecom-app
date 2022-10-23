@extends('layouts.app')
@section('PageTitle', 'Invoices')
@section('css')
<link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')

<div class="content-body">
<!-- row -->
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center mb-3">
            <div class="mb-3 me-auto">
            </div>
            <a href="" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-outline-primary mb-3">+ Generate Invoices</a>
        </div>

       {{-- content --}}

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Invoices</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive fs-14">
                       @include('accounting.invoices.table')
                    </div>
                </div>
            </div>
        </div>
        
        @include('accounting.invoices.addModal')
        @include('accounting.invoices.viewCommentsModal')
    </div>
</div>
@endsection

@section('js')
<script src="/js/sweetalert.min.js"></script>
@include('accounting.invoices.script')
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/js/plugins-init/datatables.init.js"></script>
{!! Toastr::message() !!}
@endsection