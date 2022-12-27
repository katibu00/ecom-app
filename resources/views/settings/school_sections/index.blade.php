@extends('layouts.app')
@section('PageTitle', 'School Sections ')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">School Sections</span>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addNewModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Section
                    </button>
                </div>
            </div>
            @include('settings.school_sections.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.school_sections.add_modal')
        @include('settings.school_sections.edit_modal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.school_sections.script')
    <script src="/sweetalert.min.js"></script>
@endsection
