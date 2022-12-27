@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
            <img src="/uploads/{{ $school->username }}/{{ $school->logo }}" width="25" height="25" />
        </span>
        <span class="app-brand-text demo menu-text">{{ $school->username }}</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      
      @if(auth()->user()->usertype == 'admin')
       @include('layouts.sidebar.admin')
      @endif
     
  
    </ul>
  </aside>