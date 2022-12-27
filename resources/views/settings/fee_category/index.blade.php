@extends('layouts.app')
@section('PageTitle', 'Fee Categories')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Fee Categories</span>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addNewModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Fee Category(s)
                    </button>
                </div>
            </div>
            @include('settings.fee_category.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.fee_category.addModal')
        @include('settings.fee_category.editModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.fee_category.script')
    <script src="/sweetalert.min.js"></script>
@endsection
