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
}

.hrm-filter-form {
    display: flex;
    gap: 12px;
}

.hrm-select {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 8px 16px;
    font-size: 14px;
    color: #1e293b;
    font-weight: 600;
    outline: none;
    cursor: pointer;
    transition: all 0.2s;
}

.hrm-select:focus { border-color: #3b82f6; }

.hrm-btn-action {
    background: #3b82f6;
    color: #ffffff;
    border: none;
    font-weight: 700;
    font-size: 14px;
    padding: 8px 18px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.hrm-btn-action:hover { background: #2563eb; }

.hrm-btn-generate {
    background: #10b981;
    color: #ffffff;
    border: none;
    font-weight: 700;
    font-size: 14px;
    padding: 8px 18px;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    transition: all 0.2s;
}

.hrm-btn-generate:hover {
    background: #059669;
    transform: translateY(-1px);
}

/* ── STATS CARDS ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: 16px;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.stat-info h3 {
    margin: 0;
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
}

.stat-info p {
    margin: 2px 0 0;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
}

.stat-base { background: #eff6ff; color: #2563eb; }
.stat-net { background: #ecfdf5; color: #10b981; }
.stat-paid { background: #d1fae5; color: #059669; }
.stat-pending { background: #fee2e2; color: #dc2626; }

/* ── TABLE CARD ── */
.hrm-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 30px;
}

.hrm-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.hrm-card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

.hrm-table {
    width: 100%;
    border-collapse: collapse;
}

.hrm-table th {
    background: #fafafb;
    padding: 16px 18px;
    font-size: 11px;
    font-weight: 800;
    color: #475569;
    text-transform: uppercase;
    border-bottom: 1px solid #f1f5f9;
}

.hrm-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13px;
    vertical-align: middle;
}

.avatar-mini {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    object-fit: cover;
    margin-right: 10px;
}

.badge-status {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
}

.badge-pending { background: #fee2e2; color: #dc2626; }
.badge-paid { background: #d1fae5; color: #059669; }

.badge-days {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
}

.badge-pres { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
.badge-abs { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
.badge-leave { background: #fffbeb; color: #92400e; border: 1px solid #fef3c7; }

.btn-action {
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.btn-pay { background: #10b981; color: #ffffff; }
.btn-pay:hover { background: #059669; }
.btn-print { background: #eff6ff; color: #2563eb; }
.btn-print:hover { background: #2563eb; color: #ffffff; }
.btn-delete { background: #fef2f2; color: #dc2626; }
.btn-delete:hover { background: #dc2626; color: #ffffff; }

.form-group label {
    font-weight: 700;
    font-size: 13px;
    color: #475569;
    margin-bottom: 6px;
    display: block;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1.5px solid #cbd5e1;
    padding: 10px 14px;
    font-size: 14px;
    font-weight: 500;
}
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
            <h1>Monthly Salaries & Payslips</h1>
            <p>Generate, calculate deductions, disburse payments, and print paper records for staff accounts.</p>
        </div>

        {{-- Filters & Generate Actions --}}
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <form action="{{ route('admin.hrm.payslips.index') }}" method="GET" class="hrm-filter-form">
                <select name="year" class="hrm-select">
                    @for($y = Carbon\Carbon::now()->year - 2; $y <= Carbon\Carbon::now()->year + 1; $y++)
                        <option value="{{ $y }}" {{ $year === $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <select name="month" class="hrm-select">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month === $m ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create(null, $m, 1)->format('F') }}
                        </option>
                    @endfor
                </select>
                <button type="submit" class="hrm-btn-action">
                    <i class="bi bi-funnel-fill me-1"></i> Filter Sheet
                </button>
            </form>

            <form action="{{ route('admin.hrm.payslips.generate') }}" method="POST" onsubmit="return confirm('Generate / Recalculate salary slips for all active employees for this month?')">
                @csrf
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <button type="submit" class="hrm-btn-generate">
                    <i class="bi bi-gear-fill me-1"></i> Generate Payslips
                </button>
            </form>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-base"><i class="bi bi-wallet2"></i></div>
            <div class="stat-info">
                <h3>৳{{ number_format($totalBaseSalary, 2) }}</h3>
                <p>Est. Base Payroll</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-net"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-info">
                <h3>৳{{ number_format($totalNetSalary, 2) }}</h3>
                <p>Net Payout Amount</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-paid"><i class="bi bi-check2-circle"></i></div>
            <div class="stat-info">
                <h3>{{ $totalPaidCount }}</h3>
                <p>Paid Payslips</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-pending"><i class="bi bi-hourglass-bottom"></i></div>
            <div class="stat-info">
                <h3>{{ $totalPendingCount }}</h3>
                <p>Pending Disbursements</p>
            </div>
        </div>
    </div>

    {{-- PAYSLIPS TABLE CARD --}}
    <div class="hrm-card">
        <div class="hrm-card-header">
            <h4 class="hrm-card-title">Monthly Payslips Ledger — {{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</h4>
        </div>
        <div class="table-responsive">
            <table class="hrm-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Base Salary</th>
                        <th>Attendances (P/A/L)</th>
                        <th>Advances</th>
                        <th>Deductions</th>
                        <th>Bonus</th>
                        <th>Net Payable</th>
                        <th>Status</th>
                        <th style="width: 250px; text-align: center;">Disbursements / Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($payslips->isEmpty())
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 50px; color: #94a3b8;">
                                <i class="bi bi-calculator" style="font-size: 36px; display: block; margin-bottom: 12px;"></i>
                                No payslips generated for this month. Click the <b>Generate Payslips</b> button above to create them.
                            </td>
                        </tr>
                    @else
                        @foreach($payslips as $slip)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <img src="{{ $slip->employee->getImageUrl('employee_image') }}" alt="" class="avatar-mini">
                                        <div>
                                            <div style="font-weight: 700; color: #1e293b;">{{ $slip->employee->name }}</div>
                                            <div style="font-size: 11px; color: #64748b;">{{ $slip->employee->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-weight: 600; color: #1e293b;">৳{{ number_format($slip->base_salary, 2) }}</td>
                                <td>
                                    <div style="display: flex; gap: 4px;">
                                        <span class="badge-days badge-pres" title="Present days">{{ $slip->present_days }}P</span>
                                        <span class="badge-days badge-abs" title="Absent days">{{ $slip->absent_days }}A</span>
                                        <span class="badge-days badge-leave" title="Leave days">{{ $slip->leave_days }}L</span>
                                    </div>
                                </td>
                                <td style="font-weight: 600; color: #ea580c;">
                                    {{ $slip->advances_drawn > 0 ? '৳'.number_format($slip->advances_drawn, 2) : '-' }}
                                </td>
                                <td style="font-weight: 600; color: #dc2626;">
                                    {{ $slip->deductions > 0 ? '৳'.number_format($slip->deductions, 2) : '-' }}
                                </td>
                                <td style="font-weight: 600; color: #10b981;">
                                    {{ $slip->bonus > 0 ? '৳'.number_format($slip->bonus, 2) : '-' }}
                                </td>
                                <td style="font-weight: 800; color: #10b981; font-size: 14px;">৳{{ number_format($slip->net_salary, 2) }}</td>
                                <td>
                                    <span class="badge-status badge-{{ $slip->status }}">{{ $slip->status }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        @if($slip->status === 'pending')
                                            <button class="btn-action btn-pay" data-bs-toggle="modal" data-bs-target="#modalPaySalary-{{ $slip->id }}">
                                                <i class="bi bi-wallet2"></i> Pay Salary
                                            </button>
                                        @else
                                            <a href="{{ route('admin.hrm.payslips.print', $slip->id) }}" target="_blank" class="btn-action btn-print">
                                                <i class="bi bi-printer"></i> Print Payslip
                                            </a>
                                        @endif
                                        
                                        @if($slip->status === 'pending')
                                            <form action="{{ route('admin.hrm.payslips.destroy', $slip->id) }}" method="POST" onsubmit="return confirm('Delete this payslip record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- PAY DISBURSEMENT MODAL --}}
                            <div class="modal fade" id="modalPaySalary-{{ $slip->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 16px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="font-weight: 700;">Disburse Salary: {{ $slip->employee->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.hrm.payslips.pay', $slip->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body text-start">
                                                <div class="p-3 mb-3 bg-light rounded-3" style="font-size: 13px; font-weight: 600;">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span>Base Salary:</span>
                                                        <span>৳{{ number_format($slip->base_salary, 2) }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1 text-danger">
                                                        <span>Advances Deducted:</span>
                                                        <span>- ৳{{ number_format($slip->advances_drawn, 2) }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1 text-danger">
                                                        <span>Absent Deductions:</span>
                                                        <span>- ৳{{ number_format($slip->deductions, 2) }}</span>
                                                    </div>
                                                    <hr class="my-2">
                                                    <div class="d-flex justify-content-between text-success style-holder" style="font-size: 15px; font-weight: 800;">
                                                        <span>Est. Net Payable:</span>
                                                        <span>৳{{ number_format($slip->net_salary, 2) }}</span>
                                                    </div>
                                                </div>

                                                <div class="row g-3">
                                                    <div class="col-6 form-group">
                                                        <label>Performance Bonus (Optional)</label>
                                                        <input type="number" name="bonus" class="form-control" placeholder="0.00" min="0" step="any">
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label>Custom Deductions (Penalty)</label>
                                                        <input type="number" name="custom_deductions" class="form-control" placeholder="0.00" min="0" step="any">
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label>Payment Method</label>
                                                        <select name="payment_method" class="form-select" required>
                                                            <option value="Cash" selected>Cash Payment</option>
                                                            <option value="bKash">bKash Account</option>
                                                            <option value="Nagad">Nagad Wallet</option>
                                                            <option value="Bank Transfer">Bank Transfer / Pay Order</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label>Disbursement Notes</label>
                                                        <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Disbursed salary via bank transfer..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="background: #fafafb;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                                                <button type="submit" class="btn btn-success" style="border: none; border-radius: 8px;">Complete Payment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
