@extends('layouts.app')
@section('PageTitle', 'Bank Accounts')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">Bank Accounts</span>

                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addNewModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Bank Account(s)
                    </button>
                </div>
            </div>
            @include('settings.bank_accounts.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.bank_accounts.addModal')
        @include('settings.bank_accounts.editModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
    @include('settings.bank_accounts.script')
@endsection
