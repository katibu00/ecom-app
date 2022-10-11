@extends('layouts.app')
@section('PageTitle', 'Comments Entry')
@section('content')

<div class="content-body">
<!-- row -->
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center mb-3">
            <div class="mb-3 me-auto">
            </div>
            <a href="" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-outline-primary mb-3">+ New Comments</a>
        </div>

       {{-- content --}}

       <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Comments Entry</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('comments.table')
                </div>
            </div>
        </div>
    </div>
        
        @include('comments.addModal')
        @include('comments.viewCommentsModal')
        {{-- @include('settings.assign_subjects.editModal') --}}
    </div>
</div>
@endsection

@section('js')
<script src="/js/sweetalert.min.js"></script>
@include('comments.script')
<script src="/handlebar/handlebars-v4.7.7.js"></script>
{!! Toastr::message() !!}
@endsection