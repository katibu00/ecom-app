@extends('layouts.app')
@section('PageTitle', 'Schools')

@section('css')
<link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="content-body">
<!-- row -->
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center mb-3">
            <div class="mb-3 me-auto">
            </div>
            <a href="{{ route('school.admin.create') }}" class="btn btn-outline-primary mb-3">+ Add New School</a>
        </div>

       {{-- content --}}

       <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Registered Schools</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example4" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Students #</th>
                                <th>State </th>
                                <th>Fee/Student </th>
                                <th>Last Login </th>
                                <th>Registered</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $key => $school)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $school->name }}</td>
                                <td>{{ $school->username }}</td>
                                @php
                                    $students = App\Models\User::select('id')->where('usertype','student')->where('status','active')->where('school_id',$school->id)->get()->count();
                                @endphp
                                <td class="text-center">{{ $students }}</td>
                                <td>{{ $school->state }}</td>
                                <td class="text-center">&#x20A6;{{ $school->service_fee }}</td>
                                <td></td>
                                <td>{{ $school->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="dropdown dropstart text-center">
                                        <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#detailsModal" id="school_details" data-username="{{ $school->username }}">Details</a>
                                            <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#editModal" id="edit_school" data-name="{{ $school->name }}" data-username="{{ $school->username }}" data-service_fee="{{ $school->service_fee }}" data-heading="{{ $school->heading }}">Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Record payment</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Suspend</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Email Reset Link</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Reset Admin Password</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete Permanently</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        
        @include('intellisas.details_modal')
        @include('intellisas.edit_school_modal')
    </div>
</div>
@endsection

@section('js')
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/js/plugins-init/datatables.init.js"></script>
@include('intellisas.script')
@endsection