<div class="table-responsive text-nowrap">
    <table class="table table-hover">
    <thead>
        <tr>
            <th class="text-center">S/N</th>
            <th>Class</th>
            <th class="text-center">Form Master</th>
            <th class="text-center">Principal</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($classes as $key => $row)
        @php
        $principal = App\Models\Comment::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term',$school->term)->where('class_id',$row->id)->where('officer','p')->first(); 
        $form_master = App\Models\Comment::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term',$school->term)->where('class_id',$row->id)->where('officer','fm')->first(); 
        @endphp

        <tr>
            
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ @$row->name }}</td>
            <td class="text-center">
               @if($form_master)
                 <i class="ti ti-checkbox" style="font-size: 22px; color: green"></i> <p class="fst-italic">{{ $form_master->created_at->diffForHumans() }}</p>
               @else
                 <i class="ti ti-square-x" style="font-size: 22px; color: red"></i>
               @endif
            </td>
            <td class="text-center">
                @if($principal)
                 <i class="ti ti-checkbox" style="font-size: 22px; color: green"></i> <p class="fst-italic">{{ $principal->created_at->diffForHumans() }}</p>
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
                        <a class="dropdown-item viewDetails" href="#" data-class_id="{{ $row->id }}" data-class_name="{{ $row->name }}" data-bs-toggle="modal" data-bs-target="#viewCommentsModal"><i class="ti ti-eye text-primary me-2"></i>View Comments</a>
                        <a class="dropdown-item" href="#"><i class="ti ti-trash me-1 text-danger"></i>Delete Comments</a>
                    </div>
                </div>
            </td>
           
        </tr>
        @endforeach
    </tbody>
</table>
</div>