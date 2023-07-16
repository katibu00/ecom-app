<div class="table-responsive">
    <table class="table table-sm table-hover">

        <thead>
            <tr>
                <th>S/N</th>
                <th>Student</th>
                <th>S/N</th>
                <th>Grade</th>
                <th>Score</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $key => $student)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</td>
                <td>1</td>
                <td>{{ $gradesLists[0]->name }}</td>
                <td>
                    @php
                    $score = App\Models\PsychomotorGrade::select('score','id')
                        ->where('class_id',$class_id)
                        ->where('term', $school->term)
                        ->where('session_id',$school->session_id)
                        ->where('school_id', $school->id)
                        ->where('student_id', $student->id)
                        ->where('grade_id', $gradesLists[0]->id)
                        ->where('type', $type)
                        ->first();
                    @endphp
                    {{ @$score->score }}
                </td>
                <td>
                    <div>
                        <button type="button" data-id="{{ @$score->id }}" data-name="{{ @$value->name }}" data-status="{{ @$value->status }}" data-student-name="{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}" data-grade-name="{{ $gradesLists[0]->name }}" data-score="{{ @$score->score }}" class="btn btn-icon btn-outline-primary editItem"
                            data-bs-toggle="modal" data-bs-target="#editModal">
                            <span class="ti ti-pencil me-1"></span>
                        </button>                        
                    </div>
                </td>
            </tr>
            @for ($i = 1; $i < count($gradesLists); $i++)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $i+1 }}</td>
                <td>{{ $gradesLists[$i]->name }}</td>
                <td>
                    @php
                    $score = App\Models\PsychomotorGrade::select('score','id')
                        ->where('class_id',$class_id)
                        ->where('term', $school->term)
                        ->where('session_id',$school->session_id)
                        ->where('school_id', $school->id)
                        ->where('student_id', $student->id)
                        ->where('grade_id', $gradesLists[$i]->id)
                        ->where('type', $type)
                        ->first();
                    @endphp
                    {{ @$score->score }}
                </td>
                <td>
                    <div>
                        <button type="button" data-id="{{ @$score->id }}" data-name="{{ @$value->name }}" data-status="{{ @$value->status }}" data-student-name="{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}" data-grade-name="{{ $gradesLists[$i]->name }}" data-score="{{ @$score->score }}" class="btn btn-icon btn-outline-primary editItem"
                            data-bs-toggle="modal" data-bs-target="#editModal">
                            <span class="ti ti-pencil me-1"></span>
                        </button>                        
                    </div>
                </td>
            </tr>
            @endfor
            @endforeach
        </tbody>
    </table>
</div>
