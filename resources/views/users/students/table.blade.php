<div class="d-none" id="loading_div">
  <div class="col-12 d-flex align-items-center justify-content-center">
  <div class="spinner-border my-5" style="height: 40px; width: 40px; margin: 0 auto;" role="status"></div>
  </div>
</div>

<div class="table-responsive text-nowrap" id="content_div">
    <table class="table mb-2 table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th></th>
                <th>Name</th>
                <th>Roll #</th>
                <th>Class</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($students as $key => $student)
                <tr>
                    <td>
                        @if (@$students->firstItem())
                            {{ $students->firstItem() + $key }}
                        @else
                            {{ $key + 1 }}
                        @endif
                    </td>
                    <td>
                        <div class="avatar avatar-sm me-2">
                            <img @if ($student->image == 'default.png') src="/uploads/default.png" @else src="/uploads/{{ $school->username }}/{{ $student->image }}" @endif
                                alt="Avatar" class="rounded-circle" />
                        </div>
                    </td>
                    <td>
                        <strong>{{ @$student->first_name . ' ' . @$student->middle_name . ' ' . @$student->last_name }}</strong>
                    </td>
                    <td>
                        {{ @$student->login }}
                    </td>
                    <td>
                        {{ @$student->class->name }}
                    </td>
                    <td>
                        {{ @$student->parent->title . ' ' . @$student->parent->first_name . ' ' . @$student->parent->last_name }}
                    </td>
                    <td>
                        @if (@$student->status == 1)
                            <span class="badge bg-label-success me-1">Active</span>
                        @else
                            <span class="badge bg-label-danger me-1">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item student_details" href="javascript:void(0);"
                                    data-student_id="{{ $student->id }}" data-student_name="{{ @$student->first_name . ' ' . @$student->middle_name . ' ' . @$student->last_name }}" data-bs-toggle="modal"
                                    data-bs-target="#detailsModal"><i class="ti ti-user me-1"></i> Details</a>
                                <a class="dropdown-item edit_student" href="javascript:void(0);"
                                    data-student_id="{{ $student->id }}" data-student_name="{{ @$student->first_name . ' ' . @$student->middle_name . ' ' . @$student->last_name }}" data-bs-toggle="modal"
                                    data-bs-target="#editModal"><i class="ti ti-pencil me-1"></i> Edit</a>
                               
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center" id="nav_links">
        {{ $students->links() }}
    </div>
</div>
