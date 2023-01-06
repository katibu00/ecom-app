@extends('layouts.app')
@section('PageTitle', 'Students')


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">


        <div class="row mb-5">




            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements  d-flex flex-row">
                            <h5 class="m-0 me-2 d-none d-md-block">Students</h5>

                            <div class="col-md-3 mb-1">
                                <input type="text" class="form-control form-control-sm" id="search"
                                    placeholder="Search by name or roll #..." />
                            </div>


                            <div class="card-title-elements ms-auto">
                                <select class="form-select form-select-sm w-auto" id="select_class">
                                    <option value="all">All Active</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                    <option value="Suspended" value="Suspended">Suspended</option>
                                    <option value="Transferred" value="Transferred">Transferred</option>
                                    <option value="Graduated" value="Graduated">Graduated</option>
                                </select>

                                <a href="{{ route('users.students.create') }}" class="btn btn-xs btn-primary">
                                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add New Students
                                </a>
                            </div>
                        </div>
                       
                         @include('users.students.table')

                    </div>
                </div>
            </div>
        </div>
        <!--/ Header elements -->


        @include('users.students.details_modal')
        @include('users.students.edit_modal')

    </div>

@endsection

@section('js')
    @include('users.students.script')
@endsection
