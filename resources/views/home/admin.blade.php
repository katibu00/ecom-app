@extends('layouts.app')
@section('PageTitle', 'Admin Home')
@section('content')
 <!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    
    <!-- Orders -->
    <div class="col-lg-2 col-6 mb-4">
      <div class="card">
        <div class="card-body text-center">
          <div class="badge rounded-pill p-2 bg-label-danger mb-2">
            <i class="ti ti-briefcase ti-sm"></i>
          </div>
          <h5 class="card-title mb-2">&#8358;{{ number_format($fee_collected,0) }}</h5>
          <small>Fee Collected</small>
        </div>
      </div>
    </div>

    <!-- Reviews -->
    <div class="col-lg-2 col-6 mb-4">
      <div class="card">
        <div class="card-body text-center">
          <div class="badge rounded-pill p-2 bg-label-success mb-2">
            <i class="ti ti-message-dots ti-sm"></i>
          </div>
          <h5 class="card-title mb-2">&#8358;{{ number_format($total_invoice-$fee_collected-$total_discount,0) }}</h5>
          <small>Outstanding</small>
        </div>
      </div>
    </div>
    <!-- Statistics -->
    <div class="col-lg-8 mb-4 col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <small class="text-muted">Fee Collection Stat (Totals this Term)</small>
          {{-- <small class="text-muted">Updated 1 month ago</small> --}}
        </div>
        <div class="card-body pt-2">
          <div class="row gy-3">
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                  <i class="ti ti-chart-pie-2 ti-sm"></i>
                </div>
                <div class="card-info">
                  <h5 class="mb-0">&#8358;{{ number_format($total_invoice,0) }}</h5>
                  <small>Invoice Raised</small>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-info me-3 p-2">
                  <i class="ti ti-users ti-sm"></i>
                </div>
                <div class="card-info">
                  <h5 class="mb-0">&#8358;{{ number_format($total_discount,0) }}</h5>
                  <small>Discounts</small>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-danger me-3 p-2">
                  <i class="ti ti-shopping-cart ti-sm"></i>
                </div>
                <div class="card-info">
                  <h5 class="mb-0">&#8358;{{ number_format($total_pre_bal,0) }}</h5>
                  <small>Pre. Balance</small>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-success me-3 p-2">
                  <i class="ti ti-currency-dollar ti-sm"></i>
                </div>
                <div class="card-info">
                  <h5 class="mb-0">&#8358;{{ number_format($total_expenses,0) }}</h5>
                  <small>Expenses</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>




  </div>
</div>
<!-- / Content -->
@endsection
@section('js')
<script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<script src="/assets/js/cards-statistics.js"></script>
@endsection