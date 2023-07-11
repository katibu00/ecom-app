<div class="table-responsive text-nowrap">
    <table class="table" id="feeTable">
        <thead>
            <tr>
                <th class="text-center">S/N</th>
                <th>Class</th>
                <th class="text-center">Regular</th>
                <th class="text-center">Transfer</th>
                @foreach ($student_types as $student_type)
                    <th class="text-center">{{ $student_type->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($feeStructure as $key => $row)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td><strong>{{ @$row['class']->name }}</strong></td>
                    <td class="text-center">
                        @if ($row['regular'])
                            <div>
                                <a href="#" data-class_id="{{ $row['class']->id }}" data-name="{{ $row['class']->name }}" data-std_type="Regular" data-term="{{ $row['regular']->term }}" data-bs-toggle="modal" data-bs-target="#detailsModal" class="btn btn-info shadow btn-xs me-1 feeDetails"><i class="ti ti-eye me-1"></i></a>
                                <a href="{{ route('settings.fee_structure.edit', ['class_id' => $row['class']->id, 'student_type' => 'regular', 'term' => $row['regular']->term]) }}" class="btn btn-primary btn-xs me-1"><i class="ti ti-pencil me-1"></i></a>
                                <a href="#" data-class_id="{{ $row['class']->id }}" data-name="{{ $row['class']->name }}" data-std_type="r" data-term="{{ $row['regular']->term }}" data-bs-toggle="modal" data-bs-target="#copyModal" class="btn btn-success btn-xs me-1 copyItem"><i class="ti ti-files me-1"></i></a>
                            </div>
                        @else
                            <span class="badge bg-warning">Fee not structured</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($row['transfer'])
                            <div>
                                <a href="#" data-class_id="{{ $row['class']->id }}" data-name="{{ $row['class']->name }}" data-std_type="Transfer" data-term="{{ $row['transfer']->term }}" data-bs-toggle="modal" data-bs-target="#detailsModal" class="btn btn-info shadow btn-xs me-1 feeDetails"><i class="ti ti-eye me-1"></i></a>
                                <a href="{{ route('settings.fee_structure.edit', ['class_id' => $row['class']->id, 'student_type' => 'transfer', 'term' => $row['transfer']->term]) }}" class="btn btn-primary btn-xs me-1"><i class="ti ti-pencil me-1"></i></a>
                                <a href="#" data-class_id="{{ $row['class']->id }}" data-name="{{ $row['class']->name }}" data-std_type="t" data-term="{{ $row['transfer']->term }}" data-bs-toggle="modal" data-bs-target="#copyModal" class="btn btn-success btn-xs me-1 copyItem"><i class="ti ti-files me-1"></i></a>
                            </div>
                        @else
                            <span class="badge bg-warning">Fee not structured</span>
                        @endif
                    </td>
                    @foreach ($student_types as $student_type)
                        <td class="text-center">
                            @if (isset($row['studentTypes'][$student_type->id]))
                                <div>
                                    <a href="#" data-class_id="{{ $row['class']->id }}" data-name="{{ $row['class']->name }}" data-std_type="{{ $student_type->name }}" data-term="{{ $row['studentTypes'][$student_type->id]->term }}" data-bs-toggle="modal" data-bs-target="#detailsModal" class="btn btn-info shadow btn-xs me-1 feeDetails"><i class="ti ti-eye me-1"></i></a>
                                    <a href="{{ route('settings.fee_structure.edit', ['class_id' => $row['class']->id, 'student_type' => $student_type->id, 'term' => $row['studentTypes'][$student_type->id]->term]) }}" data-id="{{ $row['class']->id }}" data-name="{{ $row['class']->name }}" class="btn btn-primary btn-xs me-1 editItem"><i class="ti ti-pencil me-1"></i></a>
                                    <a href="#" data-class_id="{{ $row['class']->id }}" data-name="{{ $row['class']->name }}" data-std_type="{{ $student_type->name }}" data-term="{{ $row['studentTypes'][$student_type->id]->term }}" data-bs-toggle="modal" data-bs-target="#copyModal" class="btn btn-success btn-xs me-1 copyItem"><i class="ti ti-files me-1"></i></a>
                                </div>
                            @else
                                <span class="badge bg-warning">Fee not structured</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
