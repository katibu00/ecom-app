@extends('layouts.app')
@section('PageTitle', 'Invoices')


@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header header-elements  d-flex flex-row">
               
                <form action="{{ route('invoices.bulk_action') }}" method="post" class=" col-md-6 col-sm-7">
                    @csrf
                    <div class="row">
                        <div class="col-3 mb-1">
                            <select class="form-select  form-select-sm" name="class_id">
                                <option value=""></option>                           
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach                         
                            </select>
                            @error('class_id')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3 mb-1">
                            <select class="form-select form-select-sm" name="action">
                                <option value=""></option>                           
                                <option value="delete">Delete</option>                           
                            </select>
                            @error('action')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-sm btn-secondary">Apply</button>
                        </div>
                     </div>
                 </form>
                <div class="card-header-elements ms-auto">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Generate Invoices
                    </button>
                </div>
            </div>
            @include('accounting.invoices.table')
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('accounting.invoices.addModal')
        @include('accounting.invoices.editModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
@include('accounting.invoices.script')
@endsection
