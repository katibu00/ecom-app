@extends('layouts.app')
@section('PageTitle', 'Subjects Offering')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row mb-5">
        <div class="col-md">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="m-0">{{ $name->name }} Subjects</h5>
                    <a href="{{ route('subjects_offering.index') }}" class="btn btn-primary">Manage Subject Offering</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table mb-2 table-sm">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Students Offering</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($optional_subjects as $subject)
                                <tr>
                                    <td>{{ $subject->subject->name }}</td>
                                    <td>
                                        @if ($subject->students->count() > 0)
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($subject->students as $student)
                                                {{ $counter }}. {{ $student->student->first_name }} {{ $student->student->last_name }}
                                                <br>
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endforeach
                                        @else
                                            No student is offering this subject.
                                        @endif
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
