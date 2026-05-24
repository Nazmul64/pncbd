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
        
        <form action="{{ route('emplee.dashboard') }}" method="GET" class="mb-4">
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background:#3b82f6; color:#ffffff; padding:20px;">
                <h5 class="modal-title fw-bold" id="loanCalcModalLabel">
                    <i class="fa-solid fa-calculator me-2"></i> ঋণ ক্যালকুলেটর (Loan Calculator)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div class="calc-box mb-4">
                    {{-- Amount --}}
                    <div class="mb-4">
                        <div class="calc-slider-label">
                            <span>ঋণের পরিমাণ (Amount)</span>
                            <span class="text-primary"><span id="calcAmountLabel">50,000</span> BDT</span>
                        </div>
                        <input type="range" class="form-range" id="calcAmountRange" min="5000" max="1000000" step="5000" value="50000" oninput="calculateInstallments()">
                    </div>

                    {{-- Tenure --}}
                    <div class="mb-4">
                        <div class="calc-slider-label">
                            <span>ঋণের মেয়াদ (Tenure)</span>
                            <span class="text-primary"><span id="calcTenureLabel">12</span> মাস</span>
                        </div>
                        <input type="range" class="form-range" id="calcTenureRange" min="3" max="36" step="3" value="12" oninput="calculateInstallments()">
                    </div>

                    {{-- Rate --}}
                    <div>
                        <div class="calc-slider-label">
                            <span>বার্ষিক ইন্টারেস্ট রেট (Interest Rate)</span>
                            <span class="text-primary">2.4% (Flat)</span>
                        </div>
                    </div>
                </div>

                {{-- Outputs --}}
                <div class="calc-result-list">
                    <div class="calc-result-item">
                        <span class="calc-result-label">ঋণের মোট মূল পরিমাণ:</span>
                        <span class="calc-result-value"><span id="resPrincipal">50,000</span> BDT</span>
                    </div>
                    <div class="calc-result-item">
                        <span class="calc-result-label">মোট সুদের পরিমাণ:</span>
                        <span class="calc-result-value text-danger"><span id="resInterest">1,200</span> BDT</span>
                    </div>
                    <div class="calc-result-item" style="background:#eff6ff;">
                        <span class="calc-result-label" style="color:#2563eb;">সর্বমোট প্রদেয় পরিমাণ:</span>
                        <span class="calc-result-value text-primary"><span id="resTotalPayable">51,200</span> BDT</span>
                    </div>
                    <div class="calc-result-item" style="background:#ecfdf5;">
                        <span class="calc-result-label" style="color:#059669;">মাসিক কিস্তির পরিমাণ (EMI):</span>
                        <span class="calc-result-value text-success" style="font-size:16px;"><span id="resEMI">4,267</span> BDT</span>
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
    // EMI & Loan Calculator interactive logic
    function calculateInstallments() {
        const amountRange = document.getElementById('calcAmountRange');
        const tenureRange = document.getElementById('calcTenureRange');
        
        const amount = parseInt(amountRange.value);
        const tenure = parseInt(tenureRange.value);
        const interestRate = 0.024; // 2.4% flat barshik rate
        
        // Show labels
        document.getElementById('calcAmountLabel').textContent = amount.toLocaleString('bn-BD');
        document.getElementById('calcTenureLabel').textContent = tenure;
        
        // Compute math
        const interestAmount = Math.round(amount * interestRate * (tenure / 12));
        const totalPayable = amount + interestAmount;
        const monthlyEMI = Math.round(totalPayable / tenure);
        
        // Output inside visual results list
        document.getElementById('resPrincipal').textContent = amount.toLocaleString('bn-BD');
        document.getElementById('resInterest').textContent = interestAmount.toLocaleString('bn-BD');
        document.getElementById('resTotalPayable').textContent = totalPayable.toLocaleString('bn-BD');
        document.getElementById('resEMI').textContent = monthlyEMI.toLocaleString('bn-BD');
    }

    // Trigger calculation once on load
    document.addEventListener('DOMContentLoaded', function() {
        calculateInstallments();
    });
</script>
@endsection
