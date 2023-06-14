
<li class="menu-item {{ $route == 'parent.home' ? 'active' : '' }}">
    <a href="{{ route('parent.home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-home"></i>
        <div data-i18n="Home">Home</div>
    </a>
</li>
<li class="menu-item {{ $route == 'fees_billing.index' ? 'active' : '' }}">
    <a href="{{ route('fees_billing.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-cash"></i>
        <div data-i18n="Fees & Billing">Fees & Billing</div>
    </a>
</li>
<li class="menu-item {{ $route == 'parent.' ? 'active' : '' }}">
    <a href="{{ route('parent.home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-notebook"></i>
        <div data-i18n="Gradebook">Gradebook</div>
    </a>
</li>
<li class="menu-item {{ $route == 'parent.' ? 'active' : '' }}">
    <a href="{{ route('parent.home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-report-analytics"></i>
        <div data-i18n="Result">Result</div>
    </a>
</li>
<li class="menu-item {{ $route == 'parent.' ? 'active' : '' }}">
    <a href="{{ route('parent.home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-calendar"></i>
        <div data-i18n="Attendance">Attendance</div>
    </a>
</li>