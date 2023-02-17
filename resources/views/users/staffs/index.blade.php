@extends('layouts.app')
@section('PageTitle', 'Staffs')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements  d-flex flex-row">
                            <h5 class="m-0 me-2 d-none d-md-block">Staffs</h5>

                            <div class="col-md-3 mb-1">
                                <input type="text" class="form-control form-control-sm" id="search"
                                    placeholder="Search by name ..." />
                            </div>
                            <div class="card-title-elements ms-auto">
                                <select class="form-select form-select-sm w-auto" id="sort_staffs">
                                    <option value="all">All</option>
                                    <option value="1">Active</option>
                                    <option value="0" value="Inactive">Inactive</option>
                                </select>

                                <a href="{{ route('users.staffs.create') }}" class="btn btn-xs btn-primary">
                                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add New Staffs
                                </a>
                            </div>
                        </div>
                       
                         @include('users.staffs.table')

                    </div>
                </div>
            </div>
        </div>
        <!--/ Header elements -->
        @include('users.staffs.details_modal')
        @include('users.staffs.edit_modal')
    </div>
@endsection
@section('js')
    @include('users.staffs.script')
@endsection
