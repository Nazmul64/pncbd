@extends('admin.master')

@section('main-content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.hrm-page {
    padding: 30px 24px;
    background: #f8fafc;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.hrm-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 16px;
}

.hrm-header h1 {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
}

.hrm-header p {
    margin: 4px 0 0;
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.hrm-btn-primary {
    background: #3b82f6;
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    padding: 12px 24px;
    border-radius: 12px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
    transition: all 0.2s ease;
    text-decoration: none;
    cursor: pointer;
}

.hrm-btn-primary:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    color: #ffffff;
}

/* ── STATS GRID ── */
.hrm-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.hrm-stat-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0,0,0,0.04);
    position: relative;
    overflow: hidden;
}

.hrm-stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 4px;
    background: var(--card-color);
}

.hrm-stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    background: var(--icon-bg);
    color: var(--card-color);
}

.hrm-stat-info { display: flex; flex-direction: column; }
.hrm-stat-val { font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1.1; }
.hrm-stat-lbl { font-size: 13px; font-weight: 600; color: #64748b; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px; }

/* ── LAYOUT ── */
.hrm-layout {
    display: grid;
    grid-template-columns: 3fr 2fr;
    gap: 24px;
    margin-bottom: 30px;
}

@media(max-width: 1024px) {
    .hrm-layout { grid-template-columns: 1fr; }
}

.hrm-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0,0,0,0.04);
    margin-bottom: 24px;
    overflow: hidden;
}

.hrm-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    background: #fafafb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.hrm-card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}

.hrm-card-title i { color: #3b82f6; }

.hrm-card-body {
    padding: 24px;
}

.hrm-card-body.no-pad { padding: 0; }

/* ── FORM CONTROL ── */
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.form-label {
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.hrm-input {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
    outline: none;
    transition: all 0.2s;
}

.hrm-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* ── SCROLLABLE TABLES ── */
.hrm-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.hrm-table th {
    background: #f8fafc;
    padding: 14px 20px;
    font-size: 11px;
    font-weight: 750;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

.hrm-table td {
    padding: 16px 20px;
    font-size: 14px;
    color: #1e293b;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.hrm-table tr:hover td {
    background: #fafafb;
}

.avatar-mini {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    object-fit: cover;
    margin-right: 10px;
}

/* ── MODAL ── */
.hrm-modal {
    display: none;
    position: fixed;
    z-index: 1050;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
}

.hrm-modal-content {
    background: #ffffff;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    overflow: hidden;
    animation: modalAnim 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes modalAnim {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.hrm-modal-header {
    background: #1e293b;
    color: #ffffff;
    padding: 18px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.hrm-modal-header h3 { margin: 0; font-size: 16px; font-weight: 700; }
.hrm-modal-close {
    background: transparent;
    border: none;
    color: rgba(255,255,255,0.7);
    font-size: 24px;
    cursor: pointer;
}

.hrm-modal-close:hover { color: #ffffff; }
.hrm-modal-body { padding: 24px; }
</style>

<div class="hrm-page">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; margin-bottom: 24px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; margin-bottom: 24px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="hrm-header">
        <div>
            <h1>Advances & Payroll</h1>
            <p>Track employee salaries, advanced salary loans, and compute payable monthly payroll slips.</p>
        </div>
        
        {{-- Filters & Trigger --}}
        <div style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
            <form action="{{ route('admin.hrm.advance-salaries.index') }}" method="GET" style="display: flex; gap: 10px;">
                <select name="year" class="hrm-input" style="padding: 8px 16px;">
                    @for($y = Carbon\Carbon::now()->year - 2; $y <= Carbon\Carbon::now()->year + 1; $y++)
                        <option value="{{ $y }}" {{ $year === $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <select name="month" class="hrm-input" style="padding: 8px 16px;">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month === $m ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create(null, $m, 1)->format('F') }}
                        </option>
                    @endfor
                </select>
                <button type="submit" class="hrm-btn-primary" style="padding: 10px 18px; box-shadow: none;">Filter</button>
            </form>

            <button type="button" class="hrm-btn-primary" onclick="openDisburseModal()">
                <i class="bi bi-cash-coin"></i> Disburse Advance Salary
            </button>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="hrm-stats-grid">
        <div class="hrm-stat-card" style="--card-color: #3b82f6; --icon-bg: #dbeafe;">
            <div class="hrm-stat-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="hrm-stat-info">
                <div class="hrm-stat-val">৳{{ number_format($stats['total_base_salary'], 2) }}</div>
                <div class="hrm-stat-lbl">Base Payroll (Active)</div>
            </div>
        </div>
        <div class="hrm-stat-card" style="--card-color: #f59e0b; --icon-bg: #fef3c7;">
            <div class="hrm-stat-icon"><i class="bi bi-bank2"></i></div>
            <div class="hrm-stat-info">
                <div class="hrm-stat-val">৳{{ number_format($stats['total_advances_month'], 2) }}</div>
                <div class="hrm-stat-lbl">Advances Disbursed (Month)</div>
            </div>
        </div>
        <div class="hrm-stat-card" style="--card-color: #10b981; --icon-bg: #d1fae5;">
            <div class="hrm-stat-icon"><i class="bi bi-wallet2"></i></div>
            <div class="hrm-stat-info">
                <div class="hrm-stat-val">৳{{ number_format($stats['total_net_payable'], 2) }}</div>
                <div class="hrm-stat-lbl">Net Payroll Payable (Month)</div>
            </div>
        </div>
    </div>

    {{-- LAYOUT PANELS --}}
    <div class="hrm-layout">
        {{-- Left: Pay slips Calculator --}}
        <div>
            <div class="hrm-card">
                <div class="hrm-card-header">
                    <h4 class="hrm-card-title">
                        <i class="bi bi-calculator-fill"></i> Payroll Slips — {{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                    </h4>
                </div>
                <div class="hrm-card-body no-pad">
                    @if(empty($paySlips))
                        <div style="text-align: center; padding: 50px 24px; color: #94a3b8;">
                            No active employees.
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table class="hrm-table">
                                <thead>
                                    <tr>
                                        <th>Staff Member</th>
                                        <th>Base Salary</th>
                                        <th>Advance Taken</th>
                                        <th>Net Payout</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paySlips as $slip)
                                    <tr>
                                        <td>
                                            <div style="display: flex; align-items: center;">
                                                <img src="{{ $slip['employee']->getImageUrl('employee_image') }}" alt="" class="avatar-mini">
                                                <div>
                                                    <div style="font-weight: 700; color: #1e293b; font-size: 14px;">{{ $slip['employee']->name }}</div>
                                                    <div style="font-size: 11px; color: #64748b;">{{ $slip['employee']->phone }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="font-weight: 600; color: #475569;">৳{{ number_format($slip['base_salary'], 2) }}</span>
                                        </td>
                                        <td>
                                            <span style="font-weight: 700; color: #e11d48;">
                                                @if($slip['advance_taken'] > 0)
                                                    -৳{{ number_format($slip['advance_taken'], 2) }}
                                                @else
                                                    ৳0.00
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span style="font-weight: 800; color: #10b981; font-size: 15px;">৳{{ number_format($slip['net_payable'], 2) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Advance Payout history ledger --}}
        <div>
            <div class="hrm-card">
                <div class="hrm-card-header">
                    <h4 class="hrm-card-title">
                        <i class="bi bi-clock-history"></i> Advances Logs ({{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }})
                    </h4>
                </div>
                <div class="hrm-card-body no-pad" style="max-height: 480px; overflow-y: auto;">
                    @if($advances->isEmpty())
                        <div style="text-align: center; padding: 50px 24px; color: #94a3b8;">
                            No advanced salary drawings in this month.
                        </div>
                    @else
                        <table class="hrm-table">
                            <thead>
                                <tr>
                                    <th>Staff & Details</th>
                                    <th>Disbursed</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($advances as $adv)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;">{{ $adv->employee->name }}</div>
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                            <i class="bi bi-calendar-event me-1"></i>{{ $adv->date->format('d M Y') }}
                                        </div>
                                        @if($adv->note)
                                            <div style="font-size: 11px; font-style: italic; color: #94a3b8; margin-top: 4px; word-break: break-all;">Note: {{ $adv->note }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="font-weight: 800; color: #f59e0b;">৳{{ number_format($adv->amount, 2) }}</div>
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('admin.hrm.advance-salaries.destroy', $adv->id) }}" method="POST" onsubmit="return confirm('Delete this advanced salary transaction? This will refund their net salary payable for this month.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- DISBURSE MODAL --}}
<div class="hrm-modal" id="disburseAdvanceModal">
    <div class="hrm-modal-content">
        <div class="hrm-modal-header">
            <h3>Disburse Advance Salary Drawing</h3>
            <button type="button" class="hrm-modal-close" onclick="closeDisburseModal()">&times;</button>
        </div>
        <div class="hrm-modal-body">
            <form action="{{ route('admin.hrm.advance-salaries.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Employee</label>
                    <select name="employee_id" class="hrm-input" required>
                        <option value="">Select active employee...</option>
                        @foreach($employeesList as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }} (Base: ৳{{ number_format($emp->salary, 0) }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Advance Amount (৳)</label>
                    <input type="number" name="amount" min="1" step="1" class="hrm-input" placeholder="e.g. 5000" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Disbursement Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="hrm-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Optional Note</label>
                    <textarea name="note" class="hrm-input" style="min-height: 80px; resize: vertical;" placeholder="Add remarks or explanation for advance drawing..."></textarea>
                </div>

                <button type="submit" class="hrm-btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
                    Disburse & Save Record
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDisburseModal() {
    document.getElementById('disburseAdvanceModal').style.display = 'flex';
}

function closeDisburseModal() {
    document.getElementById('disburseAdvanceModal').style.display = 'none';
}

// Close when clicking outside modal body
document.addEventListener("DOMContentLoaded", function() {
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('disburseAdvanceModal');
        if (e.target === modal) {
            closeDisburseModal();
        }
    });
});
</script>
@endsection
