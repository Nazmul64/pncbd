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
    flex-wrap: wrap;
    gap: 16px;
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
    padding: 0; /* Let grid have full space */
}

/* ── FILTERING DROPDOWNS ── */
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

.hrm-select:focus {
    border-color: #3b82f6;
}

.hrm-btn-filter {
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

.hrm-btn-filter:hover { background: #2563eb; }

/* ── SCROLLABLE ATTENDANCE GRID ── */
.grid-container {
    overflow-x: auto;
    width: 100%;
}

.attendance-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    min-width: 1200px;
}

.attendance-table th {
    background: #f8fafc;
    padding: 14px 10px;
    font-size: 11px;
    font-weight: 800;
    color: #475569;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
    border-right: 1px solid #f1f5f9;
}

.attendance-table th.employee-col {
    text-align: left;
    padding-left: 24px;
    position: sticky;
    left: 0;
    background: #f8fafc;
    z-index: 10;
    min-width: 250px;
    border-right: 2px solid #e2e8f0;
}

.attendance-table th.summary-col {
    min-width: 80px;
    background: #f8fafc;
    border-left: 2px solid #e2e8f0;
}

.attendance-table td {
    padding: 12px 10px;
    text-align: center;
    border-bottom: 1px solid #f1f5f9;
    border-right: 1px solid #f1f5f9;
    vertical-align: middle;
}

.attendance-table td.employee-col {
    text-align: left;
    padding-left: 24px;
    position: sticky;
    left: 0;
    background: #ffffff;
    z-index: 10;
    border-right: 2px solid #e2e8f0;
}

.attendance-table tr:hover td.employee-col {
    background: #fafafb;
}

.attendance-table tr:hover td {
    background: #fafafb;
}

.attendance-table td.summary-col {
    font-weight: 700;
    border-left: 2px solid #e2e8f0;
}

/* ── PREMIUM ATTENDANCE BUTTON TOGGLE ── */
.btn-attendance-toggle {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 800;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    outline: none;
    user-select: none;
}

.btn-attendance-toggle.is-present {
    background-color: #d1fae5;
    color: #065f46;
    border: 1.5px solid #10b981;
}

.btn-attendance-toggle.is-present:hover {
    background-color: #a7f3d0;
    transform: scale(1.1);
}

.btn-attendance-toggle.is-absent {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1.5px solid #f87171;
}

.btn-attendance-toggle.is-absent:hover {
    background-color: #fecaca;
    transform: scale(1.1);
}

.avatar-mini {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    object-fit: cover;
    margin-right: 10px;
}

.present-tally { color: #10b981; }
.absent-tally { color: #ef4444; }

.hrm-btn-save {
    background: #10b981;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    padding: 14px 30px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
    transition: all 0.2s;
}

.hrm-btn-save:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
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
            <h1>Attendance Sheets Log</h1>
            <p>Mark daily employee attendance check-ins. Unchecked boxes disburse as absent logs.</p>
        </div>
        
        {{-- Year / Month Selector --}}
        <form action="{{ route('admin.hrm.attendance.index') }}" method="GET" class="hrm-filter-form">
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
            <button type="submit" class="hrm-btn-filter">
                <i class="bi bi-funnel-fill me-1"></i> Filter Sheet
            </button>
        </form>
    </div>

    {{-- SHEET CARD --}}
    <div class="hrm-card">
        <div class="hrm-card-header">
            <h4 class="hrm-card-title">
                <i class="bi bi-calendar-check-fill"></i> Checklist Grid — {{ Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
            </h4>
            <div style="display: flex; gap: 16px; align-items: center; font-size: 13px; font-weight: 700;">
                <span style="display: inline-flex; align-items: center; gap: 6px;">
                    <span class="btn-attendance-toggle is-present" style="width: 22px; height: 22px; font-size: 9px; cursor: default;">P</span> Present
                </span>
                <span style="display: inline-flex; align-items: center; gap: 6px;">
                    <span class="btn-attendance-toggle is-absent" style="width: 22px; height: 22px; font-size: 9px; cursor: default;">A</span> Absent
                </span>
            </div>
        </div>

        <form action="{{ route('admin.hrm.attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="year" value="{{ $year }}">
            <input type="hidden" name="month" value="{{ $month }}">

            <div class="hrm-card-body">
                @if($employees->isEmpty())
                    <div style="text-align: center; padding: 60px 24px; color: #94a3b8;">
                        <i class="bi bi-people" style="font-size: 40px; display: block; margin-bottom: 12px;"></i>
                        No active employees registered to record attendance.
                    </div>
                @else
                    <div class="grid-container">
                        <table class="attendance-table">
                            <thead>
                                <tr>
                                    <th class="employee-col">Staff Member Name</th>
                                    {{-- Render calendar days --}}
                                    @for($day = 1; $day <= $daysInMonth; $day++)
                                        @php
                                            $dateObj = Carbon\Carbon::create($year, $month, $day);
                                            $isWeekend = $dateObj->isWeekend();
                                        @endphp
                                        <th style="{{ $isWeekend ? 'background: #fff1f2; color: #e11d48;' : '' }}">
                                            <div>{{ sprintf('%02d', $day) }}</div>
                                            <div style="font-size: 9px; margin-top: 2px; font-weight: 600; text-transform: uppercase;">{{ $dateObj->minDayName }}</div>
                                        </th>
                                    @endfor
                                    <th class="summary-col present-tally font-weight-bold" style="border-left: 2px solid #cbd5e1;">Pres.</th>
                                    <th class="summary-col absent-tally font-weight-bold">Abs.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                <tr data-employee-row="{{ $employee->id }}">
                                    <td class="employee-col">
                                        <div style="display: flex; align-items: center;">
                                            <img src="{{ $employee->getImageUrl('employee_image') }}" alt="" class="avatar-mini">
                                            <div>
                                                <div style="font-weight: 700; color: #1e293b; font-size: 14px;">{{ $employee->name }}</div>
                                                <div style="font-size: 11px; color: #64748b; font-weight: 500;">{{ $employee->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- Status toggles for each day of the month --}}
                                    @for($day = 1; $day <= $daysInMonth; $day++)
                                        @php
                                            $status = $attendanceGrid[$employee->id][$day] ?? null;
                                            $isPresent = ($status === 'present');
                                        @endphp
                                        <td>
                                            <input type="hidden" 
                                                   name="attendance[{{ $employee->id }}][{{ $day }}]" 
                                                   id="status-{{ $employee->id }}-{{ $day }}" 
                                                   value="{{ $isPresent ? 'present' : 'absent' }}"
                                                   class="d-day-input"
                                                   data-emp-id="{{ $employee->id }}">
                                            
                                            <button type="button" 
                                                    class="btn-attendance-toggle {{ $isPresent ? 'is-present' : 'is-absent' }}" 
                                                    id="btn-{{ $employee->id }}-{{ $day }}"
                                                    onclick="toggleStatus('{{ $employee->id }}', '{{ $day }}')">
                                                {{ $isPresent ? 'P' : 'A' }}
                                            </button>
                                        </td>
                                    @endfor
                                    {{-- Summaries calculated on page load --}}
                                    <td class="summary-col present-tally" id="p-count-{{ $employee->id }}" style="border-left: 2px solid #cbd5e1;">
                                        {{ $employeeHistory[$employee->id]['present'] }}
                                    </td>
                                    <td class="summary-col absent-tally" id="a-count-{{ $employee->id }}">
                                        {{ $employeeHistory[$employee->id]['absent'] }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            @if($employees->isNotEmpty())
                <div style="padding: 24px; border-top: 1px solid #f1f5f9; text-align: right; background: #fafafb;">
                    <button type="submit" class="hrm-btn-save">
                        <i class="bi bi-save-fill me-1"></i> Save Attendance Sheets
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>

<script>
function toggleStatus(empId, day) {
    const input = document.getElementById(`status-${empId}-${day}`);
    const btn = document.getElementById(`btn-${empId}-${day}`);
    
    if (input.value === 'present') {
        input.value = 'absent';
        btn.innerText = 'A';
        btn.classList.remove('is-present');
        btn.classList.add('is-absent');
    } else {
        input.value = 'present';
        btn.innerText = 'P';
        btn.classList.remove('is-absent');
        btn.classList.add('is-present');
    }
    
    updateTallies(empId);
}

function updateTallies(empId) {
    const daysInMonth = {{ $daysInMonth }};
    const empInputs = document.querySelectorAll(`.d-day-input[data-emp-id="${empId}"]`);
    let present = 0;
    
    empInputs.forEach(input => {
        if (input.value === 'present') {
            present++;
        }
    });
    
    let absent = daysInMonth - present;
    
    // Update UI elements with micro-animations
    const pEl = document.getElementById(`p-count-${empId}`);
    const aEl = document.getElementById(`a-count-${empId}`);
    
    pEl.innerText = present;
    aEl.innerText = absent;
    
    pEl.style.transition = "transform 0.15s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
    aEl.style.transition = "transform 0.15s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
    
    pEl.style.transform = "scale(1.2)";
    aEl.style.transform = "scale(1.2)";
    
    setTimeout(() => {
        pEl.style.transform = "scale(1)";
        aEl.style.transform = "scale(1)";
    }, 150);
}
</script>
@endsection
