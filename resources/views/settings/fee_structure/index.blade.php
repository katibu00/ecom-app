@extends('layouts.app')
@section('PageTitle', 'Fee Structure')

@section('content')
    <!-- content @s -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <div class="row align-items-center">
                    <div class="col-md-4 col-sm-12 text-center text-md-start">
                        <h5 class="card-title text-white mb-0">Fee Structure</h5>
                    </div>
                    <div class="col-md-8 col-sm-12 mt-3 mt-md-0 text-center text-md-end">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-sm-6">
                                <label for="termSelect" class="form-label text-white mb-0">Change Term:</label>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <select class="form-select form-select-sm" id="termSelect" name="term">
                                    <option value="first">First Term</option>
                                    <option value="second">Second Term</option>
                                    <option value="third">Third Term</option>
                                </select>
                                
                            </div>
                            <div class="col-md-4 col-sm-12 mt-3 mt-md-0">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary">
                                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Fee Structure
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('settings.fee_structure.table')
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
        @include('settings.fee_structure.addModal')
        @include('settings.fee_structure.detailsModal')
        @include('settings.fee_structure.copyModal')
    </div>
    <!-- content @e -->
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    @include('settings.fee_structure.script')
@endsection
