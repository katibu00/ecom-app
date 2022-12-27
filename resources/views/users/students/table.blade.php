<div class="table-responsive text-nowrap">
    <table class="table mb-2">
      <thead>
        <tr>
          <th>#</th>
          <th colspan="2" class="text-center">Name</th>
          <th>Contact</th>
          <th>Address</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($students as $key => $student )
        <tr>
          <td>
           @if(@$students->firstItem()) {{ $students->firstItem() + $key }} @else {{ $key +1 }} @endif
          </td>
          <td>
            <div class="avatar avatar-sm me-2">
                <img @if($student->image == 'default.png') src="/uploads/default.png" @else src="/uploads/{{ $school->username }}/{{ $student->image }}" @endif  alt="Avatar" class="rounded-circle" />
            </div>
          </td>
          <td>
            <strong>{{ $student->name }}</strong>
          </td>
          <td>
            {{ @$student->lga->name.' - '.@$student->ward->name }}
          </td>
          <td>
            {{ $student->phone1}}
          </td>
          <td>@if($student->status == 1)<span class="badge bg-label-success me-1">Verified</span> @else <span class="badge bg-label-danger me-1">Unverified</span> @endif</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ti ti-dots-vertical"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item userDetails" href="javascript:void(0);" data-id="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#userDetailsModal"
                  ><i class="ti ti-user me-1"></i> Details</a
                >
                <a class="dropdown-item verifyUser" data-id="{{ $student->id }}" data-name="{{ $student->name }}" data-status="{{ $student->status }}" href="javascript:void(0);"
                  ><i class="ti ti-checkup-list me-1"></i>{{ $student->status == 1 ? 'Unverify': 'Verify'}}</a
                >
                <a class="dropdown-item" href="javascript:void(0);"
                  ><i class="ti ti-trash me-1"></i> Delete</a
                >
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
    {{ $students->links() }}
    </div>
  </div>
  
