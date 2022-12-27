<div class="table-responsive text-nowrap">
<table class="table">
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
            <td><strong>{{ @$value->name }}</strong></td>
            @php
                $regular = App\Models\FeeStructure::where('school_id',auth()->user()->school_id)->where('class_id',$value->id)->where('student_type','r')->first();
                $transfer = App\Models\FeeStructure::where('school_id',auth()->user()->school_id)->where('class_id',$value->id)->where('student_type','t')->first();
            @endphp
            <td class="text-center">@if($regular) 
                <div>
                    <a href="#" data-class_id="{{ $value->id }}" data-name="{{ $value->name }}" data-std_type="Regular" data-bs-toggle="modal" data-bs-target="#detailsModal" class="btn btn-info shadow btn-xs me-1 feeDetails"><i class="ti ti-eye me-1"></i></a>
                    <a href="{{ route('settings.fee_structure.edit','class_id='.$value->id.'&student_type=regular')}}" class="btn btn-primary btn-xs me-1"><i class="ti ti-pencil me-1"></i></a>
                </div>
                @else <span class="badge light badge-danger">Not Structured</span> @endif</td>

            <td class="text-center">@if($transfer) 
                
                <div>
                    <a href="#" data-class_id="{{ $value->id }}" data-name="{{ $value->name }}" data-std_type="Transfer" data-bs-toggle="modal" data-bs-target="#detailsModal" class="btn btn-info shadow btn-xs me-1 feeDetails"><i class="ti ti-eye me-1"></i></a>
                    <a href="#" data-id="{{ $value->id }}" data-name="{{ $value->name }}"  data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary btn-xs me-1 editItem"><i class="ti ti-pencil me-1"></i></a>
                </div>
                
                @else <span class="badge light badge-danger">Not Structured</span> @endif</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>