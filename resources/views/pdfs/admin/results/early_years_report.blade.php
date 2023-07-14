<html>
<head>
    <title>Early Years Report</title>
    <style>
        body {
            font-family: "Comic Sans MS", cursive, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #ff3399;
            text-align: center;
            margin-top: 0;
            background-color: #f2f2f2;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }
        th {
            background-color: #ffcc99;
            color: #333333;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        tr:nth-child(odd) {
            background-color: #ebebeb;
        }
        .grade-excellent {
            background-color: #7be39f;
            color: #ffffff;
        }
        .grade-very-good {
            background-color: #ffcc00;
            color: #ffffff;
        }
        .grade-good {
            background-color: #66b3ff;
            color: #ffffff;
        }
        .grade-needs-improvement {
            background-color: #ff9933;
            color: #ffffff;
        }
        .grade-not-assessed {
            background-color: #cccccc;
            color: #333333;
        }
        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>
    @foreach($students as $student)
    <div style="page-break-after: always;">
        <h1>Early Years Report - {{ $student->first_name.' '.$student->middle_name.' '.$student->last_name }}</h1>

        <table>
            <thead>
                <tr>
                    <th>Learning Domain</th>
                    <th>Learning Outcome</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($domains as $domain)
                <tr>
                    <td rowspan="{{ count($domain->learningOutcomes) }}" style="background-color: #ffcc99; color: #333333;">{{ $domain->name }}</td>
                    @foreach($domain->learningOutcomes as $key => $outcome)
                    @if($key > 0)
                    <tr>
                    @endif
                    <td class="text-left">{{ $outcome->name }}</td>
                    <td>
                        @php
                            $grade = $student->earlyYearMarks()->where('learning_outcome_id', $outcome->id)->first();
                            $gradeText = '';
                            $gradeClass = '';
                            if ($grade) {
                                switch ($grade->grade) {
                                    case 'vg':
                                        $gradeText = 'Very Good';
                                        $gradeClass = 'grade-very-good';
                                        break;
                                    case 'ex':
                                        $gradeText = 'Excellent';
                                        $gradeClass = 'grade-excellent';
                                        break;
                                    case 'g':
                                        $gradeText = 'Good';
                                        $gradeClass = 'grade-good';
                                        break;
                                    case 'ni':
                                        $gradeText = 'Needs Improvements';
                                        $gradeClass = 'grade-needs-improvement';
                                        break;
                                    case 'na':
                                        $gradeText = 'Not Assessed';
                                        $gradeClass = 'grade-not-assessed';
                                        break;
                                }
                            }
                        @endphp
                        <span class="grade {{ $gradeClass }}">{{ $gradeText }}</span>
                    </td>
                    @if($key > 0)
                    </tr>
                    @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
</body>
</html>