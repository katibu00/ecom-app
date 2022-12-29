


<li class="menu-item {{ $route == 'intellisas.home' ? 'active' : '' }}">
    <a href="{{ route('intellisas.home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-home"></i>
        <div data-i18n="Home">Home</div>
    </a>
</li>
<li class="menu-item {{ $route == 'schools.index' ? 'active' : '' }} {{ $route == 'schools.admin.create' ? 'active' : '' }}">
    <a href="{{ route('schools.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-building"></i>
        <div data-i18n="Schools">Schools</div>
    </a>
</li>
