<div class="table-responsive text-nowrap">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center">S/N</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Designation</th>
                <th>Teacher</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $key => $value)
            <tr>
                
                <td class="text-center">{{ @$key + 1 }}</td>
                <td>{{ @$value->name }}</td>
                <td></td>
                <td></td>
                <td></td>
            
            </tr>
            @php
                @$subjects = App\Models\AssignSubject::where('class_id',@$value->id)->where('school_id',auth()->user()->school_id)->get();
            @endphp
            @foreach ($subjects as $row => $subject )
            <tr>
                <td></td>
                <td>{{ @$row+1 }}</td>
                <td>{{  @$subject->subject->name }}</td>
                <td>{{  @$subject->designation == 1 ? 'Compulsory':'Optional' }}</td>
                <td>{{  @$subject->teacher->title }} {{  @$subject->teacher->first_name }} {{  @$subject->teacher->last_name }}</td>
                <td class="text-center">
                    <div>
                        <button type="button" data-subject_name="{{ @$subject->subject->name }}" data-class_name="{{ @$value->name }}" data-id="{{ @$subject->id }}" data-teacher_id="{{ @$subject->teacher_id }}" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary shadow btn-xs sharp me-1 editItem"><i class="ti ti-pencil me-1"></i></button>
                        <button type="button" data-id="{{ @$subject->id }}" data-name="{{ @$subject->subject->name }}" class="btn btn-danger shadow btn-xs sharp deleteItem"><i class="ti ti-trash me-1"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
            
            @endforeach
        </tbody>
    </table>
</div>