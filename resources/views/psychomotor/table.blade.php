<table class="table table-responsive-sm r">
    <thead>
        <tr>
            <th class="text-center">S/N</th>
            <th>Class</th>
            <th class="text-center">Psychomotor</th>
            <th class="text-center">Affective</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($classes as $key => $class)
        @php
        $psychomotor = App\Models\PsychomotorSubmit::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term',$school->term)->where('class_id',$class->id)->where('type', 1)->first(); 
        $affective = App\Models\PsychomotorSubmit::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term',$school->term)->where('class_id',$class->id)->where('type',2)->first(); 
       
       @endphp

        <tr>
            
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ @$class->name }}</td>
            <td class="text-center">
               @if($psychomotor)
                 <i class="ti ti-checkbox" style="font-size: 22px; color: green"></i> <p class="fst-italic">{{ $psychomotor->created_at->diffForHumans() }}</p>
               @else
                 <i class="ti ti-square-x" style="font-size: 22px; color: red"></i>
               @endif
            </td>
            <td class="text-center">
                @if($affective)
                <i class="ti ti-checkbox" style="font-size: 22px; color: green"></i> <p class="fst-italic">{{ $affective->created_at->diffForHumans() }}</p>
                @else
                 <i class="ti ti-square-x" style="font-size: 22px; color: red"></i>
               @endif
               
            </td>
            <td class="text-center">
                <div class="dropdown">
                    <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#fff" cx="5" cy="12" r="2"/><circle fill="#fff" cx="12" cy="12" r="2"/><circle fill="#fff" cx="19" cy="12" r="2"/></g></svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('psychomotor.view', ['class_id' => $class->id, 'type' => 1]) }}"><i class="ti ti-eye text-primary me-2"></i>View Psychomotor</a>
                        <a class="dropdown-item" href="{{ route('psychomotor.view', ['class_id' => $class->id, 'type' => 2]) }}"><i class="ti ti-eye text-primary me-2"></i>View Affective</a>
                        <a class="dropdown-item" href="#"><i class="ti ti-trash me-1 text-danger"></i>Delete All</a>
                    </div>
                </div>
            </td>
           
        </tr>
        
       
        
        @endforeach
    </tbody>
</table>