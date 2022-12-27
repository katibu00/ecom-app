@extends('layout.master')
@section('PageTitle', 'Attendance Details')
@section('content')


    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Attendance Details ({{@$class->name}})</h4>
                            </div>
                            <a class="btn btn-success float-right btn-sm" href="{{route('attendance.index')}}"><i class="fa fa-arrow-left"></i>Go Back</a>
                        </div>
                        <hr>
                        <div class="iq-card-body">

                            <table class="table-sm table-bordered table-striped table-responsive" style="width: 100%; margin-top: -30px;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align:middle;">S/N</th>
                                        <th class="text-center" style="vertical-align:middle;">Date</th>
                                        <th class="text-center" style="vertical-align:middle;">Status</th>
                                        <th class="text-center" style="vertical-align:middle;">Absentees</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($dates as $key => $date)
                                        <tr class="text-center">
                                            <td>{{$key+1}}</td>
                                            <td >{{\Carbon\Carbon::parse($date->date)->format('l, jS M Y')}}</td>
                                            @php
                                            $absent = App\Models\Attendance::where('class_id', $class_id)->where('class_section_id',  $class_section_id)->where('school_id',  $school->id)->where('status','!=','present')->where('term',$school->term)->where('session_id',$school->session_id)->where('date',$date->date)->get()->count();
                                            @endphp

                                               @if ($absent == 0)
                                               <td> All Present</td>
                                               <td></td>
                                                @else

                                                @php
                                                $absents = App\Models\Attendance::where('class_id', $class_id)->where('class_section_id',  $class_section_id)->where('school_id',  $school->id)->where('status','!=','present')->where('term',$school->term)->where('session_id',$school->session_id)->where('date',$date->date)->get();
                                                @endphp
                                                 <td>{{$absents->count()}} Absents</td>
                                                 <td>
                                                @foreach ($absents as $absent)

                                              {{$absent['user']['first_name']}}  {{$absent['user']['middle_name']}} {{$absent['user']['last_name']}} <br>
                                                @endforeach
                                            </td>
                                               @endif
                                                {{-- {{$user['user']['first_name']}}  {{$user['user']['middle_name']}}  {{$user['user']['last_name']}} --}}
                                            </td>


                                    @endforeach

                                <tbody><br>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
