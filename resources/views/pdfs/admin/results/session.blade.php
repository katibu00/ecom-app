<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>End of Session Report Sheet</title>
    <style type="text/css">
        table {
            border-collapse: collapse;
        }

        h2 h3 {
            margin: 0;
            padding: 0;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table .table {
            background-color: #fff;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
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

        table tr td {
            padding: 5px;
        }

        .table-bordered thead th,
        .table-bordered td,
        .table-bordered th {
            border: 1px solid black !important;
        }

        .table-bordered thead th {
            background-color: #cacaca;
        }

        body {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

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
        
        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }
        }

        p {
            font-size: 14px;
        }
    </style>
</head>
@php
    $count = $students->count();
@endphp
@foreach ($students as $position => $student)

    <body>
        <div class="container" style="margin-top: 0px;">
            <div class="row">
                <div class="col-md-12">
                    <table width="100%">
                        <tr>
                            <td class="text-center" width="15%">
                                <img src="/uploads/{{ $school->username }}/{{ $school->logo }}"
                                    style="width: 80px; height: 80px;">
                            </td>
                            <td class="text-center" width="85%">
                                <{{ $school->heading }} style="text-transform: uppercase;">
                                    <strong>{{ $school->name }}</strong></{{ $school->heading }}>
                                    <h5 style="margin-top: -10px;"><strong>Tel: {{ $school->phone_first }} | website:
                                            {{ $school->website }} | Email: {{ $school->email }}</strong></h5>
                                    <h5 style="margin-top: -20px;"><strong>{{ $school->address }}</strong></h5>
                            </td>

                        </tr>
                    </table>
                    <div style="margin-top: -30px;">
                        <h4
                            style="text-transform: uppercase; text-align: center; border-bottom: 2px solid black; border-top: 2px solid black; padding:5px;">
                            <strong>Student's End of Session Report Form</strong>
                        </h4>
                    </div>
                </div>


                <div style="width: 100%">
                    <div style="width: 40%; float: left;">
                        @php
                            $user = App\Models\user::where('id', $student->student_id)->first();
                        @endphp
                        <p style="margin-top: -15px; text-transform:uppercase;"><strong>REG. NUMBER:</strong>
                            {{ @$user->login }}</p>
                        <p style="margin-top: -15px; text-transform:uppercase;"><strong>Name:</strong>
                            {{ @$user->first_name . ' ' . @$user->middle_name . ' ' . @$user->last_name }}</p>
                        <p style="margin-top: -15px; text-transform:uppercase;"><strong>Class: </strong>
                            {{ @$user->class->name }}</p>
                    </div>

                    @php
                        $subjects = App\Models\Mark::select('subject_id')
                            ->where('class_id', $class_id)
                            ->where('term', $term)
                            ->where('school_id', $school_id)
                            ->groupBy('subject_id')
                            ->get();
                        $subject_number = $subjects->count();
                        
                    @endphp

                    <div style="width: 40%; float: left; margin-left: 0px;">
                        @php
                            $session = App\Models\Session::where('id', $session_id)
                                ->where('school_id', $school_id)
                                ->first();
                        @endphp
                        <p style="margin-top: -15px;"><strong>SESSION:</strong> {{ $session->name }}</p>
                        <p style="margin-top: -15px;"><strong>Class Population:</strong> {{ $count }}</p>
                        <p style="margin-top: -15px;"><strong>Position:</strong> {{ $position + 1 }}</p>

                    </div>

                    <div style="width:20%; float: right;">
                        @if ($school->show_passport == 'on')
                            <p style="margin-top: -10px; margin-left: 0px;"><img
                                    @if ($user->image == 'default.png') src="/uploads/default.png" @else src="/uploads/{{ $school->username }}/{{ $user->image }}" @endif
                                    style="width: 100px; height: 100px; border: 0px solid black;"></p>
                        @endif
                    </div>
                </div>

                <div style="width: 100%; overflow: hidden; clear:both; margin-top: 30px;">

                    <table border="1" width="100%" cellpadding="1" cellspacing="2">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center" style="width: 5%">S/N</th>
                                <th rowspan="2" class="text-center" style="vertical-align:middle;width:25%">Subject
                                </th>
                                <th colspan="3" class="text-center" style="vertical-align:middle; width:30%;">Term
                            <tr>
                                <th class="text-center" style="display: table-cell;">First</th>
                                <th class="text-center" style="display: table-cell; ">Second</th>
                                <th class="text-center" style="display: table-cell;">Third</th>
                                <th rowspan="1" class="text-center" style="vertical-align:middle; width: 10%;">
                                    Average</th>
                                <th rowspan="1" class="text-center" style="vertical-align:middle; width: 10%;">Grade
                                </th>
                                <th rowspan="1" class="text-center" style="vertical-align:middle; width: 15%">Remarks
                                </th>
                            </tr>
                            </th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $subjects = App\Models\Mark::select('subject_id')
                                    ->where('class_id', $class_id)
                                    ->where('school_id', $school_id)
                                    ->groupBy('subject_id')
                                    ->get();
                            @endphp
                            @foreach ($subjects as $key => $subject)
                                @php
                                    $subject_name = App\Models\Subject::select('name')
                                        ->where('id', $subject->subject_id)
                                        ->first();
                                @endphp

                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ @$subject_name->name }}</td>

                                    {{-- First Term --}}
                                    <td class="text-center">
                                        @php
                                            $marks = App\Models\Mark::where('student_id', $user->id)
                                                ->where('class_id', $class_id)
                                                ->where('term', 'first')
                                                ->where('school_id', $school_id)
                                                ->where('session_id', $session_id)
                                                ->where('subject_id', $subject->subject_id)
                                                ->get();
                                            
                                            $total_first = 0;
                                            foreach ($marks as $key => $value) {
                                                $total_first += $value->marks;
                                            }
                                            
                                        @endphp
                                        {{ $total_first }}
                                    </td>
                                    {{-- Second Term --}}
                                    <td class="text-center">
                                        @php
                                            $marks = App\Models\Mark::where('student_id', $user->id)
                                                ->where('class_id', $class_id)
                                                ->where('term', 'second')
                                                ->where('school_id', $school_id)
                                                ->where('session_id', $session_id)
                                                ->where('subject_id', $subject->subject_id)
                                                ->get();
                                            
                                            $total_second = 0;
                                            foreach ($marks as $key => $value) {
                                                $total_second += $value->marks;
                                            }
                                            
                                        @endphp
                                        {{ $total_second }}
                                    </td>
                                    {{-- Third Term --}}
                                    <td class="text-center">
                                        @php
                                            $marks = App\Models\Mark::where('student_id', $user->id)
                                                ->where('class_id', $class_id)
                                                ->where('term', 'third')
                                                ->where('school_id', $school_id)
                                                ->where('session_id', $session_id)
                                                ->where('subject_id', $subject->subject_id)
                                                ->get();
                                            
                                            $total_third = 0;
                                            foreach ($marks as $key => $value) {
                                                $total_third += $value->marks;
                                            }
                                            
                                        @endphp
                                        {{ $total_third }}
                                    </td>

                                    @php
                                        $total_score = $total_first + $total_second + $total_third;
                                        $average_score = $total_score / 3;
                                        @$grade_marks = App\Models\Grade::where([['start_mark', '<=', (int) $average_score], ['end_mark', '>=', (int) $average_score]])
                                            ->where('type', $school->result_settings->grading_style)
                                            ->first();
                                        @$letter_grade = $grade_marks->letter_grade;
                                        @$remark = $grade_marks->remarks;
                                    @endphp
                                    <td class="text-center">{{ number_format($average_score, 2) }}</td>
                                    <td class="text-center">{{ $letter_grade }}</td>
                                    <td class="text-left">{{ $remark }}</td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                </div>

            </div>
            <div style=" width: 100%; overflow: auto; clear:both; margin-top: 20px;">
                <div style="width: 20%; float: left; text-align: center;">
                    <img src="/uploads/qr-code.png" style="width: 80px; height: 80px;">
                </div>

                <div style="width: 80%; float: right;">
                    @if ($school->result_settings->grading_style == 'waec')
                        <p style="font-size: 12px;">INTERPRETATION OF GRADES: A1 Excellent 75 - 100%, B2 Very Good
                            70-74%, B3 Good 65-69%, C4 Credit 60-64%, C5 Credit 55-59%, C6 Credit 50-54%, D7 Pass
                            45-49%, E8 Pass 40-45%, F9 Fail 1-44%, ABSENT 0%</p>
                    @endif
                    @if ($school->result_settings->grading_style == 'standard')
                        <p style="font-size: 12px;">INTERPRETATION OF GRADES: A Excellent 70-100%, B Very Good 60-69%, C
                            Credit 50-59%, D Pass 40-49%, F Fail 1-39%, ABSENT 0%</p>
                    @endif
                </div>
            </div>

            <div style=" width: 100%; margin-top: 0px; clear: bo4th;">
                <p style="font-size: 14px; text-align: center; margin-top: -35px;">THIS REPORT DOES NOT REQUIRE
                    SIGNATURE</p>
            </div>
            <div class="footer">
                <p style="font-size: 13px; text-align: center">Generated on {{ date('l, jS \of F Y ') }} @
                    {{ date('h:i A') }} | intellisas</p>
            </div>
            <br><br>
            <div style=" page-break-before: always;"></div>
@endforeach
</div>
</body>
{{-- <script>
        window.onload = function(){
            window.print();

        }
    </script> --}}

</html>
