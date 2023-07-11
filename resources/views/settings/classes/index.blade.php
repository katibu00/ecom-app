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
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addNewModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Class(s)
                    </button>
                    @endif
                </div>
            </div>
            @include('settings.classes.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.classes.add_modal')
        @include('settings.classes.edit_modal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.classes.script')
@endsection
