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
                <span>ঋণ চুক্তিপত্র</span>
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
                                    border: 3px solid #10b981;
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
                                    border: 2px solid #10b981;
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
                                    border: 1px solid #10b981;
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
                                <div class="cert-title-main">UBS Loan Management System</div>
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

                                <div class="cert-status-banner">
                                    ✓ উপরোক্ত ব্যক্তির ঋণ আবেদন অনুমোদিত হয়েছে
                                </div>
                                <div class="text-center text-muted small" style="font-size:11px;">
                                    অনুমোদনের তারিখ: <span id="prevApprovalDateBottom">24/05/2026</span>
                                </div>

                                <div class="cert-footer-stamps">
                                    <div class="cert-stamps-group">
                                        {{-- Stamp 1: UBS Swiss Bank --}}
                                        <div class="cert-stamp-circle cert-stamp-ubs">
                                            <i class="fa-solid fa-building-columns"></i>
                                            <span>UBS</span>
                                        </div>
                                        {{-- Stamp 2: Govt --}}
                                        <div class="cert-stamp-circle cert-stamp-gov">
                                            <i class="fa-solid fa-star"></i>
                                            <span>GOVT</span>
                                        </div>
                                        {{-- Stamp 3: Leaf Stamp --}}
                                        <div class="cert-stamp-circle cert-stamp-leaf">
                                            <i class="fa-solid fa-leaf"></i>
                                            <span>LEGAL</span>
                                        </div>
                                    </div>
                                    <div class="cert-signature-box">
                                        <div class="cert-signature-hand">UBS Manager</div>
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
        const printWindow = window.open('', '_blank', 'height=850,width=800');
        printWindow.document.write('<html><head><title>Loan Approval Certificate</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
        printWindow.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">');
        printWindow.document.write('<style>');
        printWindow.document.write(`
            @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&display=swap');
            body { font-family: 'Hind Siliguri', 'Outfit', sans-serif; background: #ffffff; padding: 20px; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
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
        `);
        printWindow.document.write('</style></head><body>');
        printWindow.document.write(printContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    }
</script>
@endsection


