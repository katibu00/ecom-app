@extends('layouts.app')
@section('PageTitle', 'At a Glance')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row mb-5">
        <div class="col-md">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title header-elements d-flex flex-row">
                        <h5 class="m-0 me-2 d-none d-md-block">At a Glance</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-2 table-sm">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Students</th>
                                    <th>Subjects</th>
                                    <th>Master</th>
                                    <th>Marking</th>
                                    <th>Fee Collection </th>
                                    <th>Attendance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $class)
                                <tr>
                                    <td>{{ $class->name }}</td>
                                    <td>{{ $class->students->count() }}</td>
                                    <td>{{ $class->assignedSubjects->count() }}</td>
                                    <td>{{ $class->formMaster->first_name }} {{ $class->formMaster->last_name }}</td>
                                    @php
                                    $ca = App\Models\CAScheme::where('school_id', $school->id)
                                                              ->where('class_id', 'LIKE', '%'.$class->id.'%')
                                                              ->count();
                                
                                    // Check if $ca is zero or if there are no assigned subjects
                                    $ca_progress = 0;
                                    if ($ca > 0 && $class->assignedSubjects->count() > 0) {
                                        $marked_ca = App\Models\Mark::select('type', 'subject_id')
                                                                    ->where('school_id', $school->id)
                                                                    ->where('session_id', $school->session_id)
                                                                    ->where('term', $school->term)
                                                                    ->where('class_id', $class->id)
                                                                    ->where('marks', '!=', null)
                                                                    ->groupBy('type', 'subject_id')
                                                                    ->count();
                                
                                        $ca_progress = number_format($marked_ca / ($ca * $class->assignedSubjects->count()) * 100, 2);
                                    }
                                    @endphp
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $ca_progress }}%;" aria-valuenow="{{ $ca_progress }}" aria-valuemin="0" aria-valuemax="100">{{ $ca_progress }}%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $class->getFeeCollectionProgress() }}%;" aria-valuenow="{{ $class->getFeeCollectionProgress() }}" aria-valuemin="0" aria-valuemax="100">{{ $class->getFeeCollectionProgress() }}%</div>
                                        </div>
                                    </td>
                                    <td>{{ $class->attendanceRecords->count() }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">

                                                <a class="dropdown-item" href="{{ route('glance.students', ['classId' => $class->id]) }}">
                                                    <i class="ti ti-users me-1"></i> Students
                                                </a>

                                                <a class="dropdown-item" href="{{ route('glance.subjects', ['classId' => $class->id]) }}">
                                                    <i class="ti ti-book me-1"></i> Subjects
                                                </a>

                                                <a class="dropdown-item" href="{{ route('glance.subject_offering', ['classId' => $class->id]) }}">
                                                    <i class="ti ti-check me-1"></i> Subjects Offering
                                                </a>
                                                
                                                <a class="dropdown-item" href="{{ route('glance.fee_structure', ['classId' => $class->id]) }}">
                                                    <i class="ti ti-businessplan me-1"></i> Fee Schedule
                                                </a>

                                                <a class="dropdown-item" href="{{ route('glance.invoices', ['classId' => $class->id]) }}">
                                                    <i class="ti ti-calendar me-1"></i> Invoices
                                                </a>

                                                <a class="dropdown-item" href="{{ route('glance.fee_collection', ['classId' => $class->id]) }}">
                                                    <i class="ti ti-report-money me-1"></i> Fee Collection
                                                </a>
                                                
                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i class="ti ti-file-check me-1"></i> Gradebook
                                                </a>

                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i class="ti ti-checklist me-1"></i> Attendance
                                                </a>
                                               
                                            </div>
                                        </div>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
  