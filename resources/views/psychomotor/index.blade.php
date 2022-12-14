@extends('layouts.app')
@section('PageTitle', 'Psychomotor Grade')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-header header-elements">
                            <span class="me-2">Psychomotor Grade</span>

                            <div class="card-header-elements ms-auto">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                                    class="btn btn-sm btn-primary">
                                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Psychomotor Grade
                                </button>
                            </div>
                        </div>

                        @include('psychomotor.table')

                    </div>
                </div>
                @include('psychomotor.addModal')
                @include('psychomotor.viewCommentsModal')
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/sweetalert.min.js"></script>
    @include('psychomotor.script')
    {!! Toastr::message() !!}
@endsection
