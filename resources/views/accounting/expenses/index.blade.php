@extends('layouts.app')
@section('PageTitle', 'Expenses')

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
                <option value="All" value="approved">Approved</option>
                <option value="All" value="unapproved">Rejected</option>
                <option value="All" value="unapproved">Awaiting Approval</option>
                
            </select>
            <button data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-outline-primary mx-3">+ Record New Expense(s)</button>
        </div>

        

       {{-- content --}}

       <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Expenses</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                  @include('accounting.expenses.table')
                </div>
            </div>
        </div>
    </div>

    {{-- @include('users.students.details_modal') --}}
    @include('accounting.expenses.add_modal')

    </div>
</div>
@endsection

@section('js')
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/js/plugins-init/datatables.init.js"></script>
@include('accounting.expenses.script')
@endsection