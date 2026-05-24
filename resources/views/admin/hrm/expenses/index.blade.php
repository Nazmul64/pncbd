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

/* ── LAYOUT PANELS ── */
.hrm-layout-grid {
    display: grid;
    grid-template-columns: 3fr 1fr;
    gap: 24px;
}

@media(max-width: 1024px) {
    .hrm-layout-grid { grid-template-columns: 1fr; }
}

.hrm-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0,0,0,0.04);
    margin-bottom: 30px;
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

.hrm-card-title i { color: #ef4444; }

.hrm-card-body {
    padding: 24px;
}

.hrm-card-body.no-pad { padding: 0; }

/* ── FORM FILTERS ── */
.filter-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,0.04);
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    height: fit-content;
}

.filter-card h4 {
    margin: 0 0 16px 0;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    color: #475569;
    letter-spacing: 0.5px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 16px;
}

.form-label {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.hrm-input {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    font-weight: 500;
    outline: none;
    transition: all 0.2s;
}

.hrm-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* ── EXPENDITURES TABLE ── */
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

/* ── MODALS ── */
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

    {{-- HEADER --}}
    <div class="hrm-header">
        <div>
            <h1>Expenditures Ledger</h1>
            <p>Monitor company expenditures, administrative bills, utilities, and minor payments.</p>
        </div>
        <button type="button" class="hrm-btn-primary" onclick="openExpenseModal()">
            <i class="bi bi-plus-circle-fill"></i> Add New Expense
        </button>
    </div>

    {{-- CARD TOTALS --}}
    <div class="hrm-card" style="margin-bottom: 24px; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #ffffff; border: none; box-shadow: 0 10px 24px rgba(15,23,42,0.15);">
        <div class="hrm-card-body" style="display: flex; align-items: center; justify-content: space-between; padding: 30px;">
            <div>
                <span style="font-size: 13px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">
                    @if($startDate && $endDate)
                        Total Expenses (Range: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }})
                    @else
                        Total Expenses ({{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }})
                    @endif
                </span>
                <h2 style="font-size: 40px; font-weight: 800; margin: 8px 0 0 0; color: #f43f5e; letter-spacing: -1px;">৳{{ number_format($totalExpenses, 2) }}</h2>
            </div>
            <div style="font-size: 46px; color: rgba(244, 63, 94, 0.2);"><i class="bi bi-receipt"></i></div>
        </div>
    </div>

    {{-- PANELS --}}
    <div class="hrm-layout-grid">
        {{-- Left: Expenses Table --}}
        <div>
            <div class="hrm-card">
                <div class="hrm-card-header">
                    <h4 class="hrm-card-title">
                        <i class="bi bi-receipt-cutoff"></i> Expenditures Log
                    </h4>
                </div>
                <div class="hrm-card-body no-pad">
                    @if($expenses->isEmpty())
                        <div style="text-align: center; padding: 60px 24px; color: #94a3b8;">
                            <i class="bi bi-inbox" style="font-size: 40px; display: block; margin-bottom: 12px;"></i>
                            No expenses registered inside selected dates.
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table class="hrm-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Expense Title & Details</th>
                                        <th>Amount</th>
                                        <th style="text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenses as $exp)
                                    <tr>
                                        <td style="font-weight: 600; color: #475569; width: 140px;">
                                            <i class="bi bi-calendar-event me-2 text-primary"></i>{{ $exp->date->format('d M Y') }}
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: #1e293b; font-size: 15px;">{{ $exp->title }}</div>
                                            @if($exp->description)
                                                <div style="font-size: 12px; color: #64748b; margin-top: 4px; font-style: italic;">{{ $exp->description }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="font-weight: 800; color: #f43f5e; font-size: 16px;">৳{{ number_format($exp->amount, 2) }}</span>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="display: inline-flex; gap: 8px;">
                                                <button type="button" class="btn btn-sm btn-outline-secondary edit-expense-btn" data-expense="{{ json_encode($exp) }}" style="border-radius: 8px;">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="{{ route('admin.hrm.expenses.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Delete this expenditure record completely?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div style="padding: 20px 24px; border-top: 1px solid #f1f5f9;">
                            {{ $expenses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Filters Panel --}}
        <div>
            <div class="filter-card">
                <h4><i class="bi bi-funnel-fill me-1"></i> Filter Logs</h4>
                
                {{-- Mode 1: Month / Year --}}
                <form action="{{ route('admin.hrm.expenses.index') }}" method="GET" style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1.5px dashed #e2e8f0;">
                    <div class="form-group">
                        <label class="form-label">Selected Year</label>
                        <select name="year" class="hrm-input">
                            @for($y = Carbon\Carbon::now()->year - 2; $y <= Carbon\Carbon::now()->year + 1; $y++)
                                <option value="{{ $y }}" {{ $year === $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Selected Month</label>
                        <select name="month" class="hrm-input">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $month === $m ? 'selected' : '' }}>
                                    {{ Carbon\Carbon::create(null, $m, 1)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="hrm-btn-primary" style="width:100%; justify-content:center; box-shadow:none;">
                        Apply Month Filter
                    </button>
                </form>

                {{-- Mode 2: Custom Date range --}}
                <form action="{{ route('admin.hrm.expenses.index') }}" method="GET">
                    <div class="form-group">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="hrm-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="hrm-input" required>
                    </div>
                    <button type="submit" class="hrm-btn-primary" style="width:100%; justify-content:center; box-shadow:none; background:#475569;">
                        Apply Date Range
                    </button>
                </form>
                
                @if(request()->filled('start_date') || request()->filled('year'))
                    <a href="{{ route('admin.hrm.expenses.index') }}" class="btn btn-outline-secondary d-block text-center mt-3" style="border-radius:10px; font-weight:700; padding:10px;">Clear Filter</a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ADD MODAL --}}
<div class="hrm-modal" id="addExpenseModal">
    <div class="hrm-modal-content">
        <div class="hrm-modal-header">
            <h3>Record Administrative Expenditure</h3>
            <button type="button" class="hrm-modal-close" onclick="closeExpenseModal()">&times;</button>
        </div>
        <div class="hrm-modal-body">
            <form action="{{ route('admin.hrm.expenses.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Expense Title / Description <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="hrm-input" placeholder="e.g. Electricity Bill" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Amount (৳) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="amount" min="0.01" class="hrm-input" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="hrm-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Additional Remarks</label>
                    <textarea name="description" class="hrm-input" style="min-height: 80px; resize: vertical;" placeholder="Enter details or payment receipts note..."></textarea>
                </div>
                <button type="submit" class="hrm-btn-primary" style="width:100%; justify-content:center; margin-top:10px;">
                    Save Expense Record
                </button>
            </form>
        </div>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="hrm-modal" id="editExpenseModal">
    <div class="hrm-modal-content">
        <div class="hrm-modal-header">
            <h3>Edit Expenditure Details</h3>
            <button type="button" class="hrm-modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <div class="hrm-modal-body">
            <form id="editExpenseForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Expense Title / Description <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="edit_title" class="hrm-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Amount (৳) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="amount" id="edit_amount" min="0.01" class="hrm-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="edit_date" class="hrm-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Additional Remarks</label>
                    <textarea name="description" id="edit_description" class="hrm-input" style="min-height: 80px; resize: vertical;"></textarea>
                </div>
                <button type="submit" class="hrm-btn-primary" style="width:100%; justify-content:center; margin-top:10px;">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openExpenseModal() {
    document.getElementById('addExpenseModal').style.display = 'flex';
}

function closeExpenseModal() {
    document.getElementById('addExpenseModal').style.display = 'none';
}

function openEditModal(expense) {
    const modal = document.getElementById('editExpenseModal');
    const form = document.getElementById('editExpenseForm');
    
    // Set Action Route
    const actionRoute = '{{ route("admin.hrm.expenses.update", ":id") }}'.replace(':id', expense.id);
    form.action = actionRoute;
    
    // Populate Fields
    document.getElementById('edit_title').value = expense.title;
    document.getElementById('edit_amount').value = parseFloat(expense.amount);
    
    // Format date correctly YYYY-MM-DD
    const expDate = new Date(expense.date);
    const y = expDate.getFullYear();
    const m = String(expDate.getMonth() + 1).padStart(2, '0');
    const d = String(expDate.getDate()).padStart(2, '0');
    document.getElementById('edit_date').value = `${y}-${m}-${d}`;
    
    document.getElementById('edit_description').value = expense.description || '';
    
    modal.style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editExpenseModal').style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function() {
    // Open edit expense details modal
    const editBtns = document.querySelectorAll(".edit-expense-btn");
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const expData = JSON.parse(this.getAttribute('data-expense'));
            openEditModal(expData);
        });
    });

    // Close when clicking outside modal body
    window.addEventListener('click', function(e) {
        const addModal = document.getElementById('addExpenseModal');
        const editModal = document.getElementById('editExpenseModal');
        if (e.target === addModal) closeExpenseModal();
        if (e.target === editModal) closeEditModal();
    });
});
</script>
@endsection
