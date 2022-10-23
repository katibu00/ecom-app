<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th class="text-center">S/N</th>
            <th>Class</th>
            <th class="text-center">Regular</th>
            <th class="text-center">Transfer</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($classes as $key => $value)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ @$value->name }}</td>
            @php
                $regular = App\Models\FeeStructure::where('school_id',auth()->user()->school_id)->where('class_id',$value->id)->where('student_type','r')->first();
                $transfer = App\Models\FeeStructure::where('school_id',auth()->user()->school_id)->where('class_id',$value->id)->where('student_type','t')->first();
            @endphp
            <td class="text-center">@if($regular) 

                <div>
                    <a href="#" data-class_id="{{ $value->id }}" data-name="{{ $value->name }}" data-std_type="Regular" data-bs-toggle="modal" data-bs-target="#detailsModal" class="btn btn-info shadow btn-xs sharp me-1 feeDetails"><i class="fa fa-eye"></i></a>
                    <a href="#" data-id="{{ $value->id }}" data-name="{{ $value->name }}"  data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary shadow btn-xs sharp me-1 editItem"><i class="fa fa-pencil"></i></a>
                    <a href="#" data-id="{{ $value->id }}" data-name="{{ $value->name }}" class="btn btn-danger shadow btn-xs sharp deleteItem"><i class="fa fa-trash"></i></a>
                </div>
                
                @else <span class="badge light badge-danger">Not Structured</span> @endif</td>


            <td class="text-center">@if($transfer) 
                
                <div>
                    <a href="#" data-class_id="{{ $value->id }}" data-name="{{ $value->name }}" data-std_type="Transfer" data-bs-toggle="modal" data-bs-target="#detailsModal" class="btn btn-info shadow btn-xs sharp me-1 feeDetails"><i class="fa fa-eye"></i></a>
                    <a href="#" data-id="{{ $value->id }}" data-name="{{ $value->name }}"  data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary shadow btn-xs sharp me-1 editItem"><i class="fa fa-pencil"></i></a>
                    <a href="#" data-id="{{ $value->id }}" data-name="{{ $value->name }}" class="btn btn-danger shadow btn-xs sharp deleteItem"><i class="fa fa-trash"></i></a>
                </div>
                
                @else <span class="badge light badge-danger">Not Structured</span> @endif</td>
        </tr>
        @endforeach
    </tbody>
</table>