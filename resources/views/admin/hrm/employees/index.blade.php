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
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
    transition: all 0.3s ease;
}

.hrm-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.05);
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

/* ── FILTER & TABLE CARD ── */
.hrm-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0,0,0,0.04);
    margin-bottom: 30px;
    overflow: hidden;
}

.hrm-filter-bar {
    padding: 20px 24px;
    background: #fafafb;
    border-bottom: 1px solid #f1f5f9;
}

.hrm-filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    align-items: center;
}

.hrm-input {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
    transition: all 0.2s;
    outline: none;
}

.hrm-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.hrm-btn-filter {
    background: #f1f5f9;
    color: #475569;
    border: 1.5px solid #e2e8f0;
    font-weight: 700;
    font-size: 14px;
    padding: 10px 20px;
    border-radius: 10px;
    transition: all 0.2s;
    cursor: pointer;
}

.hrm-btn-filter:hover {
    background: #e2e8f0;
    color: #0f172a;
}

/* ── DATA TABLE ── */
.hrm-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.hrm-table th {
    background: #f8fafc;
    padding: 14px 20px;
    font-size: 12px;
    font-weight: 700;
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

.hrm-avatar {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    object-fit: cover;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}

.hrm-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

.badge-active { background: #dcfce7; color: #16a34a; }
.badge-inactive { background: #fee2e2; color: #dc2626; }

/* ── STATUS TOGGLE SWITCH ── */
.status-switch {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 24px;
}

.status-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.status-slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #cbd5e1;
    transition: .3s;
    border-radius: 24px;
}

.status-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
}

input:checked + .status-slider {
    background-color: #10b981;
}

input:checked + .status-slider:before {
    transform: translateX(22px);
}

/* ── PROFILE MODAL ── */
.hrm-modal {
    display: none;
    position: fixed;
    z-index: 1050;
    top: 0; left: 0; width: 100%; height: 100%;
    overflow-y: auto;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
}

.hrm-modal-content {
    background: #ffffff;
    border-radius: 20px;
    width: 90%;
    max-width: 800px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    overflow: hidden;
    position: relative;
    border: 1px solid rgba(255,255,255,0.1);
    animation: modalAnim 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes modalAnim {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.hrm-modal-header {
    background: #1e293b;
    color: #ffffff;
    padding: 20px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.hrm-modal-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
}

.hrm-modal-close {
    background: transparent;
    border: none;
    color: rgba(255,255,255,0.7);
    font-size: 24px;
    cursor: pointer;
    transition: color 0.2s;
}

.hrm-modal-close:hover { color: #ffffff; }

.hrm-modal-body {
    padding: 30px;
}

.profile-grid {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 30px;
}

@media(max-width: 600px) {
    .profile-grid { grid-template-columns: 1fr; }
}

.profile-avatar-sec {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.profile-avatar-sec img {
    width: 150px;
    height: 150px;
    border-radius: 20px;
    object-fit: cover;
    border: 4px solid #f1f5f9;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 12px;
}

.profile-details-sec h4 {
    margin: 0 0 16px 0;
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
}

.details-tab-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
}

@media(max-width: 500px) {
    .details-tab-grid { grid-template-columns: 1fr; }
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-lbl {
    font-size: 11px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.detail-val {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}

.documents-section {
    margin-top: 30px;
    border-top: 1px solid #f1f5f9;
    padding-top: 24px;
}

.documents-section h5 {
    margin: 0 0 16px 0;
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}

.doc-images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 16px;
}

.doc-card {
    background: #f8fafc;
    border-radius: 12px;
    border: 1.5px dashed #cbd5e1;
    padding: 12px;
    text-align: center;
}

.doc-card img {
    width: 100%;
    height: 90px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: transform 0.2s;
}

.doc-card img:hover {
    transform: scale(1.04);
}

.doc-title {
    font-size: 11px;
    font-weight: 700;
    color: #475569;
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
            <h1>Employees Directory</h1>
            <p>Manage employee records, files, parent details, and monthly base pay rates.</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            <a href="{{ route('admin.hrm.employees.id-card') }}" style="background: linear-gradient(135deg,#1e40af,#3b82f6); color: #fff; font-weight: 700; font-size: 14px; padding: 12px 20px; border-radius: 12px; border: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(59,130,246,0.3); transition: all 0.2s; text-decoration: none;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
                <i class="bi bi-person-badge-fill"></i> আইডি কার্ড জেনারেটর
            </a>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('create-employees'))
                <a href="{{ route('admin.hrm.employees.create') }}" class="hrm-btn-primary">
                    <i class="bi bi-person-plus-fill"></i> Add New Employee
                </a>
            @endif
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="hrm-stats-grid">
        <div class="hrm-stat-card" style="--card-color: #3b82f6; --icon-bg: #dbeafe;">
            <div class="hrm-stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="hrm-stat-info">
                <div class="hrm-stat-val">{{ $stats['total'] }}</div>
                <div class="hrm-stat-lbl">Total Registered</div>
            </div>
        </div>
        <div class="hrm-stat-card" style="--card-color: #10b981; --icon-bg: #d1fae5;">
            <div class="hrm-stat-icon"><i class="bi bi-person-check-fill"></i></div>
            <div class="hrm-stat-info">
                <div class="hrm-stat-val">{{ $stats['active'] }}</div>
                <div class="hrm-stat-lbl">Active Employees</div>
            </div>
        </div>
        <div class="hrm-stat-card" style="--card-color: #ef4444; --icon-bg: #fee2e2;">
            <div class="hrm-stat-icon"><i class="bi bi-person-x-fill"></i></div>
            <div class="hrm-stat-info">
                <div class="hrm-stat-val">{{ $stats['inactive'] }}</div>
                <div class="hrm-stat-lbl">Inactive</div>
            </div>
        </div>
        <div class="hrm-stat-card" style="--card-color: #8b5cf6; --icon-bg: #ede9fe;">
            <div class="hrm-stat-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="hrm-stat-info">
                <div class="hrm-stat-val">৳{{ number_format($stats['total_payroll'], 2) }}</div>
                <div class="hrm-stat-lbl">Monthly Base Payroll</div>
            </div>
        </div>
    </div>

    {{-- TABLE AND FILTER CARD --}}
    <div class="hrm-card">
        {{-- Search / Filter bar --}}
        <div class="hrm-filter-bar">
            <form action="{{ route('admin.hrm.employees.index') }}" method="GET" class="hrm-filter-form">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, phone or NID..." class="hrm-input" style="flex: 1; min-width: 250px;">
                <select name="status" class="hrm-input" style="min-width: 150px;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="hrm-btn-filter" style="background: #3b82f6; color: #fff; border-color: #3b82f6;">
                    <i class="bi bi-search me-1"></i> Search
                </button>
                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.hrm.employees.index') }}" class="hrm-btn-filter">Clear</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        @if($employees->isEmpty())
            <div style="text-align: center; padding: 50px 24px; color: #94a3b8;">
                <i class="bi bi-people" style="font-size: 40px; display: block; margin-bottom: 12px;"></i>
                No employees registered or matching filters.
            </div>
        @else
            <div style="overflow-x: auto;">
                <table class="hrm-table">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Employee Details</th>
                            <th>NID Number</th>
                            <th>Location Details</th>
                            <th>Base Salary</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>
                                <img src="{{ $employee->getImageUrl('employee_image') }}" alt="{{ $employee->name }}" class="hrm-avatar">
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 15px;">{{ $employee->name }}</div>
                                <div style="font-size: 13px; color: #64748b; font-weight: 600; margin-top: 2px;"><i class="bi bi-telephone-fill me-1"></i>{{ $employee->phone }}</div>
                            </td>
                            <td>
                                <span style="font-weight: 600; font-family: monospace; color: #475569;">{{ $employee->nid_number }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #334155;">{{ $employee->district ?? 'N/A' }}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $employee->thana ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">৳{{ number_format($employee->salary, 2) }}</div>
                            </td>
                            <td>
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('edit-employees'))
                                    <label class="status-switch">
                                        <input type="checkbox" class="toggle-status-chk" data-id="{{ $employee->id }}" {{ $employee->status === 'active' ? 'checked' : '' }}>
                                        <span class="status-slider"></span>
                                    </label>
                                @else
                                    <span class="hrm-badge {{ $employee->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                        {{ ucfirst($employee->status) }}
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end;">
                                    {{-- ID Card Button --}}
                                    <a href="{{ route('admin.hrm.employees.id-card') }}?emp={{ $employee->id }}"
                                       style="background: linear-gradient(135deg,#1e40af,#3b82f6); color: #fff; border: none; padding: 5px 11px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; transition: all 0.2s;">
                                        <i class="bi bi-person-badge-fill"></i> ID Card
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-primary show-details-btn" data-employee="{{ json_encode($employee) }}" style="border-radius: 8px; font-weight: 600; padding: 6px 12px;">
                                        <i class="bi bi-eye"></i> Details
                                    </button>
                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('edit-employees'))
                                        <a href="{{ route('admin.hrm.employees.edit', $employee->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px; font-weight: 600; padding: 6px 12px;">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    @endif
                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('delete-employees'))
                                        <form action="{{ route('admin.hrm.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete this employee record? This cannot be undone!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px; font-weight: 600; padding: 6px 12px;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding: 20px 24px; border-top: 1px solid #f1f5f9;">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
</div>

{{-- DETAILS MODAL --}}
<div class="hrm-modal" id="employeeDetailsModal">
    <div class="hrm-modal-content">
        <div class="hrm-modal-header">
            <h3>Employee Profile Card</h3>
            <button type="button" class="hrm-modal-close" onclick="closeDetailsModal()">&times;</button>
        </div>
        <div class="hrm-modal-body">
            <div class="profile-grid">
                <div class="profile-avatar-sec">
                    <img id="detailEmployeePhoto" src="" alt="Employee Photo">
                    <span id="detailStatusBadge" class="hrm-badge">Active</span>
                </div>
                <div class="profile-details-sec">
                    <h4 id="detailName">Habib</h4>
                    
                    <div class="details-tab-grid">
                        <div class="detail-item">
                            <span class="detail-lbl">Phone Number</span>
                            <span class="detail-val" id="detailPhone">0170000000</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-lbl">NID Number</span>
                            <span class="detail-val" id="detailNid">1234567890</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-lbl">Monthly Salary</span>
                            <span class="detail-val" id="detailSalary">৳0.00</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-lbl">Region</span>
                            <span class="detail-val" id="detailRegion">Dhaka</span>
                        </div>
                    </div>

                    <div class="details-tab-grid" style="grid-template-columns: 1fr;">
                        <div class="detail-item">
                            <span class="detail-lbl">Full Address</span>
                            <span class="detail-val" id="detailAddress">Sector 10, Uttara</span>
                        </div>
                    </div>

                    <h4 style="font-size: 16px; margin-top: 24px; border-top: 1px solid #f1f5f9; padding-top: 16px;">Family Details</h4>
                    <div class="details-tab-grid">
                        <div class="detail-item">
                            <span class="detail-lbl">Father's Name</span>
                            <span class="detail-val" id="detailFatherName">Abul</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-lbl">Father's Phone</span>
                            <span class="detail-val" id="detailFatherPhone">01700000</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-lbl">Mother's Name</span>
                            <span class="detail-val" id="detailMotherName">Amena</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-lbl">Mother's Phone</span>
                            <span class="detail-val" id="detailMotherPhone">01700000</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-lbl">Mother's NID</span>
                            <span class="detail-val" id="detailMotherNid">1234567</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="documents-section">
                <h5>Uploaded Official Documents</h5>
                <div class="doc-images-grid">
                    <div class="doc-card" id="cardEmpNid">
                        <img id="detailEmpNidImg" src="" alt="Employee NID" onclick="viewImageFull(this.src)">
                        <span class="doc-title">Employee NID</span>
                    </div>
                    <div class="doc-card" id="cardFatherNid">
                        <img id="detailFatherNidImg" src="" alt="Father NID" onclick="viewImageFull(this.src)">
                        <span class="doc-title">Father NID</span>
                    </div>
                    <div class="doc-card" id="cardMotherNid">
                        <img id="detailMotherNidImg" src="" alt="Mother NID" onclick="viewImageFull(this.src)">
                        <span class="doc-title">Mother NID</span>
                    </div>
                    <div class="doc-card" id="cardParents">
                        <img id="detailParentsImg" src="" alt="Parents Photo" onclick="viewImageFull(this.src)">
                        <span class="doc-title">Parents Photo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Dynamic Details Modal Control
function openDetailsModal(employee) {
    const modal = document.getElementById('employeeDetailsModal');
    
    // Core details
    document.getElementById('detailName').innerText = employee.name;
    document.getElementById('detailPhone').innerText = employee.phone;
    document.getElementById('detailNid').innerText = employee.nid_number;
    document.getElementById('detailSalary').innerText = '৳' + parseFloat(employee.salary).toLocaleString('en-US', {minimumFractionDigits: 2});
    document.getElementById('detailRegion').innerText = (employee.district || 'N/A') + ', ' + (employee.thana || 'N/A');
    document.getElementById('detailAddress').innerText = employee.address || 'N/A';
    
    // Family
    document.getElementById('detailFatherName').innerText = employee.father_name || 'N/A';
    document.getElementById('detailFatherPhone').innerText = employee.father_phone || 'N/A';
    document.getElementById('detailMotherName').innerText = employee.mother_name || 'N/A';
    document.getElementById('detailMotherPhone').innerText = employee.mother_phone || 'N/A';
    document.getElementById('detailMotherNid').innerText = employee.mother_nid_number || 'N/A';
    
    // Main Photo
    let avatarUrl = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(employee.name) + '&background=3b82f6&color=fff&size=200';
    if (employee.employee_image) {
        avatarUrl = '{{ asset('') }}' + employee.employee_image;
    }
    document.getElementById('detailEmployeePhoto').src = avatarUrl;
    
    // Status Badge
    const statusB = document.getElementById('detailStatusBadge');
    statusB.className = 'hrm-badge ' + (employee.status === 'active' ? 'badge-active' : 'badge-inactive');
    statusB.innerText = employee.status.charAt(0).toUpperCase() + employee.status.slice(1);

    // Official Documents Images Helper
    const placeholder = '{{ asset("assets/backend/images/placeholder.jpg") }}';
    
    setupDocImage('detailEmpNidImg', employee.nid_image, 'cardEmpNid');
    setupDocImage('detailFatherNidImg', employee.father_nid_image, 'cardFatherNid');
    setupDocImage('detailMotherNidImg', employee.mother_nid_image, 'cardMotherNid');
    setupDocImage('detailParentsImg', employee.parents_image, 'cardParents');

    modal.style.display = 'flex';
}

function setupDocImage(imgId, relativePath, cardId) {
    const imgEl = document.getElementById(imgId);
    const cardEl = document.getElementById(cardId);
    if (relativePath) {
        imgEl.src = '{{ asset('') }}' + relativePath;
        cardEl.style.display = 'block';
    } else {
        cardEl.style.display = 'none';
    }
}

function closeDetailsModal() {
    document.getElementById('employeeDetailsModal').style.display = 'none';
}

function viewImageFull(src) {
    window.open(src, '_blank');
}

// Attach Event Listeners on DOM load
document.addEventListener('DOMContentLoaded', function() {
    // Show Details modal
    const showBtns = document.querySelectorAll('.show-details-btn');
    showBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const empData = JSON.parse(this.getAttribute('data-employee'));
            openDetailsModal(empData);
        });
    });

    // Close modal when clicking outside content
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('employeeDetailsModal');
        if (e.target === modal) {
            closeDetailsModal();
        }
    });

    // Status AJAX Switcher
    const toggleSwitches = document.querySelectorAll('.toggle-status-chk');
    toggleSwitches.forEach(sw => {
        sw.addEventListener('change', function() {
            const employeeId = this.getAttribute('data-id');
            const targetUrl = '{{ route("admin.hrm.employees.toggle-status", ":id") }}'.replace(':id', employeeId);

            fetch(targetUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    console.log('AJAX Switcher Status:', data.status);
                } else {
                    alert('Error changing employee status.');
                    this.checked = !this.checked; // Revert
                }
            })
            .catch(err => {
                console.error(err);
                alert('Connection error occurred.');
                this.checked = !this.checked; // Revert
            });
        });
    });
});
</script>
@endsection
