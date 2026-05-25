<div id="sidebar">
  <div class="sb-brand">
    <div class="sb-icon">G</div>
    <div>
      <strong>Shahzadimart Shop</strong>
      <span>Sub Admin</span>
    </div>
  </div>

  <div class="sb-section">Main</div>
  <ul class="sb-menu">
    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-dashboard'))
    <li class="{{ request()->routeIs('subadmin.dashboard') ? 'active' : '' }}">
      <a href="{{ route('subadmin.dashboard') }}">
        <i class="fas fa-th-large"></i> Dashboard
      </a>
    </li>
    @endif
  </ul>



  {{-- Users Section --}}
  @php
    $showUsers = auth()->user()->isSuperAdmin()
      || auth()->user()->hasPermission('view-users');
  @endphp
  @if($showUsers)
  <div class="sb-section">Users</div>
  <ul class="sb-menu">

    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-users'))
    <li class="{{ request()->routeIs('subadmin.customers*') ? 'active' : '' }}">
      <a href="#">
        <i class="fas fa-users"></i> Customers
        <i class="fa-solid fa-chevron-right arr"></i>
      </a>
    </li>
    @endif



  </ul>
  @endif



  <div class="sb-bottom">
    <ul class="sb-menu">
      <li class="{{ request()->routeIs('subadmin.settings*') ? 'active' : '' }}">
        <a href="#"><i class="fas fa-cog"></i> Settings</a>
      </li>
      <li>
        <a href="{{ route('subadmin.logout') }}"
           onclick="event.preventDefault(); document.getElementById('subadmin-logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
    <form id="subadmin-logout-form" action="{{ route('subadmin.logout') }}" method="POST" style="display:none;">
      @csrf
    </form>
  </div>
</div>
