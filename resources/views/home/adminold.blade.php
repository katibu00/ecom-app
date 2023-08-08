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
                            <h5 class="mb-0 me-2">{{ number_format($totalStudents, 0) }}</h5>
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
                            <h5 class="mb-0 me-2">{{ number_format($totalParents, 0) }}</h5>
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
                            <h5 class="mb-0 me-2">{{ number_format($totalStaff, 0) }}</h5>
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





            <!-- Revenue Report -->
            <div class="col-12 col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header pb-3">
                        <h5 class="m-0 card-title">Revenue Report</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-bordered g-0">
                            <div class="col-md-8">
                                <div id="totalRevenueChart"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center mt-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="budgetId" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <script>
                                                document.write(new Date().getFullYear());
                                            </script>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="budgetId">
                                            <a class="dropdown-item prev-year1" href="javascript:void(0);">
                                                <script>
                                                    document.write(new Date().getFullYear() - 1);
                                                </script>
                                            </a>
                                            <a class="dropdown-item prev-year2" href="javascript:void(0);">
                                                <script>
                                                    document.write(new Date().getFullYear() - 2);
                                                </script>
                                            </a>
                                            <a class="dropdown-item prev-year3" href="javascript:void(0);">
                                                <script>
                                                    document.write(new Date().getFullYear() - 3);
                                                </script>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-center pt-4 mb-0">$25,825</h3>
                                <p class="mb-4 text-center"><span class="fw-semibold">Budget: </span>56,800</p>
                                <div class="px-3">
                                    <div id="budgetChart"></div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary">Increase Button</button>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- <script src="/assets/js/cards-analytics.js"></script> --}}


    {{-- <script>
 const legendColor = '#6C757D'; // Replace with your desired legend color
  const labelColor = '#6C757D'; 

  const totalRevenueChartEl = document.querySelector('#totalRevenueChart'),
  
    totalRevenueChartOptions = {
      series: [
        {
          name: 'Earning',
          data: [270, 210, 180, 200, 250, 280, 250, 270, 150]
        },
        {
          name: 'Expense',
          data: [-140, -160, -180, -150, -100, -60, -80, -100, -180]
        }
      ],
      chart: {
        height: 350,
        parentHeightOffset: 0,
        stacked: true,
        type: 'bar',
        toolbar: { show: false }
      },
      tooltip: {
        enabled: false
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '40%',
          borderRadius: 9,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: ['#1E88E5', '#FFC107'],
        dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 6,
        lineCap: 'round',
        colors: '#FF5722',
      },
      legend: {
        show: true,
        horizontalAlign: 'left',
        position: 'top',
        fontFamily: 'Public Sans',
        markers: {
          height: 12,
          width: 12,
          radius: 12,
          offsetX: -3,
          offsetY: 2
        },
        labels: {
          colors: legendColor
        },
        itemMargin: {
          horizontal: 5
        }
      },
      grid: {
        show: false,
        padding: {
          bottom: -8,
          top: 20
        }
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        labels: {
          style: {
            fontSize: '13px',
            colors: labelColor,
            fontFamily: 'Public Sans'
          }
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          offsetX: -16,
          style: {
            fontSize: '13px',
            colors: labelColor,
            fontFamily: 'Public Sans'
          }
        },
        min: -200,
        max: 300,
        tickAmount: 5
      },
      responsive: [
        {
          breakpoint: 1700,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '43%'
              }
            }
          }
        },
        {
          breakpoint: 1441,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '50%'
              }
            }
          }
        },
        {
          breakpoint: 1300,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '62%'
              }
            }
          }
        },
        {
          breakpoint: 991,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '38%'
              }
            }
          }
        },
        {
          breakpoint: 850,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '50%'
              }
            }
          }
        },
        {
          breakpoint: 449,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '73%'
              }
            },
            xaxis: {
              labels: {
                offsetY: -5
              }
            }
          }
        },
        {
          breakpoint: 394,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '88%'
              }
            }
          }
        }
      ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof totalRevenueChartEl !== undefined && totalRevenueChartEl !== null) {
    const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
    totalRevenueChart.render();
  }

    </script> --}}




    <script>
        const legendColor = '#6C757D';
        const labelColor = '#6C757D'; 
        const totalRevenueChartEl = document.querySelector('#totalRevenueChart');
    
        // Assuming you have passed the $chartData['paymentData'] and $chartData['expenseData'] arrays from the controller
        const paymentData = {!! json_encode($chartData['paymentData']) !!};
        const expenseData = {!! json_encode($chartData['expenseData']) !!};
        const months = {!! json_encode($chartData['months']) !!};
    
        const totalRevenueChartOptions = {
            series: [
                {
                    name: 'Earning',
                    data: paymentData
                },
                {
                    name: 'Expense',
                    data: expenseData
                }
            ],
            chart: {
                height: 350,
                parentHeightOffset: 0,
                stacked: true,
                type: 'bar',
                toolbar: { show: false }
            },
            tooltip: {
                enabled: false
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',
                    borderRadius: 9,
                    startingShape: 'rounded',
                    endingShape: 'rounded'
                }
            },
            colors: ['#1E88E5', '#FFC107'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 6,
                lineCap: 'round',
                colors: '#FF5722',
            },
            legend: {
                show: true,
                horizontalAlign: 'left',
                position: 'top',
                fontFamily: 'Public Sans',
                markers: {
                    height: 12,
                    width: 12,
                    radius: 12,
                    offsetX: -3,
                    offsetY: 2
                },
                labels: {
                    colors: legendColor
                },
                itemMargin: {
                    horizontal: 5
                }
            },
            grid: {
                show: false,
                padding: {
                    bottom: -8,
                    top: 20
                }
            },
            xaxis: {
                categories: months,
                labels: {
                    style: {
                        fontSize: '13px',
                        colors: labelColor,
                        fontFamily: 'Public Sans'
                    }
                },
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    offsetX: -16,
                    style: {
                        fontSize: '13px',
                        colors: labelColor,
                        fontFamily: 'Public Sans'
                    },
                    formatter: function (value) {
                        return "₦" + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    }
                },
                min: Math.min(...paymentData, ...expenseData) - 50,
                max: Math.max(...paymentData, ...expenseData) + 50,
                tickAmount: 5
            },
            responsive: [
                // Add your responsive options here
            ],
            states: {
                hover: {
                    filter: {
                        type: 'none'
                    }
                },
                active: {
                    filter: {
                        type: 'none'
                    }
                }
            }
        };
    
        if (typeof totalRevenueChartEl !== 'undefined' && totalRevenueChartEl !== null) {
            const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
            totalRevenueChart.render();
        }
    </script>
    
    




    <script>
        const budgetChartEl = document.querySelector('#budgetChart');
        const budgetChartOptions = {
          chart: {
            height: 100,
            toolbar: { show: false },
            zoom: { enabled: false },
            type: 'line'
          },
          series: [
            {
              name: 'Revenue',
              data: [2500, 3200, 2200, 3000, 3800, 4200, 3900, 3600, 3100, 4000, 4700]
            },
            {
              name: 'Expenses',
              data: [1800, 2100, 1900, 2400, 2200, 2700, 2600, 2300, 2500, 2100, 2400]
            }
          ],
          stroke: {
            curve: 'smooth',
            dashArray: [5, 0],
            width: [1, 2]
          },
          legend: {
            show: false
          },
          colors: ['#1E88E5', '#7367F0'],
          grid: {
            show: false,
            borderColor: '#f1f1f1',
            padding: {
              top: -30,
              bottom: -15,
              left: 25
            }
          },
          markers: {
            size: 0
          },
          xaxis: {
            labels: {
              show: false
            },
            axisTicks: {
              show: false
            },
            axisBorder: {
              show: false
            }
          },
          yaxis: {
            show: false
          },
          tooltip: {
            enabled: false
          }
        };
      
        if (typeof budgetChartEl !== undefined && budgetChartEl !== null) {
          const budgetChart = new ApexCharts(budgetChartEl, budgetChartOptions);
          budgetChart.render();
        }
      </script>
      
   



    {{-- <script>
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
    </script> --}}


    <script>
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Present', 'Absent', 'Leave'],
                datasets: [{
                    backgroundColor: ['#4CAF50', '#FF5722', '#FFC107'],
                    data: [{{ $present_percent }}, {{ $absent_percent }}, {{ $leave_percent }}]
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
