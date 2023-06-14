@extends('layouts.app')
@section('PageTitle', 'Publish Result')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Publish Result</span>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addNewModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Publish New Result
                    </button>
                </div>
            </div>
            @include('results.publish.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('results.publish.add_modal')
        @include('results.publish.edit_modal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('results.publish.script')
@endsection
