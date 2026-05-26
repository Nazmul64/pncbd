{{-- ============================================================
     EMPLOYEE (EMPLEE) SIDEBAR
     resources/views/emplee/pages/siderbar.blade.php
     Premium UI/UX - Clean Loan Management & Core Features Only
============================================================ --}}

@php
    $u = auth()->user();
    $dashActive       = request()->routeIs('admin.emplee.dashboard');
    $profileActive    = request()->routeIs('admin.emplee.profile.*');
    $chatActive       = request()->routeIs('admin.emplee.chat.*');
    $staffChatActive  = request()->routeIs('admin.emplee.staff-chat.*');
@endphp

<aside id="sidebar">

<a href="{{ route('admin.emplee.dashboard') }}" class="sb-brand">
    <div class="sb-icon" style="overflow:hidden; padding: 0; background: transparent;">
        @if(!empty($gs->header_logo))
            <img src="{{ asset($gs->header_logo) }}" alt="Logo" style="width:40px; height:40px; object-fit:contain; border-radius:10px;">
        @else
            <span style="display:flex; align-items:center; justify-content:center; width:40px; height:40px; background:var(--primary); border-radius:10px; font-size:18px; font-weight:900; color:#fff; text-transform:uppercase;">
                {{ substr($gs->site_name ?? 'P', 0, 1) }}
            </span>
        @endif
    </div>
    <div>
        <span class="sb-brand-name">{{ $gs->site_name ?? 'PNCBD' }}</span>
        <span class="sb-brand-tag">Employee Panel</span>
    </div>
</a>

<nav class="sb-nav">

<div class="sb-section">Core</div>

@if($u->canAccessAdmin() || $u->hasPermission('view-dashboard'))
<a href="{{ route('admin.emplee.dashboard') }}" class="sb-item {{ $dashActive ? 'active' : '' }}">
    <span class="sb-left"><i class="fas fa-chart-line sb-ico"></i> Dashboard</span>
</a>
<a href="{{ route('admin.emplee.profile.index') }}" class="sb-item {{ $profileActive ? 'active' : '' }}">
    <span class="sb-left"><i class="fas fa-user-circle sb-ico"></i> My Profile</span>
</a>
<a href="{{ route('admin.emplee.id-card') }}" class="sb-item {{ request()->routeIs('admin.emplee.id-card') ? 'active' : '' }}">
    <span class="sb-left"><i class="fas fa-id-card sb-ico" style="color: #3b82f6;"></i> আইডি কার্ড ক্রিয়েট</span>
</a>
@endif

<div class="sb-sep"></div>

{{-- Communication Section --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-chat', 'manage-chat']))
<div class="sb-section">Communication</div>
<a href="{{ route('admin.emplee.chat.index') }}" class="sb-item {{ $chatActive ? 'active' : '' }}">
    <span class="sb-left">
        <i class="fas fa-comments sb-ico"></i> Live Chat
        <span class="badge bg-danger ms-2" id="sbUnreadBadge" style="display:none; font-size:10px;">0</span>
    </span>
</a>
@endif

{{-- Admin ↔ Staff Private Chat --}}
<a href="{{ route('admin.emplee.staff-chat.index') }}" class="sb-item {{ $staffChatActive ? 'active' : '' }}">
    <span class="sb-left">
        <i class="fas fa-headset sb-ico" style="color:#8b5cf6"></i> Admin Chat
        <span class="badge bg-danger ms-2" id="sbStaffChatBadge" style="display:none; font-size:10px;">0</span>
    </span>
</a>
<div class="sb-sep"></div>

{{-- Account Settings --}}
<div class="sb-item {{ $profileActive ? 'active' : '' }}">
    <a href="{{ route('admin.emplee.profile.index') }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%;">
        <span class="sb-left"><i class="fas fa-user-gear sb-ico"></i> Profile & Password</span>
    </a>
</div>

</nav>

<div class="sb-logout-wrap">
    <form method="POST" action="{{ route('emplee.logout') }}">
        @csrf
        <button type="submit" class="sb-logout">
            <i class="fas fa-sign-out-alt"></i> Sign Out
        </button>
    </form>
</div>

</aside>

<script>
window.sbToggle = function(t) {
    var s = t.nextElementSibling;
    if (!s || !s.classList.contains('sb-sub')) return;
    var o = s.classList.contains('open');
    
    // Close others
    document.querySelectorAll('.sb-sub.open').forEach(function(x) {
        if (x !== s) {
            x.classList.remove('open');
            if (x.previousElementSibling) x.previousElementSibling.classList.remove('open');
        }
    });
    
    if (!o) {
        s.classList.add('open');
        t.classList.add('open');
    } else {
        s.classList.remove('open');
        t.classList.remove('open');
    }
};

// Auto-open active menu
document.querySelectorAll('.sb-sub').forEach(function(s) {
    if (s.querySelector('a.active')) {
        s.classList.add('open');
        if (s.previousElementSibling) s.previousElementSibling.classList.add('open');
    }
});

// Sidebar Unread Badge Polling
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-chat', 'manage-chat']))
function sbRefreshUnread() {
    fetch('{{ route("admin.emplee.chat.unread") }}')
        .then(r => r.json())
        .then(d => {
            const badge = document.getElementById('sbUnreadBadge');
            if (badge) {
                if (d.count > 0) {
                    badge.textContent = d.count > 99 ? '99+' : d.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        }).catch(() => {});
}
sbRefreshUnread();
setInterval(sbRefreshUnread, 15000);
@endif

// Staff ↔ Admin Chat unread badge
(function pollAdminChatBadge() {
    var b = document.getElementById('sbStaffChatBadge');
    if (!b) return;
    fetch('{{ route("admin.emplee.staff-chat.unread") }}')
        .then(r => r.json())
        .then(d => {
            if (d.count > 0) {
                b.textContent = d.count > 99 ? '99+' : d.count;
                b.style.display = 'inline-block';
            } else {
                b.style.display = 'none';
            }
        }).catch(() => {});
    setTimeout(pollAdminChatBadge, 12000);
})();
</script>
