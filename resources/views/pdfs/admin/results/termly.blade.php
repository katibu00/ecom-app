<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>End of Term Report Sheet</title>
    <link rel="stylesheet" type="text/css" href="/fontawesome/css/all.css">
    <link rel="stylesheet" type="text/css" href="/fontawesome/css/fontawesome.min.css">
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
        .footer{
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            left: 0;
            float: left;
            clear: both;
        }
       
    </style>
</head>
@php
    $count = $students->count();
    $settings = App\Models\ResultSettings::where('School_id',auth()->user()->school_id)->first();
@endphp

<body>

@foreach($students as $position => $student)
@php

    $withhold = 0;
    if($settings->withhold == 1)
    {
        $student_payments = App\Models\PaymentRecord::where('student_id',$student->student_id)
                ->where('session_id',$session_id)
                ->where('term',$term)
                ->where('class_id',$class_id)
                ->where('school_id',$school->id)
                ->sum('paid_amount');

        if($student_payments < $settings->minimun_amount)
        {
            $withhold = 1;
        }
    }
 
               
@endphp
<div class="container" style="margin-top: 0px;">
<div class="row">
    <div class="col-md-12">
       <table width="100%">
           <tr>
               <td class="text-center" width="15%">
                <img  @if($school->logo == null) src="/uploads/no-image.jpg" @else src="/uploads/{{ $school->username }}/{{ $school->logo }}" @endif style="width: 80px; height: 80px;">
            </td>
               <td class="text-center" width="85%">
                <{{ $school->heading }} style="text-transform: uppercase; color: #009879;"><strong>{{$school->name}}</strong></{{$school->heading}}>
                <h5 style="margin-top: -10px;"><strong>Tel: {{$school->phone_first}} | website: {{$school->website}} | Email: {{$school->email}}</strong></h5>
                <h5 style="margin-top: -20px;"><strong>{{$school->address}}</strong></h5>
            </td>
           </tr>
       </table>
       <div style="margin-top: -30px;">
        <h4 style="text-transform: uppercase; text-align: center; border-bottom: 2px solid #009879; border-top: 2px solid #009879; padding:5px; color: #009879;"><strong>Student's End of Term Report Form</strong></h4>
       </div>
    </div>

    <div style="width: 100%">
        <div style="width: 45%; float: left;">
                @php
                    $user = App\Models\User::select('id','first_name','middle_name','last_name','class_id','login')->where('id',$student->student_id)->first();
                @endphp
               <p style="margin-top: -15px;"><strong>Roll Number:</strong> {{$user->login}}</p>
               <p style="margin-top: -15px;"><strong>Name:</strong> {{$user->first_name}}  {{$user->middle_name}}  {{$user->last_name}}</p>
               <p style="margin-top: -15px; "><strong>Class: </strong> {{ $user->class->name }}</p>
               @if( @$user['parent']['first_name'] != null)<p style="margin-top: -15px;"><strong>Parent/Guardian: </strong> {{ @$user['parent']['title'] }}  {{ @$user['parent']['first_name'] }}  {{ @$user['parent']['last_name'] }}</p>@endif
               @if( @$user['parent']['phone'] != null) <p style="margin-top: -15px;"><strong>Mobile Number: </strong> {{$user['parent']['phone']}}</p>@endif
        </div>

        @php            
            $compulsorySubjects = App\Models\AssignSubject::where('designation', 1)
                    ->where('school_id', $school->id)
                    ->where('class_id', $user->class->id)
                    ->pluck('subject_id');

                // Fetch the subjects the student is offering
                $offeredSubjects = App\Models\SubjectOffering::where('student_id', $user->id)
                    ->where('offering', 1)
                    ->pluck('subject_id');

                // Merge the compulsory subjects with the offered subjects, and remove duplicates
                $subjects = App\Models\Subject::whereIn('id', $compulsorySubjects)
                    ->where('school_id', $school->id)
                    ->orWhereIn('id', $offeredSubjects)
                    ->distinct()
                    ->get();

            $subject_number = $subjects->count();

            $total = App\Models\ProcessedMark::select('total')->where('session_id',$session_id)->where('class_id',$class_id)->where('term',$term)->where('school_id',$school->id)->where('student_id',$student->student_id)->first();

            $total_marks = $total->total;
            $average =  $total_marks/$subject_number
         @endphp

        <div style="width: 40%; float: left; margin-left: 0px;">
                <p style="margin-top: -15px;"><strong>TERM:</strong> {{ ucfirst($term) }} Term</p>
                @php
                    $session = App\Models\Session::where('id',$session_id)->where('school_id',$school->id)->first();
                @endphp
                <p style="margin-top: -15px;"><strong>Session:</strong> {{$session->name}}</p>
                <p style="margin-top: -15px;"><strong>Class Population:</strong> {{$count}}</p>

                @if($settings->show_position == '1')
                   <p style="margin-top: -15px;"><strong>Position:</strong> @if($withhold == 0) {{ addOrdinalNumberSuffix($position+1) }} @else Withheld  @endif</p>
                @endif

                <p style="margin-top: -15px;"><strong>Marks Obtained:</strong>  @if($withhold == 0) {{ $total_marks }} out of   {{ $subject_number*100 }} @else Withheld @endif</p>
                <p style="margin-top: -15px;"><strong>Average Score:</strong> @if($withhold == 0) {{ number_format($average,2) }} @else Witheld @endif</p>
                @if($school->show_attendance == 'on')
                     @php
                         $absent = App\Models\Attendance::where('class_id', $class_id)->where('class_section_id',  $class_section_id)->where('school_id',  $school_id)->where('status','!=','present')->where('term',$term)->where('session_id',$session_id)->where('user_id',$user->id)->get()->count();
                         $number = App\Models\Attendance::select('date')->where('class_id', $class_id)->where('class_section_id',  $class_section_id)->where('school_id',  $school_id)->where('session_id',$session_id)->where('term',$term)->groupBy('date')->get()->count();
                     @endphp

                <p style="margin-top: -15px;"><strong>Attendance:</strong>Absent {{$absent}} out of {{$number}} times</p>
                @endif
        </div>

        <div style="width:15%; float: right;">
            @if($settings->show_passport == '1')
              <p style="margin-top: -10px; margin-left: 0px;"><img @if($user->image == null) src="/uploads/default.png" @else src="/uploads/{{$school->username}}/{{$user->image}}" @endif style="width: 100px; height: 100px; border: 0px solid black;"></p>
            @endif
        </div>
    </div>

    <div style="width: 100%; overflow: auto; clear:both; margin-top: 30px;" >
            <table class="styled-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">S/N</th>
                        <th style="width: 25%;">Subject</th>
                        @if($settings->break_ca == 1)
                            @php
                            $class_cas = App\Models\CAScheme::select('id','code')->where('school_id',$school->id)->where('class_id','like','%'.$class_id.'%')->where('status',1)->get();
                            @endphp
                            @foreach ($class_cas as $ca)
                            <th  class="text-center"  style="width: 3%;">{{ $ca->code }}</th>
                            @endforeach
                        @else
                        <th  class="text-center"  style="width: 5%;">CA</th>
                        @endif                      
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
                            <td class="text-left">{{ @$subject->name }}</td>

                            @if($withhold == 0)
                            @php
                                 $ca = App\Models\Mark::where('student_id', $student->student_id)->where('class_id',$class_id)->where('term',$term)->where('school_id',$school->id)->where('type','!=', 'exam')->where('subject_id',$subject->id)->sum('marks');
                                 $exam = App\Models\Mark::where('student_id', $student->student_id)->where('class_id',$class_id)->where('term',$term)->where('school_id',$school->id)->where('type','exam')->where('subject_id',$subject->id)->sum('marks');
                             
                                $total_score = $exam+$ca;
                                @$grade_marks = App\Models\Grade::where([['start_mark','<=',(int)$total_score],['end_mark','>=',(int)$total_score]])->where('type',$settings->grading_style)->first();
                                @$letter_grade = $grade_marks->letter_grade;
                                @$remark = $grade_marks->remarks;
                            @endphp
                           
                           @if($settings->break_ca == 1)
                                @foreach ($class_cas as $ca)
                                    @php
                                        $ca_score = App\Models\Mark::select('marks')->where('student_id',@$student->student_id)->where('class_id',$class_id)->where('term',$term)->where('school_id',$school->id)->where('type',$ca->code)->where('subject_id',$subject->id)->first();
                                    @endphp
                                <td class="text-center">{{ @$ca_score->marks }}</td>
                                @endforeach
                            @else

                                <td class="text-center">{{$ca}}</td>
                            @endif

                            @if($exam == 0)
                            <td class="text-center" colspan="4">In Progress</td>
                            @else
                             <td class="text-center">{{$exam}}</td>
                             <td class="text-center">{{$total_score}}</td>
                             <td class="text-center">{{@$letter_grade}}</td>
                             <td class="text-center">{{@$remark}}</td>
                             @endif
                             @else
                             <td colspan="5">Result Witheld Due to Non-payment of Fees</td>
                             @endif
                        </tr>
                    @endforeach

                </tbody>
            </table>
      
            @if(@$psychomotor)
            <div style="margin-top: 25px"></div>

            <div style="width: 100% margin: px; clear: both; overflow: hidden;">
                <div style="width: 47%; float: left;">
                    <table class="styled-table" style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Psychomotor Skills</th>
                                <th>5</th>
                                <th>4</th>
                                <th>3</th>
                                <th>2</th>
                                <th>1</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $psychomotors = App\Models\PsychomotorCrud::where('school_id',$school->id)->where('status',1)->get();
                            @endphp
                            @foreach ($psychomotors as $psychomotor)
                                @php
                                    $score = App\Models\PsychomotorGrade::select('score')->where('school_id',$school->id)->where('session_id',@$session_id)->where('term',@$term)->where('class_id',@$class_id)->where('student_id',$student->student_id)->where('grade_id',$psychomotor->id)->first();
                                @endphp
                                <tr>
                               
                                <td style="text-align: left;">{{ $psychomotor->name}}</td>
                                @if($withhold == 0)
                                <td>{!! @$score->score == 5? '<i class="fa fa-check"></i>': '' !!}</td>
                                <td>{!! @$score->score == 4? '<i class="fa fa-check"></i>': '' !!}</td>
                                <td>{!! @$score->score == 3? '<i class="fa fa-check"></i>': '' !!}</td>
                                <td>{!! @$score->score == 2? '<i class="fa fa-check"></i>': '' !!}</td>
                                <td>{!! @$score->score == 1? '<i class="fa fa-check"></i>': '' !!}</td>
                                @else
                                    <td colspan="5">Witheld</td>
                                @endif
                                </tr>
                            @endforeach     
                        </tbody>
                    </table>
                </div>

                <div style="width: 47%; float: right;">

                    <table class="styled-table" style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Affective Traits</th>
                                <th>5</th>
                                <th>4</th>
                                <th>3</th>
                                <th>2</th>
                                <th>1</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $affectives = App\Models\AffectiveCrud::where('school_id',$school->id)->where('status',1)->get();
                            @endphp
                            @foreach ($affectives as $affective)
                                @php
                                    $score = App\Models\PsychomotorGrade::select('score')->where('school_id',$school->id)->where('session_id',@$session_id)->where('term',@$term)->where('class_id',@$class_id)->where('student_id',$student->student_id)->where('grade_id',$affective->id)->first();
                                @endphp
                                <tr>
                                <td style="text-align: left;">{{ $affective->name}}</td>
                                @if($withhold == 0)
                                <td>{!! @$score->score == 5? '<i class="fa fa-check"></i>': '' !!}</td>
                                <td>{!! @$score->score == 4? '<i class="fa fa-check"></i>': '' !!}</td>
                                <td>{!! @$score->score == 3? '<i class="fa fa-check"></i>': '' !!}</td>
                                <td>{!! @$score->score == 2? '<i class="fa fa-check"></i>': '' !!}</td>
                                <td>{!! @$score->score == 1? '<i class="fa fa-check"></i>': '' !!}</td>
                                @else
                                <td colspan="5">Witheld</td>
                                @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <p style="margin-top: 10px"><strong>SCALE: </strong> 5 - Excellent, 4 - Good, 3 - Fair, 2 - Poor, 1 - Very Poor</p>

            @endif

            @if(@$comments)
                @php
                    if($withhold == 0)
                    {
                        $principal = App\Models\Comment::select('comment','additional')->where('school_id', $school->id)
                        ->where('student_id', $user->id)
                        ->where('session_id', $session_id)
                        ->where('term', $term)
                        ->where('class_id', $class_id)
                        ->where('officer', 'p')
                        ->first(); 
                    $master = App\Models\Comment::select('comment','additional')->where('school_id', $school->id)
                        ->where('student_id', $user->id)
                        ->where('session_id', $session_id)
                        ->where('term', $term)
                        ->where('class_id', $class_id)
                        ->where('officer', 'fm')
                        ->first();
                        $principal_comment = @$principal->comment.' '.@$principal->additional;
                        $master_comment = @$master->comment.' '.@$master->additional;
                        $principal_length = strlen($principal_comment);
                        $master_length = strlen($master_comment);

                    }
                   
                @endphp
                <div style="width: 100%; overflow: hidden; clear:both; margin-top: 0px;">
                    <p style="margin: 0 0px; font-size: {{ @$principal_length > 100 ? 12 : 15 }}px; line-height: 1.8em;">Form Master's Comment: <span
                            style="border-bottom: 1px solid black;  padding: 5px 10px;">
                            @if($withhold == 0) {{ @$master_comment }} @else Withheld @endif</span></p>
                    <p style="margin: 10px 0px; font-size: {{ @$principal_length > 100 ? 12 : 15 }}px; line-height: 1.8em;">Principal's Comment: <span
                            style="border-bottom: 1px solid black;  padding: 2px 10px;">
                            @if($withhold == 0) {{ @$principal_comment }} @else Withheld @endif</span></p>
                </div>
            @endif

            @if(@$next_term)
               <p style="font-size: 14px; margin-top: 10px;">Next Term Begins: {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}</p>
            @endif
    </div>
    <div style=" width: 100%; overflow: hidden; clear:both; margin-top: 5px;">
        <div style="width: 20%; float: left; text-align: center;">
            <img src="/uploads/qr-code.png" style="width: 80px; height: 80px;">
        </div>

        <div style="width: 80%; float: right;">
            @if($settings->grading_style == 'waec')
                <p style="font-size: 12px;">INTERPRETATION OF GRADES: A1 Excellent 75 - 100%, B2 Very Good 70-74%, B3 Good 65-69%, C4 Credit 60-64%, C5 Credit 55-59%, C6 Credit 50-54%, D7 Pass 45-49%, E8 Pass 40-45%, F9 Fail 1-44%, ABSENT 0%</p>
            @endif
            @if($settings->grading_style == 'standard')
                <p style="font-size: 12px;">INTERPRETATION OF GRADES: A Excellent 70-100%, B Very Good 60-69%,  C Credit 50-59%, D Pass 40-49%, F Fail 1-39%, ABSENT 0%</p>
            @endif
        </div>
    </div>

    <div style=" width: 100%; margin-top: 0px; clear: bo4th;">
            <p style="font-size: 14px; text-align: center; margin-top: -35px;">THIS REPORT DOES NOT REQUIRE SIGNATURE</p>
    </div>
    <div class="footer">
        <p style="font-size: 13px; text-align: center">Generated on {{date("l, jS \of F Y ")}} @ {{date("h:i A")}} | intellisas</p>
    </div>

</div>
<br><br>
<div style=" page-break-before: always;"></div>
@endforeach
</body>

<script>
    window.onload = function(){
        window.print();
    }
</script>
</html>

<?php
                    

function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
    switch ($num % 10) {
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
    }
    }
    return $num.'th';
}

?>

