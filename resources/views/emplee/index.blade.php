@extends('emplee.master')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&display=swap');

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
                <div class="customer-profile-box">
                    <div class="customer-avatar">
                        {{ substr($searchResult->name, 0, 1) }}
                    </div>
                    <div class="customer-details">
                        <h5>{{ $searchResult->name }}</h5>
                        <p><i class="fa-solid fa-envelope me-1"></i> {{ $searchResult->email }}</p>
                        <p><i class="fa-solid fa-phone me-1"></i> {{ $searchResult->phone }}</p>
                        <p><i class="fa-solid fa-calendar-day me-1"></i> যোগদানের তারিখ: {{ $searchResult->created_at->format('d M, Y') }}</p>
                        @if($searchResult->information)
                            <span class="badge-kyc-verified">
                                <i class="fa-solid fa-circle-check"></i> KYC Verified (ডকুমেন্টেশন জমা দেয়া হয়েছে)
                            </span>
                        @else
                            <span class="badge-kyc-verified" style="background:#fef2f2; color:#ef4444;">
                                <i class="fa-solid fa-circle-xmark"></i> KYC Pending (ডকুমেন্টেশন জমা দেয়া হয়নি)
                            </span>
                        @endif
                    </div>
                </div>

                <div class="loan-table-wrapper">
                    <table class="loan-table">
                        <thead>
                            <tr>
                                <th>ঋণ আইডি</th>
                                <th>পেমেন্ট মেথড</th>
                                <th>অ্যাকাউন্ট নম্বর</th>
                                <th>ঋণের পরিমাণ</th>
                                <th>মেয়াদ</th>
                                <th>স্ট্যাটাস</th>
                                <th style="text-align: right;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($searchResult->loans as $loan)
                                <tr>
                                    <td class="fw-bold">#{{ $loan->id }}</td>
                                    <td>{{ ucfirst($loan->payment_method) }}</td>
                                    <td class="fw-semibold text-secondary">{{ $loan->account_number }}</td>
                                    <td class="fw-bold text-success">{{ number_format($loan->amount) }} BDT</td>
                                    <td>{{ $loan->tenure }} মাস</td>
                                    <td>
                                        @if($loan->status === 'pending')
                                            <span class="status-pill status-pill-pending">
                                                <i class="fa-solid fa-clock"></i> Pending
                                            </span>
                                        @elseif($loan->status === 'approved')
                                            <span class="status-pill status-pill-approved">
                                                <i class="fa-solid fa-circle-check"></i> Approved
                                            </span>
                                        @else
                                            <span class="status-pill status-pill-rejected">
                                                <i class="fa-solid fa-circle-xmark"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        @if($loan->status === 'pending')
                                            <div class="action-btn-group" style="justify-content: flex-end;">
                                                <form action="{{ route('emplee.loans.updateStatus', $loan->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn-loan-approve">Approve</button>
                                                </form>
                                                <form action="{{ route('emplee.loans.updateStatus', $loan->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn-loan-reject">Reject</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted small">কোনো একশন প্রযোজ্য নয়</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 30px; color: #64748b;">
                                        <i class="fa-solid fa-folder-open" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                                        এই ইউজারের কোনো ঋণের আবেদন পাওয়া যায়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
            <button class="tool-card tool-card-orange" data-bs-toggle="modal" data-bs-target="#stampModal">
                <i class="fa-solid fa-stamp"></i>
                <span>স্ট্যাম্প</span>
            </button>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODALS FOR INTERACTIVE PREMIUM TOOLS --}}
{{-- ========================================== --}}

{{-- 1. Loan Calculator Modal --}}
<div class="modal fade" id="loanCalcModal" tabindex="-1" aria-labelledby="loanCalcModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15); font-family: 'Hind Siliguri', sans-serif;">
            <div class="modal-header" style="background:#ffffff; color:#0f172a; border-bottom: 1px solid #e2e8f0; padding:20px 24px;">
                <div class="w-100 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(59,130,246,0.1); color: #2563eb; border-radius: 12px; font-size: 24px; margin-bottom: 8px;">
                        <i class="fa-solid fa-calculator"></i>
                    </div>
                    <h5 class="modal-title fw-bold" style="font-size: 24px; color: #0f172a; margin: 0;">ঋণ ক্যালকুলেটর</h5>
                    <p class="text-muted small" style="margin: 4px 0 0 0; font-size: 13px;">সহজে ঋণের হিসাব করুন</p>
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
                            <input type="number" id="deedAmount" class="form-control" placeholder="যেমন: 100000" style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" oninput="clearCalculationResult()">
                            
                            {{-- Quick buttons --}}
                            <div class="d-flex gap-2 mt-2 flex-wrap">
                                <button type="button" class="btn btn-sm btn-light" onclick="setDeedAmount(50000)" style="font-size: 12px; font-weight: 600; border-radius: 6px; padding: 4px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;">৫০,০০০</button>
                                <button type="button" class="btn btn-sm btn-light" onclick="setDeedAmount(100000)" style="font-size: 12px; font-weight: 600; border-radius: 6px; padding: 4px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;">১,০০,০০০</button>
                                <button type="button" class="btn btn-sm btn-light" onclick="setDeedAmount(200000)" style="font-size: 12px; font-weight: 600; border-radius: 6px; padding: 4px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;">২,০০,০০০</button>
                                <button type="button" class="btn btn-sm btn-light" onclick="setDeedAmount(500000)" style="font-size: 12px; font-weight: 600; border-radius: 6px; padding: 4px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;">৫,০০,০০০</button>
                            </div>
                        </div>

                        {{-- Tenure --}}
                        <div class="mb-4">
                            <label class="form-label" style="font-weight: 600; color: #334155; font-size: 14px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-calendar-days text-secondary"></i> মেয়াদ (মাস)
                            </label>
                            <input type="number" id="deedTenure" class="form-control" placeholder="যেমন: 12" style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" oninput="clearCalculationResult()">
                            
                            {{-- Quick buttons --}}
                            <div class="d-flex gap-2 mt-2 flex-wrap">
                                <button type="button" class="btn btn-sm btn-light" onclick="setDeedTenure(12)" style="font-size: 12px; font-weight: 600; border-radius: 6px; padding: 4px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;">১২ মাস</button>
                                <button type="button" class="btn btn-sm btn-light" onclick="setDeedTenure(24)" style="font-size: 12px; font-weight: 600; border-radius: 6px; padding: 4px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;">২৪ মাস</button>
                                <button type="button" class="btn btn-sm btn-light" onclick="setDeedTenure(36)" style="font-size: 12px; font-weight: 600; border-radius: 6px; padding: 4px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;">৩৬ মাস</button>
                                <button type="button" class="btn btn-sm btn-light" onclick="setDeedTenure(48)" style="font-size: 12px; font-weight: 600; border-radius: 6px; padding: 4px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;">৪৮ মাস</button>
                            </div>
                        </div>

                        {{-- Interest Rate --}}
                        <div class="mb-4">
                            <label class="form-label" style="font-weight: 600; color: #334155; font-size: 14px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-percent text-secondary"></i> সুদের হার (বার্ষিক %)
                            </label>
                            <input type="text" id="deedRate" class="form-control" value="2.4" style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 14px;" oninput="clearCalculationResult()">
                        </div>

                        {{-- Calculation Submit --}}
                        <button type="button" class="btn btn-primary w-100" onclick="performDeedCalculation()" style="background:#2563eb; border:none; padding:12px; border-radius:10px; font-weight:700; font-size:15px; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow: 0 4px 12px rgba(37,99,235,0.2);">
                            <i class="fa-solid fa-calculator"></i> হিসাব করুন
                        </button>
                    </div>

                    {{-- Right Side: Result Column --}}
                    <div class="col-md-6 d-flex flex-column justify-content-center" style="padding-left: 24px; min-height: 300px; background: #fafafa; border-radius: 16px; border: 1px solid #f1f5f9;">
                        <div id="calcDefaultState" class="text-center py-5">
                            <div style="font-size: 64px; color: #cbd5e1; margin-bottom: 16px;">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <h5 style="font-size: 18px; font-weight: 700; color: #475569; margin: 0 0 6px 0;">ফলাফল</h5>
                            <p class="text-muted small" style="margin: 0; font-size: 13px;">তথ্য দিয়ে হিসাব করুন</p>
                        </div>

                        <div id="calcResultState" style="display: none; padding: 16px;">
                            <h4 class="text-center mb-4" style="font-size: 18px; font-weight: 700; color: #0f172a; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 12px;">ফলাফল বিশ্লেষণ</h4>
                            <div class="calc-result-list" style="background:#ffffff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
                                <div class="calc-result-item" style="display:flex; justify-content:space-between; padding:12px 18px; border-bottom:1px solid #f1f5f9; font-size:14px;">
                                    <span style="font-weight:600; color:#475569;">ঋণের মূল পরিমাণ:</span>
                                    <span style="font-weight:700; color:#0f172a;"><span id="resPrincipalDeed">0</span> ৳</span>
                                </div>
                                <div class="calc-result-item" style="display:flex; justify-content:space-between; padding:12px 18px; border-bottom:1px solid #f1f5f9; font-size:14px;">
                                    <span style="font-weight:600; color:#475569;">সুদের হার (বার্ষিক %):</span>
                                    <span style="font-weight:700; color:#0f172a;"><span id="resRateDeed">0</span>%</span>
                                </div>
                                <div class="calc-result-item" style="display:flex; justify-content:space-between; padding:12px 18px; border-bottom:1px solid #f1f5f9; font-size:14px;">
                                    <span style="font-weight:600; color:#475569;">মোট সুদের পরিমাণ:</span>
                                    <span style="font-weight:700; color:#ef4444;"><span id="resInterestDeed">0</span> ৳</span>
                                </div>
                                <div class="calc-result-item" style="display:flex; justify-content:space-between; padding:12px 18px; border-bottom:1px solid #f1f5f9; font-size:14px; background:#eff6ff;">
                                    <span style="font-weight:600; color:#2563eb;">সর্বমোট পরিশোধযোগ্য পরিমাণ:</span>
                                    <span style="font-weight:700; color:#1e40af;"><span id="resTotalDeed">0</span> ৳</span>
                                </div>
                                <div class="calc-result-item" style="display:flex; justify-content:space-between; padding:12px 18px; border-bottom:none; font-size:14px; background:#ecfdf5;">
                                    <span style="font-weight:600; color:#059669;">মাসিক কিস্তির পরিমাণ:</span>
                                    <span style="font-weight:700; color:#065f46; font-size:16px;"><span id="resEMIDeed">0</span> ৳</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. Certificate Modal --}}
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background:#10b981; color:#ffffff; padding:20px;">
                <h5 class="modal-title fw-bold" id="certificateModalLabel">
                    <i class="fa-solid fa-award me-2"></i> লোন যোগ্যতার সার্টিফিকেট (Eligibility Certificate)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:30px; background:#f8fafc;">
                <div class="mock-cert-box">
                    <div class="mock-cert-logo">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div class="mock-cert-title">Loan Eligibility Certificate</div>
                    <div style="font-size:14px; margin-bottom:20px; opacity:0.8;">Certificate No: UBS-2026-{{ rand(1000, 9999) }}</div>
                    
                    <p style="font-size:16px; margin: 20px 0;">This is to certify that</p>
                    <h4 style="font-size:24px; font-weight:800; margin: 10px 0; color:#065f46;">
                        {{ $searchResult ? $searchResult->name : 'Elisa Maurer' }}
                    </h4>
                    <p style="font-size:15px; max-width:600px; margin: 20px auto; line-height:1.6;">
                        has been evaluated by our staff panel and found highly eligible for the requested loan options due to an excellent credit score, fully verified KYC documents, and strong financial standing.
                    </p>
                    
                    <div class="row mt-5" style="border-top:1px solid rgba(16, 185, 129, 0.2); padding-top:20px;">
                        <div class="col-6 text-start">
                            <span class="small d-block text-muted">Date of Verification:</span>
                            <span class="fw-bold">{{ date('d M, Y') }}</span>
                        </div>
                        <div class="col-6 text-end">
                            <span class="small d-block text-muted">Authorized Signature:</span>
                            <span class="fw-bold" style="font-family: 'Outfit'; font-style:italic;">UBS Manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. Bank Check Modal --}}
<div class="modal fade" id="bankCheckModal" tabindex="-1" aria-labelledby="bankCheckModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background:#8b5cf6; color:#ffffff; padding:20px;">
                <h5 class="modal-title fw-bold" id="bankCheckModalLabel">
                    <i class="fa-solid fa-money-check-dollar me-2"></i> ব্যাংক চেক ডিসবার্সমেন্ট (Bank Check Disbursement)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:30px; background:#f8fafc;">
                <div class="mock-check-box">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold" style="font-size: 18px; letter-spacing:1px; text-transform:uppercase;">UBS SWISS BANK LTD.</span>
                        <div class="text-end">
                            <span class="small d-block">DATE:</span>
                            <span class="fw-bold border-bottom border-dark px-2">{{ date('d-m-Y') }}</span>
                        </div>
                    </div>

                    <div class="mb-3 border-bottom border-dark pb-2">
                        <span>PAY TO:</span>
                        <span class="fw-bold ms-3" style="font-family:sans-serif; text-transform:uppercase;">
                            {{ $searchResult ? $searchResult->name : 'Elisa Maurer' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <div class="flex-grow-1 border-bottom border-dark pb-2">
                            <span>AMOUNT IN WORDS:</span>
                            <span class="fw-bold ms-2 small">Fifty Thousand BDT Only</span>
                        </div>
                        <div class="ms-3 border border-dark p-2 fw-bold bg-white" style="font-size:18px; min-width:160px; text-align:right;">
                            ৳ 50,000/-
                        </div>
                    </div>

                    <div class="row pt-4" style="border-top:1px dashed #86efac;">
                        <div class="col-8">
                            <span class="small d-block" style="font-family:sans-serif;">A/C NO: 10294857362</span>
                            <span class="small d-block text-muted mt-2">⑈ 1234567 ⑈ 0123456789 ⑈ 12</span>
                        </div>
                        <div class="col-4 text-end">
                            <div class="border-bottom border-dark mb-1" style="height:30px; font-family: 'Outfit'; font-style:italic;">Manager UBS</div>
                            <span class="small text-uppercase">AUTHORIZED SIGNATURE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 4. Stamp Modal --}}
<div class="modal fade" id="stampModal" tabindex="-1" aria-labelledby="stampModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background:#f97316; color:#ffffff; padding:20px;">
                <h5 class="modal-title fw-bold" id="stampModalLabel">
                    <i class="fa-solid fa-stamp me-2"></i> ঋণ চুক্তিপত্র স্ট্যাম্প (Loan Agreement Stamp)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:30px; background:#f8fafc; max-height: 500px; overflow-y: auto;">
                <div class="mock-stamp-box">
                    <div class="stamp-header">
                        গণপ্রজাতন্ত্রী বাংলাদেশ সরকার<br>
                        <span style="font-size: 14px; font-weight: normal;">Non-Judicial Stamp - 150 BDT</span>
                    </div>

                    <div class="text-center fw-bold mb-4" style="font-size: 18px; text-decoration: underline;">ঋণ চুক্তিপত্র (Loan Agreement Deed)</div>

                    <p style="line-height:1.8; text-align:justify; font-size:14px;">
                        ১ম পক্ষ (ঋণদাতা): <strong>ইউবিএস সুইস লোন ফাইন্যান্স লিঃ</strong>, প্রধান শাখা, ঢাকা।<br>
                        ২য় পক্ষ (ঋণগ্রহীতা): <strong>{{ $searchResult ? $searchResult->name : 'Elisa Maurer' }}</strong>, ফোন নম্বর: {{ $searchResult ? $searchResult->phone : '017XXXXXXXX' }}।
                    </p>

                    <p style="line-height:1.8; text-align:justify; font-size:14px; margin-top:20px;">
                        উভয় পক্ষ স্বেচ্ছায়, সজ্ঞানে এবং অন্যের প্ররোচনা ছাড়া এই চুক্তিনামায় স্বাক্ষর করছেন। ২য় পক্ষ ১ম পক্ষের কাছ থেকে <strong>৫০,০০০ (পঞ্চাশ হাজার) টাকা</strong> ঋণ হিসেবে গ্রহণ করছেন যা বার্ষিক ২.৪% হারে আগামী ১২ মাসের মধ্যে মাসিক কিস্তিতে পরিশোধ করতে বাধ্য থাকবেন।
                    </p>

                    <div class="row mt-5 pt-5">
                        <div class="col-6">
                            <div class="border-top border-dark text-center pt-2">১ম পক্ষের স্বাক্ষর</div>
                        </div>
                        <div class="col-6">
                            <div class="border-top border-dark text-center pt-2">২য় পক্ষের স্বাক্ষর</div>
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

    function clearCalculationResult() {
        document.getElementById('calcDefaultState').style.display = 'block';
        document.getElementById('calcResultState').style.display = 'none';
    }

    // Perform Deed calculation logic matching exact screenshot formula
    function performDeedCalculation() {
        const amountEl = document.getElementById('deedAmount');
        const tenureEl = document.getElementById('deedTenure');
        const rateEl   = document.getElementById('deedRate');

        const amount = parseFloat(amountEl.value);
        const tenure = parseFloat(tenureEl.value);
        const rate   = parseFloat(rateEl.value);

        if (isNaN(amount) || isNaN(tenure) || isNaN(rate) || amount <= 0 || tenure <= 0) {
            clearCalculationResult();
            return;
        }

        // Calculation: barshik flat rate
        const interestAmount = Math.round(amount * (rate / 100) * (tenure / 12));
        const totalPayable    = amount + interestAmount;
        const monthlyEMI      = Math.round(totalPayable / tenure);

        // Update output text
        document.getElementById('resPrincipalDeed').textContent = amount.toLocaleString('bn-BD');
        document.getElementById('resRateDeed').textContent = rate;
        document.getElementById('resInterestDeed').textContent = interestAmount.toLocaleString('bn-BD');
        document.getElementById('resTotalDeed').textContent = totalPayable.toLocaleString('bn-BD');
        document.getElementById('resEMIDeed').textContent = monthlyEMI.toLocaleString('bn-BD');

        // Toggle state view
        document.getElementById('calcDefaultState').style.display = 'none';
        document.getElementById('calcResultState').style.display = 'block';
    }
</script>
@endsection
