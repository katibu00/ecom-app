@extends('layouts.app')
@section('PageTitle', 'Continous Assesment Scheme')

@section('css')
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
@endsection
@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">CA Scheme</span>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add CA Scheme
                    </button>
                </div>
            </div>
            @include('settings.ca_scheme.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.ca_scheme.addModal')
        @include('settings.ca_scheme.editModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.ca_scheme.script')
    <script src="/assets/vendor/libs/select2/select2.js"></script>
    <script src="/assets/js/modal-edit-user.js"></script>
@endsection
