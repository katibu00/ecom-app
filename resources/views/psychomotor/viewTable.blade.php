@foreach (@$students as $student)
<div class="table-responsive">
    <table class="table table-sm table-hover" style="width: 40%">

        <thead>
            <caption>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</caption>
        </thead>
        <tbody>
           
            @foreach ($gradesLists as $key => $gradesList)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <th>{{ $gradesList->name }}</th>
                    @php
                    $score = App\Models\PsychomotorGrade::select('score')
                        ->where('class_id',$class_id)
                        ->where('term', $school->term)
                        ->where('session_id',$school->session_id)
                        ->where('school_id', $school->id)
                        ->where('student_id', $student->id)
                        ->where('grade_id', $gradesList->id)
                        ->where('type', $type)
                        ->first();
                    @endphp
                    <td>{{ @$score->score }}</td>
                    <td>
                        <div>
                            <button type="button" data-id="{{ @$value->id }}" data-name="{{ @$value->name }}" data-status="{{ @$value->status }}" class="btn btn-icon btn-outline-primary editItem"
                                data-bs-toggle="modal" data-bs-target="#editModal">
                                <span class="ti ti-pencil me-1"></span>
                            </button>
                            <button type="button"  class="btn btn-icon btn-outline-danger deleteItem">
                                <span class="ti ti-trash me-1"></span>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endforeach