@extends('layouts.app')
@section('PageTitle', 'Marks Submissions')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <section id="multssiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">Marks Submissions </h4>
                                </div>
                                <div class="card-body my-1 py-50">

                                    <form method="POST" action="{{ route('marks.submissions.search') }} ">
                                        @csrf
                                        <div class="row">



                                            <div class="col-sm-3 mb-1">
                                                <label class="form-label" for="department">Department</label>
                                                <select class="select2 form-select" name="department_id">
                                                    <option value="">Select Item</option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            {{ $department->id == @$request_department ? 'selected' : '' }}>
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('department_id')
                                                    <span class="text-danger">Department Field is Required</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 mb-1">
                                                <label class="form-label" for="level_order">Level</label>
                                                <select class="form-select" name="level_order">
                                                    <option value="">Select Item</option>
                                                    @foreach ($levels as $level)
                                                        <option value="{{ $level->order }}"
                                                            {{ $level->order == @$request_level ? 'selected' : '' }}>
                                                            {{ $level->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('level_order')
                                                    <span class="text-danger">Level Field is Required</span>
                                                @enderror
                                            </div>

                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-primary mt-2">Search</button>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row   @if (!isset($allData)) d-none @endif">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-collapsed"
                                                    style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Course Code</th>
                                                            <th style="width: 50%">Course Title</th>
                                                            <th>Registered</th>
                                                            <th>marked</th>
                                                            <th>Average Score</th>
                                                            <th>Clear Passes</th>
                                                            <th>Carry-overs</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            @if (isset($allData))

                                                                @if ($allData->count() > 0)


                                                                    @foreach ($allData as $key => $data)
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $data->course_code }}</td>
                                                                        <td>{{ $data->course_title }}</td>

                                                                        @php
                                                                            $registered = App\Models\CRF::where('session_id', $institution->session_id)
                                                                                ->where('level_order', $data->level_order)
                                                                                ->where('semester', $institution->semester)
                                                                                ->where('course_id', $data->id)
                                                                            
                                                                                ->get()
                                                                                ->count();
                                                                            
                                                                        @endphp
                                                                        <td class="text-center">{{ $registered }}</td>


                                                                        @php
                                                                            $marked = App\Models\Mark::select('user_id')
                                                                                ->where('session_id', $institution->session_id)
                                                                                ->where('level_order', $data->level_order)
                                                                                ->where('semester', $institution->semester)
                                                                                ->where('course_id', $data->id)
                                                                                ->where('type', 'exam')
                                                                                ->groupBy('user_id')
                                                                                ->get();
                                                                            
                                                                        @endphp
                                                                        <td class="text-center">{{ $marked->count() }}</td>


                                                                        <?php
                                                                        $total_marks = App\Models\Mark::where('session_id', $institution->session_id)
                                                                            ->where('level_order', $data->level_order)
                                                                            ->where('semester', $institution->semester)
                                                                            ->where('course_id', $data->id)
                                                                        
                                                                            ->sum('marks');
                                                                        
                                                                        ?>

                                                                        <td class="text-center">
                                                                            @if ($marked->count() > 0)
                                                                                {{ number_format($total_marks / $marked->count(), 2) }}
                                                                            @endif
                                                                        </td>

                                                                        <?php
                                                                        $passed = 0;
                                                                        $failed = 0;
                                                                        foreach ($marked as $student) {
                                                                            $total_score = App\Models\Mark::where('session_id', $institution->session_id)
                                                                                ->where('level_order', $data->level_order)
                                                                                ->where('semester', $institution->semester)
                                                                                ->where('user_id', $student->user_id)
                                                                                ->where('course_id', $data->id)
                                                                                ->sum('marks');

                                                                                if($total_score >= 40)
                                                                                {
                                                                                    $passed++;
                                                                                }
                                                                                if($total_score <= 39)
                                                                                {
                                                                                    $failed++;
                                                                                }
                                                                        }
                                                                        
                                                                        ?>
                                                                        <td class="text-center">{{ $passed }}</td>

                                                                       

                                                                        <td class="text-center"> {{ $failed }}</td>
                                                        </tr>
                                                        <?php 
                                                            $passed = 0;
                                                            $failed = 0;
                                                        ?>
                                                        @endforeach
                                                    @else
                                                        No Marks Found
                                                        @endif

                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
