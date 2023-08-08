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
                                    <i class="ti ti-trending-up ti-sm"></i>
                                </div>
                                <h5 class="card-title mb-2">&#8358;{{ number_format(@$expectedRevenueSum, 0) }}</h5>
                                <small>Expected Revenue</small>
                            </div>
                        </div>
                    </div>
        
                    <!-- Reviews -->
                    <div class="col-lg-2 col-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="badge rounded-pill p-2 bg-label-success mb-2">
                                    <i class="ti ti-wallet ti-sm"></i>
                                </div>
                                <h5 class="card-title mb-2">
                                    {{ number_format(@$paymentSlips, 0) }}</h5>
                                <small># Payment Slips</small>
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
                                        <i class="ti ti-file-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">&#8358;{{ number_format(@$total_invoice, 0) }}</h5>
                                        <small>Invoice Raised</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-info me-3 p-2">
                                        <i class="ti ti-discount ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">&#8358;{{ number_format(@$total_discount, 0) }}</h5>
                                        <small>Discounts</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                        <i class="ti ti-currency-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">&#8358;{{ number_format(@$total_pre_bal, 0) }}</h5>
                                        <small>Pre. Balance</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <i class="ti ti-file-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ number_format(@$invoice_count, 0) }}</h5>
                                        <small># Invoices</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fee Collection -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Revenue Reports</h5>
                            <small class="text-muted">This Term Revenue Overview</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="earningReportsId" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          <div class="col-12 col-md-4 d-flex flex-column align-self-end">
                            <div class="d-flex gap-2 align-items-center mb-2 pb-1 flex-wrap">
                              <h5 class="mb-0">₦{{ number_format($revenueThisMonth,0) }} (This Month)</h5>
                              @if ($percentageChange > 0)
                                <div class="badge rounded bg-label-success">+{{ number_format($percentageChange, 1) }}%</div>
                              @elseif ($percentageChange < 0)
                                <div class="badge rounded bg-label-danger">{{ number_format($percentageChange, 1) }}%</div>
                              @else
                                <div class="badge rounded bg-label-primary">No Change</div>
                              @endif
                            </div>
                            <small class="text-muted">The more students with Payment Slip, the more accurate your Expected Fee</small>
                          </div>
                            <div class="col-12 col-md-8">
                                <div id="weeklyEarningReports"></div>
                            </div>
                        </div>
                        <div class="border rounded p-3 mt-2">
                            <div class="row gap-4 gap-sm-0">
                                <div class="col-12 col-sm-4">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="badge rounded bg-label-primary p-1">
                                            <i class="ti ti-currency-dollar ti-sm"></i>
                                        </div>
                                        <h6 class="mb-0">Revenue</h6>
                                    </div>
                                    @php
                                        $progress = number_format($fee_collected/$expectedRevenueSum*100,2); 
                                        $oustanding = number_format(($expectedRevenueSum -$fee_collected)/$expectedRevenueSum*100,2); 
                                        $expenses = number_format(($total_expenses)/$expectedRevenueSum*100,2); 
                                    @endphp
                                    <h4 class="my-2 pt-1">₦{{ number_format($fee_collected,0) }}</h4>
                                    <div class="progress w-75" style="height: 4px">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="badge rounded bg-label-info p-1"><i class="ti ti-chart-pie-2 ti-sm"></i>
                                        </div>
                                        <h6 class="mb-0">Oustanding</h6>
                                    </div>
                                    <h4 class="my-2 pt-1">₦{{ number_format($expectedRevenueSum - $fee_collected,0) }}</h4>

                                    <div class="progress w-75" style="height: 4px">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $oustanding }}%"
                                            aria-valuenow="{{ $oustanding }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="badge rounded bg-label-danger p-1">
                                            <i class="ti ti-arrow-curve-right ti-sm"></i>
                                        </div>
                                        <h6 class="mb-0">Expense</h6>
                                    </div>
                                    <h4 class="my-2 pt-1">₦{{ $total_expenses }}</h4>
                                    <div class="progress w-75" style="height: 4px">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $expenses }}%"
                                            aria-valuenow="{{ $expenses }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CA Progress -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Marks Entry Progress</h5>
                            <small class="text-muted">This Term</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="supportTrackerMenu" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="supportTrackerMenu">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12 col-sm-4 col-md-12 col-lg-4">
                            <div class="mt-lg-4 mt-lg-2 mb-lg-4 mb-2 pt-1">
                                <h3 class="mb-0">{{ $totalEnteredCAs }}/{{ $totalCAs }}</h3>
                                <p class="mb-0">Marked CAs</p>
                            </div>
                            <ul class="p-0 m-0">
                                <li class="d-flex gap-3 align-items-center mb-lg-3 pt-2 pb-1">
                                    <div class="badge rounded bg-label-primary p-1"><i class="ti ti-ticket ti-sm"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Comments</h6>
                                        <small class="text-muted">0/7 Classes Entered</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                                    <div class="badge rounded bg-label-info p-1"><i class="ti ti-circle-check ti-sm"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Psychomotor/Affective</h6>
                                        <small class="text-muted">0/7 Classes Entered</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center pb-1">
                                    <div class="badge rounded bg-label-warning p-1"><i class="ti ti-clock ti-sm"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Exams Scores</h6>
                                        <small class="text-muted">34/45 Subjects</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-8 col-md-12 col-lg-8">
                            <div id="marksEntryProgress"></div>
                        </div>
                    </div>
                </div>
            </div>





            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2"><span class="text-danger">Trial</span></h5>
                            <small>Subscription</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded-pill p-2">
                                <i class="ti ti-tag ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2">{{ number_format(@$totalStudents, 0) }}</h5>
                            <small>Students</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded-pill p-2">
                                <i class="ti ti-school ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2">{{ number_format(@$totalParents, 0) }}</h5>
                            <small>Parents</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-danger rounded-pill p-2">
                                <i class="ti ti-building-factory-2 ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2">{{ number_format(@$totalStaff, 0) }}</h5>
                            <small>Staffs</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-warning rounded-pill p-2">
                                <i class="ti ti-building-factory ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Upcoming Birthdays</h5>
                    </div>
                    <div class="card-body">
                        @if (count($selectedUsers) > 0)
                            @foreach ($selectedUsers as $userData)
                                <div class="upcoming-birthday py-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="student-info">
                                            <h6 class="student-name mb-0">{{ $userData['user']->user->first_name.' '.$userData['user']->user->middle_name.' '.$userData['user']->user->last_name }}</h6>
                                            <p class="birthday-date text-muted mb-0">
                                                {{ Carbon\Carbon::createFromFormat('Y-m-d', $userData['user']->dob)->format('F d') }}
                                            </p>
                                            <p class="birthday-age text-muted mb-0">Age: {{ $userData['age'] }}</p>
                                            <p class="days-until-birthday text-muted mb-0">
                                                @if ($userData['days_until_birthday'] === 0)
                                                    Today is the birthday!
                                                @elseif ($userData['days_until_birthday'] === 1)
                                                    Tomorrow is the birthday
                                                @else
                                                    {{ $userData['days_until_birthday'] }} days until birthday
                                                @endif
                                            </p>
                                        </div>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#smsModal">
                                            <i class="bi bi-chat-text-fill"></i> SMS
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">No upcoming birthdays.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            
            



        </div>
    </div>


@endsection

@section('js')

<script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>


<script>
      var options = {
  series: [{{ number_format($totalEnteredCAs/$totalCAs*100,0) }}],
  chart: {
    height: 350,
    type: 'radialBar',
    offsetY: -10
  },
  plotOptions: {
    radialBar: {
      startAngle: -135,
      endAngle: 135,
      dataLabels: {
        name: {
          fontSize: '16px',
          color: '#0000FF', // Change to blue color
          offsetY: 120
        },
        value: {
          offsetY: 76,
          fontSize: '22px',
          color: '#0000FF', // Change to blue color
          formatter: function (val) {
            return val + "%";
          }
        }
      }
    }
  },
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'dark',
      shadeIntensity: 0.15,
      inverseColors: false,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 50, 65, 91],
      colorStops: [
        {
          offset: 0,
          color: '#0000FF' // Change to blue color
        },
        {
          offset: 100,
          color: '#0000FF' // Change to blue color
        }
      ]
    },
  },
  stroke: {
    dashArray: 4
  },
  labels: ['Marked CAs'],
};

var chart = new ApexCharts(document.querySelector("#marksEntryProgress"), options);
chart.render();

</script>

      

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const weeklyEarningReportsEl = document.querySelector("#weeklyEarningReports");
            const currentYearData = {!! json_encode($monthlyIncomes) !!};

            weeklyEarningReportsConfig = {
                chart: {
                    height: 202,
                    parentHeightOffset: 0,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        barHeight: '60%',
                        columnWidth: '38%',
                        startingShape: 'rounded',
                        endingShape: 'rounded',
                        borderRadius: 4,
                        distributed: true
                    }
                },
                grid: {
                    show: false,
                    padding: {
                        top: -30,
                        bottom: 0,
                        left: -10,
                        right: -10
                    }
                },
                colors: [
                    '#0000FF',
                ],
                dataLabels: {
                    enabled: false
                },
                series: [{
                    data: Object.values(currentYearData),
                }, ],
                legend: {
                    show: false
                },
                xaxis: {
                    categories: [
                        @foreach ($months as $month)
                            "{{ $month['month_name'] }}",
                        @endforeach
                    ],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#0000FF',
                            fontSize: '13px',
                            fontFamily: 'Public Sans'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        show: false
                    }
                },
                tooltip: {
                    enabled: true
                },
                responsive: [{
                    breakpoint: 1025,
                    options: {
                        chart: {
                            height: 199
                        }
                    }
                }]
            };
            if (typeof weeklyEarningReportsEl !== undefined && weeklyEarningReportsEl !== null) {
                const weeklyEarningReports = new ApexCharts(weeklyEarningReportsEl, weeklyEarningReportsConfig);
                weeklyEarningReports.render();
            }
        });
    </script>


@endsection
