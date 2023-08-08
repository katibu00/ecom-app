@extends('layouts.app')
@section('PageTitle', 'Students')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row mb-5">
        <div class="col-md">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="m-0">{{ $name->name }} Subjects</h5>
                    <a href="{{ route('settings.subjects.index') }}" class="btn btn-primary">Manage Subjects</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Subject</th>
                                <th>Designation</th>
                                <th>Teacher</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $key => $subject)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $subject->subject->name }}</td>
                                <td>{{ $subject->designation == 1?'Mandatory':'Optional' }}</td>
                                <td>{{ $subject->teacher->first_name.' '.$subject->teacher->middle_name.' '.$subject->teacher->last_name }}</td>
                
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
