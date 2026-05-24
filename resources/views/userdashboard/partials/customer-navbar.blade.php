@php
    $navUser = auth()->user();
    $navName = $navUser->information->full_name ?? $navUser->name ?? 'সদস্য';
    $navPhone = $navUser->information->phone_number ?? $navUser->phone;
    $navBalance = \App\Models\Loan::where('user_id', $navUser->id)->where('status', 'approved')->sum('amount');
    $navInitial = mb_substr($navName, 0, 1);
    $activeRoute = $activeRoute ?? null;
    $siteName = $gs->site_name ?? 'UBS';
@endphp

@once
<style>
    .customer-profile-dropdown .user-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 15px;
        border-radius: 50px;
        background: #f1f5f9;
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s;
        border: none;
    }

    .customer-profile-dropdown .user-profile:hover,
    .customer-profile-dropdown.show .user-profile {
        background: #e2e8f0;
    }

    .customer-profile-dropdown .user-avatar {
        width: 40px;
        height: 40px;
        min-width: 40px;
        background: #3b82f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        overflow: hidden;
    }

    .customer-profile-dropdown .user-details {
        text-align: left;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        white-space: nowrap;
        transition: max-width 0.25s ease, opacity 0.2s ease;
    }

    .customer-profile-dropdown:hover .user-details,
    .customer-profile-dropdown.show .user-details {
        max-width: 220px;
        opacity: 1;
    }

    .customer-profile-dropdown .user-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.2;
    }

    .customer-profile-dropdown .user-phone {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .customer-profile-dropdown .dropdown-toggle::after {
        display: none;
    }

    .customer-profile-dropdown .profile-chevron {
        color: #9ca3af;
        font-size: 0.75rem;
        transition: transform 0.2s;
    }

    .customer-profile-dropdown.show .profile-chevron {
        transform: rotate(180deg);
    }

    .customer-profile-menu {
        min-width: 260px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0;
        margin-top: 8px !important;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }

    .customer-profile-menu .dropdown-header {
        padding: 14px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .customer-profile-menu .dropdown-header .header-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.95rem;
        margin-bottom: 2px;
    }

    .customer-profile-menu .dropdown-header .header-phone {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 6px;
    }

    .customer-profile-menu .dropdown-header .header-balance {
        font-size: 0.85rem;
        font-weight: 600;
        color: #059669;
    }

    .customer-profile-menu .dropdown-item {
        padding: 10px 16px;
        font-size: 0.9rem;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .customer-profile-menu .dropdown-item i {
        width: 18px;
        color: #64748b;
    }

    .customer-profile-menu .dropdown-item:hover {
        background: #f1f5f9;
        color: #1e40af;
    }

    .customer-profile-menu .dropdown-item:hover i {
        color: #3b82f6;
    }

    .customer-profile-menu .dropdown-item.logout-item {
        color: #dc2626;
    }

    .customer-profile-menu .dropdown-item.logout-item:hover {
        background: #fef2f2;
        color: #b91c1c;
    }

    .customer-profile-menu .dropdown-item.logout-item i {
        color: #dc2626;
    }

    .logo-section .navbar-logo-img {
        height: 42px;
        width: auto;
        max-width: 140px;
        object-fit: contain;
    }

    .logo-section .logo-circle-fallback {
        width: 45px;
        height: 45px;
        background: #3b82f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .logo-section .logo-text {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1e3a8a;
        white-space: nowrap;
    }
</style>
@endonce

<nav class="top-navbar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('customer.dashboard') }}" class="logo-section">
                @if(!empty($gs->header_logo))
                    <img src="{{ asset($gs->header_logo) }}" alt="{{ $siteName }}" class="navbar-logo-img">
                @else
                    <div class="logo-circle-fallback">{{ mb_substr($siteName, 0, 1) }}</div>
                @endif
                <span class="logo-text">{{ $siteName }}</span>
            </a>

            <ul class="nav-items d-none d-lg-flex">
                <li>
                    <a href="{{ route('customer.dashboard') }}" class="{{ ($activeRoute ?? '') === 'dashboard' ? 'active' : '' }}">
                        <i class="fas fa-home"></i> ড্যাশবোর্ড
                    </a>
                </li>
                <li>
                    <a href="{{ route('loan.step1') }}" class="{{ ($activeRoute ?? '') === 'loan' ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave"></i> ঋণ
                    </a>
                </li>
                <li><a href="#"><i class="fas fa-question-circle"></i> সাহায্য</a></li>
                <li><a href="#"><i class="fas fa-graduation-cap"></i> নিয়মাবলী</a></li>
            </ul>

            <div class="dropdown customer-profile-dropdown">
                <button type="button"
                        class="user-profile dropdown-toggle"
                        id="customerProfileDrop"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="true"
                        aria-expanded="false"
                        aria-label="প্রোফাইল মেনু">
                    <div class="user-avatar">
                        @if($navUser->information && $navUser->information->selfie)
                            <img src="{{ asset($navUser->information->selfie) }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            {{ $navInitial }}
                        @endif
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ $navName }}</div>
                        <div class="user-phone">{{ $navPhone ?: '—' }}</div>
                    </div>
                    <i class="fas fa-chevron-down profile-chevron"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end customer-profile-menu" aria-labelledby="customerProfileDrop">
                    <li class="dropdown-header">
                        <div class="header-name">{{ $navName }}</div>
                        <div class="header-phone">{{ $navPhone ?: '—' }}</div>
                        <div class="header-balance">ব্যালেন্স: ৳{{ number_format($navBalance, 0) }}</div>
                    </li>
                    <li><hr class="dropdown-divider my-0"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('customer.profile.index') }}">
                            <i class="fas fa-user"></i> আমার প্রোফাইল
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('customer.card') }}">
                            <i class="fas fa-id-card"></i> সদস্য কার্ড
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('customer.dashboard') }}#loan-section">
                            <i class="fas fa-file-invoice-dollar"></i> ঋণের তথ্য
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-0"></li>
                    <li>
                        <form method="POST" action="{{ route('customer.logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item logout-item w-100 border-0 bg-transparent text-start">
                                <i class="fas fa-right-from-bracket"></i> লগআউট
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
