@extends('layouts.app')
@section('PageTitle', 'Invoices')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <h5 class="me-2">Invoices</h5>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Generate Invoices
                    </button>
                </div>
            </div>
            @include('accounting.invoices.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('accounting.invoices.addModal')
        @include('accounting.invoices.editModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
@include('accounting.invoices.script')
@endsection
