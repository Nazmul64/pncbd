<!-- TOPBAR -->
<div id="topbar">
    <div class="topbar-left">
        <button class="icon-btn d-xl-none" onclick="document.body.classList.toggle('sb-open')">
            <i class="fas fa-bars"></i>
        </button>
        {{-- Mobile logo visible only when sidebar is hidden --}}
        <a href="{{ route('admin.emplee.dashboard') }}" class="d-xl-none text-decoration-none d-flex align-items-center gap-2">
            @if(!empty($gs->header_logo))
                <img src="{{ asset($gs->header_logo) }}" alt="{{ $gs->site_name ?? 'PNCBD' }}" style="height: 36px; object-fit: contain; border-radius: 8px;">
            @else
                <span style="font-weight:800; font-size:16px; color:#1e293b; letter-spacing:-0.3px;">{{ $gs->site_name ?? 'PNCBD' }}</span>
            @endif
        </a>
        <div class="search-wrap d-none d-md-block">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search..."/>
        </div>
    </div>
    <div class="topbar-right">
      <button class="icon-btn d-none d-sm-flex" title="Notifications">
        <i class="fas fa-bell"></i>
        <span class="badge-dot">4</span>
      </button>
      <div class="user-pill">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" alt="User"/>
        <span class="uname">{{ auth()->user()->name }}</span>
        <i class="fas fa-chevron-down ms-1" style="font-size:10px; opacity:0.5;"></i>
      </div>
    </div>
</div>
