<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>End of Term Report Sheet</title>
    <style type="text/css">
       .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            /* min-width: 400px; */
            width: 100%;
            margin: 0 auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }
        .styled-table th,
        .styled-table td {
            padding: 5px 5px;
        }
        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
        
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .text-left{
            text-align: left;
        }


        @media print{
            *{
                -webkit-print-color-adjust: exact;
            }
        }
       
    </style>
</head>
@php
    $count = $students->count();
@endphp

<body>

@foreach($students as $position => $student)
<div class="container" style="margin-top: -30px;">
<div class="row">
    <div class="col-md-12">
       <table width="100%">
           <tr>
               <td class="text-center" width="15%">
                <img  src="/uploads/{{$school->username}}/{{$school->logo}}" style="width: 80px; height: 80px;">
            </td>
               <td class="text-center" width="85%">
                <{{$school->heading}} style="text-transform: uppercase;"><strong>{{$school->name}}</strong></{{$school->heading}}>
                <h5 style="margin-top: -10px;"><strong>Tel: {{$school->phone_first}} | website: {{$school->website}} | Email: {{$school->email}}</strong></h5>
                <h5 style="margin-top: -20px;"><strong>{{$school->address}}</strong></h5>
            </td>

           </tr>
       </table>
       <div style="margin-top: -30px;">
        <h4 style="text-transform: uppercase; text-align: center; border-bottom: 2px solid black; border-top: 2px solid black; padding:5px;"><strong>Student's End of Term Report Form</strong></h4>
       </div>
    </div>


    <div style="width: 100%">
        <div style="width: 45%; float: left;">
                @php
                    $user = App\Models\user::where('id',$student->student_id)->first();
                @endphp
               <p style="margin-top: -15px;"><strong>Roll Number:</strong> {{$user->login}}</p>
               <p style="margin-top: -15px;"><strong>Name:</strong> {{$user->first_name}}  {{$user->middle_name}}  {{$user->last_name}}</p>
               <p style="margin-top: -15px; "><strong>Class: </strong> {{$user['class']['name']}}</p>
               @if( @$user['parent']['first_name'] != null)<p style="margin-top: -15px;"><strong>Parent/Guardian: </strong> {{ @$user['parent']['title'] }}  {{ @$user['parent']['first_name'] }}  {{ @$user['parent']['last_name'] }}</p>@endif
               @if( @$user['parent']['phone'] != null) <p style="margin-top: -15px;"><strong>Mobile Number: </strong> {{$user['parent']['phone']}}</p>@endif
        </div>

        @php
            $subjects = App\Models\Mark::select('subject_id')->where('session_id',$session_id)->where('term',$term)->where('class_id',$class_id)->where('school_id',$school->id)->groupBy('subject_id')->get();
            $subject_number = $subjects->count();

            $total = App\Models\ProcessedMark::select('total')->where('session_id',$session_id)->where('class_id',$class_id)->where('term',$term)->where('school_id',$school->id)->where('student_id',$student->student_id)->first();

            $total_marks = $total->total;
            $average =  $total_marks/$subject_number
         @endphp

        <div style="width: 40%; float: left; margin-left: 0px;">
                <p style="margin-top: -15px;"><strong>TERM:</strong> {{$term}} Term</p>
                @php
                    $session = App\Models\Session::where('id',$session_id)->where('school_id',$school->id)->first();
                @endphp
                <p style="margin-top: -15px;"><strong>Session:</strong> {{$session->name}}</p>
                <p style="margin-top: -15px;"><strong>Class Population:</strong> {{$count}}</p>

                @if($school->show_position == 'on')
                   <p style="margin-top: -15px;"><strong>Position:</strong> {{$position+1}}</p>
                @endif

                <p style="margin-top: -15px;"><strong>Marks Obtained:</strong> {{$total_marks}} out of   {{$subject_number*100}}</p>
                <p style="margin-top: -15px;"><strong>Average Score:</strong> {{number_format($average,2)}}</p>
                @if($school->show_attendance == 'on')
                     @php
                         $absent = App\Models\Attendance::where('class_id', $class_id)->where('class_section_id',  $class_section_id)->where('school_id',  $school_id)->where('status','!=','present')->where('term',$term)->where('session_id',$session_id)->where('user_id',$user->id)->get()->count();
                         $number = App\Models\Attendance::select('date')->where('class_id', $class_id)->where('class_section_id',  $class_section_id)->where('school_id',  $school_id)->where('session_id',$session_id)->where('term',$term)->groupBy('date')->get()->count();

                     @endphp

                <p style="margin-top: -15px;"><strong>Attendance:</strong>Absent {{$absent}} out of {{$number}} times</p>
                @endif
        </div>

        <div style="width:15%; float: right;">
            {{-- @if($school->show_passport == 'on') --}}
              <p style="margin-top: -10px; margin-left: 0px;"><img @if($user->image == 'default.png') src="/uploads/default.png" @else src="/uploads/{{$school->username}}/{{$user->image}}" @endif style="width: 100px; height: 100px; border: 0px solid black;"></p>
              {{-- @endif --}}
        </div>
    </div>

    <div style="width: 100%; overflow: auto; clear:both; margin-top: 30px;" >
            <table class="styled-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">S/N</th>
                        <th class="text-center"  style="width: 25%;">Subject</th>
                        <th class="text-center"  style="width: 5%;">CA</th>
                        <th class="text-center" style="width: 5%;" >Exam</th>
                        <th class="text-center"  style="width: 5%;">Total</th>
                        <th class="text-center"  style="width: 5%;">Grade</th>
                        <th class="text-center"  style="width: 15%;">Remarks</th>

                    </tr>
                </thead>
                <tbody>
                  
                    @foreach($subjects as $key => $subject)
                        @php
                           $subject_name = App\Models\Subject::select('name')->where('id',$subject->subject_id)->first();
                        @endphp
                        <tr>
                            <td class="text-center">{{$key+1}}</td>
                            <td class="text-left">{{$subject_name->name }}</td>

                            @php
                                 $ca = App\Models\Mark::where('student_id',$user->id)->where('class_id',$class_id)->where('term',$term)->where('school_id',$school->id)->where('type','!=', 'exam')->where('subject_id',$subject->subject_id)->sum('marks');
                                 $exam = App\Models\Mark::where('student_id',$user->id)->where('class_id',$class_id)->where('term',$term)->where('school_id',$school->id)->where('type','exam')->where('subject_id',$subject->subject_id)->sum('marks');

                                
                                 $total_score = $exam+$ca;

                                @$grade_marks = App\Models\Grade::where([['start_mark','<=',(int)$total_score],['end_mark','>=',(int)$total_score]])->where('type',$school->grading)->first();
                                @$letter_grade = $grade_marks->letter_grade;
                                @$remark = $grade_marks->remarks;


                            @endphp
                             <td class="text-center">{{$ca}}</td>
                             <td class="text-center">{{$exam}}</td>
                             <td class="text-center">{{$total_score}}</td>
                             <td class="text-center">{{@$letter_grade}}</td>
                             <td class="text-center">{{@$remark}}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{-- <p style="text-align: center; text-transform: uppercase; width: 100%; border-bottom: 2px solid black; padding: 5px;">REMARKS</p>

            <div style=" width: 100%; overflow: auto; clear:both; margin-top: -10px;">
                <div style="width: 50%; float: left; text-align: center;">
                    <p style="text-align: center; width: 80%; margin-left: 5%; margin-top: 7%; border-top: 1px solid black; padding: 5px;">Principal</p>
                </div>

                <div style="width: 50%; float: right;">
                    <p style="text-align: center; width: 80%; margin-left: 0%; margin-top: 7%; border-top: 1px solid black; padding: 5px;">Form Master</p>
                </div>
            </div> --}}



    </div>
    <div style=" width: 100%; overflow: auto; clear:both; margin-top: 30px;">
        <div style="width: 20%; float: left; text-align: center;">
            <img src="/uploads/qr-code.png" style="width: 80px; height: 80px;">
        </div>

        <div style="width: 80%; float: right;">
            <p style="font-size: 12px;">INTERPRETATION OF GRADES: A1 Excellent 75%-100%, B2 Very Good 70%-74%, B3 Good 65%-69%, C4 Credit 60%-64%, C5 Credit 55%-59%, C6 Credit 50%-54%, D7 Pass 45%-49%, E8 Pass 40%-45%, F9 Fail 1% - 44%, ABSENT 0%</p>
        </div>
    </div>

    {{-- <div style=" width: 100%; margin-top: 0px; clear: both;">
            <p style="font-size: 14px; text-align: center; margin-top: -5px;">THIS REPORT REQUIRES SIGNATURE</p>
    </div> --}}
    <div style=" width: 100%; margin-top: 0px;">
        <p style="font-size: 13px; text-align: center">Generated on {{date("l, jS \of F Y ")}} @ {{date("h:i A")}}</p>
    </div>

</div>
<br><br>
<div style=" page-break-before: always;"></div>
@endforeach
</body>

{{-- <script>
    window.onload = function(){
        window.print();

    }
</script> --}}
</html>

