@extends('layouts.app')
@section('PageTitle', 'Monnify API Settings')

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
                   
                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">Monnify API Settings</h5>
                    <!-- Account -->
                    <ul id="error_list"></ul>
                    <form id="monnify_form" method="POST">
               
                        <div class="card-body">
                            <div class="row mb-3">
                                <label class="col-sm-3">Enable Monnify Payment Collection</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-switch ">
                                        <input class="form-check-input" type="checkbox" id="enableMonnifySwitch" name="enable_monnify" value="1" {{ @$monnify->enable_monnify ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enableMonnifySwitch"></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="monnifyFields" style="{{ @$monnify->enable_monnify ? 'display: block;' : 'display: none;' }}">
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Secret Key</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="secret_key"
                                            value="{{ @$monnify->secret_key }}" placeholder="Monnify Secret Key" />
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Public Key</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="public_key"
                                            value="{{ @$monnify->public_key }}" placeholder="Monnify Public Key">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Contract Code</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="contract_code"
                                            value="{{ @$monnify->contract_code }}" placeholder="Monnify Contact Code">
                                    </div>
                                </div>
                            </div>
        
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
    @include('settings.monnify.script')
@endsection
