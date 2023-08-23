@extends('layouts.app')
@section('PageTitle', 'SMS Gateway Settings')

@php
$route = Route::current()->getName();
@endphp

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ $route == 'settings.basic.index' ? 'active' : '' }}" href="{{ route('settings.basic.index') }}"><i class="ti-xs ti ti-users me-1"></i> School</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $route == 'settings.monnify.index' ? 'active' : '' }}" href="{{ route('settings.monnify.index') }}"><i
                                class="ti-xs ti ti-building me-1"></i> Monnify API</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $route == 'settings.sms_gateway.index' ? 'active' : '' }}" href="{{ route('settings.sms_gateway.index') }}"><i
                                class="ti-xs ti ti-message me-1"></i> SMS Gateway</a>
                    </li>
                   
                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">SMS Gateway Settings</h5>
                    <!-- Account -->
                    <ul id="error_list"></ul>
                    <form id="sms_form" method="POST">
                        <div class="card-body">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">SMS Provider</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="sms_provider" id="sms_provider">
                                        <option value="intellisas" {{ @$sms->sms_provider === 'intellisas' ? 'selected' : '' }}>IntelliSAS</option>
                                        <option value="smartsms" {{ @$sms->sms_provider === 'smartsms' ? 'selected' : '' }}>SmartSMS</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3" id="api_token_row">
                                <label class="col-sm-3 col-form-label">API Token</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="api_token" value="{{ @$sms->api_token }}" placeholder="SMS Provider API Token">
                                </div>
                            </div>
                            
                            <div class="row mb-3" id="sender_id_row">
                                <label class="col-sm-3 col-form-label">Sender ID</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sender_id" value="{{ @$sms->sender_id }}" placeholder="Sender ID">
                                </div>
                            </div>
                    
                            <p class="alert alert-info" id="intellisas_note" style="display: none;">
                                You can only use IntelliSAS to send passwords to staffs.
                            </p>
                            
                            <div class="mt-2">
                                <button type="submit" id="submit_btn" class="btn btn-primary me-2">Save changes</button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @include('settings.sms.script')
@endsection
