@extends('layouts.app')
@section('PageTitle', 'Admin Home')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('warning_message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {!! session('warning_message') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">

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
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4 d-flex flex-column align-self-end">
                                <div class="d-flex gap-2 align-items-center mb-2 pb-1 flex-wrap">
                                    <h5 class="mb-0">₦{{ number_format($revenueThisMonth, 0) }} (This Month)</h5>
                                    {{-- @if ($percentageChange > 0)
                                        <div class="badge rounded bg-label-success">
                                            +{{ number_format($percentageChange, 1) }}%</div>
                                    @elseif ($percentageChange < 0)
                                        <div class="badge rounded bg-label-danger">
                                            {{ number_format($percentageChange, 1) }}%</div>
                                    @else
                                        <div class="badge rounded bg-label-primary">No Change</div>
                                    @endif --}}
                                </div>
                                <small class="text-muted">The more students with Payment Slip, the more accurate your
                                    Expected Fee</small>
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
                                        $progress = $expectedRevenueSum != 0 ? number_format(($fee_collected / $expectedRevenueSum) * 100, 2) : 0;
                                        $oustanding = $expectedRevenueSum != 0 ? number_format((($expectedRevenueSum - $fee_collected) / $expectedRevenueSum) * 100, 2) : 0;
                                        $expenses = $expectedRevenueSum != 0 ? number_format(($total_expenses / $expectedRevenueSum) * 100, 2) : 0;
                                    @endphp

                                    <h4 class="my-2 pt-1">₦{{ number_format($fee_collected, 0) }}</h4>
                                    <div class="progress w-75" style="height: 4px">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="badge rounded bg-label-info p-1"><i class="ti ti-chart-pie-2 ti-sm"></i>
                                        </div>
                                        <h6 class="mb-0">Oustanding</h6>
                                    </div>
                                    <h4 class="my-2 pt-1">₦{{ number_format($expectedRevenueSum - $fee_collected, 0) }}
                                    </h4>

                                    <div class="progress w-75" style="height: 4px">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $oustanding }}%" aria-valuenow="{{ $oustanding }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
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
                                        <div class="progress-bar bg-danger" role="progressbar"
                                            style="width: {{ $expenses }}%" aria-valuenow="{{ $expenses }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
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
                                @php
                                    $currentTerm = $school->term; 
                                    $totalClasses = $school->classes->count();
                                    $enteredCommentsClasses = $school->classes->filter(function ($class) use ($currentTerm) {
                                        return $currentTerm && $class->comments->where('term', $currentTerm)->count() > 0;
                                    })->count();
                                    $enteredPsychomotorClasses = $school->classes->filter(function ($class) use ($currentTerm) {
                                        return $currentTerm && $class->psychomotorSubmits->where('term', $currentTerm)->count() > 0;
                                    })->count();

                                    // $enteredExamScoresSubjects = $school->classes->reduce(function ($carry, $class) use ($currentTerm) {
                                    //     return $carry + $class->marks->where('term', $currentTerm)->where('type', 'exam')->count();
                                    // }, 0);


                                    $enteredExamScoresSubjects = $school->classes->reduce(function ($carry, $class) use ($currentTerm, $school) {
                                    $distinctSubjectClassPairs = [];

                                    foreach ($class->marks->where('session_id', $school->session_id) as $mark) {
                                        if ($mark->term === $currentTerm && $mark->type === 'exam') {
                                            $pair = $mark->subject_id . '-' . $mark->class_id;

                                            if (!in_array($pair, $distinctSubjectClassPairs)) {
                                                $distinctSubjectClassPairs[] = $pair;
                                                $carry++;
                                            }
                                        }
                                    }

                                    return $carry;
                                }, 0);

                                    $totalSubjects = $school->subjectAssignments->count();
                                @endphp
                                <li class="d-flex gap-3 align-items-center mb-lg-3 pt-2 pb-1">
                                    <div class="badge rounded bg-label-primary p-1"><i class="ti ti-ticket ti-sm"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Comments</h6>
                                        <small class="text-muted">{{ $enteredCommentsClasses }}/{{ $totalClasses }}
                                            Classes Entered</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                                    <div class="badge rounded bg-label-info p-1"><i class="ti ti-circle-check ti-sm"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Psychomotor/Affective</h6>
                                        <small class="text-muted">{{ $enteredPsychomotorClasses }}/{{ $totalClasses }}
                                            Classes Entered</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center pb-1">
                                    <div class="badge rounded bg-label-warning p-1"><i class="ti ti-clock ti-sm"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Exams Scores</h6>
                                        <small class="text-muted">{{ $enteredExamScoresSubjects }}/{{ $totalSubjects }} Subjects</small>
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
                        @if (count($upcomingBirthdays) > 0)
                            @foreach ($upcomingBirthdays as $userData)
                                <div class="upcoming-birthday py-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="student-info">
                                            <h6 class="student-name mb-0">
                                                {{ $userData['user']->user->first_name . ' ' . $userData['user']->user->middle_name . ' ' . $userData['user']->user->last_name }}
                                            </h6>
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
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#smsModal">
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

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Last 5 Payments</h5>
                            <small class="text-muted"></small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="activeProjects" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="activeProjects">
                                <a class="dropdown-item" href="{{ route('fee_collection.index') }}">Record New
                                    Payment</a>
                                <a class="dropdown-item" href="{{ route('invoices.index') }}">Invoices</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @if (count($payments) > 0)
                                @foreach ($payments as $payment)
                                    <li class="mb-4 d-flex">
                                        <div class="d-flex w-50 align-items-center me-3">

                                            <div>
                                                <h6 class="mb-0">{{ $payment['student']->first_name }}
                                                    {{ $payment['student']->last_name }}</h6>
                                                <small
                                                    class="text-muted">{{ number_format($payment['total_paid'], 0, ',', ',') }}/{{ number_format($payment['payable'], 0, ',', ',') }}
                                                    ({{ number_format($payment['current_payment'], 0, ',', ',') }} This
                                                    Trx)
                                                </small>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-grow-1 align-items-center">
                                            <div class="progress w-100 me-3" style="height: 8px">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: {{ number_format($payment['progress'], 0) }}%"
                                                    aria-valuenow="{{ number_format($payment['progress'], 0) }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="text-muted">{{ number_format($payment['progress'], 0) }}%</span>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">No Payments Recorded.</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Inspiration of the Moment</h5>
                        <blockquote class="blockquote">
                            <p class="mb-0">"{{ $randomQuote->quote }}"</p>
                            @if (isset($randomQuote->author))
                                <footer class="blockquote-footer mt-3">{{ $randomQuote->author }}</footer>
                            @endif
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>


    <script>
        var totalCAs = {{ $totalCAs }};
        var totalEnteredCAs = {{ $totalEnteredCAs }};
        var completionPercentage = totalCAs !== 0 ? (totalEnteredCAs / totalCAs * 100) : 0;

        var options = {
            series: [Math.round(completionPercentage)], // Rounding the percentage to the nearest integer
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
                            formatter: function(val) {
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
                    colorStops: [{
                            offset: 0,
                            color: '#0000FF'
                        },
                        {
                            offset: 100,
                            color: '#0000FF'
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
