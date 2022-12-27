@extends('layouts.app')
@section('PageTitle', 'Attendance Overview')


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row mb-5">

            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements  d-flex flex-row">
                            <h5 class="m-0 me-2 d-none d-md-block">Attendance Overview</h5>
                        </div>


                        <div class="table-responsive text-nowrap">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Class</th>
                                  <th>Today's Report</th>
                                  <th>Recorded (This Term)</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                                @foreach ($classes as $key => $class)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                  <td>
                                    <strong>{{ $class->name }}</strong>
                                  </td>
                                  @php
                                      $presents_today = App\Models\Attendance::where('school_id',auth()->user()->school_id)
                                                        ->where('class_id',$class->id)
                                                        ->where('date',date('Y-m-d'))
                                                        ->where('status','present')
                                                        ->count();
                                      $absents_today = App\Models\Attendance::where('school_id',auth()->user()->school_id)
                                                        ->where('class_id',$class->id)
                                                        ->where('date',date('Y-m-d'))
                                                        ->where('status','absent')
                                                        ->count();
                                      $leaves_today = App\Models\Attendance::where('school_id',auth()->user()->school_id)
                                                        ->where('class_id',$class->id)
                                                        ->where('date',date('Y-m-d'))
                                                        ->where('status','leave')
                                                        ->count();

                                      $this_term = App\Models\Attendance::select('date')->where('school_id',auth()->user()->school_id)
                                                        ->where('class_id',$class->id)
                                                        ->where('session_id',$school->session_id)
                                                        ->where('term', $school->term)
                                                        ->groupBy('date')
                                                        ->get()
                                                        ->count();
                                  @endphp
                                  <td>
                                    @if($presents_today+$absents_today != 0)
                                    <i class="ti ti-check text-success"></i>: {{ $presents_today }}
                                    <i class="ti ti-x text-danger"></i>: {{ $absents_today }}
                                    <i class="ti ti-alert-triangle text-warning"></i> {{ $leaves_today }}
                                    @else
                                    <span class="badge bg-label-danger me-1">Not Recorded</span>
                                    @endif
                                </td>
                                 
                                  <td>
                                    {{ $this_term }} times
                                  </td>
                                  <td>
                                    <div class="dropdown">
                                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                      </button>
                                      <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item overview" data-class_id="{{ $class->id }}" data-name="{{ $class->name }}" 
                                            data-bs-toggle="modal" data-bs-target="#detailsModal"><i class="ti ti-pencil me-1"></i> Details (today)</button>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                          ><i class="ti ti-trash me-1"></i> Delete (Today)</a
                                        >
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                        
                        @include('attendance.details_modal')
                    
                 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@include('attendance.script')
@endsection


