@extends('layouts.app')
@section('PageTitle', 'Psychomotor Skills')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Psychomotor Skills</span>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Psychomotor(s)
                    </button>
                </div>
            </div>
            @include('settings.psychomotor.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.psychomotor.addModal')
        @include('settings.psychomotor.editModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.psychomotor.script')
    <script src="/sweetalert.min.js"></script>
@endsection
