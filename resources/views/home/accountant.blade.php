@extends('layouts.app')
@section('PageTitle', 'IntelliSAS Home')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- first raw  -->
        <div class="row">
            <!-- View sales -->
            <div class="col-xl-4 mb-4 col-lg-5 col-12">
                <div class="card">
                    <div class="card-body ">
                        <h5 class="card-title mb-0">Welcome, {{ auth()->user()->first_name }}! 🎉</h5>
                        <p class="mb-2"><strong>Today's Quote:</strong> Be the change you want to see in the world.</p>
                        <p><strong>Date:</strong> {{ date('jS M') }} <strong>Session:</strong>
                            {{ $school->session->name . ' - ' . ucfirst($school->term) . ' Term' }}</p>
                    </div>
                </div>
            </div>
            <!-- View sales -->

            <!-- Statistics -->
            <div class="col-xl-8 mb-4 col-lg-7 col-12">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="card-title mb-0">Statistics</h5>
                            {{-- <small class="text-muted">Updated 1 month ago</small> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chalkboard" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 19h-3a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v11a1 1 0 0 1 -1 1"></path>
                                            <path d="M11 16m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                         </svg>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ $classes->count() }}</h5>
                                        <small>Managed Class(s)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-info me-3 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0"></path>
                                            <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0"></path>
                                            <path d="M3 6l0 13"></path>
                                            <path d="M12 6l0 13"></path>
                                            <path d="M21 6l0 13"></path>
                                         </svg>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ $subjects->count() }}</h5>
                                        <small>Subjects Assigned</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                         </svg>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ $students }}</h5>
                                        <small>Managed Students</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M3.5 5.5l1.5 1.5l2.5 -2.5"></path>
                                            <path d="M3.5 11.5l1.5 1.5l2.5 -2.5"></path>
                                            <path d="M3.5 17.5l1.5 1.5l2.5 -2.5"></path>
                                            <path d="M11 6l9 0"></path>
                                            <path d="M11 12l9 0"></path>
                                            <path d="M11 18l9 0"></path>
                                         </svg>
                                    </div>
                                    @php
                                        $yes = '<span class="text-success"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checkbox" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M9 11l3 3l8 -8"></path>
                                                <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                                </svg></span>';
                                        $no = '<span class="text-danger"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                <path d="M10 10l4 4m0 -4l-4 4"></path>
                                                </svg></span>';
                                    @endphp
                                    <div class="card-info">
                                        <h5 class="mb-0">{!! $attendance == 'yes' ? $yes : $no !!}</h5>
                                        <small>Attendance Taken Today</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics -->
        </div>


        <!-- second raw  -->
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Marking Progress</h5>
                            <small class="text-muted"></small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="MonthlyCampaign" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="MonthlyCampaign">
                                <a class="dropdown-item" href="javascript:void(0);">Go to Marks Entry</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @forelse ($subjects as $subject)
                            <li class="mb-4 d-flex">
                              <div class="d-flex w-50 align-items-center me-3">

                                <div>
                                  <h6 class="mb-0">{{ @$subject->subject->name.' ('.@$subject->class->name.')' }}</h6>
                                  <small class="text-muted">3/4 completed</small>
                                </div>
                              </div>
                              <div class="d-flex flex-grow-1 align-items-center">
                                <div class="progress w-100 me-3" style="height: 8px">
                                  <div
                                    class="progress-bar bg-danger"
                                    role="progressbar"
                                    style="width: 54%"
                                    aria-valuenow="54"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                  ></div>
                                </div>
                                <span class="text-muted">54%</span>
                              </div>
                            </li>
                            @empty
                            <p>No Subject Assigned to you</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Monthly Campaign State -->

            <!-- Active Projects -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Attendance Records</h5>
                            {{-- <small class="text-muted">Average 72% Completed</small> --}}
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="activeProjects" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="activeProjects">
                                <a class="dropdown-item" href="javascript:void(0);">Go to Attendances</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <!--/ Active Projects -->

            <!-- Source Visit -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Source Visits</h5>
                            {{-- <small class="text-muted">38.4k Visitors</small> --}}
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="sourceVisits" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sourceVisits">
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Download</a>
                                <a class="dropdown-item" href="javascript:void(0);">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <!--/ Source Visit -->
        </div>
    </div>

    <!-- / Content -->
@endsection
