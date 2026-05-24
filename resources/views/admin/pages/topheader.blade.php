<style>
    /* 🎨 Premium Contrast Overrides for Visitor Alerts Dropdown */
    #visitorAlertsDropdown + .dropdown-menu {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
    #visitorAlertsDropdown + .dropdown-menu * {
        color: #0f172a !important; /* Modern Dark Slate text */
    }
    #visitorAlertsDropdown + .dropdown-menu .text-white,
    #visitorAlertsDropdown + .dropdown-menu .text-white * {
        color: #ffffff !important;
    }
    #visitorAlertsDropdown + .dropdown-menu .text-muted,
    #visitorAlertsDropdown + .dropdown-menu .text-muted * {
        color: #64748b !important; /* slate-500 text */
    }
    #visitorAlertsDropdown + .dropdown-menu .text-primary,
    #visitorAlertsDropdown + .dropdown-menu .text-primary * {
        color: #2563eb !important; /* Indigo Blue */
    }
    #visitorAlertsDropdown + .dropdown-menu .bg-light,
    #visitorAlertsDropdown + .dropdown-menu .bg-light * {
        background-color: #f8fafc !important;
    }
    #visitorAlertsDropdown + .dropdown-menu .dropdown-item:hover {
        background-color: #f1f5f9 !important;
    }

    /* 🔔 Premium High-Contrast Toastr Alerts */
    #toast-container > .toast {
        opacity: 1 !important;
        box-shadow: 0 12px 40px rgba(0,0,0,0.18) !important;
        border-radius: 12px !important;
    }
    #toast-container > .toast-success {
        background: #0f172a !important; /* Slate Dark premium background */
        color: #ffffff !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
    }
    #toast-container > .toast-success .toast-title {
        color: #3b82f6 !important; /* Bright Electric Blue */
        font-weight: 700 !important;
        font-size: 14px !important;
    }
    #toast-container > .toast-success .toast-message {
        color: #f8fafc !important;
        font-size: 12.5px !important;
        line-height: 1.4 !important;
    }
</style>

<header id="topbar">
    <div class="topbar-left">
        <button id="menuToggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <div class="topbar-search d-none d-md-flex">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search...">
        </div>
    </div>

    <div class="topbar-right">
        <a href="{{ route('frontend') }}" target="_blank" class="topbar-icon-btn" title="View Site">
            <i class="bi bi-globe"></i>
        </a>

        <!-- 🔔 Live Returning Customer Alerts -->
        <div class="dropdown">
            <button class="topbar-icon-btn dropdown-toggle border-0 position-relative" type="button" id="visitorAlertsDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="outline: none;">
                <i class="bi bi-bell-fill text-warning"></i>
                <span class="topbar-badge bg-danger" id="visitor-badge" style="display: none; padding: 2px 5px; font-size: 8px;">0</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg p-0 overflow-hidden border-0 rounded-4" aria-labelledby="visitorAlertsDropdown" style="width: 320px; font-size: 13px; z-index: 2000;">
                <li class="p-3 text-white fw-bold d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                    <span><i class="bi bi-radar animate-pulse"></i> Customer Visit Alert</span>
                    <span class="badge bg-warning text-dark rounded-pill" id="visitor-unread-count" style="font-size: 10px;">0 unread</span>
                </li>
                <div id="visitor-alerts-container" style="max-height: 300px; overflow-y: auto;">
                    <li class="text-center py-4 text-muted" id="visitor-empty-msg">
                        <i class="bi bi-check-circle-fill text-success d-block fs-3 mb-2"></i>
                        No new customer visit log
                    </li>
                </div>
                <li class="border-top text-center bg-light">
                    <a class="dropdown-item py-2 fw-semibold text-primary d-flex align-items-center justify-content-center gap-1" href="#">
                        <i class="bi bi-arrow-right-circle"></i> View all visitor history
                    </a>
                </li>
            </ul>
        </div>

        <a href="#" class="topbar-icon-btn">
            <i class="bi bi-envelope"></i>
            <span class="topbar-badge">0</span>
        </a>
        <a href="#" class="topbar-icon-btn">
            <i class="bi bi-cart"></i>
            <span class="topbar-badge">0</span>
        </a>
        <a href="#" class="topbar-icon-btn">
            <i class="bi bi-person"></i>
            <span class="topbar-badge">0</span>
        </a>
        <a href="#" class="topbar-icon-btn">
            <i class="bi bi-display"></i>
            <span class="topbar-badge">1</span>
        </a>

        <div class="dropdown">
            <div class="topbar-user dropdown-toggle" id="userDrop" data-bs-toggle="dropdown">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="Admin">
                <span class="topbar-user-name d-none d-sm-block">{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDrop"
                style="font-size:13px; min-width:160px; border-color:var(--border);">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                        <i class="bi bi-person me-2"></i>Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.Generalsettings.index') }}">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Dynamic Polling & Alert Script -->

</header>
