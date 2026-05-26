@extends('emplee.master')

@section('content')
<!-- Inject html2pdf.js CDN library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Great+Vibes&family=Hind+Siliguri:wght@400;500;600;700&display=swap');

    .staff-dashboard-wrapper {
        font-family: 'Hind Siliguri', 'Outfit', sans-serif;
        padding: 30px 24px;
        background: #f8fafc;
        min-height: 100vh;
        color: #1e293b;
    }

    /* Top Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #6366f1, #4f46e5); /* Premium Indigo-to-Blue */
        border-radius: 20px;
        padding: 30px 40px;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.15);
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 75%);
        right: -50px;
        top: -50px;
    }

    .welcome-banner-text h2 {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .welcome-banner-text p {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
    }

    .btn-logout-banner {
        background: #ffffff;
        color: #4f46e5;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        text-decoration: none;
    }

    .btn-logout-banner:hover {
        background: #f1f5f9;
        color: #4338ca;
        transform: translateY(-1px);
    }

    /* Metric Stats Cards */
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 35px;
    }

    @media (max-width: 1200px) {
        .metric-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .metric-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .metric-grid {
            grid-template-columns: 1fr;
        }
    }

    .metric-card {
        border-radius: 16px;
        padding: 24px;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 140px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    }

    .metric-card-bg-orange { background: #f97316; } /* Orange */
    .metric-card-bg-green  { background: #10b981; } /* Green */
    .metric-card-bg-red    { background: #ef4444; } /* Red */
    .metric-card-bg-blue   { background: #3b82f6; } /* Blue */
    .metric-card-bg-purple { background: #8b5cf6; } /* Purple */

    .metric-icon {
        font-size: 24px;
        opacity: 0.9;
        margin-bottom: 8px;
    }

    .metric-label {
        font-size: 14px;
        font-weight: 600;
        opacity: 0.9;
    }

    .metric-value {
        font-size: 32px;
        font-weight: 800;
        margin-top: auto;
    }

    /* Content Cards */
    .dashboard-section-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Search Box */
    .search-input-group {
        position: relative;
        display: flex;
        gap: 12px;
    }

    .search-input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 16px;
    }

    .search-control {
        flex: 1;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        padding: 12px 16px 12px 46px;
        font-size: 15px;
        color: #0f172a;
        transition: all 0.2s ease;
    }

    .search-control:focus {
        outline: none;
        border-color: #3b82f6;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .btn-search-submit {
        background: #3b82f6;
        color: #ffffff;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-search-submit:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    /* Search Results Details */
    .customer-profile-box {
        display: flex;
        gap: 24px;
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .customer-profile-box {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }

    .customer-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #3b82f6;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 800;
    }

    .customer-details h5 {
        margin: 0 0 6px 0;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    .customer-details p {
        margin: 0 0 4px 0;
        font-size: 14px;
        color: #64748b;
    }

    .badge-kyc-verified {
        background: #ecfdf5;
        color: #059669;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Loan list inside search result */
    .loan-table-wrapper {
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    .loan-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .loan-table th {
        background: #f8fafc;
        padding: 14px 18px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        border-bottom: 1px solid #cbd5e1;
    }

    .loan-table td {
        padding: 14px 18px;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .loan-table tr:last-child td {
        border-bottom: none;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pill-pending { background: #fffbeb; color: #d97706; }
    .status-pill-approved { background: #ecfdf5; color: #059669; }
    .status-pill-rejected { background: #fef2f2; color: #ef4444; }

    .action-btn-group {
        display: flex;
        gap: 6px;
    }

    .btn-loan-approve {
        background: #10b981;
        color: #ffffff;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-loan-approve:hover { background: #059669; }

    .btn-loan-reject {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-loan-reject:hover { background: #dc2626; }

    /* Quick Tools Cards Grid */
    .tools-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    @media (max-width: 992px) {
        .tools-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .tools-grid {
            grid-template-columns: 1fr;
        }
    }

    .tool-card {
        border-radius: 16px;
        padding: 24px;
        color: #ffffff;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
        border: none;
        width: 100%;
    }

    .tool-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .tool-card-blue   { background: #3b82f6; }
    .tool-card-green  { background: #10b981; }
    .tool-card-purple { background: #8b5cf6; }
    .tool-card-orange { background: #f97316; }

    .tool-card i {
        font-size: 32px;
    }

    .tool-card span {
        font-size: 16px;
        font-weight: 700;
    }

    /* Calculator Premium UI in Modal */
    .calc-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
    }

    .calc-slider-label {
        display: flex;
        justify-content: space-between;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .calc-result-list {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .calc-result-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 18px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .calc-result-item:last-child {
        border-bottom: none;
    }

    .calc-result-label {
        font-weight: 600;
        color: #475569;
    }

    .calc-result-value {
        font-weight: 700;
        color: #0f172a;
    }

    /* Certificate / Bank Check / Stamp Visualizations */
    .mock-cert-box {
        border: 8px double #10b981;
        padding: 30px;
        background: #fffdf5;
        border-radius: 12px;
        text-align: center;
        color: #065f46;
        box-shadow: inset 0 0 20px rgba(16, 185, 129, 0.05);
    }

    .mock-cert-logo {
        font-size: 40px;
        margin-bottom: 14px;
    }

    .mock-cert-title {
        font-size: 22px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .mock-check-box {
        background: #f0fdf4;
        border: 2px solid #86efac;
        border-radius: 12px;
        padding: 24px;
        color: #14532d;
        font-family: monospace;
        position: relative;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .mock-stamp-box {
        background: #fff;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 40px;
    }

    .stamp-header {
        border: 4px solid #f97316;
        padding: 10px;
        text-align: center;
        color: #f97316;
        font-weight: 800;
        font-size: 18px;
        margin-bottom: 24px;
        border-radius: 6px;
    }
</style>

<div class="staff-dashboard-wrapper">
    
    {{-- Top Welcome Banner --}}
    <div class="welcome-banner">
        <div class="welcome-banner-text">
            <h2>স্টাফ ড্যাশবোর্ড</h2>
            <p>স্বাগতম, {{ auth()->user()->name }}! আপনি স্টাফ ম্যানেজমেন্ট প্যানেল অ্যাক্সেস করেছেন।</p>
        </div>
        <form action="{{ route('emplee.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout-banner">
                <i class="fa-solid fa-power-off"></i> লগআউট
            </button>
        </form>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show p-3 mb-4" role="alert" style="border-radius:12px;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 5 Columns Metric Grid --}}
    <div class="metric-grid">
        {{-- Card 1: Pending Loan --}}
        <div class="metric-card metric-card-bg-orange">
            <i class="fa-solid fa-clock metric-icon"></i>
            <div class="metric-label">Pending ঋণ</div>
            <div class="metric-value">{{ $pendingLoans }}</div>
        </div>

        {{-- Card 2: Approved Loan --}}
        <div class="metric-card metric-card-bg-green">
            <i class="fa-solid fa-circle-check metric-icon"></i>
            <div class="metric-label">Approved ঋণ</div>
            <div class="metric-value">{{ $approvedLoans }}</div>
        </div>

        {{-- Card 3: Rejected Loan --}}
        <div class="metric-card metric-card-bg-red">
            <i class="fa-solid fa-circle-xmark metric-icon"></i>
            <div class="metric-label">Rejected ঋণ</div>
            <div class="metric-value">{{ $rejectedLoans }}</div>
        </div>

        {{-- Card 4: Total Loan --}}
        <div class="metric-card metric-card-bg-blue">
            <i class="fa-solid fa-file-invoice-dollar metric-icon"></i>
            <div class="metric-label">মোট ঋণ</div>
            <div class="metric-value">{{ $totalLoans }}</div>
        </div>

        {{-- Card 5: Total User --}}
        <div class="metric-card metric-card-bg-purple">
            <i class="fa-solid fa-users metric-icon"></i>
            <div class="metric-label">মোট ইউজার</div>
            <div class="metric-value">{{ $totalUsers }}</div>
        </div>
    </div>

    {{-- Search User Section --}}
    <div class="dashboard-section-card">
        <div class="section-title">
            <i class="fa-solid fa-magnifying-glass"></i> ইউজার খুঁজুন
        </div>
        
        <form action="{{ route('admin.emplee.dashboard') }}" method="GET" class="mb-4">
            <div class="search-input-group">
                <i class="fa-solid fa-phone search-input-icon"></i>
                <input 
                    type="text" 
                    name="phone" 
                    class="search-control" 
                    placeholder="ফোন নম্বর দিয়ে খুঁজুন..." 
                    value="{{ request('phone') }}"
                    required
                />
                <button type="submit" class="btn-search-submit">
                    <i class="fa-solid fa-magnifying-glass"></i> খুঁজুন
                </button>
            </div>
        </form>

        {{-- Search Result Display --}}
        @if(request()->has('phone'))
            @if($searchResult)
                @php
                    $custApprovedBalance = $searchResult->balance;
                    $custTotalLoans = $searchResult->loans->count();
                    $custKycStatus = $searchResult->information ? 'সম্পূর্ণ ✓' : 'অসম্পূর্ণ ⚠';
                    $custKycClass = $searchResult->information ? 'text-success' : 'text-warning fw-bold';
                @endphp

                <div class="row g-4 mb-4">
                    {{-- Customer Profile Box (Left Column) --}}
                    <div class="col-md-4">
                        <div class="bg-white border p-4 text-center" style="border-radius: 16px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); min-height: 100%; display: flex; flex-direction: column; justify-content: space-between; align-items: center;">
                            <div class="w-100 text-center">
                                {{-- Circular Avatar collage --}}
                                <div class="d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border-radius: 50%; background: #eff6ff; border: 3px solid #3b82f6; overflow: hidden; margin-bottom: 12px; position: relative;">
                                    @if($searchResult->information && $searchResult->information->selfie)
                                        <img src="{{ asset('uploads/avator/' . $searchResult->information->selfie) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="font-size: 38px; font-weight: 800; color: #2563eb;">{{ substr($searchResult->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                
                                <h4 class="fw-bold mb-1" style="font-size: 20px; color: #0f172a;">{{ $searchResult->name }}</h4>
                                <p class="text-muted small mb-3" style="font-size: 13px;">{{ $searchResult->phone }}</p>
                                
                                <div class="text-start" style="font-size: 14px; color: #475569; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                                    <div class="d-flex justify-content-between py-2 border-bottom border-light">
                                        <span>প্রোফাইল:</span>
                                        <span class="{{ $custKycClass }}" style="font-size: 13.5px;">{{ $custKycStatus }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-2 border-bottom border-light">
                                        <span>ব্যালেন্স:</span>
                                        <span class="fw-bold text-success">৳{{ number_format($custApprovedBalance, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-2">
                                        <span>যোগদান:</span>
                                        <span class="fw-bold text-secondary">{{ $searchResult->created_at->format('d M, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Trigger KYC detail modal --}}
                            <button type="button" class="btn btn-primary w-100 mt-4" data-bs-toggle="modal" data-bs-target="#kycDetailModal" style="background:#2563eb; border:none; padding:12px; border-radius:10px; font-weight:700; font-size:15px; box-shadow: 0 4px 12px rgba(37,99,235,0.12);">
                                বিস্তারিত দেখুন
                            </button>
                        </div>
                    </div>

                    {{-- 4-Card Colorful Mini-Dashboard (Right Column) --}}
                    <div class="col-md-8">
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; height: 100%;">
                            {{-- Card 1: Total Balance (Green) --}}
                            <div style="background: #10b981; color: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 15px rgba(16,185,129,0.12); display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; min-height: 170px;">
                                <div style="font-size: 32px; opacity: 0.2; position: absolute; right: 20px; top: 20px;"><i class="fa-solid fa-wallet"></i></div>
                                <div style="font-size: 15px; font-weight: 600; opacity: 0.9;">মোট ব্যালেন্স</div>
                                <div style="font-size: 30px; font-weight: 800;">৳{{ number_format($custApprovedBalance, 2) }}</div>
                            </div>

                            {{-- Card 2: Total Loan Applications (Blue) --}}
                            <div style="background: #3b82f6; color: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 15px rgba(59,130,246,0.12); display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; min-height: 170px;">
                                <div style="font-size: 32px; opacity: 0.2; position: absolute; right: 20px; top: 20px;"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                                <div style="font-size: 15px; font-weight: 600; opacity: 0.9;">মোট ঋণ আবেদন</div>
                                <div style="font-size: 34px; font-weight: 800;">{{ $custTotalLoans }}</div>
                            </div>

                            {{-- Card 3: Profile Edit (Purple) --}}
                            <div style="background: #8b5cf6; color: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 15px rgba(139,92,246,0.12); display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; min-height: 170px;">
                                <div style="font-size: 32px; opacity: 0.2; position: absolute; right: 20px; top: 20px;"><i class="fa-solid fa-user-pen"></i></div>
                                <div style="font-size: 15px; font-weight: 600; opacity: 0.9;">প্রোফাইল এডিট</div>
                                <button type="button" class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#editCustomerProfileModal" style="background:#ffffff; color:#8b5cf6; font-weight:700; border:none; padding:10px; border-radius:8px; font-size:14px;">
                                    এডিট করুন
                                </button>
                            </div>

                            {{-- Card 4: Change Password (Orange) --}}
                            <div style="background: #f97316; color: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 15px rgba(249,115,22,0.12); display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; min-height: 170px;">
                                <div style="font-size: 32px; opacity: 0.2; position: absolute; right: 20px; top: 20px;"><i class="fa-solid fa-key"></i></div>
                                <div style="font-size: 15px; font-weight: 600; opacity: 0.9;">পাসওয়ার্ড পরিবর্তন</div>
                                <button type="button" class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#changeCustomerPasswordModal" style="background:#ffffff; color:#f97316; font-weight:700; border:none; padding:10px; border-radius:8px; font-size:14px;">
                                    পরিবর্তন করুন
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Loan List Table --}}
                <h5 class="fw-bold mb-3 mt-4" style="font-size: 20px; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-list-check"></i> {{ $searchResult->name }} এর ঋণ তালিকা
                </h5>
                
                <div class="loan-table-wrapper" style="border: 1px solid #cbd5e1; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 30px;">
                    <table class="loan-table table table-hover mb-0" style="vertical-align: middle; font-size: 14px;">
                        <thead class="table-light" style="background:#f8fafc;">
                            <tr>
                                <th style="padding:14px 18px; font-weight:700; color:#475569;">ID</th>
                                <th style="padding:14px 18px; font-weight:700; color:#475569;">পরিমাণ</th>
                                <th style="padding:14px 18px; font-weight:700; color:#475569;">মেয়াদ</th>
                                <th style="padding:14px 18px; font-weight:700; color:#475569;">EMI</th>
                                <th style="padding:14px 18px; font-weight:700; color:#475569;">অবস্থা</th>
                                <th style="padding:14px 18px; font-weight:700; color:#475569;">তারিখ</th>
                                <th style="padding:14px 18px; font-weight:700; color:#475569; text-align: right;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($searchResult->loans as $loan)
                                <tr>
                                    <td class="fw-bold" style="padding:14px 18px; color:#1e293b;">#{{ $loan->id }}</td>
                                    <td class="fw-bold" style="padding:14px 18px; color:#2563eb;">৳{{ number_format($loan->amount, 2) }}</td>
                                    <td style="padding:14px 18px; font-weight: 500; color:#475569;">{{ $loan->tenure }} মাস</td>
                                    <td style="padding:14px 18px; font-weight: 500; color:#475569;">৳{{ number_format($loan->monthly_installment, 2) }}</td>
                                    <td style="padding:14px 18px;">
                                        @if($loan->status === 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2" style="border-radius: 999px; font-weight: 600; font-size:12px;">
                                                <i class="fa-solid fa-clock me-1"></i> Pending
                                            </span>
                                        @elseif($loan->status === 'approved')
                                            <span class="badge bg-success text-white px-3 py-2" style="border-radius: 999px; font-weight: 600; font-size:12px; background-color: #10b981 !important;">
                                                <i class="fa-solid fa-circle-check me-1"></i> Approved
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white px-3 py-2" style="border-radius: 999px; font-weight: 600; font-size:12px;">
                                                <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding:14px 18px; color:#64748b;">{{ $loan->created_at->format('d M, Y') }}</td>
                                    <td style="padding:14px 18px; text-align: right;">
                                        @if($loan->status === 'pending')
                                            <div class="d-flex gap-1 justify-content-end">
                                                <form action="{{ route('admin.emplee.loans.updateStatus', $loan->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-sm btn-success px-3" style="background:#10b981; border:none; font-weight:700; border-radius:6px; color:#ffffff;">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.emplee.loans.updateStatus', $loan->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-sm btn-danger px-3" style="background:#ef4444; border:none; font-weight:700; border-radius:6px; color:#ffffff;">Reject</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted small">কোনো একশন প্রযোজ্য নয়</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                                        <i class="fa-solid fa-folder-open" style="font-size:32px; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                                        এই ইউজারের কোনো ঋণের আবেদন পাওয়া যায়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Modals for managing searched Customer --}}
                
                {{-- A. Edit Customer Profile Modal --}}
                <div class="modal fade" id="editCustomerProfileModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content" style="border-radius: 16px; border:none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            <div class="modal-header" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color:#ffffff; padding:18px 24px;">
                                <h5 class="modal-title fw-bold" style="font-size: 19px;"><i class="fa-solid fa-user-pen me-2"></i> গ্রাহকের বিস্তারিত প্রোফাইল এডিট</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.emplee.customer.updateProfile', $searchResult->id) }}" method="POST">
                                @csrf
                                <div class="modal-body" style="padding: 24px 30px; max-height: 70vh; overflow-y: auto;">
                                    
                                    {{-- Section 1: মৌলিক তথ্য --}}
                                    <div class="mb-4">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 15px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; color: #6d28d9 !important;">
                                            <i class="fa-solid fa-id-card"></i> মৌলিক অ্যাকাউন্ট তথ্য
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">গ্রাহকের নাম <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" value="{{ $searchResult->name }}" required style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">ইমেইল এড্রেস <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control" value="{{ $searchResult->email }}" required style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">মোবাইল নম্বর <span class="text-danger">*</span></label>
                                                <input type="text" name="phone" class="form-control" value="{{ $searchResult->phone }}" required style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">অনুমোদিত ব্যালেন্স (৳) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" name="balance" class="form-control" value="{{ $searchResult->balance }}" required style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1; font-weight: 600; color: #10b981;">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Section 2: KYC ও পেশাগত বিবরণ --}}
                                    <div class="mb-4">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 15px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; color: #6d28d9 !important;">
                                            <i class="fa-solid fa-file-invoice"></i> KYC ও পেশাগত বিবরণ
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">NID নম্বর</label>
                                                <input type="text" name="nid_number" class="form-control" value="{{ $searchResult->information ? $searchResult->information->nid_number : '' }}" style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">পেশা</label>
                                                <input type="text" name="occupation" class="form-control" value="{{ $searchResult->information ? $searchResult->information->occupation : '' }}" placeholder="উদা: ব্যবসা, চাকুরী ইত্যাদি" style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">ঋণের কারণ</label>
                                                <input type="text" name="loan_reason" class="form-control" value="{{ $searchResult->information ? $searchResult->information->loan_reason : '' }}" placeholder="ঋণ আবেদন করার সংক্ষিপ্ত কারণ লিখুন..." style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Section 3: ঠিকানা সমূহ --}}
                                    <div class="mb-4">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 15px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; color: #6d28d9 !important;">
                                            <i class="fa-solid fa-map-location-dot"></i> ঠিকানা সমূহ
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">সাধারণ ঠিকানা</label>
                                                <textarea name="address" class="form-control" rows="2" style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">{{ $searchResult->address }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">বর্তমান ঠিকানা</label>
                                                <textarea name="current_address" class="form-control" rows="2" placeholder="বর্তমান ঠিকানা লিখুন..." style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">{{ $searchResult->information ? $searchResult->information->current_address : '' }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">স্থায়ী ঠিকানা</label>
                                                <textarea name="permanent_address" class="form-control" rows="2" placeholder="স্থায়ী ঠিকানা লিখুন..." style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">{{ $searchResult->information ? $searchResult->information->permanent_address : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Section 4: মনোনীত ব্যক্তি / নমিনী তথ্য --}}
                                    <div>
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 15px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; color: #6d28d9 !important;">
                                            <i class="fa-solid fa-users-rectangle"></i> মনোনীত ব্যক্তি (নমিনী) সংক্রান্ত তথ্য
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">নমিনীর নাম</label>
                                                <input type="text" name="nominee_name" class="form-control" value="{{ $searchResult->information ? $searchResult->information->nominee_name : '' }}" placeholder="নমিনীর পূর্ণ নাম" style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">সম্পর্ক</label>
                                                <input type="text" name="nominee_relation" class="form-control" value="{{ $searchResult->information ? $searchResult->information->nominee_relation : '' }}" placeholder="উদা: বাবা, মা, ভাই, স্ত্রী" style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold mb-1" style="font-size: 13.5px; color:#475569;">নমিনীর মোবাইল নম্বর</label>
                                                <input type="text" name="nominee_phone" class="form-control" value="{{ $searchResult->information ? $searchResult->information->nominee_phone : '' }}" placeholder="নমিনীর মোবাইল নম্বর" style="border-radius:8px; padding: 10px; font-size:14px; border: 1px solid #cbd5e1;">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding:18px 30px; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:1px solid #cbd5e1; border-radius:8px; font-weight: 600; font-size: 14px; padding: 8px 18px;">বন্ধ করুন</button>
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); border:none; border-radius:8px; font-weight:700; font-size: 14px; padding: 8px 24px; box-shadow: 0 4px 12px rgba(139,92,246,0.2);">সংরক্ষণ করুন</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- B. Change Customer Password Modal --}}
                <div class="modal fade" id="changeCustomerPasswordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 16px; border:none;">
                            <div class="modal-header" style="background:#f97316; color:#ffffff; padding:16px 20px;">
                                <h5 class="modal-title fw-bold"><i class="fa-solid fa-key me-2"></i> পাসওয়ার্ড পরিবর্তন</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.emplee.customer.changePassword', $searchResult->id) }}" method="POST">
                                @csrf
                                <div class="modal-body" style="padding:24px;">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">নতুন পাসওয়ার্ড</label>
                                        <input type="password" name="password" class="form-control" required placeholder="কমপক্ষে ৬ অক্ষরের পাসওয়ার্ড দিন..." style="border-radius:8px;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">পাসওয়ার্ড নিশ্চিত করুন</label>
                                        <input type="password" name="password_confirmation" class="form-control" required placeholder="আবার নতুন পাসওয়ার্ডটি দিন..." style="border-radius:8px;">
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-top:none; padding:16px 24px;">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:1px solid #cbd5e1; border-radius:8px;">বন্ধ করুন</button>
                                    <button type="submit" class="btn btn-primary" style="background:#f97316; border:none; border-radius:8px; font-weight:700;">পরিবর্তন করুন</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- C. KYC Detail Modal --}}
                <div class="modal fade" id="kycDetailModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content" style="border-radius: 16px; border:none;">
                            <div class="modal-header" style="background:#2563eb; color:#ffffff; padding:16px 20px;">
                                <h5 class="modal-title fw-bold"><i class="fa-solid fa-circle-info me-2"></i> KYC ও গ্রাহকের বিস্তারিত তথ্য</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="padding:24px; max-height: 500px; overflow-y: auto;">
                                @if($searchResult->information)
                                    <div class="row g-4">
                                        <div class="col-md-4 text-center">
                                            <h6 class="fw-bold mb-2">গ্রাহকের সেলফি</h6>
                                            <div style="border: 2px solid #cbd5e1; border-radius: 12px; overflow: hidden; width: 100%; height: 200px;">
                                                <img src="{{ asset('uploads/avator/' . $searchResult->information->selfie) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="fw-bold border-bottom pb-2 mb-3">KYC তথ্যাদি</h6>
                                            <table class="table table-bordered table-sm" style="font-size:14.5px;">
                                                <tr>
                                                    <td class="fw-bold bg-light" style="width: 150px;">পূর্ণ নাম:</td>
                                                    <td>{{ $searchResult->information->full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold bg-light">মোবাইল নম্বর:</td>
                                                    <td>{{ $searchResult->information->phone_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold bg-light">NID নম্বর:</td>
                                                    <td class="fw-bold text-success">{{ $searchResult->information->nid_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold bg-light">পেশা:</td>
                                                    <td>{{ $searchResult->information->occupation }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold bg-light">বর্তমান ঠিকানা:</td>
                                                    <td>{{ $searchResult->information->current_address }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold bg-light">স্থায়ী ঠিকানা:</td>
                                                    <td>{{ $searchResult->information->permanent_address }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold bg-light">ঋণের কারণ:</td>
                                                    <td>{{ $searchResult->information->loan_reason }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold bg-light">মনোনীত ব্যক্তি:</td>
                                                    <td>{{ $searchResult->information->nominee_name }} ({{ $searchResult->information->nominee_relation }}) - {{ $searchResult->information->nominee_phone }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-3">
                                        <div class="col-6 text-center">
                                            <h6 class="fw-bold mb-2">NID সামনের অংশ</h6>
                                            <div style="border:1.5px solid #e2e8f0; border-radius:10px; overflow:hidden; height:150px;">
                                                <img src="{{ asset('uploads/nid/' . $searchResult->information->nid_front) }}" style="width: 100%; height: 100%; object-fit: contain;">
                                            </div>
                                        </div>
                                        <div class="col-6 text-center">
                                            <h6 class="fw-bold mb-2">NID পেছনের অংশ</h6>
                                            <div style="border:1.5px solid #e2e8f0; border-radius:10px; overflow:hidden; height:150px;">
                                                <img src="{{ asset('uploads/nid/' . $searchResult->information->nid_back) }}" style="width: 100%; height: 100%; object-fit: contain;">
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 40px; color: #f59e0b; margin-bottom: 12px;"></i>
                                        <p class="mb-0" style="font-size: 15px; font-weight: 600;">দুঃখিত, এই গ্রাহক এখনো কোনো KYC বা ডকুমেন্টস জমা দেননি।</p>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer" style="border-top:none; padding:16px 24px;">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="background:#2563eb; border:none; border-radius:8px; font-weight:700;">ঠিক আছে</button>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="alert alert-danger p-3 mb-0" style="border-radius:12px;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> দুঃখিত! এই ফোন নম্বরে কোনো ইউজার খুঁজে পাওয়া যায়নি।
                </div>
            @endif
        @endif
    </div>

    {{-- Quick Tools Section --}}
    <div class="dashboard-section-card">
        <div class="section-title">
            <i class="fa-solid fa-screwdriver-wrench"></i> দ্রুত টুলস
        </div>
        
        <div class="tools-grid">
            {{-- Tool 1: Loan Calculator --}}
            <button class="tool-card tool-card-blue" data-bs-toggle="modal" data-bs-target="#loanCalcModal">
                <i class="fa-solid fa-calculator"></i>
                <span>ঋণ ক্যালকুলেটর</span>
            </button>

            {{-- Tool 2: Certificate --}}
            <button class="tool-card tool-card-green" data-bs-toggle="modal" data-bs-target="#certificateModal">
                <i class="fa-solid fa-award"></i>
                <span>সার্টিফিকেট</span>
            </button>

            {{-- Tool 3: Bank Check --}}
            <button class="tool-card tool-card-purple" data-bs-toggle="modal" data-bs-target="#bankCheckModal">
                <i class="fa-solid fa-money-check-dollar"></i>
                <span>ব্যাংক চেক</span>
            </button>

            {{-- Tool 4: Stamp --}}
            <a href="{{ route('admin.emplee.stamp') }}" class="tool-card tool-card-orange" style="text-decoration:none;">
                <i class="fa-solid fa-stamp"></i>
                <span>ঋণ চুক্তিপত্র</span>
            </a>

            {{-- Tool 5: Insurance --}}
            <button class="tool-card tool-card-green" data-bs-toggle="modal" data-bs-target="#insuranceModal" style="background: linear-gradient(135deg, #059669 0%, #047857 100%) !important; color: #ffffff !important;">
                <i class="fa-solid fa-shield-halved"></i>
                <span>ইন্সুরেন্স</span>
            </button>
        </div>
    </div>

    {{-- 1. Loan Calculator Modal --}}
    <div class="modal fade" id="loanCalcModal" tabindex="-1" aria-labelledby="loanCalcModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
                <div class="modal-header" style="background:#ffffff; color:#0f172a; border-bottom: 1px solid #e2e8f0; padding:20px 24px; position: relative;">
                    <div class="w-100 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: rgba(37,99,235,0.08); color: #2563eb; border-radius: 16px; font-size: 28px; margin-bottom: 8px;">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                        <h5 class="modal-title fw-bold" style="font-size: 26px; color: #0f172a; margin: 0; font-family: 'Hind Siliguri';">ঋণ ক্যালকুলেটর</h5>
                        <p class="text-muted small" style="margin: 4px 0 0 0; font-size: 14px; font-family: 'Hind Siliguri';">সহজে ঋণের হিসাব করুন</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 24px; top: 24px;"></button>
                </div>
                
                <div class="modal-body" style="padding: 32px; background: #ffffff;">
                    <div class="row g-4">
                        {{-- Left Side: Input Form --}}
                        <div class="col-md-6 border-end" style="border-color: #f1f5f9 !important; padding-right: 24px;">
                            <h4 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">হিসাব করুন</h4>
                            
                            {{-- Amount --}}
                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 600; color: #334155; font-size: 14px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-money-bill-wave text-secondary"></i> ঋণের পরিমাণ (টাকা)
                                </label>
                                <input type="number" id="deedAmount" class="form-control" placeholder="যেমন: 50000" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 12px 16px; font-size: 15px; font-weight: 500;" value="50000" oninput="performDeedCalculation()">
                                
                                {{-- Quick buttons --}}
                                <div class="d-flex gap-2 mt-2 flex-wrap" style="justify-content: space-between;">
                                    <button type="button" class="btn btn-sm" onclick="setDeedAmount(50000)" style="flex: 1; min-width: 70px; font-size: 12px; font-weight: 600; border-radius: 6px; padding: 6px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; transition: all 0.2s;">৫০,০০০</button>
                                    <button type="button" class="btn btn-sm" onclick="setDeedAmount(100000)" style="flex: 1; min-width: 70px; font-size: 12px; font-weight: 600; border-radius: 6px; padding: 6px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; transition: all 0.2s;">১,০০,০০০</button>
                                    <button type="button" class="btn btn-sm" onclick="setDeedAmount(200000)" style="flex: 1; min-width: 70px; font-size: 12px; font-weight: 600; border-radius: 6px; padding: 6px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; transition: all 0.2s;">২,০০,০০০</button>
                                    <button type="button" class="btn btn-sm" onclick="setDeedAmount(500000)" style="flex: 1; min-width: 70px; font-size: 12px; font-weight: 600; border-radius: 6px; padding: 6px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; transition: all 0.2s;">৫,০০,০০০</button>
                                </div>
                            </div>

                            {{-- Tenure --}}
                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 600; color: #334155; font-size: 14px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-calendar-days text-secondary"></i> মেয়াদ (মাস)
                                </label>
                                <input type="number" id="deedTenure" class="form-control" placeholder="যেমন: 24" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 12px 16px; font-size: 15px; font-weight: 500;" value="24" oninput="performDeedCalculation()">
                                
                                {{-- Quick buttons --}}
                                <div class="d-flex gap-2 mt-2 flex-wrap" style="justify-content: space-between;">
                                    <button type="button" class="btn btn-sm" onclick="setDeedTenure(12)" style="flex: 1; min-width: 70px; font-size: 12px; font-weight: 600; border-radius: 6px; padding: 6px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; transition: all 0.2s;">১২ মাস</button>
                                    <button type="button" class="btn btn-sm" onclick="setDeedTenure(24)" style="flex: 1; min-width: 70px; font-size: 12px; font-weight: 600; border-radius: 6px; padding: 6px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; transition: all 0.2s;">২৪ মাস</button>
                                    <button type="button" class="btn btn-sm" onclick="setDeedTenure(36)" style="flex: 1; min-width: 70px; font-size: 12px; font-weight: 600; border-radius: 6px; padding: 6px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; transition: all 0.2s;">৩৬ মাস</button>
                                    <button type="button" class="btn btn-sm" onclick="setDeedTenure(48)" style="flex: 1; min-width: 70px; font-size: 12px; font-weight: 600; border-radius: 6px; padding: 6px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; transition: all 0.2s;">৪৮ মাস</button>
                                </div>
                            </div>

                            {{-- Interest Rate --}}
                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 600; color: #334155; font-size: 14px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-percent text-secondary"></i> সুদের হার (বার্ষিক %)
                                </label>
                                <input type="text" id="deedRate" class="form-control" value="2.4" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 12px 16px; font-size: 15px; font-weight: 500;" oninput="performDeedCalculation()">
                            </div>

                            {{-- Calculation Submit --}}
                            <button type="button" class="btn btn-primary w-100" onclick="performDeedCalculation()" style="background:#2563eb; border:none; padding:14px; border-radius:8px; font-weight:700; font-size:16px; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow: 0 4px 12px rgba(37,99,235,0.15);">
                                <i class="fa-solid fa-calculator"></i> হিসাব করুন
                            </button>
                        </div>

                        {{-- Right Side: Result Column --}}
                        <div class="col-md-6" style="padding-left: 24px;">
                            <h4 class="text-center mb-4" style="font-size: 18px; font-weight: 700; color: #0f172a;">ফলাফল</h4>
                            
                            <div id="calcResultState">
                                {{-- Result Cards Grid --}}
                                <div class="d-flex flex-column gap-2 mb-3">
                                    {{-- Card 1: Principal --}}
                                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02);">
                                        <div style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 4px;">মূল ঋণ</div>
                                        <div style="font-size: 26px; font-weight: 800; color: #2563eb;">৳<span id="resPrincipalDeed">50,000</span></div>
                                    </div>

                                    {{-- Card 2: Interest --}}
                                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02);">
                                        <div style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 4px;">সুদ (<span id="resInterestRateLabel">2.4</span>%)</div>
                                        <div style="font-size: 26px; font-weight: 800; color: #ea580c;">৳<span id="resInterestDeed">2,400.00</span></div>
                                    </div>

                                    {{-- Card 3: Tenure --}}
                                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02);">
                                        <div style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 4px;">মেয়াদ</div>
                                        <div style="font-size: 26px; font-weight: 800; color: #7c3aed;"><span id="resTenureDeed">24</span> মাস</div>
                                    </div>

                                    {{-- Card 4: Total Payable --}}
                                    <div style="background: #10b981; border: none; border-radius: 12px; padding: 16px 20px; color: #ffffff; box-shadow: 0 4px 12px rgba(16,185,129,0.2);">
                                        <div style="font-size: 13px; font-weight: 600; opacity: 0.9; margin-bottom: 4px;">মোট পরিশোধযোগ্য</div>
                                        <div style="font-size: 28px; font-weight: 800;">৳<span id="resTotalDeed">52,400.00</span></div>
                                    </div>

                                    {{-- Card 5: Monthly EMI --}}
                                    <div style="background: #2563eb; border: none; border-radius: 12px; padding: 16px 20px; color: #ffffff; box-shadow: 0 4px 12px rgba(37,99,235,0.2);">
                                        <div style="font-size: 13px; font-weight: 600; opacity: 0.9; margin-bottom: 4px;">মাসিক কিস্তি (EMI)</div>
                                        <div style="font-size: 28px; font-weight: 800;">৳<span id="resEMIDeed">2,183.333</span></div>
                                    </div>
                                </div>

                                {{-- Bottom Info Box --}}
                                <div style="background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 12px 16px; color: #78350f; font-size: 13.5px; font-weight: 600; text-align: left; display: flex; align-items: center; gap: 8px; margin-top: 12px;">
                                    <i class="fa-solid fa-circle-info" style="color: #f59e0b; font-size: 16px;"></i>
                                    <span>প্রতি মাসে ৳<span id="infoEMI">2,183.333</span> করে <span id="infoTenure">24</span> মাসে পরিশোধ করতে হবে।</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Installment Amortization Table --}}
                    <div id="installmentListSection" class="mt-5 pt-4 border-top" style="border-color: #e2e8f0 !important;">
                        <h5 class="fw-bold mb-3" style="font-size: 20px; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-table-list"></i> কিস্তি তালিকা
                        </h5>
                        <div class="table-responsive" style="max-height: 450px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                            <table class="table table-hover mb-0" style="font-size: 14px; vertical-align: middle;">
                                <thead class="table-light" style="position: sticky; top: 0; z-index: 10; background: #f8fafc;">
                                    <tr>
                                        <th style="font-weight:700; color:#475569; padding:14px 16px; border-bottom: 2px solid #e2e8f0;">মাস</th>
                                        <th style="font-weight:700; color:#475569; padding:14px 16px; border-bottom: 2px solid #e2e8f0;">মাসিক কিস্তি</th>
                                        <th style="font-weight:700; color:#475569; padding:14px 16px; border-bottom: 2px solid #e2e8f0;">মূল অর্থ</th>
                                        <th style="font-weight:700; color:#475569; padding:14px 16px; border-bottom: 2px solid #e2e8f0;">সুদ</th>
                                        <th style="font-weight:700; color:#475569; padding:14px 16px; border-bottom: 2px solid #e2e8f0;">বাকি</th>
                                    </tr>
                                </thead>
                                <tbody id="installmentTableBody">
                                    {{-- Dynamic rows --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

{{-- 2. Certificate Modal --}}
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            <div class="modal-header" style="background:#ffffff; color:#0f172a; border-bottom: 1px solid #e2e8f0; padding:20px 24px; position: relative;">
                <div class="w-100 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: rgba(16,185,129,0.08); color: #10b981; border-radius: 16px; font-size: 28px; margin-bottom: 8px;">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h5 class="modal-title fw-bold" style="font-size: 26px; color: #0f172a; margin: 0; font-family: 'Hind Siliguri';">ঋণ অনুমোদন সার্টিফিকেট জেনারেটর</h5>
                    <p class="text-muted small" style="margin: 4px 0 0 0; font-size: 14px; font-family: 'Hind Siliguri';">সার্টিফিকেট তৈরি ও ডাউনলোড করুন</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 24px; top: 24px;"></button>
            </div>
            
            <div class="modal-body" style="padding: 32px; background: #f8fafc;">
                <div class="row g-4">
                    {{-- Left Side: Input Form --}}
                    <div class="col-md-5 border-end" style="border-color: #cbd5e1 !important; padding-right: 24px; max-height: 600px; overflow-y: auto;">
                        <h4 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-pen-to-square text-success"></i> তথ্য প্রদান করুন
                        </h4>
                        
                        {{-- Select Approved Loan --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 14px;"><i class="fa-solid fa-magnifying-glass text-secondary me-1"></i> অনুমোদিত লোন নির্বাচন করুন</label>
                            <select id="certLoanSelect" class="form-select" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" onchange="onCertLoanSelected(this)">
                                <option value="">অনুমোদিত লোন সিলেক্ট করুন...</option>
                                @foreach($approvedLoansList as $appLoan)
                                    @php
                                        $nid = $appLoan->user->information ? $appLoan->user->information->nid_number : '';
                                        $selfie = $appLoan->user->information ? $appLoan->user->information->selfie : '';
                                        $loanData = [
                                            'name' => $appLoan->user->name,
                                            'nid' => $nid ? $nid : '6450136103',
                                            'phone' => $appLoan->user->phone,
                                            'amount' => $appLoan->amount,
                                            'tenure' => $appLoan->tenure,
                                            'interest' => $appLoan->interest_amount ?? ($appLoan->amount * 0.024 * ($appLoan->tenure / 12)),
                                            'installment' => $appLoan->monthly_installment ?? (($appLoan->amount + ($appLoan->amount * 0.024 * ($appLoan->tenure / 12))) / $appLoan->tenure),
                                            'date' => $appLoan->created_at->format('d/m/Y'),
                                            'photo' => $selfie ? asset('uploads/avator/' . $selfie) : 'https://ui-avatars.com/api/?name=' . urlencode($appLoan->user->name) . '&background=10b981&color=fff&size=128'
                                        ];
                                    @endphp
                                    <option value="{{ json_encode($loanData) }}">
                                        {{ $appLoan->user->name }} - {{ $appLoan->user->phone }} - ৳{{ number_format($appLoan->amount) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="small text-muted mt-1" style="font-size: 12px;">
                                <i class="fa-solid fa-circle-info"></i> মোট অনুমোদিত ঋণ: <span class="fw-bold text-success">{{ count($approvedLoansList) }}</span> টি
                            </div>
                        </div>

                        <div class="text-center my-3 border-bottom pb-2" style="color: #64748b; font-size: 13px; font-weight: 600;">
                            অথবা ম্যানুয়ালি তথ্য দিন
                        </div>

                        {{-- Photo selector --}}
                        <div class="mb-3 d-flex align-items-center gap-3">
                            <div class="flex-grow-1">
                                <label class="form-label fw-bold" style="color: #334155; font-size: 14px;"><i class="fa-solid fa-image text-secondary me-1"></i> ছবি/সেলফি</label>
                                <input type="file" id="certFileSelector" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; font-size: 13px;" onchange="onCertPhotoUploaded(this)">
                                <div class="small text-muted mt-1" style="font-size: 11px;">সর্বোচ্চ ফাইল সাইজ: 2MB</div>
                            </div>
                            <div style="width: 70px; height: 80px; border: 1.5px dashed #cbd5e1; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; background:#fafafa;">
                                <img id="certFormPhotoPreview" src="https://ui-avatars.com/api/?name=User&background=10b981&color=fff&size=128" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13.5px;">গ্রাহকের নাম</label>
                            <input type="text" id="certFormName" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="Rabbi Alam" oninput="updateCertPreview()">
                        </div>

                        {{-- NID --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13.5px;">NID নম্বর</label>
                            <input type="text" id="certFormNid" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="6450136103" oninput="updateCertPreview()">
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13.5px;">মোবাইল নম্বর</label>
                            <input type="text" id="certFormPhone" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="01626056939" oninput="updateCertPreview()">
                        </div>

                        {{-- Amount & Tenure --}}
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold" style="color: #334155; font-size: 13.5px;">ঋণের পরিমাণ (৳)</label>
                                <input type="number" id="certFormAmount" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="300000" oninput="updateCertPreview()">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold" style="color: #334155; font-size: 13.5px;">মেয়াদ (মাস)</label>
                                <input type="number" id="certFormTenure" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="36" oninput="updateCertPreview()">
                            </div>
                        </div>

                        {{-- Interest & EMI --}}
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold" style="color: #334155; font-size: 13.5px;">সুদের পরিমাণ (৳)</label>
                                <input type="number" id="certFormInterest" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="21600" oninput="updateCertPreview()">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold" style="color: #334155; font-size: 13.5px;">মাসিক কিস্তি (৳)</label>
                                <input type="number" id="certFormEMI" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="8933" oninput="updateCertPreview()">
                            </div>
                        </div>

                        {{-- Approval Date --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13.5px;">অনুমোদনের তারিখ</label>
                            <input type="text" id="certFormDate" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="{{ date('d/m/Y') }}" oninput="updateCertPreview()">
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <button type="button" class="btn btn-success w-100" onclick="updateCertPreview()" style="background:#10b981; border:none; padding:12px; border-radius:8px; font-weight:700; font-size:15px; display:flex; align-items:center; justify-content:center; gap:8px;">
                                <i class="fa-solid fa-signature"></i> সার্টিফিকেট তৈরি করুন
                            </button>
                            <button type="button" class="btn btn-light w-100" onclick="resetCertForm()" style="border:1px solid #cbd5e1; padding:10px; border-radius:8px; font-weight:600; font-size:14px; display:flex; align-items:center; justify-content:center; gap:6px;">
                                <i class="fa-solid fa-rotate-right"></i> ফর্ম রিসেট করুন
                            </button>
                        </div>
                    </div>

                    {{-- Right Side: Preview Column --}}
                    <div class="col-md-7" style="padding-left: 24px;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-eye text-primary"></i> প্রিভিউ
                            </h4>
                            <button type="button" class="btn btn-primary" onclick="downloadCertificate()" style="background:#2563eb; border:none; padding:8px 20px; border-radius:8px; font-weight:700; font-size:14px; display:flex; align-items:center; gap:6px; box-shadow:0 4px 10px rgba(37,99,235,0.15);">
                                <i class="fa-solid fa-download"></i> ডাউনলোড
                            </button>
                        </div>

                        {{-- Certificate Frame --}}
                        <div id="certificatePrintArea">
                            <style>
                                .cert-document-frame {
                                    border: none;
                                    padding: 30px;
                                    background: #ffffff;
                                    border-radius: 16px;
                                    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
                                    color: #1e293b;
                                    position: relative;
                                    font-family: 'Hind Siliguri', 'Outfit', sans-serif;
                                }
                                .cert-title-main {
                                    font-family: 'Outfit', sans-serif;
                                    font-size: 26px;
                                    font-weight: 800;
                                    color: #10b981;
                                    text-align: center;
                                    margin-bottom: 2px;
                                }
                                .cert-title-sub {
                                    font-family: 'Hind Siliguri', sans-serif;
                                    font-size: 15px;
                                    font-weight: 600;
                                    color: #475569;
                                    text-align: center;
                                    margin-bottom: 15px;
                                    letter-spacing: 1px;
                                }
                                .cert-divider {
                                    height: 1px;
                                    background: #e2e8f0;
                                    margin: 15px 0;
                                }
                                .cert-intro-text {
                                    font-size: 16px;
                                    font-weight: 600;
                                    color: #0f172a;
                                    text-align: center;
                                    margin-bottom: 24px;
                                    font-family: 'Hind Siliguri', sans-serif;
                                }
                                .cert-details-grid {
                                    display: flex;
                                    gap: 20px;
                                    margin-bottom: 24px;
                                }
                                .cert-info-list {
                                    flex: 1;
                                    display: flex;
                                    flex-direction: column;
                                    gap: 8px;
                                    font-family: 'Hind Siliguri', sans-serif;
                                    font-size: 14px;
                                }
                                .cert-info-item {
                                    display: flex;
                                    border-bottom: 1px dashed #f1f5f9;
                                    padding-bottom: 6px;
                                }
                                .cert-info-label {
                                    font-weight: 700;
                                    color: #475569;
                                    width: 140px;
                                }
                                .cert-info-val {
                                    font-weight: 700;
                                    color: #0f172a;
                                }
                                .cert-photo-container {
                                    width: 120px;
                                    height: 140px;
                                    border: 1px solid #e2e8f0;
                                    border-radius: 8px;
                                    overflow: hidden;
                                    background: #f8fafc;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    margin-top: 5px;
                                }
                                .cert-photo-img {
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                }
                                .cert-status-banner {
                                    background: #ecfdf5;
                                    border: none;
                                    border-radius: 8px;
                                    padding: 10px;
                                    text-align: center;
                                    color: #059669;
                                    font-weight: 700;
                                    font-size: 14px;
                                    margin-bottom: 12px;
                                    font-family: 'Hind Siliguri', sans-serif;
                                }
                                .cert-footer-stamps {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                    margin-top: 24px;
                                    padding-top: 15px;
                                    border-top: 1px solid #f1f5f9;
                                }
                                .cert-stamps-group {
                                    display: flex;
                                    gap: 12px;
                                }
                                .cert-stamp-circle {
                                    width: 48px;
                                    height: 48px;
                                    border-radius: 50%;
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 8px;
                                    font-weight: 800;
                                    position: relative;
                                    text-align: center;
                                }
                                .cert-stamp-ubs {
                                    border: 2px solid #2563eb;
                                    color: #2563eb;
                                    background: rgba(37,99,235,0.03);
                                }
                                .cert-stamp-gov {
                                    border: 2px solid #dc2626;
                                    color: #dc2626;
                                    background: rgba(220,38,38,0.03);
                                }
                                .cert-stamp-leaf {
                                    border: 2px solid #10b981;
                                    color: #10b981;
                                    background: rgba(16,185,129,0.03);
                                }
                                .cert-signature-box {
                                    text-align: center;
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                }
                                .cert-signature-line {
                                    border-top: 1.5px solid #94a3b8;
                                    width: 140px;
                                    margin-top: 25px;
                                    margin-bottom: 4px;
                                }
                                .cert-signature-label {
                                    font-size: 11px;
                                    color: #64748b;
                                    font-weight: 600;
                                }
                                .cert-signature-hand {
                                    font-family: 'Engagement', 'Outfit', cursive;
                                    font-size: 18px;
                                    color: #0f172a;
                                    font-style: italic;
                                    margin-top: -30px;
                                    font-weight: bold;
                                }
                                .cert-disclaimer {
                                    background: #f8fafc;
                                    border: 1px solid #e2e8f0;
                                    border-radius: 6px;
                                    padding: 8px 12px;
                                    font-size: 9px;
                                    color: #64748b;
                                    line-height: 1.4;
                                    text-align: justify;
                                    margin-top: 15px;
                                    font-family: sans-serif;
                                }
                            </style>

                            <div class="cert-document-frame">
                                <div class="cert-title-main">Pncbd Loan Management System</div>
                                <div class="cert-title-sub">ঋণ অনুমোদন সার্টিফিকেট</div>
                                
                                <div class="cert-divider"></div>

                                <div class="cert-intro-text">এই মর্মে প্রত্যয়ন করা যাচ্ছে যে</div>

                                <div class="cert-details-grid">
                                    <div class="cert-info-list">
                                        <div class="cert-info-item">
                                            <span class="cert-info-label">নাম:</span>
                                            <span class="cert-info-val" id="prevName">Rabbi Alam</span>
                                        </div>
                                        <div class="cert-info-item">
                                            <span class="cert-info-label">NID:</span>
                                            <span class="cert-info-val" id="prevNid">6450136103</span>
                                        </div>
                                        <div class="cert-info-item">
                                            <span class="cert-info-label">মোবাইল:</span>
                                            <span class="cert-info-val" id="prevPhone">01626056939</span>
                                        </div>
                                        <div class="cert-info-item">
                                            <span class="cert-info-label">ঋণের পরিমাণ:</span>
                                            <span class="cert-info-val">৳<span id="prevAmount">৩,০০,০০০.০০</span> টাকা</span>
                                        </div>
                                        <div class="cert-info-item">
                                            <span class="cert-info-label">মেয়াদ:</span>
                                            <span class="cert-info-val"><span id="prevTenure">36</span> মাস</span>
                                        </div>
                                        <div class="cert-info-item">
                                            <span class="cert-info-label">সুদের পরিমাণ:</span>
                                            <span class="cert-info-val">৳<span id="prevInterest">২১,৬০০.০০</span> টাকা</span>
                                        </div>
                                        <div class="cert-info-item">
                                            <span class="cert-info-label">মোট পরিশোধযোগ্য:</span>
                                            <span class="cert-info-val">৳<span id="prevTotal">৩,২১,৬০০.০০</span> টাকা</span>
                                        </div>
                                        <div class="cert-info-item">
                                            <span class="cert-info-label">মাসিক কিস্তি:</span>
                                            <span class="cert-info-val">৳<span id="prevEMI">৮,৯৩৩.০০</span> টাকা</span>
                                        </div>
                                        <div class="cert-info-item">
                                            <span class="cert-info-label">অনুমোদনের তারিখ:</span>
                                            <span class="cert-info-val" id="prevApprovalDate">24/05/2026</span>
                                        </div>
                                    </div>
                                    <div class="cert-photo-container">
                                        <img id="prevPhoto" class="cert-photo-img" src="https://ui-avatars.com/api/?name=User&background=10b981&color=fff&size=128">
                                    </div>
                                </div>

                                <div class="cert-status-banner" style="position: relative; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 80px; gap: 6px;">
                                    @if(file_exists(public_path('uploads/onomodon/approved_seal.png')))
                                        <img src="{{ asset('uploads/onomodon/approved_seal.png') }}?v={{ time() }}" alt="Approved Seal" style="max-height: 64px; object-fit: contain;">
                                    @endif
                                    <div>✓ উপরোক্ত ব্যক্তির ঋণ আবেদন অনুমোদিত হয়েছে</div>
                                </div>
                                <div class="text-center text-muted small" style="font-size:11px;">
                                    অনুমোদনের তারিখ: <span id="prevApprovalDateBottom">24/05/2026</span>
                                </div>

                                <div class="cert-footer-stamps">
                                    <div class="cert-stamps-group" style="display: flex; gap: 12px; align-items: center;">
                                        {{-- Official Bank Seal (Only One) --}}
                                        @if(file_exists(public_path('uploads/onomodon/ubs_seal.png')))
                                            <img src="{{ asset('uploads/onomodon/ubs_seal.png') }}?v={{ time() }}" alt="Official Seal" style="width: 72px; height: 72px; object-fit: contain; border-radius: 50%;">
                                        @else
                                            <div class="cert-stamp-circle cert-stamp-ubs" style="width: 72px; height: 72px; font-size: 11px;">
                                                <i class="fa-solid fa-building-columns" style="font-size: 24px; margin-bottom: 2px;"></i>
                                                <span>Pncbd Seal</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="cert-signature-box">
                                        <div class="cert-signature-hand">Pncbd Manager</div>
                                        <div class="cert-signature-line"></div>
                                        <div class="cert-signature-label">Authorization signature</div>
                                    </div>
                                </div>

                                <div class="cert-disclaimer">
                                    This document has a restricted distribution and may be used by recipients only in the performance of their official. It's contents may not otherwise be dismissed without World Bank authorization.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2.5. Insurance Modal --}}
<div class="modal fade" id="insuranceModal" tabindex="-1" aria-labelledby="insuranceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            <div class="modal-header" style="background:#ffffff; color:#0f172a; border-bottom: 1px solid #e2e8f0; padding:20px 24px; position: relative;">
                <div class="w-100 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: rgba(5,150,105,0.08); color: #059669; border-radius: 16px; font-size: 28px; margin-bottom: 8px;">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h5 class="modal-title fw-bold" style="font-size: 26px; color: #0f172a; margin: 0; font-family: 'Hind Siliguri';">ইন্সুরেন্স ডকুমেন্ট জেনারেটর</h5>
                    <p class="text-muted small" style="margin: 4px 0 0 0; font-size: 14px; font-family: 'Hind Siliguri';">ইন্সুরেন্স কপি তৈরি ও ডাউনলোড করুন</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 24px; top: 24px;"></button>
            </div>
            
            <div class="modal-body" style="padding: 32px; background: #f8fafc;">
                <div class="row g-4">
                    {{-- Left Side: Input Form --}}
                    <div class="col-md-5 border-end" style="border-color: #cbd5e1 !important; padding-right: 24px; max-height: 600px; overflow-y: auto;">
                        <h4 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-pen-to-square text-success"></i> তথ্য প্রদান করুন
                        </h4>
                        
                        {{-- Select Approved Loan --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 14px;"><i class="fa-solid fa-magnifying-glass text-secondary me-1"></i> অনুমোদিত লোন নির্বাচন করুন</label>
                            <select id="insLoanSelect" class="form-select" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" onchange="onInsLoanSelected(this)">
                                <option value="">অনুমোদিত লোন সিলেক্ট করুন...</option>
                                @foreach($approvedLoansList as $appLoan)
                                    @php
                                        $nid = $appLoan->user->information ? $appLoan->user->information->nid_number : '';
                                        $address = $appLoan->user->information ? $appLoan->user->information->permanent_address : $appLoan->user->address;
                                        $insData = [
                                            'name' => $appLoan->user->name,
                                            'nid' => $nid ? $nid : '৫২৫ ৮৫০ ৯৮৯২',
                                            'phone' => $appLoan->user->phone,
                                            'address' => $address ? $address : 'সিরাজগঞ্জ সদর।',
                                            'father' => 'মোঃ পহের আলী',
                                            'mother' => 'মোচ্ছাঃ লিলি বেগম',
                                            'branch' => '০৪৪৫',
                                            'policy' => '৯০-' . rand(1000, 9999)
                                        ];
                                    @endphp
                                    <option value="{{ json_encode($insData) }}">
                                        {{ $appLoan->user->name }} - {{ $appLoan->user->phone }} - ৳{{ number_format($appLoan->amount) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-center my-3 border-bottom pb-2" style="color: #64748b; font-size: 13px; font-weight: 600;">
                            অথবা ম্যানুয়ালি তথ্য দিন
                        </div>

                        {{-- Branch Code & Policy Number --}}
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold" style="color: #334155; font-size: 13px;">শাখা কোড</label>
                                <input type="text" id="insFormBranch" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="০৪৪৫" oninput="updateInsPreview()">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold" style="color: #334155; font-size: 13px;">পলিসি নং</label>
                                <input type="text" id="insFormPolicy" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="৯০-৩১২৯" oninput="updateInsPreview()">
                            </div>
                        </div>

                        {{-- Insured name --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13px;">বীমা গ্রাহকের নাম</label>
                            <input type="text" id="insFormName" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="মোঃ আমিন হোসেন" oninput="updateInsPreview()">
                        </div>

                        {{-- Father's name --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13px;">পিতা/স্বামীর নাম</label>
                            <input type="text" id="insFormFather" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="মোঃ পহের আলী" oninput="updateInsPreview()">
                        </div>

                        {{-- Mother's name --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13px;">মাতার নাম</label>
                            <input type="text" id="insFormMother" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="মোচ্ছাঃ লিলি বেগম" oninput="updateInsPreview()">
                        </div>

                        {{-- NID --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13px;">জাতীয় পরিচয় পত্র</label>
                            <input type="text" id="insFormNid" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="৫২৫ ৮৫০ ৯৮৯২" oninput="updateInsPreview()">
                        </div>

                        {{-- Address --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13px;">স্থায়ী ঠিকানা</label>
                            <input type="text" id="insFormAddress" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="শহীদগঞ্জ, ভাঙ্গাবাড়ি, সিরাজগঞ্জ-৬৭০০, সিরাজগঞ্জ সদর।" oninput="updateInsPreview()">
                        </div>

                        {{-- Mobile --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #334155; font-size: 13px;">মোবাইল নম্বর</label>
                            <input type="text" id="insFormPhone" class="form-control" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" value="০১৮৮৩-৭১৭৪০৬" oninput="updateInsPreview()">
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <button type="button" class="btn btn-success w-100" onclick="updateInsPreview()" style="background:#059669; border:none; padding:12px; border-radius:8px; font-weight:700; font-size:15px; display:flex; align-items:center; justify-content:center; gap:8px;">
                                <i class="fa-solid fa-signature"></i> ইন্সুরেন্স তৈরি করুন
                            </button>
                            <button type="button" class="btn btn-light w-100" onclick="resetInsForm()" style="border:1px solid #cbd5e1; padding:10px; border-radius:8px; font-weight:600; font-size:14px; display:flex; align-items:center; justify-content:center; gap:6px;">
                                <i class="fa-solid fa-rotate-right"></i> ফর্ম রিসেট করুন
                            </button>
                        </div>
                    </div>

                    {{-- Right Side: Preview Column --}}
                    <div class="col-md-7" style="padding-left: 24px;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-eye text-primary"></i> প্রিভিউ
                            </h4>
                            <button type="button" class="btn btn-primary" onclick="downloadInsurance()" style="background:#059669; border:none; padding:8px 20px; border-radius:8px; font-weight:700; font-size:14px; display:flex; align-items:center; gap:6px; box-shadow:0 4px 10px rgba(5,150,105,0.15);">
                                <i class="fa-solid fa-download"></i> ডাউনলোড
                            </button>
                        </div>

                        {{-- Insurance Document Frame --}}
                        <div id="insurancePrintArea">
                            <style>
                                .ins-document-frame {
                                    border: none;
                                    padding: 30px;
                                    background: #ffffff;
                                    border-radius: 16px;
                                    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
                                    color: #1e293b;
                                    position: relative;
                                    font-family: 'Hind Siliguri', 'Outfit', sans-serif;
                                }
                                .ins-header {
                                    display: flex;
                                    align-items: center;
                                    justify-content: space-between;
                                    margin-bottom: 20px;
                                    border-bottom: 1.5px solid #10b981;
                                    padding-bottom: 15px;
                                }
                                .ins-logo-wrapper {
                                    width: 50px;
                                    height: 50px;
                                    color: #10b981;
                                    border: 2px solid #10b981;
                                    border-radius: 50%;
                                    font-size: 24px;
                                    display: inline-flex;
                                    align-items: center;
                                    justify-content: center;
                                }
                                .ins-header-text {
                                    text-align: center;
                                    flex-grow: 1;
                                }
                                .ins-gov-text {
                                    font-size: 15px;
                                    font-weight: 800;
                                    color: #0f172a;
                                    margin-bottom: 2px;
                                }
                                .ins-company-name {
                                    font-size: 18px;
                                    font-weight: 800;
                                    color: #10b981;
                                    margin-bottom: 2px;
                                }
                                .ins-project-title {
                                    font-size: 13px;
                                    font-weight: 700;
                                    color: #475569;
                                }
                                .ins-meta-row {
                                    display: flex;
                                    justify-content: space-between;
                                    font-size: 13px;
                                    font-weight: 700;
                                    color: #1e293b;
                                    margin-bottom: 16px;
                                    padding: 0 5px;
                                }
                                .ins-details-table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    margin-bottom: 20px;
                                }
                                .ins-details-table td {
                                    padding: 8px 12px;
                                    font-size: 13.5px;
                                    font-weight: 600;
                                    border: 1px solid #f1f5f9;
                                    vertical-align: middle;
                                }
                                .ins-details-table tr:nth-child(odd) {
                                    background-color: #f8fafc;
                                }
                                .ins-label-cell {
                                    width: 160px;
                                    font-weight: 700;
                                    color: #475569;
                                }
                                .ins-val-cell {
                                    color: #0f172a;
                                }
                                .ins-desc-para {
                                    font-size: 13.5px;
                                    line-height: 1.8;
                                    color: #334155;
                                    text-align: justify;
                                    margin-bottom: 12px;
                                    font-weight: 500;
                                }
                                .ins-footer-signatures {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                    margin-top: 24px;
                                    padding-top: 15px;
                                    border-top: 1.5px solid #f1f5f9;
                                }
                                .ins-signature-box {
                                    text-align: center;
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                }
                                .ins-signature-line {
                                    border-top: 1.5px solid #94a3b8;
                                    width: 130px;
                                    margin-top: 15px;
                                    margin-bottom: 4px;
                                }
                                .ins-signature-label {
                                    font-size: 11px;
                                    color: #64748b;
                                    font-weight: 600;
                                }
                                .ins-signature-hand {
                                    font-family: 'Great Vibes', cursive;
                                    font-size: 20px;
                                    color: #1e3a8a;
                                    margin-top: -20px;
                                    font-weight: bold;
                                }
                                .ins-seal-circle {
                                    width: 48px;
                                    height: 48px;
                                    border: 2px solid #dc2626;
                                    color: #dc2626;
                                    border-radius: 50%;
                                    display: inline-flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 8px;
                                    font-weight: 800;
                                    text-align: center;
                                    background: rgba(220,38,38,0.01);
                                }
                                .ins-seal-idra {
                                    width: 48px;
                                    height: 48px;
                                    border: 2px solid #10b981;
                                    color: #10b981;
                                    border-radius: 50%;
                                    display: inline-flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 8px;
                                    font-weight: 800;
                                    text-align: center;
                                    background: rgba(16,185,129,0.01);
                                }
                                .ins-tagline {
                                    text-align: center;
                                    font-size: 11px;
                                    font-weight: 700;
                                    color: #475569;
                                    font-style: italic;
                                    margin-top: 15px;
                                }
                                .ins-brand-footer {
                                    margin-top: 20px;
                                    padding-top: 12px;
                                    border-top: 1px dashed #cbd5e1;
                                    text-align: center;
                                }
                                .ins-brand-name-eng {
                                    font-family: 'Outfit', sans-serif;
                                    font-size: 14px;
                                    font-weight: 800;
                                    color: #10b981;
                                    letter-spacing: 0.5px;
                                    margin-bottom: 2px;
                                }
                                .ins-brand-address {
                                    font-size: 9px;
                                    color: #64748b;
                                }
                            </style>

                            <div class="ins-document-frame">
                                <div class="ins-header">
                                    <div class="ins-logo-wrapper">
                                        <i class="fa-solid fa-leaf"></i>
                                    </div>
                                    <div class="ins-header-text">
                                        <div class="ins-gov-text">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার <span style="font-size:10px; font-weight:normal;">রেজিঃ নং - ৫৪৬৪৯</span></div>
                                        <div class="ins-company-name">পপুলার লাইফ ইন্সুরেন্স কোম্পানি লিমিটেড</div>
                                        <div class="ins-project-title">জনপ্রিয় বীমা প্রকল্প</div>
                                    </div>
                                    <div class="ins-logo-wrapper">
                                        <i class="fa-solid fa-leaf"></i>
                                    </div>
                                </div>

                                <div class="ins-meta-row">
                                    <div>শাখা কোড : <span id="prevInsBranch">০৪৪৫</span></div>
                                    <div>পলিসি নং : <span id="prevInsPolicy">৯০-৩১২৯</span></div>
                                </div>

                                <table class="ins-details-table">
                                    <tr>
                                        <td class="ins-label-cell">বীমা গ্রাহকের নাম</td>
                                        <td class="ins-val-cell">: <span id="prevInsName">মোঃ আমিন হোসেন</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ins-label-cell">পিতা / স্বামীর নাম</td>
                                        <td class="ins-val-cell">: <span id="prevInsFather">মোঃ পহের আলী</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ins-label-cell">মাতার নাম</td>
                                        <td class="ins-val-cell">: <span id="prevInsMother">মোচ্ছাঃ লিলি বেগম</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ins-label-cell">জাতীয় পরিচয় পত্র</td>
                                        <td class="ins-val-cell" style="font-weight: bold; color: #10b981;">: <span id="prevInsNid">৫২৫ ৮৫০ ৯৮৯২</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ins-label-cell">স্থায়ী ঠিকানা</td>
                                        <td class="ins-val-cell">: <span id="prevInsAddress">শহীদগঞ্জ, ভাঙ্গাবাড়ি, সিরাজগঞ্জ-৬৭০০, সিরাজগঞ্জ সদর।</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ins-label-cell">মোবাইল নম্বর</td>
                                        <td class="ins-val-cell">: <span id="prevInsPhone">০১৮৮৩-৭১৭৪০৬</span></td>
                                    </tr>
                                </table>

                                <div class="ins-desc-para">
                                    জীবন বীমা হল অর্থের বিনিময়ে জীবন, সম্পদ বা মালামালে সম্ভাব্য ক্ষয়ক্ষতি ন্যায়সঙ্গত ও নির্দিষ্ট ঝুঁকির স্থানান্তর। এটি একটি অনিশ্চিত ক্ষয়ক্ষতি এড়ানোর জন্য ব্যবস্থাপনার একটি অংশ।
                                </div>
                                <div class="ins-desc-para">
                                    মূলত বীমা কোম্পানি একটি নির্দিষ্ট ফি প্রিমিয়াম এর বিনিময়ে আপনার সম্ভাব্য ঝুঁকি বহন করে এবং ক্ষতির ক্ষেত্রে আর্থিক সুরক্ষা প্রদান করে।
                                </div>

                                <div class="ins-footer-signatures">
                                    <div class="ins-signature-box">
                                        <div class="ins-signature-hand">Authorized Signature</div>
                                        <div class="ins-signature-line"></div>
                                        <div class="ins-signature-label">Authorized Officer</div>
                                    </div>
                                    <div class="ins-seal-circle">
                                        <i class="fa-solid fa-star" style="font-size:12px; margin-bottom:2px;"></i>
                                        <span>GOVT</span>
                                    </div>
                                    <div class="ins-seal-idra">
                                        <i class="fa-solid fa-shield" style="font-size:12px; margin-bottom:2px;"></i>
                                        <span>IDRA</span>
                                    </div>
                                </div>
                                <div class="ins-tagline">
                                    "A Great Name in Life Insurance"
                                </div>

                                <div class="ins-brand-footer">
                                    <div class="ins-brand-name-eng">POPULAR LIFE INSURANCE COMPANY LIMITED</div>
                                    <div class="ins-brand-address">HEAD OFFICE: Peoples Insurance Bhaban (3rd Floor), 36 Dilkusha C/A, Dhaka-1000</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. Bank Check Modal --}}
<div class="modal fade" id="bankCheckModal" tabindex="-1" aria-labelledby="bankCheckModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            <div class="modal-header" style="background:#ffffff; color:#0f172a; border-bottom: 1px solid #e2e8f0; padding:20px 24px; position: relative;">
                <div class="w-100 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: rgba(139,92,246,0.08); color: #8b5cf6; border-radius: 16px; font-size: 28px; margin-bottom: 8px;">
                        <i class="fa-solid fa-money-check-dollar"></i>
                    </div>
                    <h5 class="modal-title fw-bold" style="font-size: 26px; color: #0f172a; margin: 0; font-family: 'Hind Siliguri';">ব্যাংক চেক ডিসবার্সমেন্ট</h5>
                    <p class="text-muted small" style="margin: 4px 0 0 0; font-size: 14px; font-family: 'Hind Siliguri';">চেক তৈরি ও ডাউনলোড করুন</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 24px; top: 24px;"></button>
            </div>
            
            <div class="modal-body" style="padding: 32px; background: #f8fafc;">
                <div class="row g-4">
                    {{-- Left Side: Form Input --}}
                    <div class="col-md-4 border-end" style="border-color: #cbd5e1 !important; padding-right: 24px;">
                        <div class="bg-white border p-4" style="border-radius: 16px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);">
                            <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-file-pen text-purple"></i> চেক তথ্য
                            </h4>
                            
                            {{-- Name --}}
                            <div class="mb-3">
                                <input type="text" id="checkFormName" class="form-control" placeholder="গ্রাহকের নাম" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" value="{{ $searchResult ? $searchResult->name : 'Nazmulone' }}" oninput="updateCheckPreview()">
                            </div>

                            {{-- Amount --}}
                            <div class="mb-3">
                                <input type="number" id="checkFormAmount" class="form-control" placeholder="টাকার পরিমাণ (যেমন: 25000.00)" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" value="25000" oninput="updateCheckPreview()">
                            </div>

                            {{-- Amount in words --}}
                            <div class="mb-3">
                                <textarea id="checkFormWords" class="form-control" rows="2" placeholder="কথায় টাকার পরিমাণ" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" oninput="updateCheckPreview()">Twenty Five Thousand Taka Only</textarea>
                            </div>

                            {{-- Account Number --}}
                            <div class="mb-3">
                                <input type="text" id="checkFormAccount" class="form-control" placeholder="অ্যাকাউন্ট নম্বর" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" value="10294857362" oninput="updateCheckPreview()">
                            </div>

                            {{-- Date --}}
                            <div class="mb-4">
                                <input type="text" id="checkFormDate" class="form-control" placeholder="তারিখ (যেমন: 05/24/2026)" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" value="{{ date('m/d/Y') }}" oninput="updateCheckPreview()">
                            </div>

                            <button type="button" class="btn btn-primary w-100" onclick="printCheck()" style="background:#2563eb; border:none; padding:12px; border-radius:8px; font-weight:700; font-size:15px; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow: 0 4px 10px rgba(37,99,235,0.15);">
                                <i class="fa-solid fa-download"></i> চেক ডাউনলোড করুন
                            </button>
                        </div>
                    </div>

                    {{-- Right Side: Check Preview --}}
                    <div class="col-md-8 text-center" style="padding-left: 24px;">
                        <h4 class="text-start mb-3" style="font-size: 18px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-eye text-primary"></i> প্রিভিউ
                        </h4>
                        
                        <div id="checkPrintArea" style="max-width: 100%;">
                            <style>
                                .premium-bank-check {
                                    border: 1.5px solid #64748b;
                                    border-radius: 16px;
                                    padding: 26px 32px;
                                    background: #ffffff;
                                    box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
                                    position: relative;
                                    text-align: left;
                                    font-family: 'Outfit', 'Hind Siliguri', sans-serif;
                                    color: #1e293b;
                                    /* Security background grid pattern */
                                    background-image: 
                                      radial-gradient(rgba(37, 99, 235, 0.02) 1.5px, transparent 1.5px),
                                      linear-gradient(rgba(37, 99, 235, 0.01) 1px, transparent 1px),
                                      linear-gradient(90deg, rgba(37, 99, 235, 0.01) 1px, transparent 1px);
                                    background-size: 16px 16px, 8px 8px, 8px 8px;
                                    min-height: 340px;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: space-between;
                                    overflow: hidden;
                                    border-left: 8px solid #2563eb;
                                }
                                .check-watermark {
                                    position: absolute;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                    width: 220px;
                                    height: 220px;
                                    pointer-events: none;
                                    opacity: 0.9;
                                    z-index: 1;
                                }
                                .check-logo-area {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: flex-start;
                                    margin-bottom: 20px;
                                    position: relative;
                                    z-index: 2;
                                }
                                .check-stamp-container {
                                    width: 76px;
                                    height: 76px;
                                    position: relative;
                                    transform: rotate(-3deg);
                                    filter: drop-shadow(1px 2px 4px rgba(37, 99, 235, 0.15));
                                }
                                .check-security-code {
                                    font-size: 11px;
                                    color: #64748b;
                                    font-weight: 600;
                                    font-family: 'Outfit', sans-serif;
                                    letter-spacing: 0.5px;
                                }
                                .check-body-lines {
                                    position: relative;
                                    z-index: 2;
                                    margin-bottom: 10px;
                                }
                                .check-line {
                                    display: flex;
                                    align-items: flex-end;
                                    margin-bottom: 16px;
                                    font-size: 14px;
                                }
                                .check-label {
                                    font-weight: 700;
                                    color: #475569;
                                    min-width: 175px;
                                    text-transform: uppercase;
                                    font-size: 10.5px;
                                    letter-spacing: 0.5px;
                                    font-family: 'Outfit', sans-serif;
                                }
                                .check-value-dotted {
                                    flex-grow: 1;
                                    border-bottom: 1.5px dashed #64748b;
                                    padding-bottom: 2px;
                                    font-weight: 700;
                                    color: #0f172a;
                                    font-size: 16px;
                                    font-family: 'Outfit', 'Hind Siliguri', sans-serif;
                                }
                                .check-bottom-row {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: flex-end;
                                    margin-top: 15px;
                                    padding-top: 5px;
                                    position: relative;
                                    z-index: 2;
                                }
                                .check-digits-micr {
                                    font-family: 'Courier New', Courier, monospace;
                                    font-size: 19px;
                                    font-weight: bold;
                                    letter-spacing: 6px;
                                    color: #0f172a;
                                    word-spacing: 12px;
                                    user-select: none;
                                }
                                .check-signature-container {
                                    text-align: center;
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    margin-right: 10px;
                                }
                                .check-signature-img {
                                    font-family: 'Great Vibes', cursive;
                                    font-size: 28px;
                                    color: #1e3a8a;
                                    font-weight: normal;
                                    margin-bottom: -6px;
                                    transform: rotate(-2deg);
                                    user-select: none;
                                }
                                .check-signature-line {
                                    border-top: 1.5px solid #64748b;
                                    width: 160px;
                                    margin-top: 2px;
                                    margin-bottom: 3px;
                                }
                                .check-signature-label {
                                    font-size: 10px;
                                    color: #64748b;
                                    font-weight: 600;
                                    text-transform: uppercase;
                                    letter-spacing: 0.5px;
                                }
                            </style>

                            <div class="premium-bank-check">
                                <!-- absolute globe watermark behind elements -->
                                <div class="check-watermark">
                                    <svg viewBox="0 0 100 100" fill="none" stroke="rgba(37, 99, 235, 0.025)" stroke-width="0.4">
                                        <circle cx="50" cy="50" r="42" />
                                        <circle cx="50" cy="50" r="32" />
                                        <ellipse cx="50" cy="50" rx="42" ry="15" />
                                        <ellipse cx="50" cy="50" rx="15" ry="42" />
                                        <line x1="8" y1="50" x2="92" y2="50" />
                                        <line x1="50" y1="8" x2="50" y2="92" />
                                    </svg>
                                </div>

                                <div class="check-logo-area">
                                    <!-- Site stamp / logo -->
                                    <div class="check-stamp-container">
                                        @if(!empty($gs->header_logo))
                                            {{-- Real logo image with circular frame overlay --}}
                                            <svg viewBox="0 0 100 100" style="width: 100%; height: 100%; position: absolute; top:0; left:0;">
                                                <circle cx="50" cy="50" r="43" fill="none" stroke="#2563eb" stroke-width="1.8" />
                                                <circle cx="50" cy="50" r="32" fill="none" stroke="#2563eb" stroke-width="0.8" />
                                                <defs><path id="stampTextPath2" d="M 50,50 m -35,0 a 35,35 0 1,1 70,0 a 35,35 0 1,1 -70,0" /></defs>
                                                <text font-size="6.2" font-family="'Outfit', sans-serif" font-weight="900" fill="#2563eb">
                                                    <textPath href="#stampTextPath2" startOffset="50%" text-anchor="middle">
                                                        {{ strtoupper($gs->site_name ?? 'PNCBD') }} • {{ strtoupper($gs->site_name ?? 'PNCBD') }} •
                                                    </textPath>
                                                </text>
                                            </svg>
                                            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:46px; height:46px; border-radius:50%; overflow:hidden; background:#fff;">
                                                <img src="{{ asset($gs->header_logo) }}" alt="Logo" style="width:100%; height:100%; object-fit:contain;">
                                            </div>
                                        @else
                                            {{-- Fallback: SVG stamp with site initial + name --}}
                                            <svg viewBox="0 0 100 100" style="width: 100%; height: 100%;">
                                                <defs>
                                                    <path id="stampTextPath" d="M 50,50 m -35,0 a 35,35 0 1,1 70,0 a 35,35 0 1,1 -70,0" />
                                                </defs>
                                                <circle cx="50" cy="50" r="43" fill="none" stroke="#2563eb" stroke-width="1.8" />
                                                <circle cx="50" cy="50" r="32" fill="none" stroke="#2563eb" stroke-width="0.8" />
                                                <g stroke="#2563eb" stroke-width="0.4" opacity="0.4" fill="none">
                                                    <circle cx="50" cy="50" r="23" />
                                                    <ellipse cx="50" cy="50" rx="23" ry="8" />
                                                    <ellipse cx="50" cy="50" rx="8" ry="23" />
                                                </g>
                                                <text font-size="6.2" font-family="'Outfit', sans-serif" font-weight="900" fill="#2563eb">
                                                    <textPath href="#stampTextPath" startOffset="50%" text-anchor="middle">
                                                        {{ strtoupper($gs->site_name ?? 'PNCBD') }} •
                                                    </textPath>
                                                </text>
                                                <text x="50" y="56" font-size="18" font-family="'Outfit', sans-serif" font-weight="900" fill="#2563eb" text-anchor="middle" letter-spacing="-0.5">
                                                    {{ strtoupper(substr($gs->site_name ?? 'PN', 0, 2)) }}
                                                </text>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="check-security-code">
                                        Security Code: {{ strtoupper(preg_replace('/\s+/', '-', $gs->site_name ?? 'PNCBD')) }}-2025-CHK
                                    </div>
                                </div>

                                <div class="check-body-lines">
                                    <div class="check-line">
                                        <span class="check-label">Received with thanks from:</span>
                                        <span class="check-value-dotted" id="prevCheckName">Nazmulone</span>
                                    </div>
                                    <div class="check-line">
                                        <span class="check-label">Amount:</span>
                                        <span class="check-value-dotted" style="color: #2563eb; font-size: 18px;" id="prevCheckAmount">৳ 25,000.00</span>
                                    </div>
                                    <div class="check-line">
                                        <span class="check-label">AMOUNT (in words):</span>
                                        <span class="check-value-dotted" id="prevCheckWords">Twenty Five Thousand Taka Only</span>
                                    </div>
                                    <div class="check-line">
                                        <span class="check-label">DATE:</span>
                                        <span class="check-value-dotted" id="prevCheckDate">24 May 2026</span>
                                    </div>
                                </div>

                                <div class="check-bottom-row">
                                    <div class="check-digits-micr" id="prevCheckMICR">
                                        ⑈ 104288 ⑈ 8557449 ⑈ 00020012
                                    </div>
                                    <div class="check-signature-container">
                                        <div class="check-signature-img">{{ $gs->site_name ?? 'PNCBD' }}</div>
                                        <div class="check-signature-line"></div>
                                        <div class="check-signature-label">Authorized Signature</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 4. Stamp Modal --}}
<div class="modal fade" id="stampModal" tabindex="-1" aria-labelledby="stampModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            <div class="modal-header" style="background:#f97316; color:#ffffff; padding:20px 24px; position: relative;">
                <div class="w-100 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: rgba(255,255,255,0.15); color: #ffffff; border-radius: 16px; font-size: 28px; margin-bottom: 8px;">
                        <i class="fa-solid fa-stamp"></i>
                    </div>
                    <h5 class="modal-title fw-bold" style="font-size: 26px; color: #ffffff; margin: 0; font-family: 'Hind Siliguri';">ঋণ চুক্তিপত্র স্ট্যাম্প জেনারেটর</h5>
                    <p class="text-white-50 small mb-0" style="margin-top: 4px; font-size: 14px; font-family: 'Hind Siliguri';">চুক্তিপত্র তৈরি ও ডাউনলোড করুন</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 24px; top: 24px;"></button>
            </div>
            
            <div class="modal-body" style="padding: 32px; background: #f8fafc;">
                <div class="row g-4">
                    {{-- Left Side: Input Form --}}
                    <div class="col-md-4 border-end" style="border-color: #cbd5e1 !important; padding-right: 24px; max-height: 650px; overflow-y: auto;">
                        <div class="bg-white border p-4" style="border-radius: 16px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);">
                            <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-file-signature text-warning"></i> তথ্য দিন
                            </h4>
                            
                            {{-- Select Approved Loan --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #334155; font-size: 12.5px;"><i class="fa-solid fa-magnifying-glass text-secondary me-1"></i> অনুমোদিত লোন নির্বাচন করুন</label>
                                <select id="stampLoanSelect" class="form-select" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px;" onchange="onStampLoanSelected(this)">
                                    <option value="">অনুমোদিত লোন সিলেক্ট করুন...</option>
                                    @foreach($approvedLoansList as $appLoan)
                                        @php
                                            $nid = $appLoan->user->information ? $appLoan->user->information->nid_number : '';
                                            $address = $appLoan->user->information ? $appLoan->user->information->current_address : '';
                                            $stampData = [
                                                'name' => $appLoan->user->name,
                                                'nid' => $nid ? $nid : '',
                                                'address' => $address ? $address : '',
                                                'amount' => $appLoan->amount,
                                                'tenure' => $appLoan->tenure,
                                                'installment' => $appLoan->monthly_installment ?? (($appLoan->amount + ($appLoan->amount * 0.024 * ($appLoan->tenure / 12))) / $appLoan->tenure),
                                            ];
                                        @endphp
                                        <option value="{{ json_encode($stampData) }}">
                                            {{ $appLoan->user->name }} - {{ $appLoan->user->phone }} - ৳{{ number_format($appLoan->amount) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="text-center my-3 border-bottom pb-2" style="color: #64748b; font-size: 11.5px; font-weight: 600;">
                                অথবা ম্যানুয়ালি তথ্য দিন
                            </div>

                            {{-- Borrower Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #475569; font-size: 13px;">ঋণগ্রহীতার নাম</label>
                                <input type="text" id="stampFormName" class="form-control" placeholder="ঋণগ্রহীতার নাম" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px;" value="{{ $searchResult ? $searchResult->name : 'Elisa Maurer' }}" oninput="updateStampPreview()">
                            </div>

                            {{-- NID Number --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #475569; font-size: 13px;">এনআইডি নম্বর</label>
                                <input type="text" id="stampFormNid" class="form-control" placeholder="এনআইডি নম্বর" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px;" value="{{ $searchResult && $searchResult->information ? $searchResult->information->nid_number : '' }}" oninput="updateStampPreview()">
                            </div>

                            {{-- Father's Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #475569; font-size: 13px;">পিতার নাম</label>
                                <input type="text" id="stampFormFather" class="form-control" placeholder="পিতার নাম" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px;" value="" oninput="updateStampPreview()">
                            </div>

                            {{-- Address --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #475569; font-size: 13px;">ঠিকানা</label>
                                <textarea id="stampFormAddress" class="form-control" rows="2" placeholder="ঠিকানা" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px;" oninput="updateStampPreview()">{{ $searchResult && $searchResult->information ? $searchResult->information->current_address : '' }}</textarea>
                            </div>

                            {{-- Loan Amount --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #475569; font-size: 13px;">ঋণের পরিমাণ (৳)</label>
                                <input type="number" id="stampFormAmount" class="form-control" placeholder="টাকার পরিমাণ (৳)" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px;" value="{{ $searchResult && $searchResult->loans->isNotEmpty() ? $searchResult->loans->first()->amount : '50000' }}" oninput="updateStampPreview()">
                            </div>

                            {{-- Loan Tenure --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #475569; font-size: 13px;">ঋণের মেয়াদ (মাস)</label>
                                <input type="number" id="stampFormTenure" class="form-control" placeholder="মেয়াদ (মাস)" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px;" value="{{ $searchResult && $searchResult->loans->isNotEmpty() ? $searchResult->loans->first()->tenure : '12' }}" oninput="updateStampPreview()">
                            </div>

                            {{-- Monthly Installment --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #475569; font-size: 13px;">মাসিক কিস্তি (৳)</label>
                                <input type="text" id="stampFormEMI" class="form-control" placeholder="মাসিক কিস্তির পরিমাণ (৳)" style="border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px;" value="{{ $searchResult && $searchResult->loans->isNotEmpty() ? $searchResult->loans->first()->monthly_installment : '4266.67' }}" oninput="updateStampPreview()">
                            </div>

                            {{-- Upload Stamp Image --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #475569; font-size: 13px;">স্ট্যাম্প ছবি আপলোড করুন</label>
                                <input type="file" id="stampFormImage" class="form-control" accept="image/*" style="border-radius: 8px; border: 1.5px solid #cbd5e1; font-size: 13.5px;" onchange="onStampPhotoUploaded(this)">
                            </div>

                            {{-- Upload Signature Image --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold" style="color: #475569; font-size: 13px;">স্বাক্ষর ছবি আপলোড করুন</label>
                                <input type="file" id="stampFormSignature" class="form-control" accept="image/*" style="border-radius: 8px; border: 1.5px solid #cbd5e1; font-size: 13.5px;" onchange="onStampSignatureUploaded(this)">
                            </div>

                            <button type="button" class="btn btn-primary w-100" onclick="printStamp()" style="background:#2563eb; border:none; padding:12px; border-radius:8px; font-weight:700; font-size:15px; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow: 0 4px 10px rgba(37,99,235,0.15);">
                                <i class="fa-solid fa-download"></i> ডাউনলোড করুন
                            </button>
                        </div>
                    </div>

                    {{-- Right Side: Stamp Deed Live Preview --}}
                    <div class="col-md-8 text-center" style="padding-left: 24px;">
                        <h4 class="text-start mb-3" style="font-size: 18px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-eye text-primary"></i> প্রিভিউ
                        </h4>
                        
                        <div id="stampPrintArea" style="max-width: 100%;">
                            <style>
                                .premium-stamp-deed {
                                    border: 1.5px solid #cbd5e1;
                                    border-radius: 16px;
                                    padding: 40px;
                                    background: #ffffff;
                                    box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
                                    position: relative;
                                    text-align: left;
                                    font-family: 'Noto Sans Bengali', 'Outfit', sans-serif;
                                    color: #1e293b;
                                    min-height: 900px;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: flex-start;
                                }

                                .stamp-deed-header {
                                    width: 100%;
                                    border-radius: 8px;
                                    overflow: hidden;
                                    margin-bottom: 25px;
                                    border: 1px solid #e2e8f0;
                                }

                                .stamp-deed-title {
                                    text-align: center;
                                    font-size: 18px;
                                    font-weight: 700;
                                    text-decoration: underline;
                                    color: #0f172a;
                                    margin-bottom: 24px;
                                    letter-spacing: 0.5px;
                                }

                                .stamp-deed-body {
                                    font-size: 14.5px;
                                    line-height: 1.9;
                                    color: #334155;
                                    text-align: justify;
                                }

                                .stamp-details-box {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: flex-start;
                                    margin-bottom: 24px;
                                    border-bottom: 1.5px dashed #e2e8f0;
                                    padding-bottom: 20px;
                                }

                                .stamp-details-list {
                                    flex: 1;
                                    display: flex;
                                    flex-direction: column;
                                    gap: 6px;
                                }

                                .stamp-details-item {
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                }

                                .stamp-details-label {
                                    font-weight: 700;
                                    color: #475569;
                                    min-width: 130px;
                                }

                                .stamp-details-val {
                                    font-weight: 700;
                                    color: #0f172a;
                                }

                                .stamp-deed-text-para {
                                    margin-top: 15px;
                                    text-indent: 40px;
                                    font-size: 14.5px;
                                }

                                .stamp-deed-signatures {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: flex-end;
                                    margin-top: 60px;
                                    padding: 0 10px;
                                }

                                .stamp-sig-box {
                                    text-align: center;
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                }

                                .stamp-sig-line {
                                    border-top: 1.5px solid #64748b;
                                    width: 150px;
                                    margin-top: 5px;
                                    margin-bottom: 4px;
                                }

                                .stamp-sig-label {
                                    font-size: 12px;
                                    font-weight: 700;
                                    color: #475569;
                                }

                                .stamp-photo-frame {
                                    width: 110px;
                                    height: 130px;
                                    border: 1.5px dashed #cbd5e1;
                                    border-radius: 8px;
                                    overflow: hidden;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    background: #fafafa;
                                    position: relative;
                                    flex-shrink: 0;
                                    margin-left: 20px;
                                }

                                .stamp-photo-frame img {
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                }

                                .stamp-photo-placeholder {
                                    font-size: 11px;
                                    font-weight: 700;
                                    color: #94a3b8;
                                    text-transform: uppercase;
                                    letter-spacing: 0.5px;
                                }
                            </style>

                            <div class="premium-stamp-deed">
                                {{-- Stamp Header Image --}}
                                <div class="stamp-deed-header">
                                    @if($activeStampUrl)
                                        <img src="{{ $activeStampUrl }}" alt="Government Stamp" style="width: 100%; height: auto; object-fit: contain;">
                                    @else
                                        {{-- Gorgeous Fallback Stamp Deed --}}
                                        <div class="py-4 text-center" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%); color: white; border-bottom: 4px solid #14532d;">
                                            <h3 class="fw-bold mb-1" style="font-family: 'Noto Sans Bengali'; font-size: 24px; letter-spacing: 1px;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h3>
                                            <span style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; opacity: 0.85;">Non-Judicial Stamp - ৳১০০</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="stamp-deed-title">ঋণ চুক্তিপত্র (Deed of Loan Agreement)</div>

                                <div class="stamp-deed-body">
                                    <div class="stamp-details-box">
                                        <div class="stamp-details-list">
                                            <div class="stamp-details-item">
                                                <span class="stamp-details-label">ঋণগ্রহীতার নাম:</span>
                                                <span class="stamp-details-val" id="prevStampName">Elisa Maurer</span>
                                            </div>
                                            <div class="stamp-details-item">
                                                <span class="stamp-details-label">এনআইডি নম্বর:</span>
                                                <span class="stamp-details-val font-monospace" id="prevStampNid">—</span>
                                            </div>
                                            <div class="stamp-details-item">
                                                <span class="stamp-details-label">পিতার নাম:</span>
                                                <span class="stamp-details-val" id="prevStampFather">—</span>
                                            </div>
                                            <div class="stamp-details-item">
                                                <span class="stamp-details-label">ঠিকানা:</span>
                                                <span class="stamp-details-val" id="prevStampAddress">—</span>
                                            </div>
                                            <div class="stamp-details-item">
                                                <span class="stamp-details-label">ঋণের পরিমাণ:</span>
                                                <span class="stamp-details-val" style="color: #2563eb;" id="prevStampAmount">৫০,০০০</span> টাকা
                                            </div>
                                            <div class="stamp-details-item">
                                                <span class="stamp-details-label">ঋণের মেয়াদ:</span>
                                                <span class="stamp-details-val" id="prevStampTenure">১২</span> মাস
                                            </div>
                                            <div class="stamp-details-item">
                                                <span class="stamp-details-label">মাসিক কিস্তি:</span>
                                                <span class="stamp-details-val" style="color: #ea580c;" id="prevStampEMI">৪,২৬৬.৬৭</span> টাকা
                                            </div>
                                        </div>

                                        {{-- Stamp Photo Container --}}
                                        <div class="stamp-photo-frame" id="stampPhotoContainer">
                                            <img id="prevStampPhoto" src="#" alt="স্ট্যাম্প" style="display: none;">
                                            <span class="stamp-photo-placeholder" id="prevStampPhotoPlaceholder">স্ট্যাম্প</span>
                                        </div>
                                    </div>

                                    <h5 class="fw-bold mb-3 mt-4" style="color: #0f172a; font-size: 15px;"><i class="fa-solid fa-circle-info text-warning me-1"></i> গুরুত্বপূর্ণ তথ্য ও শর্তাবলী</h5>
                                    
                                    <p class="stamp-deed-text-para">
                                        আমি <strong id="deedBodyName">Elisa Maurer</strong>, পিতা - <strong id="deedBodyFather">—</strong>, gram/ঠিকানা - <strong id="deedBodyAddress">—</strong>। আমি Union Bank of Switzerland (UBS) এর পক্ষ থেকে <strong id="deedBodyAmount">৫০,০০০</strong> টাকা ঋণগ্রহণে সম্মত হয়েছি, যার মেয়াদকাল <strong id="deedBodyTenure">১২</strong> মাস। প্রতিমাসে নির্ধারিত কিস্তি <strong id="deedBodyEMI">৪,২৬৬.৬৭</strong> টাকা করে ঋণের কিস্তি প্রদানের ক্ষেত্রে আমাকে প্রতি মাসের এক তারিখ থেকে দশ তারিখের মধ্যে নির্ধারিত অনলাইন পদ্ধতির মাধ্যমে কিস্তি জমা দিতে হবে। কোনো কারণে কিস্তি প্রদানে বিলম্ব হলে তা ব্যাংক কর্তৃপক্ষকে অবিলম্বে জানাতে হবে এবং ব্যাংকের নির্দেশনা অনুযায়ী বকেয়া পরিশোধ করতে হবে। এই শর্ত লঙ্ঘন করা হলে ব্যাংক প্রয়োজনীয় আইনানুগ ব্যবস্থা নিতে পারবে।
                                    </p>

                                    <p class="stamp-deed-text-para">
                                        Union Bank of Switzerland (UBS) আমার প্রদত্ত তথ্য, আর্থিক অবস্থা এবং ঋণ গ্রহণের যোগ্যতা যাচাই করে এই ঋণ অনুমোদন করেছে। আমি দৃঢ়ভাবে প্রতিশ্রুতি দিচ্ছি যে ব্যাংকের দেওয়া সব শর্ত ও নিয়মাবলী আমি যথাযথভাবে পালন করব। আমার পক্ষ থেকে দেওয়া তথ্য যদি পরবর্তীতে ভুল প্রমাণিত হয় বা আমি চুক্তি ভঙ্গ করি, তবে ব্যাংক আইনি ব্যবস্থা গ্রহণ করতে সম্পূর্ণ স্বাধীন থাকবে।
                                    </p>

                                    <div class="stamp-deed-signatures">
                                        <div class="stamp-sig-box">
                                            <div style="height: 50px;"></div>
                                            <div class="stamp-sig-line"></div>
                                            <div class="stamp-sig-label">ব্যাংক কর্তৃপক্ষের স্বাক্ষর</div>
                                        </div>
                                        <div class="stamp-sig-box">
                                            <div style="height: 50px; display: flex; align-items: center; justify-content: center; margin-bottom: 5px;">
                                                <img id="prevStampSignature" src="#" alt="স্বাক্ষর" style="max-height: 100%; max-width: 150px; display: none; object-fit: contain;">
                                            </div>
                                            <div class="stamp-sig-line"></div>
                                            <div class="stamp-sig-label">ঋণগ্রহীতার স্বাক্ষর</div>
                                        </div>
                                    </div>

                                    <div class="mt-5 text-center" style="font-size: 11px; color: #64748b; font-weight: 600; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                                        বিঃদ্রঃ ঋণের শর্তাবলী পালন না করলে ব্যাংক কর্তৃপক্ষ আইনানুগ ব্যবস্থা নিতে বাধ্য থাকিবে।<br>
                                        <span class="text-success fw-bold" style="font-size: 12px; display: block; margin-top: 5px;">“দেশপ্রেমের শপথ নিন, দুর্নীতিকে বিদায় দিন”</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Set Quick Values for Deed Calculator
    function setDeedAmount(val) {
        document.getElementById('deedAmount').value = val;
        performDeedCalculation();
    }

    function setDeedTenure(val) {
        document.getElementById('deedTenure').value = val;
        performDeedCalculation();
    }

    // Perform Deed calculation logic matching exact screenshot formula
    function performDeedCalculation() {
        const amountEl = document.getElementById('deedAmount');
        const tenureEl = document.getElementById('deedTenure');
        const rateEl   = document.getElementById('deedRate');

        let amount = parseFloat(amountEl.value);
        let tenure = parseFloat(tenureEl.value);
        let rate   = parseFloat(rateEl.value);

        if (isNaN(amount) || amount < 0) amount = 0;
        if (isNaN(tenure) || tenure <= 0) tenure = 1;
        if (isNaN(rate) || rate < 0) rate = 0;

        // 1. Calculation: barshik flat rate
        const interestAmount = Math.round(amount * (rate / 100) * (tenure / 12));
        const totalPayable    = amount + interestAmount;
        const monthlyEMI      = Math.round((totalPayable / tenure) * 1000) / 1000; // 3 decimals precision

        // 2. Update output text on cards
        document.getElementById('resPrincipalDeed').textContent = amount.toLocaleString('en-US');
        document.getElementById('resInterestRateLabel').textContent = rate;
        document.getElementById('resInterestDeed').textContent = (Math.round(interestAmount * 100) / 100).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('resTenureDeed').textContent = tenure;
        document.getElementById('resTotalDeed').textContent = (Math.round(totalPayable * 100) / 100).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('resEMIDeed').textContent = monthlyEMI.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
        
        // 3. Update bottom alert box values
        document.getElementById('infoEMI').textContent = monthlyEMI.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
        document.getElementById('infoTenure').textContent = tenure;

        // 4. Generate Amortization Installment List Table Rows
        const tbody = document.getElementById('installmentTableBody');
        tbody.innerHTML = ''; // reset

        const principalPerMonth = amount / tenure;
        const interestPerMonth  = interestAmount / tenure;

        for (let m = 1; m <= tenure; m++) {
            const remainingBalance = Math.max(0, amount - (m * principalPerMonth));

            // Create row
            const tr = document.createElement('tr');
            
            // Format numbers
            const fEMI = monthlyEMI.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
            const fPrincipal = principalPerMonth.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
            const fInterest = interestPerMonth.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            const fRemaining = remainingBalance.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});

            tr.innerHTML = `
                <td style="padding:14px 16px; font-weight:700; color:#1e293b;">${m}</td>
                <td style="padding:14px 16px; font-weight:700; color:#2563eb; text-decoration: underline;">৳${fEMI}</td>
                <td style="padding:14px 16px; color:#475569; font-weight:500;">৳${fPrincipal}</td>
                <td style="padding:14px 16px; color:#475569; font-weight:500;">৳${fInterest}</td>
                <td style="padding:14px 16px; font-weight:700; color:#10b981;">৳${fRemaining}</td>
            `;
            tbody.appendChild(tr);
        }
    }

    // Auto-calculate on load and when modal is shown
    document.addEventListener('DOMContentLoaded', function() {
        performDeedCalculation();
        
        var modalEl = document.getElementById('loanCalcModal');
        if (modalEl) {
            modalEl.addEventListener('shown.bs.modal', function () {
                performDeedCalculation();
            });
        }

        // Initialize Certificate Preview on first load
        updateCertPreview();

        // Initialize Check Preview on first load
        updateCheckPreview();

        // Initialize Stamp Preview on first load
        updateStampPreview();

        // Initialize Insurance Preview on first load
        updateInsPreview();

        var checkModalEl = document.getElementById('bankCheckModal');
        if (checkModalEl) {
            checkModalEl.addEventListener('shown.bs.modal', function () {
                updateCheckPreview();
            });
        }

        var stampModalEl = document.getElementById('stampModal');
        if (stampModalEl) {
            stampModalEl.addEventListener('shown.bs.modal', function () {
                updateStampPreview();
            });
        }

        var insModalEl = document.getElementById('insuranceModal');
        if (insModalEl) {
            insModalEl.addEventListener('shown.bs.modal', function () {
                updateInsPreview();
            });
        }
    });

    // ══════════════════════════════════════════════════════════════
    // Loan Approval Certificate Generator JS Handlers
    // ══════════════════════════════════════════════════════════════

    // Dropdown selection handler
    function onCertLoanSelected(selectEl) {
        if (!selectEl.value) return;

        try {
            const data = JSON.parse(selectEl.value);

            // Populate form inputs
            document.getElementById('certFormName').value = data.name;
            document.getElementById('certFormNid').value = data.nid;
            document.getElementById('certFormPhone').value = data.phone;
            document.getElementById('certFormAmount').value = data.amount;
            document.getElementById('certFormTenure').value = data.tenure;
            document.getElementById('certFormInterest').value = Math.round(data.interest);
            document.getElementById('certFormEMI').value = Math.round(data.installment);
            document.getElementById('certFormDate').value = data.date;

            // Set photo previews
            document.getElementById('certFormPhotoPreview').src = data.photo;
            document.getElementById('prevPhoto').src = data.photo;

            // Force update preview card
            updateCertPreview();
        } catch (e) {
            console.error("Error parsing loan data:", e);
        }
    }

    // Local file selfie/photo uploader handler
    function onCertPhotoUploaded(inputEl) {
        if (inputEl.files && inputEl.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('certFormPhotoPreview').src = e.target.result;
                document.getElementById('prevPhoto').src = e.target.result;
            };
            reader.readAsDataURL(inputEl.files[0]);
        }
    }

    // Synchronize inputs to preview card dynamically
    function updateCertPreview() {
        const name = document.getElementById('certFormName').value;
        const nid = document.getElementById('certFormNid').value;
        const phone = document.getElementById('certFormPhone').value;
        const amount = parseFloat(document.getElementById('certFormAmount').value) || 0;
        const tenure = parseFloat(document.getElementById('certFormTenure').value) || 0;
        const interest = parseFloat(document.getElementById('certFormInterest').value) || 0;
        const emi = parseFloat(document.getElementById('certFormEMI').value) || 0;
        const date = document.getElementById('certFormDate').value;

        // Calculate total payable
        const total = amount + interest;

        // Formatted strings
        const fAmount = amount.toLocaleString('en-US');
        const fInterest = interest.toLocaleString('en-US');
        const fTotal = total.toLocaleString('en-US');
        const fEMI = emi.toLocaleString('en-US');

        // Update preview text nodes
        document.getElementById('prevName').textContent = name;
        document.getElementById('prevNid').textContent = nid;
        document.getElementById('prevPhone').textContent = phone;
        document.getElementById('prevAmount').textContent = fAmount;
        document.getElementById('prevTenure').textContent = tenure;
        document.getElementById('prevInterest').textContent = fInterest;
        document.getElementById('prevTotal').textContent = fTotal;
        document.getElementById('prevEMI').textContent = fEMI;
        document.getElementById('prevApprovalDate').textContent = date;
        document.getElementById('prevApprovalDateBottom').textContent = date;
    }

    // Reset Certificate Form to default sample values
    function resetCertForm() {
        document.getElementById('certLoanSelect').value = "";
        document.getElementById('certFormName').value = "Rabbi Alam";
        document.getElementById('certFormNid').value = "6450136103";
        document.getElementById('certFormPhone').value = "01626056939";
        document.getElementById('certFormAmount').value = "300000";
        document.getElementById('certFormTenure').value = "36";
        document.getElementById('certFormInterest').value = "21600";
        document.getElementById('certFormEMI').value = "8933";
        document.getElementById('certFormDate').value = new Date().toLocaleDateString('en-GB'); // dd/mm/yyyy format
        document.getElementById('certFileSelector').value = "";
        document.getElementById('certFormPhotoPreview').src = "https://ui-avatars.com/api/?name=User&background=10b981&color=fff&size=128";
        document.getElementById('prevPhoto').src = "https://ui-avatars.com/api/?name=User&background=10b981&color=fff&size=128";

        updateCertPreview();
    }

    // Print/Download Certificate as PDF/Image
    function downloadCertificate() {
        const printContent = document.getElementById('certificatePrintArea').innerHTML;
        const workerElement = document.createElement('div');
        workerElement.style.position = 'absolute';
        workerElement.style.left = '-9999px';
        workerElement.style.width = '750px';
        workerElement.innerHTML = `
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&display=swap');
                .cert-print-container { font-family: 'Hind Siliguri', 'Outfit', sans-serif; background: #ffffff; padding: 20px; color: #1e293b; }
                .cert-document-frame { border: 3px solid #10b981; padding: 30px; background: #ffffff; border-radius: 16px; color: #1e293b; position: relative; }
                .cert-title-main { font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 800; color: #10b981; text-align: center; margin-bottom: 2px; }
                .cert-title-sub { font-family: 'Hind Siliguri', sans-serif; font-size: 15px; font-weight: 600; color: #475569; text-align: center; margin-bottom: 15px; letter-spacing: 1px; }
                .cert-divider { height: 1px; background: #e2e8f0; margin: 15px 0; }
                .cert-intro-text { font-size: 16px; font-weight: 600; color: #0f172a; text-align: center; margin-bottom: 24px; }
                .cert-details-grid { display: flex; gap: 20px; margin-bottom: 24px; }
                .cert-info-list { flex: 1; display: flex; flex-direction: column; gap: 8px; font-size: 14px; }
                .cert-info-item { display: flex; border-bottom: 1px dashed #f1f5f9; padding-bottom: 6px; }
                .cert-info-label { font-weight: 700; color: #475569; width: 140px; }
                .cert-info-val { font-weight: 700; color: #0f172a; }
                .cert-photo-container { width: 120px; height: 140px; border: 2px solid #10b981; border-radius: 8px; overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; }
                .cert-photo-img { width: 100%; height: 100%; object-fit: cover; }
                .cert-status-banner { background: #ecfdf5; border: 1px solid #10b981; border-radius: 8px; padding: 10px; text-align: center; color: #059669; font-weight: 700; font-size: 14px; margin-bottom: 12px; }
                .cert-footer-stamps { display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 15px; border-top: 1px solid #f1f5f9; }
                .cert-stamps-group { display: flex; gap: 12px; }
                .cert-stamp-circle { width: 48px; height: 48px; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 8px; font-weight: 800; position: relative; text-align: center; }
                .cert-stamp-ubs { border: 2px solid #2563eb; color: #2563eb; background: rgba(37,99,235,0.03); }
                .cert-stamp-gov { border: 2px solid #dc2626; color: #dc2626; background: rgba(220,38,38,0.03); }
                .cert-stamp-leaf { border: 2px solid #10b981; color: #10b981; background: rgba(16,185,129,0.03); }
                .cert-signature-box { text-align: center; display: flex; flex-direction: column; align-items: center; }
                .cert-signature-line { border-top: 1.5px solid #94a3b8; width: 140px; margin-top: 25px; margin-bottom: 4px; }
                .cert-signature-label { font-size: 11px; color: #64748b; font-weight: 600; }
                .cert-signature-hand { font-family: 'Engagement', 'Outfit', cursive; font-size: 18px; color: #0f172a; font-style: italic; margin-top: -30px; font-weight: bold; }
                .cert-disclaimer { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 12px; font-size: 9px; color: #64748b; line-height: 1.4; text-align: justify; margin-top: 15px; }
            </style>
            <div class="cert-print-container">
                ${printContent}
            </div>
        `;
        document.body.appendChild(workerElement);
        
        const customerName = document.getElementById('certFormName').value || 'Customer';
        const opt = {
            margin:       [10, 10, 10, 10],
            filename:     'Loan_Approval_Certificate_' + customerName.replace(/\s+/g, '_') + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2.5, useCORS: true, logging: false },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        
        html2pdf().set(opt).from(workerElement).save().then(() => {
            document.body.removeChild(workerElement);
        });
    }

    // ══════════════════════════════════════════════════════════════
    // Popular Life Insurance Generator JS Handlers
    // ══════════════════════════════════════════════════════════════

    // Dropdown selection handler for Insurance
    function onInsLoanSelected(selectEl) {
        if (!selectEl.value) return;

        try {
            const data = JSON.parse(selectEl.value);

            // Populate form inputs
            document.getElementById('insFormName').value = data.name;
            document.getElementById('insFormNid').value = data.nid;
            document.getElementById('insFormPhone').value = data.phone;
            document.getElementById('insFormAddress').value = data.address;
            document.getElementById('insFormFather').value = data.father;
            document.getElementById('insFormMother').value = data.mother;
            document.getElementById('insFormBranch').value = data.branch;
            document.getElementById('insFormPolicy').value = data.policy;

            // Force update preview
            updateInsPreview();
        } catch (e) {
            console.error("Error parsing loan data for insurance:", e);
        }
    }

    // Synchronize inputs to preview card dynamically
    function updateInsPreview() {
        const name = document.getElementById('insFormName').value || '—';
        const nid = document.getElementById('insFormNid').value || '—';
        const phone = document.getElementById('insFormPhone').value || '—';
        const address = document.getElementById('insFormAddress').value || '—';
        const father = document.getElementById('insFormFather').value || '—';
        const mother = document.getElementById('insFormMother').value || '—';
        const branch = document.getElementById('insFormBranch').value || '—';
        const policy = document.getElementById('insFormPolicy').value || '—';

        // Update preview text nodes
        document.getElementById('prevInsName').textContent = name;
        document.getElementById('prevInsNid').textContent = nid;
        document.getElementById('prevInsPhone').textContent = phone;
        document.getElementById('prevInsAddress').textContent = address;
        document.getElementById('prevInsFather').textContent = father;
        document.getElementById('prevInsMother').textContent = mother;
        document.getElementById('prevInsBranch').textContent = branch;
        document.getElementById('prevInsPolicy').textContent = policy;
    }

    // Reset Insurance Form to default values
    function resetInsForm() {
        document.getElementById('insLoanSelect').value = "";
        document.getElementById('insFormBranch').value = "০৪৪৫";
        document.getElementById('insFormPolicy').value = "৯০-৩১২৯";
        document.getElementById('insFormName').value = "মোঃ আমিন হোসেন";
        document.getElementById('insFormFather').value = "মোঃ পহের আলী";
        document.getElementById('insFormMother').value = "মোচ্ছাঃ লিলি বেগম";
        document.getElementById('insFormNid').value = "৫২৫ ৮৫০ ৯৮৯২";
        document.getElementById('insFormAddress').value = "শহীদগঞ্জ, ভাঙ্গাবাড়ি, সিরাজগঞ্জ-৬৭০০, সিরাজগঞ্জ সদর।";
        document.getElementById('insFormPhone').value = "০১৮৮৩-৭১৭৪০৬";

        updateInsPreview();
    }

    // Download Insurance as PDF/Image (Print wrapper)
    function downloadInsurance() {
        const printContent = document.getElementById('insurancePrintArea').innerHTML;
        const workerElement = document.createElement('div');
        workerElement.style.position = 'absolute';
        workerElement.style.left = '-9999px';
        workerElement.style.width = '750px';
        workerElement.innerHTML = `
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&family=Great+Vibes&display=swap');
                .ins-print-container { font-family: 'Hind Siliguri', 'Outfit', sans-serif; background: #ffffff; padding: 20px; color: #1e293b; }
                .ins-document-frame { border: none; padding: 30px; background: #ffffff; color: #1e293b; position: relative; }
                .ins-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 1.5px solid #10b981; padding-bottom: 15px; }
                .ins-logo-wrapper { width: 50px; height: 50px; color: #10b981; border: 2px solid #10b981; border-radius: 50%; font-size: 24px; display: inline-flex; align-items: center; justify-content: center; }
                .ins-header-text { text-align: center; flex-grow: 1; }
                .ins-gov-text { font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
                .ins-company-name { font-size: 18px; font-weight: 800; color: #10b981; margin-bottom: 2px; }
                .ins-project-title { font-size: 13px; font-weight: 700; color: #475569; }
                .ins-meta-row { display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 16px; padding: 0 5px; }
                .ins-details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                .ins-details-table td { padding: 8px 12px; font-size: 13.5px; font-weight: 600; border: 1px solid #f1f5f9; vertical-align: middle; }
                .ins-details-table tr:nth-child(odd) { background-color: #f8fafc; }
                .ins-label-cell { width: 160px; font-weight: 700; color: #475569; }
                .ins-val-cell { color: #0f172a; }
                .ins-desc-para { font-size: 13.5px; line-height: 1.8; color: #334155; text-align: justify; margin-bottom: 12px; font-weight: 500; }
                .ins-footer-signatures { display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 15px; border-top: 1.5px solid #f1f5f9; }
                .ins-signature-box { text-align: center; display: flex; flex-direction: column; align-items: center; }
                .ins-signature-line { border-top: 1.5px solid #94a3b8; width: 130px; margin-top: 15px; margin-bottom: 4px; }
                .ins-signature-label { font-size: 11px; color: #64748b; font-weight: 600; }
                .ins-signature-hand { font-family: 'Great Vibes', cursive; font-size: 20px; color: #1e3a8a; margin-top: -20px; font-weight: bold; }
                .ins-seal-circle { width: 48px; height: 48px; border: 2px solid #dc2626; color: #dc2626; border-radius: 50%; display: inline-flex; flex-direction: column; align-items: center; justify-content: center; font-size: 8px; font-weight: 800; text-align: center; background: rgba(220,38,38,0.01); }
                .ins-seal-idra { width: 48px; height: 48px; border: 2px solid #10b981; color: #10b981; border-radius: 50%; display: inline-flex; flex-direction: column; align-items: center; justify-content: center; font-size: 8px; font-weight: 800; text-align: center; background: rgba(16,185,129,0.01); }
                .ins-tagline { text-align: center; font-size: 11px; font-weight: 700; color: #475569; font-style: italic; margin-top: 15px; }
                .ins-brand-footer { margin-top: 20px; padding-top: 12px; border-top: 1px dashed #cbd5e1; text-align: center; }
                .ins-brand-name-eng { font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 800; color: #10b981; letter-spacing: 0.5px; margin-bottom: 2px; }
                .ins-brand-address { font-size: 9px; color: #64748b; }
            </style>
            <div class="ins-print-container">
                ${printContent}
            </div>
        `;
        document.body.appendChild(workerElement);
        
        const customerName = document.getElementById('insFormName').value || 'Customer';
        const opt = {
            margin:       [10, 10, 10, 10],
            filename:     'Popular_Life_Insurance_' + customerName.replace(/\s+/g, '_') + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2.5, useCORS: true, logging: false },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        
        html2pdf().set(opt).from(workerElement).save().then(() => {
            document.body.removeChild(workerElement);
        });
    }

    // ══════════════════════════════════════════════════════════════
    // Bank Check Generator JS Handlers
    // ══════════════════════════════════════════════════════════════

    // Automatic English Number to Words converter
    function numberToWords(num) {
        if (num === 0) return 'Zero';
        
        const a = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        
        function chunk(n) {
            if (n < 20) return a[n];
            const digit = n % 10;
            if (n < 100) return b[Math.floor(n / 10)] + (digit ? ' ' + a[digit] : '');
            const hundred = Math.floor(n / 100);
            const rest = n % 100;
            return a[hundred] + ' Hundred' + (rest ? ' and ' + chunk(rest) : '');
        }
        
        let words = '';
        const billion = Math.floor(num / 1000000000);
        num %= 1000000000;
        const million = Math.floor(num / 1000000);
        num %= 1000000;
        const thousand = Math.floor(num / 1000);
        num %= 1000;
        const remaining = num;
        
        if (billion) {
            words += chunk(billion) + ' Billion ';
        }
        if (million) {
            words += chunk(million) + ' Million ';
        }
        if (thousand) {
            words += chunk(thousand) + ' Thousand ';
        }
        if (remaining) {
            words += chunk(remaining);
        }
        
        return words.trim() + ' Taka Only';
    }

    // Dynamic Date Formatter
    function formatCheckDate(dateStr) {
        if (!dateStr) return '';
        
        // Try parsing MM/DD/YYYY or YYYY-MM-DD
        let parts = dateStr.split(/[-/]/);
        if (parts.length === 3) {
            let month = parseInt(parts[0], 10);
            let day = parseInt(parts[1], 10);
            let year = parseInt(parts[2], 10);
            
            // Check if YYYY-MM-DD format
            if (parts[0].length === 4) {
                year = parseInt(parts[0], 10);
                month = parseInt(parts[1], 10);
                day = parseInt(parts[2], 10);
            }
            
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            if (month >= 1 && month <= 12 && day >= 1 && day <= 31) {
                return `${day} ${months[month-1]} ${year}`;
            }
        }
        
        // Native fallback
        const d = new Date(dateStr);
        if (!isNaN(d.getTime())) {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
        }
        
        return dateStr;
    }

    // Dynamic update check preview card
    function updateCheckPreview() {
        const name = document.getElementById('checkFormName').value || 'Nazmulone';
        const amountVal = document.getElementById('checkFormAmount').value;
        const account = document.getElementById('checkFormAccount').value || '104288 8557449 00020012';
        const dateStr = document.getElementById('checkFormDate').value;
        
        // Auto-generate words dynamically if triggered by active amount field
        const activeEl = document.activeElement;
        let words = document.getElementById('checkFormWords').value;
        
        if (activeEl && activeEl.id === 'checkFormAmount' && amountVal !== '') {
            const num = parseFloat(amountVal);
            if (!isNaN(num) && num >= 0) {
                words = numberToWords(Math.floor(num));
                document.getElementById('checkFormWords').value = words;
            }
        }
        
        // Format amount currency with comma formatting
        let formattedAmount = '৳ 0.00';
        if (amountVal !== '') {
            const parsedAmount = parseFloat(amountVal);
            if (!isNaN(parsedAmount)) {
                formattedAmount = '৳ ' + parsedAmount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        }
        
        // Formatted Date
        const formattedDate = formatCheckDate(dateStr);
        
        // Format MICR text
        let micrText = '';
        const parts = account.trim().split(/\s+/);
        if (parts.length >= 3) {
            micrText = `⑈ ${parts[0]} ⑈ ${parts[1]} ⑈ ${parts[2]}`;
        } else if (parts.length === 2) {
            micrText = `⑈ ${parts[0]} ⑈ ${parts[1]} ⑈ 00020012`;
        } else {
            micrText = `⑈ ${account} ⑈ 8557449 ⑈ 00020012`;
        }

        // Write values to preview card elements
        document.getElementById('prevCheckName').textContent = name;
        document.getElementById('prevCheckAmount').textContent = formattedAmount;
        document.getElementById('prevCheckWords').textContent = words || 'Zero Taka Only';
        document.getElementById('prevCheckDate').textContent = formattedDate;
        document.getElementById('prevCheckMICR').textContent = micrText;
    }

    // Print / Download Bank Check
    function printCheck() {
        const printContent = document.getElementById('checkPrintArea').innerHTML;
        const workerElement = document.createElement('div');
        workerElement.style.position = 'absolute';
        workerElement.style.left = '-9999px';
        workerElement.style.width = '1000px';
        workerElement.innerHTML = `
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Great+Vibes&family=Hind+Siliguri:wght@400;500;600;700&display=swap');
                .check-print-container { font-family: 'Hind Siliguri', 'Outfit', sans-serif; background: #ffffff; padding: 20px; color: #1e293b; }
                .premium-bank-check {
                    border: 1.5px solid #64748b;
                    border-radius: 16px;
                    padding: 28px 36px;
                    background: #ffffff;
                    position: relative;
                    text-align: left;
                    color: #1e293b;
                    background-image: 
                      radial-gradient(rgba(37, 99, 235, 0.02) 1.5px, transparent 1.5px),
                      linear-gradient(rgba(37, 99, 235, 0.01) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(37, 99, 235, 0.01) 1px, transparent 1px);
                    background-size: 16px 16px, 8px 8px, 8px 8px;
                    min-height: 330px;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    overflow: hidden;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                    border-left: 8px solid #2563eb;
                }
                .check-watermark {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 220px;
                    height: 220px;
                    pointer-events: none;
                    opacity: 0.9;
                    z-index: 1;
                }
                .check-logo-area {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    margin-bottom: 20px;
                    position: relative;
                    z-index: 2;
                }
                .check-stamp-container {
                    width: 76px;
                    height: 76px;
                    position: relative;
                    transform: rotate(-3deg);
                    filter: drop-shadow(1px 2px 4px rgba(37, 99, 235, 0.15));
                }
                .check-security-code {
                    font-size: 11px;
                    color: #64748b;
                    font-weight: 600;
                    font-family: 'Outfit', sans-serif;
                    letter-spacing: 0.5px;
                }
                .check-body-lines {
                    position: relative;
                    z-index: 2;
                    margin-bottom: 15px;
                }
                .check-line {
                    display: flex;
                    align-items: flex-end;
                    margin-bottom: 18px;
                    font-size: 14.5px;
                }
                .check-label {
                    font-weight: 700;
                    color: #475569;
                    min-width: 175px;
                    text-transform: uppercase;
                    font-size: 10.5px;
                    letter-spacing: 0.5px;
                    font-family: 'Outfit', sans-serif;
                }
                .check-value-dotted {
                    flex-grow: 1;
                    border-bottom: 1.5px dashed #64748b;
                    padding-bottom: 2px;
                    font-weight: 700;
                    color: #0f172a;
                    font-size: 17px;
                    font-family: 'Outfit', 'Hind Siliguri', sans-serif;
                }
                .check-bottom-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-end;
                    margin-top: 15px;
                    padding-top: 10px;
                    position: relative;
                    z-index: 2;
                }
                .check-digits-micr {
                    font-family: 'Courier New', Courier, monospace;
                    font-size: 20px;
                    font-weight: bold;
                    letter-spacing: 6px;
                    color: #0f172a;
                    word-spacing: 12px;
                }
                .check-signature-container {
                    text-align: center;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    margin-right: 10px;
                }
                .check-signature-img {
                    font-family: 'Great Vibes', cursive;
                    font-size: 30px;
                    color: #1e3a8a;
                    font-weight: normal;
                    margin-bottom: -5px;
                    transform: rotate(-2deg);
                }
                .check-signature-line {
                    border-top: 1.5px solid #64748b;
                    width: 160px;
                    margin-top: 2px;
                    margin-bottom: 3px;
                }
                .check-signature-label {
                    font-size: 10.5px;
                    color: #64748b;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
            </style>
            <div class="check-print-container">
                ${printContent}
            </div>
        `;
        document.body.appendChild(workerElement);
        
        const customerName = document.getElementById('checkFormName').value || 'Customer';
        const opt = {
            margin:       [10, 10, 10, 10],
            filename:     'Bank_Check_' + customerName.replace(/\s+/g, '_') + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2.5, useCORS: true, logging: false },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };
        
        html2pdf().set(opt).from(workerElement).save().then(() => {
            document.body.removeChild(workerElement);
        });
    }

    // ══════════════════════════════════════════════════════════════
    // Loan Stamp Deed Generator JS Handlers
    // ══════════════════════════════════════════════════════════════

    // Helper to convert English digits to Bangla numerals
    function toBanglaNumerals(num) {
        if (num === null || num === undefined) return '';
        const banglaDigits = {'0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'};
        return num.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
    }

    // Dropdown selection handler for Stamp Deed
    function onStampLoanSelected(selectEl) {
        if (!selectEl.value) return;

        try {
            const data = JSON.parse(selectEl.value);

            // Populate form inputs
            document.getElementById('stampFormName').value = data.name;
            document.getElementById('stampFormNid').value = data.nid;
            document.getElementById('stampFormAddress').value = data.address;
            document.getElementById('stampFormAmount').value = data.amount;
            document.getElementById('stampFormTenure').value = data.tenure;
            
            // Format monthly EMI
            const rawInstallment = parseFloat(data.installment) || 0;
            document.getElementById('stampFormEMI').value = rawInstallment.toFixed(2);
            
            // Father name is not standard in tables, clear for manual input
            document.getElementById('stampFormFather').value = "";

            // Update preview
            updateStampPreview();
        } catch (e) {
            console.error("Error parsing loan data for stamp:", e);
        }
    }

    // Local stamp image reader
    function onStampPhotoUploaded(inputEl) {
        if (inputEl.files && inputEl.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('prevStampPhoto');
                img.src = e.target.result;
                img.style.display = 'block';
                const placeholder = document.getElementById('prevStampPhotoPlaceholder');
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            };
            reader.readAsDataURL(inputEl.files[0]);
        }
    }

    // Local signature image reader
    function onStampSignatureUploaded(inputEl) {
        if (inputEl.files && inputEl.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('prevStampSignature');
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(inputEl.files[0]);
        }
    }

    // Update Stamp Preview text nodes and paragraph values
    function updateStampPreview() {
        const name = document.getElementById('stampFormName').value || '—';
        const nid = document.getElementById('stampFormNid').value || '—';
        const father = document.getElementById('stampFormFather').value || '—';
        const address = document.getElementById('stampFormAddress').value || '—';
        const amountVal = parseFloat(document.getElementById('stampFormAmount').value) || 0;
        const tenureVal = parseFloat(document.getElementById('stampFormTenure').value) || 0;
        
        let emiRaw = document.getElementById('stampFormEMI').value || '0';
        let formattedEMI;
        if (/^\d+(\.\d+)?$/.test(emiRaw.trim())) {
            let parsedEMI = parseFloat(emiRaw);
            formattedEMI = toBanglaNumerals(parsedEMI.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        } else {
            formattedEMI = toBanglaNumerals(emiRaw);
        }

        let formattedAmount = amountVal > 0 ? toBanglaNumerals(amountVal.toLocaleString('en-IN')) : '০';
        let formattedTenure = tenureVal > 0 ? toBanglaNumerals(tenureVal.toString()) : '০';
        let formattedNid = toBanglaNumerals(nid);

        // Update stamp preview card details
        document.getElementById('prevStampName').textContent = name;
        document.getElementById('prevStampNid').textContent = formattedNid;
        document.getElementById('prevStampFather').textContent = father;
        document.getElementById('prevStampAddress').textContent = address;
        document.getElementById('prevStampAmount').textContent = formattedAmount;
        document.getElementById('prevStampTenure').textContent = formattedTenure;
        document.getElementById('prevStampEMI').textContent = formattedEMI;

        // Update deed body paragraph placeholders
        document.getElementById('deedBodyName').textContent = name;
        document.getElementById('deedBodyFather').textContent = father;
        document.getElementById('deedBodyAddress').textContent = address;
        document.getElementById('deedBodyAmount').textContent = formattedAmount;
        document.getElementById('deedBodyTenure').textContent = formattedTenure;
        document.getElementById('deedBodyEMI').textContent = formattedEMI;
    }

    // Print/Download Stamp Deed
    function printStamp() {
        const printContent = document.getElementById('stampPrintArea').innerHTML;
        const workerElement = document.createElement('div');
        workerElement.style.position = 'absolute';
        workerElement.style.left = '-9999px';
        workerElement.style.width = '750px';
        workerElement.innerHTML = `
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap');
                .stamp-print-container { font-family: 'Noto Sans Bengali', 'Outfit', sans-serif; background: #ffffff; padding: 20px; color: #1e293b; }
                .premium-stamp-deed {
                    border: none;
                    padding: 10px;
                    background: #ffffff;
                    box-shadow: none;
                    position: relative;
                    text-align: left;
                    color: #1e293b;
                    min-height: auto;
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-start;
                }
                .stamp-deed-header {
                    width: 100%;
                    border-radius: 8px;
                    overflow: hidden;
                    margin-bottom: 25px;
                    border: 1px solid #e2e8f0;
                }
                .stamp-deed-title {
                    text-align: center;
                    font-size: 20px;
                    font-weight: 700;
                    text-decoration: underline;
                    color: #0f172a;
                    margin-bottom: 24px;
                    letter-spacing: 0.5px;
                }
                .stamp-deed-body {
                    font-size: 15px;
                    line-height: 2.0;
                    color: #334155;
                    text-align: justify;
                }
                .stamp-details-box {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    margin-bottom: 24px;
                    border-bottom: 1.5px dashed #e2e8f0;
                    padding-bottom: 20px;
                }
                .stamp-details-list {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                }
                .stamp-details-item {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }
                .stamp-details-label {
                    font-weight: 700;
                    color: #475569;
                    min-width: 130px;
                }
                .stamp-details-val {
                    font-weight: 700;
                    color: #0f172a;
                }
                .stamp-deed-text-para {
                    margin-top: 20px;
                    text-indent: 40px;
                    font-size: 15px;
                }
                .stamp-deed-signatures {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-end;
                    margin-top: 80px;
                    padding: 0 10px;
                }
                .stamp-sig-box {
                    text-align: center;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                .stamp-sig-line {
                    border-top: 1.5px solid #64748b;
                    width: 150px;
                    margin-top: 5px;
                    margin-bottom: 4px;
                }
                .stamp-sig-label {
                    font-size: 12px;
                    font-weight: 700;
                    color: #475569;
                }
                .stamp-photo-frame {
                    width: 110px;
                    height: 130px;
                    border: 1.5px dashed #cbd5e1;
                    border-radius: 8px;
                    overflow: hidden;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #fafafa;
                    position: relative;
                    flex-shrink: 0;
                    margin-left: 20px;
                }
                .stamp-photo-frame img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                .stamp-photo-placeholder {
                    font-size: 11px;
                    font-weight: 700;
                    color: #94a3b8;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
            </style>
            <div class="stamp-print-container">
                ${printContent}
            </div>
        `;
        document.body.appendChild(workerElement);
        
        const customerName = document.getElementById('stampFormName').value || 'Customer';
        const opt = {
            margin:       [10, 10, 10, 10],
            filename:     'Loan_Agreement_Stamp_' + customerName.replace(/\s+/g, '_') + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2.5, useCORS: true, logging: false },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        
        html2pdf().set(opt).from(workerElement).save().then(() => {
            document.body.removeChild(workerElement);
        });
    }
</script>
@endsection


