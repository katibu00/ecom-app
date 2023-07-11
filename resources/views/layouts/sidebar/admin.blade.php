<li class="menu-item {{ $route == 'admin.home' ? 'active' : '' }}">
    <a href="{{ route('admin.home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-home"></i>
        <div data-i18n="Home">Home</div>
    </a>
</li>

<li class="menu-item {{ $prefix == '/billing' ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-cash"></i>
        <div data-i18n="Fees & Billing">Fees & Billing</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ $route == 'fee_collection.index' ? 'active' : '' }} ">
            <a href="{{ route('fee_collection.index') }}" class="menu-link">
                <div data-i18n="Collect Fee">Collect Fee</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'track_payments' ? 'active' : '' }} ">
            <a href="{{ route('track_payments') }}" class="menu-link">
                <div data-i18n="Track Payments">Track Payments</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'payments.index' ? 'active' : '' }} ">
            <a href="{{ route('payments.index') }}" class="menu-link">
                <div data-i18n="Payment Records">Payments Records</div>
            </a>
        </li>
       

        <li
            class="menu-item {{ $route == 'invoices.index' ? 'active open' : '' }} {{ $route == 'invoices.print.index' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Invoices">Invoices</div>
            </a>
            <ul class="menu-sub">
                 <li class="menu-item {{ $route == 'invoices.index' ? 'active' : '' }} ">
                    <a href="{{ route('invoices.index') }}" class="menu-link">
                        <div data-i18n="All Invoices">All Invoices</div>
                    </a>
                </li>
                <li class="menu-item {{ $route == 'invoices.print.index' ? 'active' : '' }} ">
                    <a href="{{ route('invoices.print.index') }}" class="menu-link">
                        <div data-i18n="Print Invoices">Print</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ $route == 'expenses.index' ? 'active' : '' }} ">
            <a href="{{ route('expenses.index') }}" class="menu-link">
                <div data-i18n="Expenditures">Expenditures</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'billing.report.index' ? 'active' : '' }} {{ $route == 'billing.report.generate' ? 'active' : '' }}">
            <a href="{{ route('billing.report.index') }}" class="menu-link">
                <div data-i18n="Financial Report">Report</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item {{ $prefix == '/marks' ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-notebook"></i>
        <div data-i18n="Marks Entry">Marks Entry</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ $route == 'marks.create' ? 'active' : '' }} {{ $route == 'marks.create.fetch' ? 'active' : '' }}">
            <a href="{{ route('marks.create') }}" class="menu-link">
                <div data-i18n="Enter Marks">Enter Marks</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'psychomotor.index' ? 'active' : '' }}">
            <a href="{{ route('psychomotor.index') }}" class="menu-link">
                <div data-i18n="Socio-emotional skills">Socio-emotional skills</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'marks.grade_book.index' ? 'active' : '' }} {{ $route == 'marks.grade_book.search' ? 'active' : '' }}">
            <a href="{{ route('marks.grade_book.index') }}" class="menu-link">
                <div data-i18n="Gradebook">Gradebook</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'marks.submissions.index' ? 'active' : '' }} {{ $route == 'marks.submissions.search' ? 'active' : '' }}">
            <a href="{{ route('marks.submissions.index') }}" class="menu-link">
                <div data-i18n="Submissions">Submissions</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item {{ $prefix == '/attendance' ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-calendar"></i>
        <div data-i18n="Attendance">Attendance</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ $route == 'attendance.overview' ? 'active' : '' }}">
            <a href="{{ route('attendance.overview') }}" class="menu-link">
                <div data-i18n="Overview">Overview</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'attendance.take.index' ? 'active' : '' }} {{ $route == 'attendance.take.search' ? 'active' : '' }}">
            <a href="{{ route('attendance.take.index') }}" class="menu-link">
                <div data-i18n="Record">Record</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'attendance.report.index' ? 'active' : '' }} {{ $route == 'attendance.report.search' ? 'active' : '' }}">
            <a href="{{ route('attendance.report.index') }}" class="menu-link">
                <div data-i18n="Report">Report</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item {{ $prefix == '/result' ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-report-analytics"></i>
        <div data-i18n="Result Generation">Result Generation</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ $route == 'result.termly.index' ? 'active' : '' }}">
            <a href="{{ route('result.termly.index') }}" class="menu-link">
                <div data-i18n="End of Term Report">End of Term Report</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'comments.index' ? 'active' : '' }}">
            <a href="{{ route('comments.index') }}" class="menu-link">
                <div data-i18n="Comments">Comments</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'result.publish' ? 'active' : '' }}">
            <a href="{{ route('result.publish') }}" class="menu-link">
                <div data-i18n="Publish Result">Publish Result</div>
            </a>
        </li>
       
        <li class="menu-item {{ $route == 'result.settings' ? 'active' : '' }}">
            <a href="{{ route('result.settings') }}" class="menu-link">
                <div data-i18n="Result Settings">Result Settings</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item {{ $prefix == '/users' ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="Users">Users</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ $route == 'users.students.index' ? 'active' : '' }} {{ $route == 'users.students.create' ? 'active' : '' }}">
            <a href="{{ route('users.students.index') }}" class="menu-link">
                <div data-i18n="Students">Students</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'subjects_offering.index' ? 'active' : '' }} {{ $route == 'get-subjects_offering' ? 'active' : '' }}">
            <a href="{{ route('subjects_offering.index') }}" class="menu-link">
                <div data-i18n="Subjects Offering">Subjects Offering</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'users.staffs.index' ? 'active' : '' }} {{ $route == 'users.staffs.create' ? 'active' : '' }}">
            <a href="{{ route('users.staffs.index') }}" class="menu-link">
                <div data-i18n="Staffs">Staffs</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'users.parents.index' ? 'active' : '' }} {{ $route == 'users.parents.create' ? 'active' : '' }}">
            <a href="{{ route('users.parents.index') }}" class="menu-link">
                <div data-i18n="Parents">Parents</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item {{ $prefix == '/settings' ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-settings"></i>
        <div data-i18n="Settings">Settings</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ $route == 'settings.basic.index' ? 'active' : '' }}  {{ $route == 'settings.monnify.index' ? 'active' : '' }}">
            <a href="{{ route('settings.basic.index') }}" class="menu-link">
                <div data-i18n="School Settings">School Settings</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'settings.sessions.index' ? 'active' : '' }}">
            <a href="{{ route('settings.sessions.index') }}" class="menu-link">
                <div data-i18n="Sessions">Sessions</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'settings.sections.index' ? 'active' : '' }}">
            <a href="{{ route('settings.sections.index') }}" class="menu-link">
                <div data-i18n="School Sections">School Sections</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'settings.classes.index' ? 'active' : '' }}">
            <a href="{{ route('settings.classes.index') }}" class="menu-link">
                <div data-i18n="Classes">Classes</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'settings.subjects.index' ? 'active' : '' }}">
            <a href="{{ route('settings.subjects.index') }}" class="menu-link">
                <div data-i18n="Subjects">Subjects</div>
            </a>
        </li>
        <li class="menu-item {{ $route == 'settings.assign_subjects.index' ? 'active' : '' }}">
            <a href="{{ route('settings.assign_subjects.index') }}" class="menu-link">
                <div data-i18n="Assign Subjects">Assign Subjects</div>
            </a>
        </li>

        <li
            class="menu-item {{ $route == 'settings.psychomotor_crud.index' ? 'active open' : '' }} {{ $route == 'settings.affective_crud.index' ? 'active open' : '' }} {{ $route == 'settings.ca_scheme.index' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Result Settings">Result Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $route == 'settings.psychomotor_crud.index' ? 'active' : '' }}">
                    <a href="{{ route('settings.psychomotor_crud.index') }}" class="menu-link">
                        <div data-i18n="Psychomotor SKills">Psychomotor SKills</div>
                    </a>
                </li>
                <li class="menu-item {{ $route == 'settings.affective_crud.index' ? 'active' : '' }}">
                    <a href="{{ route('settings.affective_crud.index') }}" class="menu-link">
                        <div data-i18n="Affective Traits">Affective Traits</div>
                    </a>
                </li>
                <li class="menu-item {{ $route == 'settings.ca_scheme.index' ? 'active' : '' }}">
                    <a href="{{ route('settings.ca_scheme.index') }}" class="menu-link">
                        <div data-i18n="CA Scheme">CA Scheme</div>
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="menu-item {{ $route == 'settings.fee_category.index' ? 'active open' : '' }} {{ $route == 'settings.student_type.index' ? 'active open' : '' }} {{ $route == 'settings.fee_structure.edit' ? 'active open' : '' }} {{ $route == 'settings.fee_structure.index' ? 'active open' : '' }} {{ $route == 'settings.banks.index' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Fee Settings">Fee Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $route == 'settings.fee_category.index' ? 'active' : '' }}">
                    <a href="{{ route('settings.fee_category.index') }}" class="menu-link">
                        <div data-i18n="Fee Categories">Fee Categories</div>
                    </a>
                </li>
                <li class="menu-item {{ $route == 'settings.student_type.index' ? 'active' : '' }}">
                    <a href="{{ route('settings.student_type.index') }}" class="menu-link">
                        <div data-i18n="Student Types">Student Types</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ $route == 'settings.fee_structure.index' ? 'active' : '' }} {{ $route == 'settings.fee_structure.edit' ? 'active' : '' }}">
                    <a href="{{ route('settings.fee_structure.index') }}" class="menu-link">
                        <div data-i18n="Fee Structure">Fee Structure</div>
                    </a>
                </li>
                <li class="menu-item {{ $route == 'settings.banks.index' ? 'active' : '' }}">
                    <a href="{{ route('settings.banks.index') }}" class="menu-link">
                        <div data-i18n="Bank Accounts">Bank Accounts</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</li>
