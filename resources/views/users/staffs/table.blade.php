<table class="mainStaffTable table table-stripped" id="mainStaffTable">
    <thead>
        <tr>
            <th>
                <div class="form-check">
                    <input class="form-check-input select-all-checkbox" type="checkbox">
                </div>
            </th>
            <th>#</th> <!-- Serial Number Column -->
            <th>Name</th>
            <th>Email/Phone</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr class="no-results-row" style="display: none;">
            <td colspan="7" class="text-center" style="color: red;">No result found.</td>
        </tr>
        @foreach ($staffData as $index => $staff)
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input staff-checkbox" type="checkbox" value="{{ $staff['id'] }}">
                    </div>
                </td>
                <td>{{ $index + 1 }}</td> <!-- Serial Number -->
                <td>{{ $staff['first_name'] }} {{ $staff['last_name'] }}</td>
                <td>{{ $staff['email'] ?? $staff['phone'] }}</td>
                <td>{{ ucfirst($staff['usertype']) }}</td>
                <td>
                    @if ($staff['status'] == 1)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#">Details</a></li>
                            <li><a class="dropdown-item edit-profile-btn" data-bs-toggle="modal"
                                data-bs-target="#editModal" href="#" data-user-id="{{ $staff['id'] }}" data-user-name=">{{ $staff['first_name'].' '. $staff['last_name'] }}">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="#">Suspend</a></li>
                            <li><a class="dropdown-item" href="#">Send Password</a></li>
                            <li><a class="dropdown-item" href="#">Assign Subjects</a></li>
                            <li><a class="dropdown-item" href="#">Assign to Class</a></li>
                        </ul>
                    </div>
                </td>
                
            </tr>
        @endforeach
    </tbody>
</table>
