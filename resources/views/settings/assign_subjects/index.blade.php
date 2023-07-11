@extends('layouts.app')
@section('PageTitle', 'Classes')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Classes</span>

                <div class="card-header-elements ms-auto">
                    @if (count($classes) > 0)
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Assign Subjects
                    </button>
                    @endif
                </div>
            </div>
            @include('settings.assign_subjects.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.assign_subjects.addModal')
        @include('settings.assign_subjects.editModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.assign_subjects.script')
@endsection
