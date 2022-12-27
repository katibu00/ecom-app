@extends('layouts.app')
@section('PageTitle', 'Attendance Report')


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row mb-5">

            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-title header-elements  d-flex flex-row">
                            <h5 class="m-0 me-2 d-none d-md-block">Attendance Report</h5>
                        </div>


                        <form class="form" action="{{ route('attendance.report.search')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 mb-1">
                                    <select class="default-select form-control wide mb-3" id="class_id" name="class_id">
                                        <option value="">--select Class--</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" {{$class->id == @$class_id? 'selected':''}}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-sm-4">
                                    <label class="form-label" for=""></label>
                                    <button type="submit" class="btn btn-primary">Search Students</button>
                                </div>
                            </div>
                        </form>

                        
                        @if(isset($dates))
                        <h6>Number of Days Recorded: {{ $dates->count() }} </h6>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Student</th>
                                  @foreach ($dates as $i => $date) 
                                  <th>{{ \Carbon\Carbon::parse($date->date)->format('D, d M') }}</th>
                                  @endforeach
                                 <th>Summary</th>
                                </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                                @foreach ($students as $key => $student)
                                    @php
                                        $std_absents = 0;
                                        $std_leaves = 0;
                                    @endphp
                                <tr>
                                    <td>{{ $key + 1}}</td>
                                    <td>{{ $student->first_name.' '.$student->middle_name.' '.$student->last_name }}</td>
                                    @foreach ($dates as $date)
                                        @php
                                        
                                            $attendance = App\Models\Attendance::select('status')->where('date',$date->date)->where('class_id',$class_id)->where('student_id',$student->id)->first();
                                        @endphp
                                        <td>
                                            @if($attendance->status == 'present')<i class="ti ti-check text-success"></i> @endif

                                            @if($attendance->status == 'absent')<i class="ti ti-x text-danger"></i>
                                            @php
                                                $std_absents++;
                                            @endphp
                                            @endif 
                                            @if($attendance->status == 'leave')<i class="ti ti-alert-triangle text-warning"></i>
                                            @php
                                                $std_leaves++;
                                            @endphp
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>{{ 'Abs: '.$std_absents.' Lea: '.$std_leaves }}</td>
                                </tr>
                                @endforeach

                              </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

