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

.btn-log-leave {
    background: #3b82f6;
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    padding: 12px 24px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    transition: all 0.2s;
}

.btn-log-leave:hover {
    background: #2563eb;
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
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
}

.stat-info p {
    margin: 2px 0 0;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
}

.stat-pending { background: #fef3c7; color: #d97706; }
.stat-approved { background: #d1fae5; color: #059669; }
.stat-month { background: #e0f2fe; color: #0284c7; }

/* ── TABLE & LIST ── */
.hrm-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
}

.hrm-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
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
    padding: 16px 24px;
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    text-align: left;
    border-bottom: 1px solid #f1f5f9;
}

.hrm-table td {
    padding: 16px 24px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    font-size: 14px;
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

.badge-pending { background: #fef3c7; color: #d97706; }
.badge-approved { background: #d1fae5; color: #059669; }
.badge-rejected { background: #fee2e2; color: #dc2626; }

.badge-type {
    background: #f1f5f9;
    color: #475569;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    text-transform: capitalize;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-edit { background: #eff6ff; color: #2563eb; }
.btn-edit:hover { background: #2563eb; color: #ffffff; }
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

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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

    {{-- HEADER --}}
    <div class="hrm-header">
        <div>
            <h1>Leaves & Time-off Logs</h1>
            <p>Track, register, and approve employee holidays, casual leave, and medical leaves.</p>
        </div>
        <button class="btn-log-leave" data-bs-toggle="modal" data-bs-target="#modalLogLeave">
            <i class="bi bi-plus-lg me-1"></i> Log Employee Leave
        </button>
    </div>

    {{-- STATS CARDS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-pending"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-info">
                <h3>{{ $pendingCount }}</h3>
                <p>Pending Approvals</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-approved"><i class="bi bi-calendar2-check-fill"></i></div>
            <div class="stat-info">
                <h3>{{ $approvedCount }}</h3>
                <p>Total Approved Leaves</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-month"><i class="bi bi-calendar3"></i></div>
            <div class="stat-info">
                <h3>{{ $thisMonthCount }}</h3>
                <p>Leaves This Month</p>
            </div>
        </div>
    </div>

    {{-- LEAVES TABLE CARD --}}
    <div class="hrm-card">
        <div class="hrm-card-header">
            <h4 class="hrm-card-title">Employee Leave Registers</h4>
        </div>
        <div class="table-responsive">
            <table class="hrm-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Duration</th>
                        <th>Total Days</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th style="width: 100px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($leaves->isEmpty())
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="bi bi-calendar-x" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                                No leave logs registered yet.
                            </td>
                        </tr>
                    @else
                        @foreach($leaves as $leave)
                            @php
                                $days = Carbon\Carbon::parse($leave->start_date)->diffInDays(Carbon\Carbon::parse($leave->end_date)) + 1;
                            @endphp
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <img src="{{ $leave->employee->getImageUrl('employee_image') }}" alt="" class="avatar-mini">
                                        <div>
                                            <div style="font-weight: 700; color: #1e293b;">{{ $leave->employee->name }}</div>
                                            <div style="font-size: 11px; color: #64748b;">{{ $leave->employee->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-type">{{ $leave->leave_type }}</span>
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $leave->start_date->format('d M Y') }} - {{ $leave->end_date->format('d M Y') }}</div>
                                </td>
                                <td style="font-weight: 700; color: #0f172a;">{{ $days }} Days</td>
                                <td>
                                    <span class="badge-status badge-{{ $leave->status }}">{{ $leave->status }}</span>
                                </td>
                                <td style="font-size: 13px; color: #64748b; max-width: 200px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                    {{ $leave->reason ?? 'No reason supplied' }}
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <button class="btn-action btn-edit" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditLeave-{{ $leave->id }}" 
                                                title="Edit Leave">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <form action="{{ route('admin.hrm.leaves.destroy', $leave->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this leave record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Delete Leave">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- EDIT MODAL FOR EACH LEAVE --}}
                            <div class="modal fade" id="modalEditLeave-{{ $leave->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 16px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="font-weight: 700;">Edit Leave Record</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.hrm.leaves.update', $leave->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-12 form-group">
                                                        <label>Select Staff Member</label>
                                                        <select name="employee_id" class="form-select" required>
                                                            @foreach($employees as $emp)
                                                                <option value="{{ $emp->id }}" {{ $leave->employee_id === $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label>Leave Type</label>
                                                        <select name="leave_type" class="form-select" required>
                                                            <option value="casual" {{ $leave->leave_type === 'casual' ? 'selected' : '' }}>Casual Leave</option>
                                                            <option value="sick" {{ $leave->leave_type === 'sick' ? 'selected' : '' }}>Sick Leave</option>
                                                            <option value="emergency" {{ $leave->leave_type === 'emergency' ? 'selected' : '' }}>Emergency Leave</option>
                                                            <option value="unpaid" {{ $leave->leave_type === 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label>Start Date</label>
                                                        <input type="date" name="start_date" class="form-control" value="{{ $leave->start_date->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label>End Date</label>
                                                        <input type="date" name="end_date" class="form-control" value="{{ $leave->end_date->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label>Approval Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="pending" {{ $leave->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="approved" {{ $leave->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                            <option value="rejected" {{ $leave->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label>Reason / Notes</label>
                                                        <textarea name="reason" class="form-control" rows="3" placeholder="Reason for time off...">{{ $leave->reason }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="background: #fafafb;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                                                <button type="submit" class="btn btn-primary" style="background: #3b82f6; border: none; border-radius: 8px;">Save Changes</button>
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
        @if($leaves->hasPages())
            <div style="padding: 20px 24px; border-top: 1px solid #f1f5f9;">
                {{ $leaves->links() }}
            </div>
        @endif
    </div>
</div>

{{-- LOG LEAVE MODAL --}}
<div class="modal fade" id="modalLogLeave" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Log New Leave Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.hrm.leaves.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 form-group">
                            <label>Select Staff Member</label>
                            <select name="employee_id" class="form-select" required>
                                <option value="" disabled selected>-- Select Employee --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label>Leave Type</label>
                            <select name="leave_type" class="form-select" required>
                                <option value="casual" selected>Casual Leave</option>
                                <option value="sick">Sick Leave</option>
                                <option value="emergency">Emergency Leave</option>
                                <option value="unpaid">Unpaid Leave</option>
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6 form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12 form-group">
                            <label>Approval Status</label>
                            <select name="status" class="form-select" required>
                                <option value="approved" selected>Approved</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label>Reason / Notes</label>
                            <textarea name="reason" class="form-control" rows="3" placeholder="Reason for time off..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #fafafb;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #3b82f6; border: none; border-radius: 8px;">Register Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
