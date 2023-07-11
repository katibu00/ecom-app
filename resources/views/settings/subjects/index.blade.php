@extends('layouts.app')
@section('PageTitle', 'Subjects')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Subjects</span>

                <div class="card-header-elements ms-auto">
                    @if (count($subjects) > 0)
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addNewModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Subject(s)
                    </button>
                    @endif
                </div>
            </div>
            @include('settings.subjects.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.subjects.add_modal')
        @include('settings.subjects.edit_modal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.subjects.script')
@endsection
