@extends('layouts.app')
@section('PageTitle', 'Fee Structure')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Fee Structure</span>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-success">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Fee Structure(s)
                    </button>
                </div>
            </div>
            @include('settings.fee_structure.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.fee_structure.addModal')
        @include('settings.fee_structure.detailsModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.fee_structure.script')
@endsection
