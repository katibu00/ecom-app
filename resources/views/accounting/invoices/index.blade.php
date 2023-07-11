@extends('layouts.app')
@section('PageTitle', 'Invoices')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap">
                <form action="{{ route('invoices.bulk_action') }}" method="post" class="col-md-6 col-sm-7">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-12 col-md-3 mb-2">
                            <select class="form-select form-select-sm" name="class_id">
                                <option value="">-- Class --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <select class="form-select form-select-sm" name="action">
                                <option value="">-- Action --</option>
                                <option value="delete">Delete</option>
                            </select>
                            @error('action')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <div class="col-12 col-md-2 mb-2">
                            <button type="submit" class="btn btn-sm btn-secondary">Apply</button>
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <select class="form-select form-select-sm" id="sortStudentType" name="sort_student_type">
                                <option value="">-- Sort by --</option>
                                <option value="regular">Regular</option>
                                <option value="transfer">Transfer</option>
                                @foreach ($studentTypes as $type)
                                    <option value="type_{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                                @foreach ($classes as $class)
                                    <option value="class_{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                </form>
                <div class="ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                        class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Generate Invoices
                    </button>
                </div>
            </div>
            <div class="card-body">
                @include('accounting.invoices.table')
            </div>
        </div>
        @include('accounting.invoices.addModal')
        @include('accounting.invoices.editModal')
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    @include('accounting.invoices.script')
@endsection
