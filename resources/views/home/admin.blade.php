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
                        <h5 class="card-title mb-2">&#8358;{{ number_format($fee_collected, 0) }}</h5>
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
                        <h5 class="card-title mb-2">
                            &#8358;{{ number_format($total_invoice - $fee_collected - $total_discount, 0) }}</h5>
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
                                        <h5 class="mb-0">&#8358;{{ number_format($total_invoice, 0) }}</h5>
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
                                        <h5 class="mb-0">&#8358;{{ number_format($total_discount, 0) }}</h5>
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
                                        <h5 class="mb-0">&#8358;{{ number_format($total_pre_bal, 0) }}</h5>
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
                                        <h5 class="mb-0">&#8358;{{ number_format($total_expenses, 0) }}</h5>
                                        <small>Expenses</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- fee collection graph -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title m-0 me-2 pt-1 mb-2">Fee Collection</h5>

                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="timelineWapper" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineWapper">
                                <a class="dropdown-item" href="javascript:void(0);">Collect Fee</a>
                                <a class="dropdown-item" href="javascript:void(0);">Generate Invoices</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body pb-0">

                        <canvas id="fee_collection"></canvas>

                    </div>
                </div>
            </div>
            <!--/ fee collection graph -->

            <!-- attendance graph -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title m-0 me-2 pt-1 mb-2">Average Attendance (This Term)</h5>

                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="timelineWapper" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineWapper">
                                <a class="dropdown-item" href="javascript:void(0);">Attendace Report</a>
                                <a class="dropdown-item" href="javascript:void(0);">Take Attendance</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body pb-0">

                        <div style="width:50%; height: 50%;">
                          <canvas id="attendanceChart"></canvas>
                      </div>

                    </div>
                </div>
            </div>
            <!--/ attendance graph -->






        </div>
    </div>
    <!-- / Content -->
@endsection
@section('js')
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <script src="/assets/js/cards-statistics.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var totals = new Array(12).fill(0);

        <?php foreach ($payments as $payment): ?>
        totals[<?php echo $payment->month - 1; ?>] = <?php echo $payment->total; ?>;
        <?php endforeach; ?>

        var ctx = document.getElementById('fee_collection').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Total Amount Collected',
                    data: totals,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                
            }
        });
    </script>


    <script>
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Present', 'Absent', 'Leave'],
                datasets: [{
                    backgroundColor: ['#4CAF50', '#FF5722', '#FFC107'],
                    data: [{{$present_percent}}, {{$absent_percent}}, {{$leave_percent}}]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Attendance Chart'
                },
                
            }
        });
      </script>



@endsection
