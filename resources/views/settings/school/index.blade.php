@extends('layouts.app')
@section('PageTitle', 'School Settings')

@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
@endsection

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
                    <h5 class="card-header">School Basic Settings</h5>
                    <!-- Account -->
                    <ul id="error_list"></ul>
                    <form id="edit_school_form" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img @if ($school->logo == 'default.jpg') src="/uploads/no-image.jpg" @else src="/uploads/{{ $school->username }}/{{ $school->logo }}" @endif
                                    alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new logo</span>
                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" hidden
                                            name="logo" accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>

                                    <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">School Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $school->name }}" placeholder="School Name" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="username"
                                            value="{{ $school->username }}" placeholder="Username" disabled />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Motto</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="motto"
                                            value="{{ $school->motto }}" placeholder="Motto">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="address"
                                            value="{{ $school->address }}" placeholder="Full Address">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="school_email"
                                            value="{{ $school->email }}" placeholder="School Email">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Phone Number</label>
                                    <div class="col-sm-10">
                                        <input type="tel" class="form-control" name="school_phone"
                                            value="{{ $school->phone_first }}" placeholder="School Mobile Phone Number">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Alternate Phone Number</label>
                                    <div class="col-sm-10">
                                        <input type="tel" class="form-control" name="alternate_phone"
                                            value="{{ $school->phone_second }}" placeholder="Alternate Phone Number">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Website</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="website"
                                            value="{{ $school->website }}" placeholder="Web Address">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Session</label>
                                    <div class="col-sm-10">
                                        <select id="" class="select2 form-select" name="session_id"
                                            data-allow-clear="true">
                                            <option value=""></option>
                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}"
                                                    {{ $school->session_id == $session->id ? 'selected' : '' }}>
                                                    {{ $session->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Term</label>
                                    <div class="col-sm-10">
                                        <select id="" class="select2 form-select" name="term"
                                            data-allow-clear="true">
                                            <option value=""></option>
                                            <option value="first" {{ $school->term == 'first' ? 'selected' : '' }}>First
                                            </option>
                                            <option value="second" {{ $school->term == 'second' ? 'selected' : '' }}>
                                                Second</option>
                                            <option value="third" {{ $school->term == 'third' ? 'selected' : '' }}>Third
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Fee/Head/Term</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="service_fee"
                                            value="{{ $school->service_fee }}"
                                            placeholder="Negociated Service Fee/Student" disabled>
                                    </div>
                                </div>



                            </div>
                            <div class="mt-2">
                                <button type="submit" id="submit_btn" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-label-secondary">Reset</button>
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

    <script src="/assets/vendor/libs/select2/select2.js"></script>
    @include('settings.school.script')
@endsection
