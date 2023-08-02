<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>End of Term Broadsheet Result</title>
    <style type="text/css">
        .content-table{
            border-collapse: collapse;
            margin: 0px; 0;
            font-size: 0.7em;

            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            /* box-shadow: 0 2px 12px rgba(22,22,22,0.1); */
            /* border-radius: 12px 12px 0 0; */
            border: 3px solid black;

        }

        .content-table thead tr{
            color: #14211e;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;

        }
        .content-table th,
        .content-table td{
            padding: 2px 10px;
        }
        .content-table tbody tr{
            border-bottom: 2px solid #dddddd;
        }
        .content-table tbody tr:nth-of-type(even){
            background-color: #f3f3f3;
        }
        .content-table tbody tr:last-of-type{
            border-bottom: 5px solid    #009878;
        }
        .content-table th{
            background-color: rgb(72, 67, 67);
            color: white;
        }
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
        p{
            font-size: 0.7em;
        }
    </style>
</head>
@php
    $class = App\Models\Classes::where('id',$class_id)->where('school_id',$school->id)->first();
@endphp

<body>
<div class="container" style="margin-top: 0px;">
<div class="row">
    <div class="col-md-12">
       <table width="100%">
           <tr>
               <td class="text-center" width="15%">
                <img src="{{asset("uploads").'/'.$institution->username.'/'.$institution->logo}}" style="width: 80px; height: 80px;">
            </td>
               <td class="text-center" width="85%">
                <{{$institution->heading}} style="text-transform: uppercase;"><strong>{{$school->name}}</strong></{{$institution->heading}}>
                <h5 style="margin-top: -10px;"><strong>Tel: {{$school->phone_first}} | website: {{$school->website}} | Email: {{$school->email}}</strong></h5>
                <h5 style="margin-top: -20px;"><strong>{{$school->address}}</strong></h5>
            </td>

           </tr>
       </table>
       <div style="margin-top: -40px;">
        <h4 style=" text-align: center; border-bottom: 2px solid black; padding:5px;">Class: {{$class->name}} &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; Students' End of Term Report Form (Broadsheet)  &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;<span style="margin-right: 0">Term: {{$school->term}} Term &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; {{$school['session']['name']}} Session</span></h4>
       </div>
    </div>

    </div>

    <div style="width: 100%; overflow: auto; clear:both; margin-top: 0px;">
        <div class="col-md-12">
            <table border="1" width="100%" cellpadding="1" cellspacing="2" class="content-table">
                <thead>
                    <tr>

                        <th class="text-center" style="width: 5%">S/N</th>
                        <th class="text-center" style="width: 20%">Name</th>
                        {{-- <th class="text-center"  >Roll Number</th> --}}


                       @php
                           $subjects = App\Models\Mark::select('subject_id')->where('class_id',$class_id)->where('term',$term)->where('school_id',$school_id)->groupBy('subject_id')->get();
                        @endphp

                      @foreach($subjects as $key => $subject)
                        @php
                          $subject_name = App\Models\Subject::select('name')->where('id', $subject->subject_id)->first();
                        @endphp

                            <th class="text-center">{{ @$subject_name->name }}</th>

                    @endforeach



                        <th class="text-center"  style="width: 10%;">Total</th>
                        <th class="text-center"  style="width: 10%;">Average</th>
                        <th class="text-center"  style="width: 10%;">Remarks</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $key => $student)

                    <tr>
                        <td class="text-center">{{$key + 1}}</td>
                        @php
                            @$user = App\Models\user::where('id',$student->student_id)->first();
                            $total_failed = 0;
                        @endphp
                        <td>{{@$user->first_name}} {{@$user->middle_name}} {{@$user->last_name}}</td>
                        {{-- <td>{{$user->roll_number}}</td> --}}

                        @foreach($subjects as $key => $subject)


                        @php

                        @$score = App\Models\Mark::where('student_id',@$user->id)->where('class_id',$class_id)->where('term',$term)->where('school_id',$school_id)->where('subject_id',$subject->subject_id)->sum('marks');
                        @$grade_marks = App\Models\Grade::where([['start_mark','<=',(int)$score],['end_mark','>=',(int)$score]])->where('type',$institution->grading)->first();
                        @$letter_grade = $grade_marks->letter_grade;
                           if ($score <= 39) {
                                $total_failed += 1;
                            }
                        @endphp

                            <td class="text-center">{{$score}} ({{$letter_grade}})</td>

                       @endforeach

                       @php
                       $total_score = App\Models\Mark::where('student_id',@$user->id)->where('class_id',$class_id)->where('term',$term)->where('school_id',$school_id)->sum('marks');
                       @endphp

                        <td class="text-center">{{$total_score}}</td>

                        <td class="text-center">{{number_format($total_score/$subjects->count(),2)}}</td>
                        <td class="text-center">@if($total_failed == 0) Clear Pass @else {{$subjects->count()-$total_failed}} Passes, {{$total_failed}} Fail @endif</td>

                    </tr>

                    @endforeach

                </tbody>
            </table>


            <div style=" width: 100%; overflow: auto; clear:both; margin-top: 20px;">
                <div style="width: 50%; float: left; text-align: center;">
                    <p style="text-align: center; width: 80%; margin-left: 5%; margin-top: 7%; border-top: 1px solid black; padding: 5px;">Principal</p>
                </div>

                <div style="width: 50%; float: right;">
                    <p style="text-align: center; width: 80%; margin-left: 0%; margin-top: 7%; border-top: 1px solid black; padding: 5px;">Form Master</p>
                </div>
            </div>


        </div>
    </div>

    <div style=" width: 100%; margin-top: -20px;">
        <p style="font-size: 13px; text-align: center">Generated on {{date("l, jS \of F Y ")}} @ {{date("h:i A")}}</p>
    </div>

</div>
</body>

</html>

