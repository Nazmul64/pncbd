@extends('admin.master')

@section('main-content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.db-page {
    padding: 30px 24px;
    background: #f4f7fb;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.db-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 16px;
}

.db-header h1 {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
}

.db-header p {
    margin: 4px 0 0;
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

/* ── STAT CARDS ── */
.db-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
}

.db-stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.02);
    position: relative;
    overflow: hidden;
}

.db-stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 4px;
    background: var(--card-color);
    opacity: 0.8;
}

.db-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
}

.db-stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    flex-shrink: 0;
    background: var(--icon-bg);
    color: var(--card-color);
}

.db-stat-info { display: flex; flex-direction: column; }
.db-stat-val { font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1.1; }
.db-stat-label { font-size: 12px; font-weight: 600; color: #64748b; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px; }

/* ── SECTION TITLE ── */
.db-section-title {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: -0.3px;
}
.db-section-title i { color: #3b82f6; font-size: 20px; }

/* ── TIME PERIOD CARDS ── */
.db-time-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
}

.db-time-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(0,0,0,0.02);
    position: relative;
    overflow: hidden;
}

.db-time-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 3px;
    background: var(--time-gradient);
}

.db-time-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
}

.db-time-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    background: var(--time-bg);
    color: var(--time-color);
}

.db-time-label {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}

.db-time-stats {
    display: flex;
    gap: 24px;
}

.db-time-stat {
    flex: 1;
}

.db-time-stat-val {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
}

.db-time-stat-lbl {
    font-size: 11px;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 2px;
}

/* ── CHART & TABLE LAYOUT ── */
.db-layout {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
}
@media(max-width: 1200px) { .db-layout { grid-template-columns: 1fr; } }

.db-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(0,0,0,0.02);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.db-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.db-card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 10px;
}
.db-card-title i { color: #3b82f6; font-size: 18px; }

.db-card-link {
    font-size: 13px;
    font-weight: 600;
    color: #3b82f6;
    text-decoration: none;
    transition: color 0.2s;
}
.db-card-link:hover { color: #1d4ed8; text-decoration: underline; }

.db-card-body { padding: 24px; flex: 1; }
.db-card-body.no-pad { padding: 0; }

/* ── TABLE ── */
.db-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.db-table th {
    background: #f8fafc;
    padding: 14px 20px;
    font-size: 11px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.db-table td {
    padding: 14px 20px;
    font-size: 13.5px;
    color: #1e293b;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.db-table tr:last-child td { border-bottom: none; }
.db-table tr:hover td { background: #f8fafc; }

/* ── STATUS BADGES ── */
.db-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.3px;
    gap: 5px;
}
.badge-pending { background: #fef3c7; color: #d97706; }
.badge-approved { background: #dcfce7; color: #16a34a; }
.badge-rejected { background: #fee2e2; color: #dc2626; }

.db-user-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.db-user-avatar {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    color: #fff;
    flex-shrink: 0;
}

.db-user-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 13.5px;
}

.db-user-phone {
    font-size: 11.5px;
    color: #94a3b8;
    margin-top: 1px;
}

/* ── METHOD CARDS ── */
.db-method-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 14px;
}

.db-method-card {
    background: linear-gradient(135deg, var(--m-bg-1), var(--m-bg-2));
    border-radius: 14px;
    padding: 20px;
    text-align: center;
    transition: transform 0.2s;
    border: 1px solid rgba(0,0,0,0.04);
}
.db-method-card:hover { transform: translateY(-3px); }

.db-method-icon {
    font-size: 28px;
    margin-bottom: 10px;
    color: var(--m-color);
}

.db-method-name {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    text-transform: capitalize;
    margin-bottom: 8px;
}

.db-method-stat {
    display: flex;
    justify-content: center;
    gap: 20px;
}

.db-method-val {
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
}

.db-method-lbl {
    font-size: 10px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-top: 2px;
}

/* ── QUICK STATS ROW ── */
.db-quick-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
}

.db-quick-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    border: 1.5px solid var(--q-border);
    transition: all 0.2s;
}
.db-quick-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.04); }

.db-quick-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    background: var(--q-bg);
    color: var(--q-color);
    flex-shrink: 0;
}

.db-quick-val {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
}

.db-quick-lbl {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    margin-top: 2px;
}

/* ── CHART TAB BUTTONS ── */
.db-chart-tabs {
    display: flex;
    gap: 6px;
}

.db-chart-tab {
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s;
}
.db-chart-tab:hover { border-color: #3b82f6; color: #3b82f6; }
.db-chart-tab.active { background: #3b82f6; color: #fff; border-color: #3b82f6; }

/* ── RESPONSIVE ── */
@media(max-width: 768px) {
    .db-page { padding: 20px 16px; }
    .db-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .db-stat-card { padding: 16px; gap: 12px; }
    .db-stat-icon { width: 44px; height: 44px; font-size: 20px; }
    .db-stat-val { font-size: 20px; }
    .db-time-grid { grid-template-columns: 1fr; }
}
</style>

<div class="db-page">
    {{-- HEADER --}}
    <div class="db-header">
        <div>
            <h1>📊 লোন ড্যাশবোর্ড</h1>
            <p>স্বাগতম, {{ auth()->user()->name }}! আজকের লোন আপডেট দেখুন।</p>
        </div>
        <div style="font-size: 14px; font-weight: 600; color: #64748b; background: #fff; padding: 10px 16px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <i class="bi bi-calendar3 me-2"></i> {{ date('d M Y, l') }}
        </div>
    </div>

    {{-- ══════════ LOAN STATS GRID ══════════ --}}
    <div class="db-stats-grid">
        {{-- Total Loans --}}
        <div class="db-stat-card" style="--card-color: #6366f1; --icon-bg: #eef2ff;">
            <div class="db-stat-icon"><i class="bi bi-stack"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($totalLoans) }}</div>
                <div class="db-stat-label">মোট আবেদন</div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="db-stat-card" style="--card-color: #f59e0b; --icon-bg: #fef3c7;">
            <div class="db-stat-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($pendingLoans) }}</div>
                <div class="db-stat-label">পেন্ডিং আবেদন</div>
            </div>
        </div>

        {{-- Approved --}}
        <div class="db-stat-card" style="--card-color: #10b981; --icon-bg: #d1fae5;">
            <div class="db-stat-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($approvedLoans) }}</div>
                <div class="db-stat-label">অনুমোদিত</div>
            </div>
        </div>

        {{-- Rejected --}}
        <div class="db-stat-card" style="--card-color: #ef4444; --icon-bg: #fee2e2;">
            <div class="db-stat-icon"><i class="bi bi-x-circle-fill"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($rejectedLoans) }}</div>
                <div class="db-stat-label">প্রত্যাখ্যাত</div>
            </div>
        </div>
    </div>

    {{-- ══════════ AMOUNT STATS ══════════ --}}
    <div class="db-stats-grid">
        {{-- Total Amount Applied --}}
        <div class="db-stat-card" style="--card-color: #3b82f6; --icon-bg: #dbeafe;">
            <div class="db-stat-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">৳{{ number_format($totalAmountApplied) }}</div>
                <div class="db-stat-label">মোট আবেদিত পরিমাণ</div>
            </div>
        </div>

        {{-- Total Amount Approved --}}
        <div class="db-stat-card" style="--card-color: #10b981; --icon-bg: #d1fae5;">
            <div class="db-stat-icon"><i class="bi bi-wallet-fill"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">৳{{ number_format($totalAmountApproved) }}</div>
                <div class="db-stat-label">অনুমোদিত পরিমাণ</div>
            </div>
        </div>

        {{-- Total Payable --}}
        <div class="db-stat-card" style="--card-color: #8b5cf6; --icon-bg: #ede9fe;">
            <div class="db-stat-icon"><i class="bi bi-receipt-cutoff"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">৳{{ number_format($totalPayableAmount) }}</div>
                <div class="db-stat-label">মোট পরিশোধযোগ্য</div>
            </div>
        </div>

        {{-- Total Interest --}}
        <div class="db-stat-card" style="--card-color: #ec4899; --icon-bg: #fce7f3;">
            <div class="db-stat-icon"><i class="bi bi-percent"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">৳{{ number_format($totalInterestAmount) }}</div>
                <div class="db-stat-label">মোট সুদ</div>
            </div>
        </div>
    </div>

    {{-- ══════════ TODAY / 7 DAYS / 30 DAYS ══════════ --}}
    <h4 class="db-section-title"><i class="bi bi-clock-history"></i> সময়ভিত্তিক পরিসংখ্যান</h4>
    <div class="db-time-grid">
        {{-- Today --}}
        <div class="db-time-card" style="--time-gradient: linear-gradient(90deg, #f59e0b, #f97316); --time-bg: #fef3c7; --time-color: #d97706;">
            <div class="db-time-header">
                <div class="db-time-icon"><i class="bi bi-sun-fill"></i></div>
                <div class="db-time-label">আজকের আবেদন</div>
            </div>
            <div class="db-time-stats">
                <div class="db-time-stat">
                    <div class="db-time-stat-val">{{ number_format($loansToday) }}</div>
                    <div class="db-time-stat-lbl">আবেদন সংখ্যা</div>
                </div>
                <div class="db-time-stat">
                    <div class="db-time-stat-val">৳{{ number_format($amountToday) }}</div>
                    <div class="db-time-stat-lbl">আবেদিত পরিমাণ</div>
                </div>
            </div>
        </div>

        {{-- 7 Days --}}
        <div class="db-time-card" style="--time-gradient: linear-gradient(90deg, #3b82f6, #6366f1); --time-bg: #dbeafe; --time-color: #3b82f6;">
            <div class="db-time-header">
                <div class="db-time-icon"><i class="bi bi-calendar-week"></i></div>
                <div class="db-time-label">শেষ ৭ দিন</div>
            </div>
            <div class="db-time-stats">
                <div class="db-time-stat">
                    <div class="db-time-stat-val">{{ number_format($loans7Days) }}</div>
                    <div class="db-time-stat-lbl">আবেদন সংখ্যা</div>
                </div>
                <div class="db-time-stat">
                    <div class="db-time-stat-val">৳{{ number_format($amount7Days) }}</div>
                    <div class="db-time-stat-lbl">আবেদিত পরিমাণ</div>
                </div>
            </div>
        </div>

        {{-- 30 Days --}}
        <div class="db-time-card" style="--time-gradient: linear-gradient(90deg, #10b981, #14b8a6); --time-bg: #d1fae5; --time-color: #10b981;">
            <div class="db-time-header">
                <div class="db-time-icon"><i class="bi bi-calendar-month"></i></div>
                <div class="db-time-label">শেষ ৩০ দিন</div>
            </div>
            <div class="db-time-stats">
                <div class="db-time-stat">
                    <div class="db-time-stat-val">{{ number_format($loans30Days) }}</div>
                    <div class="db-time-stat-lbl">আবেদন সংখ্যা</div>
                </div>
                <div class="db-time-stat">
                    <div class="db-time-stat-val">৳{{ number_format($amount30Days) }}</div>
                    <div class="db-time-stat-lbl">আবেদিত পরিমাণ</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════ USERS & KYC QUICK ROW ══════════ --}}
    <div class="db-quick-row">
        <div class="db-quick-card" style="--q-border: #c7d2fe; --q-bg: #eef2ff; --q-color: #6366f1;">
            <div class="db-quick-icon"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="db-quick-val">{{ number_format($totalRegisteredUsers) }}</div>
                <div class="db-quick-lbl">রেজিস্টার্ড ইউজার</div>
            </div>
        </div>
        <div class="db-quick-card" style="--q-border: #bbf7d0; --q-bg: #f0fdf4; --q-color: #16a34a;">
            <div class="db-quick-icon"><i class="bi bi-file-earmark-person-fill"></i></div>
            <div>
                <div class="db-quick-val">{{ number_format($totalKycSubmitted) }}</div>
                <div class="db-quick-lbl">KYC জমা দিয়েছে</div>
            </div>
        </div>
        @if($hasHRM)
        <div class="db-quick-card" style="--q-border: #bae6fd; --q-bg: #f0f9ff; --q-color: #0284c7;">
            <div class="db-quick-icon"><i class="bi bi-person-badge-fill"></i></div>
            <div>
                <div class="db-quick-val">{{ number_format($totalEmployees) }}</div>
                <div class="db-quick-lbl">সক্রিয় কর্মচারী</div>
            </div>
        </div>
        <div class="db-quick-card" style="--q-border: #fde68a; --q-bg: #fffbeb; --q-color: #d97706;">
            <div class="db-quick-icon"><i class="bi bi-calendar-check-fill"></i></div>
            <div>
                <div class="db-quick-val">{{ number_format($attendanceToday) }}</div>
                <div class="db-quick-lbl">আজকের উপস্থিতি</div>
            </div>
        </div>
        @endif
    </div>

    {{-- ══════════ CHART + PAYMENT METHOD ══════════ --}}
    <div class="db-layout">
        {{-- 30-Day Loan Trend Chart --}}
        <div class="db-card">
            <div class="db-card-header">
                <h5 class="db-card-title"><i class="bi bi-graph-up-arrow"></i> শেষ ৩০ দিনের লোন আবেদন ট্রেন্ড</h5>
                <div class="db-chart-tabs">
                    <button class="db-chart-tab active" onclick="switchChart('count', this)">আবেদন সংখ্যা</button>
                    <button class="db-chart-tab" onclick="switchChart('amount', this)">পরিমাণ (৳)</button>
                </div>
            </div>
            <div class="db-card-body">
                <canvas id="loanChart" style="width: 100%; max-height: 320px;"></canvas>
            </div>
        </div>

        {{-- Payment Method Breakdown --}}
        <div class="db-card">
            <div class="db-card-header">
                <h5 class="db-card-title"><i class="bi bi-credit-card-2-front-fill"></i> পেমেন্ট পদ্ধতি</h5>
            </div>
            <div class="db-card-body">
                <div class="db-method-grid">
                    @forelse($methodStats as $method)
                    @php
                        $colors = [
                            'bkash'  => ['--m-bg-1: #fce7f3', '--m-bg-2: #fdf2f8', '--m-color: #db2777', 'bi-phone-fill'],
                            'nagad'  => ['--m-bg-1: #ffedd5', '--m-bg-2: #fff7ed', '--m-color: #ea580c', 'bi-phone-fill'],
                            'bank'   => ['--m-bg-1: #dbeafe', '--m-bg-2: #eff6ff', '--m-color: #2563eb', 'bi-bank2'],
                            'rocket' => ['--m-bg-1: #e0e7ff', '--m-bg-2: #eef2ff', '--m-color: #7c3aed', 'bi-phone-fill'],
                        ];
                        $key = strtolower($method->payment_method);
                        $c = $colors[$key] ?? ['--m-bg-1: #f1f5f9', '--m-bg-2: #f8fafc', '--m-color: #64748b', 'bi-credit-card'];
                    @endphp
                    <div class="db-method-card" style="{{ $c[0] }}; {{ $c[1] }}; {{ $c[2] }};">
                        <div class="db-method-icon"><i class="bi {{ $c[3] }}"></i></div>
                        <div class="db-method-name">{{ $method->payment_method }}</div>
                        <div class="db-method-stat">
                            <div>
                                <div class="db-method-val">{{ $method->total }}</div>
                                <div class="db-method-lbl">আবেদন</div>
                            </div>
                            <div>
                                <div class="db-method-val">৳{{ number_format($method->amount) }}</div>
                                <div class="db-method-lbl">পরিমাণ</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; color: #94a3b8; padding: 30px; grid-column: 1 / -1;">
                        <i class="bi bi-inbox" style="font-size: 36px; display: block; margin-bottom: 8px;"></i>
                        কোনো লোন আবেদন নেই
                    </div>
                    @endforelse
                </div>

                {{-- Doughnut Chart --}}
                @if($methodStats->count() > 0)
                <div style="margin-top: 24px;">
                    <canvas id="methodChart" style="max-height: 220px;"></canvas>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════ RECENT LOAN APPLICATIONS TABLE ══════════ --}}
    <div class="db-card" style="margin-bottom: 24px;">
        <div class="db-card-header">
            <h5 class="db-card-title"><i class="bi bi-file-earmark-text-fill"></i> সাম্প্রতিক লোন আবেদনসমূহ</h5>
            <a href="{{ route('admin.loans.index') }}" class="db-card-link">সব দেখুন <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="db-card-body no-pad" style="overflow-x: auto;">
            <table class="db-table">
                <thead>
                    <tr>
                        <th>আবেদনকারী</th>
                        <th>পেমেন্ট পদ্ধতি</th>
                        <th>পরিমাণ</th>
                        <th>মেয়াদ</th>
                        <th>মাসিক কিস্তি</th>
                        <th>মোট পরিশোধ</th>
                        <th>স্ট্যাটাস</th>
                        <th>তারিখ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLoans as $loan)
                    <tr>
                        <td>
                            <div class="db-user-cell">
                                <div class="db-user-avatar" style="background: {{ ['#6366f1','#3b82f6','#10b981','#f59e0b','#ef4444','#ec4899','#8b5cf6'][($loan->id ?? 0) % 7] }};">
                                    {{ substr($loan->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="db-user-name">{{ $loan->user->name ?? 'N/A' }}</div>
                                    <div class="db-user-phone">{{ $loan->user->phone ?? $loan->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight: 600; text-transform: capitalize;">
                                @if(strtolower($loan->payment_method) === 'bkash')
                                    <span style="color: #db2777;">বিকাশ</span>
                                @elseif(strtolower($loan->payment_method) === 'nagad')
                                    <span style="color: #ea580c;">নগদ</span>
                                @elseif(strtolower($loan->payment_method) === 'bank')
                                    <span style="color: #2563eb;">{{ $loan->bank->name ?? 'ব্যাংক' }}</span>
                                @else
                                    {{ $loan->payment_method }}
                                @endif
                            </span>
                        </td>
                        <td style="font-weight: 700;">৳{{ number_format($loan->amount) }}</td>
                        <td>{{ $loan->tenure }} মাস</td>
                        <td style="font-weight: 600;">৳{{ number_format($loan->monthly_installment) }}</td>
                        <td style="font-weight: 600;">৳{{ number_format($loan->total_payable) }}</td>
                        <td>
                            @if($loan->status === 'pending')
                                <span class="db-badge badge-pending"><i class="bi bi-clock"></i> পেন্ডিং</span>
                            @elseif($loan->status === 'approved')
                                <span class="db-badge badge-approved"><i class="bi bi-check-lg"></i> অনুমোদিত</span>
                            @elseif($loan->status === 'rejected')
                                <span class="db-badge badge-rejected"><i class="bi bi-x-lg"></i> প্রত্যাখ্যাত</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap; font-size: 12px; color: #64748b;">
                            {{ $loan->created_at->format('d M Y') }}<br>
                            <span style="font-size: 11px;">{{ $loan->created_at->format('h:i A') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #94a3b8;">
                            <i class="bi bi-inbox" style="font-size: 36px; display: block; margin-bottom: 8px;"></i>
                            কোনো লোন আবেদন পাওয়া যায়নি
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ══════════ HRM SECTION (if available) ══════════ --}}
    @if($hasHRM)
    <h4 class="db-section-title" style="margin-top: 10px;"><i class="bi bi-people-fill"></i> HRM সারসংক্ষেপ</h4>
    <div class="db-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        <div class="db-stat-card" style="--card-color: #10b981; --icon-bg: #d1fae5;">
            <div class="db-stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($totalEmployees) }}</div>
                <div class="db-stat-label">সক্রিয় কর্মচারী</div>
            </div>
        </div>
        <div class="db-stat-card" style="--card-color: #3b82f6; --icon-bg: #dbeafe;">
            <div class="db-stat-icon"><i class="bi bi-calendar-check"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($attendanceToday) }}</div>
                <div class="db-stat-label">আজকের উপস্থিতি</div>
            </div>
        </div>
        <div class="db-stat-card" style="--card-color: #f59e0b; --icon-bg: #fef3c7;">
            <div class="db-stat-icon"><i class="bi bi-calendar-minus"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($activeLeaves) }}</div>
                <div class="db-stat-label">আজকে ছুটিতে</div>
            </div>
        </div>
        <div class="db-stat-card" style="--card-color: #ef4444; --icon-bg: #fee2e2;">
            <div class="db-stat-icon"><i class="bi bi-cash-coin"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">৳{{ number_format($expensesThisMonth) }}</div>
                <div class="db-stat-label">মাসিক ব্যয়</div>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ══════════ CHARTS JS ══════════ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── 30-Day Loan Trend Chart ──
    const ctx = document.getElementById('loanChart');
    if (!ctx) return;

    const chartLabels = @json($chartLabels);
    const chartCountData = @json($chartCountData);
    const chartAmountData = @json($chartAmountData);

    window.loanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'আবেদন সংখ্যা',
                data: chartCountData,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.08)',
                borderWidth: 2.5,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 13, weight: '700', family: 'Plus Jakarta Sans' },
                    bodyFont: { size: 12, family: 'Plus Jakarta Sans' },
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 11, weight: '500', family: 'Plus Jakarta Sans' },
                        color: '#94a3b8',
                        maxTicksLimit: 10,
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font: { size: 11, weight: '500', family: 'Plus Jakarta Sans' },
                        color: '#94a3b8',
                        precision: 0,
                    }
                }
            }
        }
    });

    // ── Switch Chart Data ──
    window.switchChart = function(type, btn) {
        document.querySelectorAll('.db-chart-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        const chart = window.loanChart;
        if (type === 'count') {
            chart.data.datasets[0].data = chartCountData;
            chart.data.datasets[0].label = 'আবেদন সংখ্যা';
            chart.data.datasets[0].borderColor = '#6366f1';
            chart.data.datasets[0].backgroundColor = 'rgba(99, 102, 241, 0.08)';
            chart.data.datasets[0].pointBackgroundColor = '#6366f1';
            chart.options.scales.y.ticks.callback = null;
        } else {
            chart.data.datasets[0].data = chartAmountData;
            chart.data.datasets[0].label = 'আবেদিত পরিমাণ (৳)';
            chart.data.datasets[0].borderColor = '#10b981';
            chart.data.datasets[0].backgroundColor = 'rgba(16, 185, 129, 0.08)';
            chart.data.datasets[0].pointBackgroundColor = '#10b981';
            chart.options.scales.y.ticks.callback = function(v) { return '৳' + v.toLocaleString(); };
        }
        chart.update();
    };

    // ── Payment Method Doughnut Chart ──
    const methodCtx = document.getElementById('methodChart');
    if (methodCtx) {
        const methodData = @json($methodStats);
        const methodColors = {
            'bkash': '#db2777',
            'nagad': '#ea580c',
            'bank': '#2563eb',
            'rocket': '#7c3aed',
        };
        const defaultColors = ['#6366f1', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#ec4899'];

        new Chart(methodCtx, {
            type: 'doughnut',
            data: {
                labels: methodData.map(m => m.payment_method),
                datasets: [{
                    data: methodData.map(m => m.total),
                    backgroundColor: methodData.map((m, i) => methodColors[m.payment_method.toLowerCase()] || defaultColors[i % defaultColors.length]),
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12, weight: '600', family: 'Plus Jakarta Sans' }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 13, weight: '700', family: 'Plus Jakarta Sans' },
                        bodyFont: { size: 12, family: 'Plus Jakarta Sans' },
                        padding: 12,
                        cornerRadius: 10,
                    }
                }
            }
        });
    }
});
</script>

@endsection
