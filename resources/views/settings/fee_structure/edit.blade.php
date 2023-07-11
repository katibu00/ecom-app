@extends('layouts.app')
@section('PageTitle', 'Edit Fee Structure')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-4">
        <div class="card-header header-elements">
            <h5 class="card-title">{{ $pageTitle = 'Edit Fee Structure: ' . (@$class->name ?: 'Unknown Class') . ' - ' . $termName . ' Term - ' . (@$studentType ?: 'Unknown Student Type') }}</h5>
            <div class="card-header-elements ms-auto">
                <a href="{{ route('settings.fee_structure.index') }}" class="btn btn-sm btn-info">
                    <span class="tf-icon ti ti-list ti-xs me-1"></span>Back to List
                </a>
            </div>
        </div>
       
        <div class="card-body">
            @include('settings.fee_structure.edit_table')
        </div>

    </div>
    @include('settings.fee_structure.editModal')
</div>
@endsection

@section('js')
    @include('settings.fee_structure.script')
    <script src="/sweetalert.min.js"></script>
@endsection

