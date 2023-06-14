<li class="menu-item {{ $route == 'teacher.home' ? 'active' : '' }}">
    <a href="{{ route('teacher.home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-home"></i>
        <div data-i18n="Home">Home</div>
    </a>
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
    </ul>
</li>
