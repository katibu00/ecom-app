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
        @foreach ($classes as $key => $row)
        @php
        $psychomotor = App\Models\PsychomotorSubmit::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term',$school->term)->where('class_id',$row->id)->where('type','psychomotor')->first(); 
        $affective = App\Models\PsychomotorSubmit::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term',$school->term)->where('class_id',$row->id)->where('type','affective')->first(); 
       
       @endphp

        <tr>
            
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ @$row->name }}</td>
            <td class="text-center">
               @if($psychomotor)
                 <i class="fa fa-check-square" style="font-size: 22px; color: green"></i> <p class="fst-italic">{{ $psychomotor->created_at->diffForHumans() }}</p>
               @else
                 <i class="fa fa-window-close-o" style="font-size: 22px; color: red"></i>
               @endif
            </td>
            <td class="text-center">
                @if($affective)
                 <i class="fa fa-check-square" style="font-size: 22px; color: green"></i> <p class="fst-italic">{{ $affective->created_at->diffForHumans() }}</p>
               @else
                 <i class="fa fa-window-close-o" style="font-size: 22px; color: red"></i>
               @endif
               
            </td>
            <td class="text-center">
                <div class="dropdown">
                    <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item viewDetails" href="#" data-class_id="{{ $row->id }}" data-class_name="{{ $row->name }}" data-bs-toggle="modal" data-bs-target="#viewCommentsModal"><i class="fa fa-eye text-primary me-2"></i>View Comments</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-trash text-danger me-2"></i>Delete Comments</a>
                    </div>
                </div>
            </td>
           
        </tr>
        
       
        
        @endforeach
    </tbody>
</table>