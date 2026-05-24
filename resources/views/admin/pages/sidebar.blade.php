{{-- ============================================================
     ADMIN SIDEBAR
     resources/views/admin/pages/sidebar.blade.php
     Premium UI/UX - 100% Permission-based
============================================================ --}}

@php
    $u = auth()->user();
    $gs = \App\Models\Generalsetting::getSettings();

    // ── Active state helpers ───────────────────────────────────────────────
    $dashActive       = request()->routeIs('admin.dashboard');
    $posActive        = request()->routeIs('admin.pos.*');
    $ordersActive     = request()->routeIs('admin.order.*') || request()->routeIs('admin.orders.*');
    $incompleteActive = request()->routeIs('admin.incomplete-orders.*');
    $catsActive       = request()->routeIs('admin.category.*') || request()->routeIs('admin.subcategory.*') || request()->routeIs('admin.childcategory.*');
    $prodsActive      = request()->routeIs('admin.products.*') || request()->routeIs('admin.product.settings.*') || request()->routeIs('admin.product-serial.*');
    $affActive        = request()->routeIs('admin.affiliateproduct.*');
    $couponsActive    = request()->routeIs('admin.coupons.*');
    $custsActive      = request()->routeIs('customer.*');
    $usersActive      = request()->routeIs('admin.users.*');
    $vendorsActive    = request()->routeIs('admin.seller.*');
    $rolesActive      = request()->routeIs('admin.roles.*');
    $permsActive      = request()->routeIs('admin.permissions.*');
    $sliderActive     = request()->routeIs('admin.slider.*');
    $reviewsActive    = request()->routeIs('admin.reviews.*');
    $campaignActive   = request()->routeIs('admin.campaigncreate.*');
    $shippingActive   = request()->routeIs('admin.shipping.*');
    $colorsActive     = request()->routeIs('admin.color.*') || request()->routeIs('admin.size.*') || request()->routeIs('admin.unit.*') || request()->routeIs('admin.productbrands.*');
    $dupActive        = request()->routeIs('admin.duplicateordersetting.*') || request()->routeIs('admin.Ipblockmanage.*');
    $deliveryActive   = request()->routeIs('admin.DeliveryInformation.*');
    $taxActive        = request()->routeIs('admin.alltaxes.*');
    $blogActive       = request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.blog-posts.*');
    $chatActive       = request()->routeIs('admin.chat.*');
    $settingsActive   = request()->routeIs('admin.Generalsettings.*') || request()->routeIs('admin.websitefavicon.*') || request()->routeIs('admin.footer-settings.*') || request()->routeIs('admin.contact.*') || request()->routeIs('admin.pixels.*') || request()->routeIs('admin.googletagmanager.*') || $campaignActive || $shippingActive || $reviewsActive || $taxActive || request()->routeIs('admin.nagad.*') || request()->routeIs('admin.mail.*');
    $apiActive        = request()->routeIs('admin.paymentgetewaymanage.*') || request()->routeIs('admin.steadfastcourier.*') || request()->routeIs('admin.pathaocourier.*') || request()->routeIs('admin.Smsgatewaysetup.*') || request()->routeIs('admin.payment.*') || request()->routeIs('admin.payment.history');
    $pagesActive      = request()->routeIs('admin.pages.*') || request()->routeIs('admin.footercategory.*') || request()->routeIs('admin.aboutcompany.*') || request()->routeIs('admin.tremsandcondation.*') || request()->routeIs('admin.contactinfomationadmins.*');
    $aiActive         = request()->routeIs('admin.aiprompt.*');
    $posOrdersActive  = request()->routeIs('admin.pos.orders');
    $staffHistoryActive = request()->routeIs('admin.order-history.*');
    $assignActive       = request()->routeIs('admin.order.assignments.*');
    $landingActive      = request()->routeIs('admin.landing-pages.*');
    $documentationActive = request()->routeIs('admin.user-informations.*') || request()->routeIs('admin.documentation.*');
    $purchaseActive = request()->routeIs('admin.suppliers.*')
                   || request()->routeIs('admin.purchases.*')
                   || request()->routeIs('admin.purchases.report')
                   || request()->routeIs('admin.purchases.summary')
                   || request()->routeIs('admin.purchase-returns.*');
    $loanAllActive      = request()->routeIs('admin.loans.*');
    $loanAppActive      = request()->routeIs('admin.loan-applications.*');
    $loanApprovalActive = request()->routeIs('admin.loan-approvals.*');
    $bankCheckActive    = request()->routeIs('admin.bank-check-approvals.*');
    $loanGroupActive    = $loanAllActive || $loanAppActive || $loanApprovalActive || $bankCheckActive || request()->routeIs('admin.banks.*');
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --sb-w          : 280px;
    --sb-col-w      : 76px;
    --sb-bg         : #0B1121;
    --sb-bg-glass   : rgba(11, 17, 33, 0.95);
    --sb-border     : rgba(255, 255, 255, 0.05);
    --sb-brand-h    : 72px;
    --sb-item-h     : 44px;

    --sb-accent-1   : #3b82f6;
    --sb-accent-2   : #8b5cf6;
    --sb-gradient   : linear-gradient(135deg, var(--sb-accent-1), var(--sb-accent-2));

    --sb-text       : #94a3b8;
    --sb-text-hover : #f8fafc;
    --sb-text-active: #ffffff;

    --sb-hover-bg   : rgba(255, 255, 255, 0.04);
    --sb-active-bg  : rgba(59, 130, 246, 0.1);

    --sb-radius     : 12px;
    --sb-ease       : 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: var(--sb-w);
    background: var(--sb-bg-glass);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    display: flex;
    flex-direction: column;
    z-index: 1040;
    transition: width var(--sb-ease), transform var(--sb-ease);
    border-right: 1px solid var(--sb-border);
    box-shadow: 4px 0 24px rgba(0,0,0,0.2);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

body.sb-collapsed #sidebar { width: var(--sb-col-w); }
@media(max-width: 991px){
    #sidebar { transform: translateX(-100%); width: var(--sb-w); }
    body.sb-open #sidebar { transform: translateX(0); box-shadow: 4px 0 32px rgba(0,0,0,0.5); }
}

#main-content { margin-left: var(--sb-w); transition: margin-left var(--sb-ease); min-height: 100vh; }
body.sb-collapsed #main-content { margin-left: var(--sb-col-w); }
@media(max-width: 991px){ #main-content { margin-left: 0 !important; } }

.sb-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); z-index: 1039; backdrop-filter: blur(4px); }
body.sb-open .sb-overlay { display: block; }

.sb-brand {
    height: var(--sb-brand-h);
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0 20px;
    flex-shrink: 0;
    border-bottom: 1px solid var(--sb-border);
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    position: relative;
}

.sb-brand::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.5), transparent);
    opacity: 0;
    transition: opacity 0.5s ease;
}

.sb-brand:hover::after { opacity: 1; }

.sb-icon {
    width: 38px;
    height: 38px;
    background: var(--sb-gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);
    position: relative;
    overflow: hidden;
}

.sb-icon::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(180deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
}

.sb-brand-text { display: flex; flex-direction: column; overflow: hidden; }
.sb-brand-name { font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -0.3px; }
.sb-brand-tag { font-size: 11px; color: var(--sb-accent-1); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-top: 2px; }

body.sb-collapsed .sb-brand-text, .sb-section { transition: opacity var(--sb-ease); }
body.sb-collapsed .sb-brand-text { opacity: 0; pointer-events: none; }

.sb-nav {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 16px 0 24px;
}
.sb-nav::-webkit-scrollbar { width: 5px; }
.sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 10px; }
.sb-nav::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.15); }

.sb-section {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #475569;
    padding: 20px 24px 8px;
    white-space: nowrap;
}
body.sb-collapsed .sb-section { opacity: 0; height: 0; padding: 0; overflow: hidden; }

.sb-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: var(--sb-item-h);
    padding: 0 16px;
    margin: 2px 12px;
    border-radius: var(--sb-radius);
    color: var(--sb-text);
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
    overflow: hidden;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    background: transparent;
    user-select: none;
}

.sb-item:hover {
    background: var(--sb-hover-bg);
    color: var(--sb-text-hover);
    transform: translateX(4px);
}

.sb-item.active, .sb-item.open {
    background: var(--sb-active-bg);
    color: var(--sb-text-active);
    border-color: rgba(59, 130, 246, 0.2);
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.02);
}

.sb-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 60%;
    width: 3px;
    background: var(--sb-accent-1);
    border-radius: 0 4px 4px 0;
    box-shadow: 0 0 8px var(--sb-accent-1);
}

.sb-left { display: flex; align-items: center; gap: 14px; overflow: hidden; flex: 1; min-width: 0; }
.sb-text { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; transition: opacity var(--sb-ease); font-weight: 600; }
body.sb-collapsed .sb-text { opacity: 0; width: 0; pointer-events: none; }

.sb-ico {
    font-size: 18px;
    flex-shrink: 0;
    width: 22px;
    text-align: center;
    color: #64748b;
    transition: all 0.3s ease;
}
.sb-item:hover .sb-ico { color: #fff; transform: scale(1.1); }
.sb-item.active .sb-ico, .sb-item.open .sb-ico { color: var(--sb-accent-1); text-shadow: 0 0 12px rgba(59, 130, 246, 0.4); }

.sb-arr {
    font-size: 11px;
    flex-shrink: 0;
    color: #475569;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
body.sb-collapsed .sb-arr { opacity: 0; }
.sb-item.open .sb-arr { transform: rotate(90deg); color: var(--sb-text-active); }

.sb-sub {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    margin: 0 12px;
    border-radius: 0 0 var(--sb-radius) var(--sb-radius);
}
.sb-sub.open { max-height: 1200px; }
body.sb-collapsed .sb-sub { display: none; }

.sb-sub-inner {
    padding: 6px 0 12px;
    position: relative;
}
.sb-sub-inner::before {
    content: '';
    position: absolute;
    left: 26px;
    top: 0;
    bottom: 12px;
    width: 1px;
    background: rgba(255,255,255,0.06);
}

.sb-sub a {
    display: flex;
    align-items: center;
    gap: 12px;
    height: 38px;
    padding: 0 16px 0 46px;
    font-size: 13.5px;
    font-weight: 500;
    color: #64748b;
    text-decoration: none;
    border-radius: 8px;
    margin: 2px 8px;
    transition: all 0.2s ease;
    position: relative;
}

.sb-sub a::before {
    content: '';
    position: absolute;
    left: 22px;
    top: 50%;
    transform: translateY(-50%);
    width: 8px;
    height: 1px;
    background: rgba(255,255,255,0.06);
    transition: all 0.2s ease;
}

.sb-sub a i { font-size: 14px; color: #475569; transition: color 0.2s ease; }

.sb-sub a:hover { color: #e2e8f0; background: rgba(255,255,255,0.03); transform: translateX(3px); }
.sb-sub a:hover::before { width: 12px; background: var(--sb-accent-1); }
.sb-sub a:hover i { color: #e2e8f0; }

.sb-sub a.active { color: #fff; background: rgba(255,255,255,0.05); }
.sb-sub a.active::before { width: 12px; background: var(--sb-accent-1); height: 2px; border-radius: 2px; }
.sb-sub a.active i { color: var(--sb-accent-1); }

.sb-sep { height: 1px; background: linear-gradient(90deg, transparent, var(--sb-border), transparent); margin: 12px 24px; }

.sb-user-profile {
    padding: 16px 20px;
    border-top: 1px solid var(--sb-border);
    background: rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    gap: 12px;
    overflow: hidden;
    text-decoration: none;
    transition: background 0.2s ease;
}
.sb-user-profile:hover { background: rgba(0,0,0,0.3); }

.sb-avatar {
    width: 36px; height: 36px; border-radius: 10px;
    background: var(--sb-accent-1);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 14px; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.sb-user-info { display: flex; flex-direction: column; overflow: hidden; }
.sb-user-name { font-size: 14px; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sb-user-role { font-size: 11px; color: var(--sb-text); margin-top: 2px; }

.sb-logout-btn {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
    display: flex; align-items: center; justify-content: center;
    margin-left: auto; cursor: pointer; transition: all 0.2s ease;
}
.sb-logout-btn:hover { background: #ef4444; color: #fff; transform: scale(1.05); }

.sb-tip {
    position: fixed;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(8px);
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 8px;
    white-space: nowrap;
    z-index: 9999;
    pointer-events: none;
    box-shadow: 0 4px 16px rgba(0,0,0,0.3);
    border: 1px solid rgba(255,255,255,0.1);
    font-family: 'Plus Jakarta Sans', sans-serif;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.2s ease;
}
.sb-tip.show { opacity: 1; transform: translateX(0); }

body.sb-collapsed .sb-user-profile { justify-content: center; padding: 16px 0; }
body.sb-collapsed .sb-user-info, body.sb-collapsed .sb-logout-btn { display: none; }
</style>

<aside id="sidebar">

{{-- ══ BRAND ══ --}}
<a href="{{ route('admin.dashboard') }}" class="sb-brand">
    <div class="sb-icon">
        @if($gs->header_logo)
            <img src="{{ asset($gs->header_logo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
        @else
            <i class="bi bi-shop"></i>
        @endif
    </div>
    <div class="sb-brand-text">
        <span class="sb-brand-name">{{ $gs->site_name }}</span>
        <span class="sb-brand-tag">Admin Portal</span>
    </div>
</a>

<nav class="sb-nav">

{{-- ════ MAIN ════ --}}
<div class="sb-section">Main Menu</div>

{{-- Dashboard --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-dashboard'))
<a href="{{ route('admin.dashboard') }}" class="sb-item {{ $dashActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-grid-1x2-fill sb-ico"></i><span class="sb-text">Dashboard</span></span>
</a>
<a href="{{ route('admin.profile.index') }}" class="sb-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-person-circle sb-ico"></i><span class="sb-text">My Profile</span></span>
</a>
@endif













{{-- ════ MARKETING & CRM ════ --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-users','create-users','view-orders']))
<div class="sb-sep"></div>
<div class="sb-section">Marketing & CRM</div>
@endif

{{-- Live Chat --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-users'))
<a href="{{ route('admin.chat.index') }}" class="sb-item {{ $chatActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-chat-right-dots-fill sb-ico"></i><span class="sb-text">Live Chat</span></span>
</a>
@endif

{{-- Loans --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-users'))

{{-- Bank Check Approvals (standalone top button) --}}
<a href="{{ route('admin.bank-check-approvals') }}" class="sb-item {{ $bankCheckActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-bank2 sb-ico"></i><span class="sb-text">Bank Check Approvals</span></span>
</a>

{{-- Loan Applications (standalone) --}}
<a href="{{ route('admin.loan-applications') }}" class="sb-item {{ $loanAppActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-file-earmark-text sb-ico"></i><span class="sb-text">Loan Applications</span></span>
</a>

{{-- Loan Approvals (standalone) --}}
<a href="{{ route('admin.loan-approvals') }}" class="sb-item {{ $loanApprovalActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-check2-square sb-ico"></i><span class="sb-text">Loan Approvals</span></span>
</a>

{{-- Loan Requests (all loans) --}}
<a href="{{ route('admin.loans.index') }}" class="sb-item {{ ($loanAllActive && !$loanAppActive && !$loanApprovalActive && !$bankCheckActive) ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-wallet2 sb-ico"></i><span class="sb-text">Loan Requests</span></span>
</a>

{{-- Bank Setup --}}
<a href="{{ route('admin.banks.index') }}" class="sb-item {{ request()->routeIs('admin.banks.*') ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-bank sb-ico"></i><span class="sb-text">ব্যাংক সেটআপ</span></span>
</a>

{{-- Documentation --}}
<a href="{{ route('admin.documentation.index') }}" class="sb-item {{ $documentationActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-file-earmark-person sb-ico"></i><span class="sb-text">ডকুমেন্টেশন</span></span>
</a>

@endif





{{-- ════ HRM SYSTEM ════ --}}
{{-- @if($u->isSuperAdmin() || $u->isAdmin() || $u->hasAnyPermission(['view-employees','manage-attendance','manage-expenses','manage-salary-advance']))
<div class="sb-sep"></div>
<div class="sb-section">HRM System</div>
<div class="sb-item {{ request()->routeIs('admin.hrm.*') ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-people-fill sb-ico"></i><span class="sb-text">HRM Module</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ (request()->routeIs('admin.hrm.*') || request()->routeIs('admin.hrm.leaves.*') || request()->routeIs('admin.hrm.payslips.*')) ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.hrm.employees.index') }}" class="{{ request()->routeIs('admin.hrm.employees.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge-fill"></i> Employees
        </a>
        <a href="{{ route('admin.hrm.attendance.index') }}" class="{{ request()->routeIs('admin.hrm.attendance.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check-fill"></i> Attendance
        </a>
        <a href="{{ route('admin.hrm.leaves.index') }}" class="{{ request()->routeIs('admin.hrm.leaves.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-minus-fill"></i> Leave Logs
        </a>
        <a href="{{ route('admin.hrm.advance-salaries.index') }}" class="{{ request()->routeIs('admin.hrm.advance-salaries.*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i> Salary & Advances
        </a>
        <a href="{{ route('admin.hrm.payslips.index') }}" class="{{ request()->routeIs('admin.hrm.payslips.*') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i> Salaries & Payroll
        </a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="{{ request()->routeIs('admin.hrm.expenses.*') ? 'active' : '' }}">
            <i class="bi bi-receipt-cutoff"></i> Expenditures
        </a>
    </div>
</div>
@endif --}}

{{-- ════ SYSTEM & SECURITY ════ --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-roles','view-users','view-settings']))
<div class="sb-sep"></div>
<div class="sb-section">System & Security</div>
@endif

{{-- Administrators --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-users'))
<div class="sb-item {{ $usersActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-person-bounding-box sb-ico"></i><span class="sb-text">Administrators</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $usersActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> All Admins
        </a>
        @if($u->isSuperAdmin() || $u->hasPermission('create-users'))
        <a href="{{ route('admin.users.create') }}" class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
            <i class="bi bi-person-plus-fill"></i> Add Admin
        </a>
        @endif
    </div>
</div>
@endif

{{-- Roles & Permissions --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-roles','create-roles','edit-roles']))
<div class="sb-item {{ ($rolesActive || $permsActive) ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-shield-lock-fill sb-ico"></i><span class="sb-text">Access Control</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ ($rolesActive || $permsActive) ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="bi bi-shield-check"></i> Roles
        </a>
        <a href="{{ route('admin.permissions.index') }}" class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
            <i class="bi bi-key-fill"></i> Permissions
        </a>
    </div>
</div>
@endif

{{-- Configuration (Settings) --}}
@if($u->isSuperAdmin() || $u->hasPermission('edit-settings'))
<div class="sb-item {{ $settingsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-gear-fill sb-ico"></i><span class="sb-text">Configuration</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $settingsActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.Generalsettings.index') }}" class="{{ request()->routeIs('admin.Generalsettings.*') ? 'active' : '' }}">
            <i class="bi bi-card-image"></i> General Settings
        </a>

        <a href="{{ route('admin.Generalsettings.index') }}" class="{{ request()->routeIs('admin.Generalsettings.*') ? 'active' : '' }}">
            <i class="bi bi-aspect-ratio"></i> Layout Settings
        </a>

        <a href="{{ route('admin.footer-settings.index') }}" class="{{ request()->routeIs('admin.footer-settings.*') ? 'active' : '' }}">
            <i class="bi bi-layout-text-window-reverse"></i> Footer Settings
        </a>
        <a href="{{ route('admin.contact.index') }}" class="{{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> Contact Info
        </a>
        <a href="{{ route('admin.mail.index') }}" class="{{ request()->routeIs('admin.mail.*') ? 'active' : '' }}">
            <i class="bi bi-envelope-at-fill"></i> Mail Configuration
        </a>


    </div>
</div>
@endif



{{-- ══ ACCOUNT SETTINGS ══ --}}
<div class="sb-section">Account</div>
<a href="{{ route('admin.profile.index') }}" class="sb-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
    <div class="sb-left">
        <i class="bi bi-person-gear sb-ico"></i>
        <span class="sb-text">Profile & Password</span>
    </div>
</a>

</nav>

{{-- ══ USER PROFILE & LOGOUT ══ --}}
<div class="sb-user-profile">
    <div class="sb-avatar">{{ substr($u->name, 0, 1) }}</div>
    <div class="sb-user-info">
        <div class="sb-user-name">{{ $u->name }}</div>
        <div class="sb-user-role">Administrator</div>
    </div>
    <a href="{{ route('admin.logout') }}" class="sb-logout-btn" title="Logout">
        <i class="bi bi-power"></i>
    </a>
</div>

</aside>

<div class="sb-overlay" onclick="sbClose()"></div>

<script>
(function(){
    'use strict';
    window.toggleSidebar = function(){
        if(window.innerWidth < 992){ document.body.classList.toggle('sb-open'); }
        else { document.body.classList.toggle('sb-collapsed'); }
    };
    window.sbClose = function(){ document.body.classList.remove('sb-open'); };

    window.sbToggle = function(t){
        var s = t.nextElementSibling;
        if(!s || !s.classList.contains('sb-sub')) return;
        var open = s.classList.contains('open');
        document.querySelectorAll('.sb-sub.open').forEach(function(x){
            x.classList.remove('open');
            if(x.previousElementSibling) x.previousElementSibling.classList.remove('open');
        });
        if(!open){
            s.classList.add('open');
            t.classList.add('open');
        }
    };

    document.querySelectorAll('.sb-sub').forEach(function(s){
        if(s.querySelector('a.active')){
            s.classList.add('open');
            if(s.previousElementSibling) s.previousElementSibling.classList.add('open');
        }
    });

    document.addEventListener('keydown', function(e){ if(e.key === 'Escape') window.sbClose(); });

    var sx = 0, sb = document.getElementById('sidebar');
    if(sb){
        sb.addEventListener('touchstart', function(e){ sx = e.touches[0].clientX; }, {passive: true});
        sb.addEventListener('touchend', function(e){ if(sx - e.changedTouches[0].clientX > 60) window.sbClose(); }, {passive: true});
    }

    document.querySelectorAll('#sidebar .sb-item').forEach(function(el){
        var t = el.querySelector('.sb-text');
        if(!t) return;
        var label = t.textContent.trim();

        el.addEventListener('mouseenter', function(){
            if(!document.body.classList.contains('sb-collapsed')) return;
            var r = el.getBoundingClientRect();
            var tip = document.createElement('div');
            tip.className = 'sb-tip';
            tip.textContent = label;
            document.body.appendChild(tip);

            setTimeout(() => {
                tip.style.left = (r.right + 12) + 'px';
                tip.style.top = (r.top + r.height/2 - tip.offsetHeight/2) + 'px';
                tip.classList.add('show');
            }, 10);

            el._tip = tip;
        });

        el.addEventListener('mouseleave', function(){
            if(el._tip){
                var tip = el._tip;
                tip.classList.remove('show');
                setTimeout(() => tip.remove(), 200);
                el._tip = null;
            }
        });
    });
})();
</script>
