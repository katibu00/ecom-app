@extends('layouts.app')
@section('PageTitle', 'Class Sections')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Class Sections</span>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addNewModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Class Section(s)
                    </button>
                </div>
            </div>
            @include('settings.class_section.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.class_section.add_modal')
        @include('settings.class_section.edit_modal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.class_section.script')
@endsection
