@extends('layouts.app')
@section('PageTitle', 'Affective Traits')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Affective Traits</span>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Affective Trait(s)
                    </button>
                </div>
            </div>
            @include('settings.affective.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.affective.addModal')
        @include('settings.affective.editModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.affective.script')
    <script src="/sweetalert.min.js"></script>
@endsection
