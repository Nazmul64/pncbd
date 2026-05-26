@extends('admin.master')

@section('main-content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap');

.idcard-page {
    padding: 30px 24px;
    background: #f1f5f9;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ── PAGE HEADER ── */
.idcard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 16px;
}
.idcard-header h1 {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}
.idcard-header h1 .hd-icon {
    width: 46px; height: 46px;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 22px;
    box-shadow: 0 4px 14px rgba(59,130,246,0.3);
}
.idcard-header p { margin: 5px 0 0; font-size: 13.5px; color: #64748b; font-weight: 500; }

/* ── MAIN GRID ── */
.idcard-layout {
    display: grid;
    grid-template-columns: 360px 1fr;
    gap: 28px;
    align-items: start;
}
@media(max-width:1100px){ .idcard-layout { grid-template-columns: 1fr; } }

/* ── SELECTOR PANEL ── */
.idcard-panel {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 24px rgba(0,0,0,0.04);
    overflow: hidden;
}
.idcard-panel-header {
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 10px;
}
.idcard-panel-header i { color: #3b82f6; font-size: 18px; }
.idcard-panel-body { padding: 22px; }

.idcard-form-group { margin-bottom: 18px; }
.idcard-label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 7px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.idcard-label span { color: #ef4444; }
.idcard-control {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    color: #1e293b;
    font-family: inherit;
    transition: border 0.2s, box-shadow 0.2s;
    outline: none;
    background: #fff;
}
.idcard-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}
select.idcard-control { cursor: pointer; }

/* Color theme selector */
.theme-swatches {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 6px;
}
.theme-swatch {
    width: 36px; height: 36px;
    border-radius: 10px;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.2s;
    position: relative;
}
.theme-swatch.selected { border-color: #0f172a; transform: scale(1.15); }
.theme-swatch:hover { transform: scale(1.1); }

/* Download button */
.btn-download {
    width: 100%;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: #fff;
    border: none;
    padding: 13px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.25s;
    box-shadow: 0 4px 16px rgba(59,130,246,0.3);
    margin-top: 10px;
}
.btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(59,130,246,0.4);
}
.btn-download:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.btn-download:disabled:hover { box-shadow: none; transform: none; }

/* ── PREVIEW AREA ── */
.idcard-preview-wrap {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 24px rgba(0,0,0,0.04);
    padding: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 24px;
}
.preview-label {
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    align-self: flex-start;
    display: flex;
    align-items: center;
    gap: 6px;
}
.preview-label::before {
    content: '';
    width: 3px; height: 16px;
    background: #3b82f6;
    border-radius: 4px;
}

/* ── THE ACTUAL ID CARD ── */
#id-card-canvas-wrap {
    display: flex;
    gap: 28px;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
}

.id-card {
    width: 320px;
    height: 500px;
    border-radius: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.08);
    font-family: 'Plus Jakarta Sans', sans-serif;
    flex-shrink: 0;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    box-sizing: border-box;
}

/* Punch hole slot */
.punch-slot-container {
    width: 100%;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
}
.punch-slot {
    width: 48px;
    height: 10px;
    background: #cbd5e1;
    border-radius: 5px;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.15);
}

/* Brand Header */
.card-brand-header {
    margin-top: 35px;
    padding: 0 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 5;
    position: relative;
}
.card-brand-logo-wrap {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
    border: 1.5px solid #f1f5f9;
}
.card-brand-logo {
    width: 28px;
    height: 28px;
    object-fit: contain;
}
.card-brand-logo-placeholder {
    font-size: 16px;
}
.card-brand-text-wrap {
    display: flex;
    flex-direction: column;
}
.card-brand-name {
    font-size: 14px;
    font-weight: 800;
    color: #1e3a8a;
    letter-spacing: -0.3px;
    text-transform: uppercase;
}
.card-brand-tagline {
    font-size: 9px;
    font-weight: 700;
    color: #94a3b8;
    letter-spacing: 0.5px;
}

/* Vector Geometric Background SVG (100% stable in all PDF/Print/Downloads) */
.card-bg-svg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    pointer-events: none;
}

/* Photo Container & Frame */
.card-photo-container {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    position: relative;
    z-index: 5;
}
.card-photo-frame {
    width: 110px;
    height: 110px;
    border: 4px solid #3b82f6;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(59,130,246,0.3);
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card-photo-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Employee metadata (Name & Desig) */
.card-emp-meta {
    margin-top: 10px;
    text-align: center;
    z-index: 5;
    position: relative;
    padding: 0 15px;
}
.card-emp-name {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.3px;
    text-transform: uppercase;
}
.card-emp-designation {
    font-size: 10px;
    font-weight: 700;
    color: #3b82f6;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    margin-top: 2px;
}

/* Details list */
.card-details-list {
    margin-top: 15px;
    padding: 0 35px;
    z-index: 5;
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 7px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.card-detail-item {
    display: flex;
    align-items: center;
    font-size: 11.5px;
    font-weight: 600;
    line-height: 1.4;
}
.card-detail-label {
    width: 78px;
    color: #64748b;
    font-weight: 600;
    letter-spacing: 0.2px;
    text-align: left;
    flex-shrink: 0;
}
.card-detail-separator {
    width: 12px;
    color: #94a3b8;
    font-weight: 700;
    text-align: center;
    flex-shrink: 0;
}
.card-detail-value {
    color: #0f172a;
    font-weight: 700;
    text-align: left;
    word-break: break-all;
}

/* QR Code */
.card-qr-container {
    margin-top: 12px;
    display: flex;
    justify-content: center;
    z-index: 5;
    position: relative;
}
.card-qr-box {
    padding: 4px;
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.card-qr-box div {
    display: block;
}

/* Back QR (Larger) */
.card-qr-container-back {
    margin-top: 22px;
    display: flex;
    justify-content: center;
    z-index: 5;
    position: relative;
}
.card-qr-box-back {
    padding: 6px;
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

/* Terms & Conditions list */
.card-terms-list {
    margin: 15px 45px 0;
    padding: 0;
    list-style: none;
    z-index: 5;
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.card-terms-list li {
    font-size: 8px;
    color: #64748b;
    font-weight: 500;
    line-height: 1.25;
    position: relative;
    padding-left: 10px;
    text-align: left;
}
.card-terms-list li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: #3b82f6;
    font-weight: 800;
}

/* Footers */
.card-footer-website {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 34px;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.8px;
    z-index: 5;
    text-transform: uppercase;
}
.card-footer-text {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 34px;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.5px;
    z-index: 5;
    text-transform: uppercase;
}

/* Loading state */
.download-loading { display: none; }

/* Employee select search */
.emp-search-wrap { position: relative; }
.emp-search-list {
    position: absolute;
    z-index: 999;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    max-height: 220px;
    overflow-y: auto;
    width: 100%;
    display: none;
}
.emp-search-list.show { display: block; }
.emp-search-item {
    padding: 10px 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s;
    font-size: 13.5px;
    font-weight: 600;
    color: #1e293b;
}
.emp-search-item:last-child { border-bottom: none; }
.emp-search-item:hover { background: #f1f5f9; }
.emp-search-item img {
    width: 34px; height: 34px;
    border-radius: 8px;
    object-fit: cover;
    flex-shrink: 0;
}
.emp-search-item small {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
    display: block;
}

/* From employees list — ID Card badge button */
.btn-id-card {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: #fff;
    border: none;
    padding: 5px 11px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    transition: all 0.2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.btn-id-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59,130,246,0.35);
    color: #fff;
}
</style>

<div class="idcard-page">
    <div class="idcard-header">
        <div>
            <h1>
                <span class="hd-icon"><i class="bi bi-person-badge-fill"></i></span>
                আইডি কার্ড জেনারেটর
            </h1>
            <p>কর্মীর তথ্য নির্বাচন করুন এবং প্রফেশনাল আইডি কার্ড ডাউনলোড করুন</p>
        </div>
        <a href="{{ request()->routeIs('admin.emplee.*') ? route('admin.emplee.dashboard') : route('admin.hrm.employees.index') }}" class="btn btn-outline-secondary" style="border-radius: 10px; font-weight: 700; padding: 10px 20px;">
            <i class="bi bi-arrow-left me-2"></i> {{ request()->routeIs('admin.emplee.*') ? 'ড্যাশবোর্ডে ফিরুন' : 'কর্মী তালিকায় ফিরুন' }}
        </a>
    </div>

    <div class="idcard-layout">

        {{-- LEFT: Controls --}}
        <div>
            <div class="idcard-panel">
                <div class="idcard-panel-header">
                    <i class="bi bi-sliders2"></i> কার্ড কাস্টমাইজ করুন
                </div>
                <div class="idcard-panel-body">

                    {{-- Employee Selector --}}
                    <div class="idcard-form-group">
                        <label class="idcard-label">কর্মী নির্বাচন করুন <span>*</span></label>
                        <div class="emp-search-wrap">
                            <input type="text" id="empSearchInput" class="idcard-control"
                                   placeholder="নাম বা ফোন দিয়ে খুঁজুন..." autocomplete="off">
                            <div class="emp-search-list" id="empSearchList">
                                @foreach($employees as $emp)
                                <div class="emp-search-item" data-employee="{{ json_encode([
                                    'id'          => $emp->id,
                                    'name'        => $emp->name,
                                    'designation' => $emp->designation ?? 'Staff',
                                    'phone'       => $emp->phone,
                                    'email'       => $emp->email ?? '—',
                                    'blood_group' => $emp->blood_group ?? '—',
                                    'nid'         => $emp->nid_number,
                                    'address'     => $emp->address ?? '',
                                    'district'    => $emp->district ?? '',
                                    'join_date'   => $emp->join_date ? $emp->join_date->format('d M Y') : date('d M Y'),
                                    'expire_date' => $emp->expire_date ? $emp->expire_date->format('d M Y') : '—',
                                    'image'       => $emp->employee_image ? asset($emp->employee_image) : 'https://ui-avatars.com/api/?name='.urlencode($emp->name).'&background=1e40af&color=fff&size=200',
                                    'status'      => $emp->status,
                                ]) }}">
                                    <img src="{{ $emp->getImageUrl('employee_image') }}" alt="{{ $emp->name }}">
                                    <div>
                                        {{ $emp->name }}
                                        <small>{{ $emp->designation ?? 'No designation' }} · {{ $emp->phone }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Manual Input Fields for real-time creation --}}
                    <div style="margin: 16px 0; padding: 16px; background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 12px;">
                        <div style="font-weight: 800; font-size: 13.5px; color: #1e3a8a; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                            <i class="bi bi-pencil-square" style="color: #3b82f6; font-size: 16px;"></i>
                            কার্ড ডাটা এন্ট্রি (ম্যানুয়াল ইনপুট)
                        </div>
                        
                        {{-- Name --}}
                        <div class="idcard-form-group" style="margin-bottom: 10px;">
                            <label class="idcard-label" style="font-size: 11.5px; margin-bottom: 4px; color: #1e3a8a;">স্টাফ কর্মী নাম</label>
                            <input type="text" id="manualName" class="idcard-control" style="padding: 8px 12px; font-size: 13px; border: 1px solid #bfdbfe;" placeholder="যেমন: Nazmul Hossain">
                        </div>

                        {{-- Designation --}}
                        <div class="idcard-form-group" style="margin-bottom: 10px;">
                            <label class="idcard-label" style="font-size: 11.5px; margin-bottom: 4px; color: #1e3a8a;">পদবী (Designation)</label>
                            <input type="text" id="manualDesignation" class="idcard-control" style="padding: 8px 12px; font-size: 13px; border: 1px solid #bfdbfe;" placeholder="যেমন: Creative Designer">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                            {{-- ID No --}}
                            <div class="idcard-form-group" style="margin-bottom: 0;">
                                <label class="idcard-label" style="font-size: 11.5px; margin-bottom: 4px; color: #1e3a8a;">আইডি নং</label>
                                <input type="text" id="manualId" class="idcard-control" style="padding: 8px 12px; font-size: 13px; border: 1px solid #bfdbfe;" placeholder="যেমন: 00001">
                            </div>
                            {{-- Blood Group --}}
                            <div class="idcard-form-group" style="margin-bottom: 0;">
                                <label class="idcard-label" style="font-size: 11.5px; margin-bottom: 4px; color: #1e3a8a;">রক্তের গ্রুপ</label>
                                <input type="text" id="manualBlood" class="idcard-control" style="padding: 8px 12px; font-size: 13px; border: 1px solid #bfdbfe;" placeholder="যেমন: AB">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                            {{-- Phone --}}
                            <div class="idcard-form-group" style="margin-bottom: 0;">
                                <label class="idcard-label" style="font-size: 11.5px; margin-bottom: 4px; color: #1e3a8a;">ফোন নম্বর</label>
                                <input type="text" id="manualPhone" class="idcard-control" style="padding: 8px 12px; font-size: 13px; border: 1px solid #bfdbfe;" placeholder="যেমন: 017xxxxxxxx">
                            </div>
                            {{-- Email --}}
                            <div class="idcard-form-group" style="margin-bottom: 0;">
                                <label class="idcard-label" style="font-size: 11.5px; margin-bottom: 4px; color: #1e3a8a;">ইমেইল</label>
                                <input type="text" id="manualEmail" class="idcard-control" style="padding: 8px 12px; font-size: 13px; border: 1px solid #bfdbfe;" placeholder="যেমন: mail@domain.com">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                            {{-- Join Date --}}
                            <div class="idcard-form-group" style="margin-bottom: 0;">
                                <label class="idcard-label" style="font-size: 11.5px; margin-bottom: 4px; color: #1e3a8a;">যোগদানের তারিখ</label>
                                <input type="text" id="manualJoinDate" class="idcard-control" style="padding: 8px 12px; font-size: 13px; border: 1px solid #bfdbfe;" placeholder="যেমন: 26 May 2026">
                            </div>
                            {{-- Expire Date --}}
                            <div class="idcard-form-group" style="margin-bottom: 0;">
                                <label class="idcard-label" style="font-size: 11.5px; margin-bottom: 4px; color: #1e3a8a;">মেয়াদ শেষ</label>
                                <input type="text" id="manualExpireDate" class="idcard-control" style="padding: 8px 12px; font-size: 13px; border: 1px solid #bfdbfe;" placeholder="যেমন: 25 May 2029">
                            </div>
                        </div>

                        {{-- Photo Upload --}}
                        <div class="idcard-form-group" style="margin-bottom: 0;">
                            <label class="idcard-label" style="font-size: 11.5px; margin-bottom: 4px; color: #1e3a8a;">স্টাফ ফটো আপলোড</label>
                            <input type="file" id="manualPhoto" class="idcard-control" style="padding: 6px 12px; font-size: 12px; border: 1px dashed #3b82f6; background: #fff;" accept="image/*">
                        </div>
                    </div>

                    {{-- Color Theme --}}
                    <div class="idcard-form-group">
                        <label class="idcard-label">রঙের থিম নির্বাচন করুন</label>
                        <div class="theme-swatches">
                            <div class="theme-swatch selected" data-primary="#1e40af" data-secondary="#3b82f6" style="background: linear-gradient(135deg,#1e40af,#3b82f6);" title="Royal Blue"></div>
                            <div class="theme-swatch" data-primary="#064e3b" data-secondary="#10b981" style="background: linear-gradient(135deg,#064e3b,#10b981);" title="Emerald"></div>
                            <div class="theme-swatch" data-primary="#7c2d12" data-secondary="#ef4444" style="background: linear-gradient(135deg,#7c2d12,#ef4444);" title="Ruby Red"></div>
                            <div class="theme-swatch" data-primary="#4c1d95" data-secondary="#8b5cf6" style="background: linear-gradient(135deg,#4c1d95,#8b5cf6);" title="Deep Purple"></div>
                            <div class="theme-swatch" data-primary="#0c4a6e" data-secondary="#0ea5e9" style="background: linear-gradient(135deg,#0c4a6e,#0ea5e9);" title="Ocean Blue"></div>
                            <div class="theme-swatch" data-primary="#1c1917" data-secondary="#57534e" style="background: linear-gradient(135deg,#1c1917,#57534e);" title="Carbon"></div>
                        </div>
                    </div>

                    {{-- Shape Style Selector --}}
                    <div class="idcard-form-group">
                        <label class="idcard-label">কার্ডের ব্যাকগ্রাউন্ড শেপ (Shape Style)</label>
                        <select id="shapeStyleSelect" class="idcard-control">
                            <option value="chevron">Modern Chevron (মডার্ন শেভরণ - সেম টু সেম)</option>
                            <option value="curves">Elegant Curves (এলিজেন্ট কার্ভস)</option>
                            <option value="diagonal">Modern Diagonal (মডার্ন ডায়াগনাল)</option>
                            <option value="minimalist">Minimalist Accents (মিনিমালিস্ট বর্ডার)</option>
                        </select>
                    </div>

                    {{-- Company Name override --}}
                    <div class="idcard-form-group">
                        <label class="idcard-label">প্রতিষ্ঠানের নাম</label>
                        <input type="text" id="overrideCompany" class="idcard-control"
                               value="{{ $gs->site_name ?? config('app.name') }}"
                               placeholder="Company Name">
                    </div>

                    {{-- Website --}}
                    <div class="idcard-form-group">
                        <label class="idcard-label">ওয়েবসাইট</label>
                        <input type="text" id="overrideWebsite" class="idcard-control"
                               value="{{ $gs->site_url ?? url('/') }}"
                               placeholder="www.yoursite.com">
                    </div>

                    <hr style="margin: 4px 0 16px; border-color: #f1f5f9;">

                    {{-- Preview note --}}
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 12px 14px; font-size: 13px; color: #1d4ed8; font-weight: 600; margin-bottom: 16px;">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        কর্মী নির্বাচন করলেই কার্ড প্রিভিউ আপডেট হবে।
                    </div>

                    <button class="btn-download" id="downloadFrontBtn" onclick="downloadCard('front')" disabled>
                        <span class="download-ready"><i class="bi bi-download me-1"></i> Front কার্ড ডাউনলোড</span>
                        <span class="download-loading">⏳ তৈরি হচ্ছে...</span>
                    </button>
                    <button class="btn-download" id="downloadBackBtn" onclick="downloadCard('back')" disabled style="margin-top: 8px; background: linear-gradient(135deg, #064e3b, #10b981); box-shadow: 0 4px 16px rgba(16,185,129,0.3);">
                        <span class="download-ready"><i class="bi bi-download me-1"></i> Back কার্ড ডাউনলোড</span>
                        <span class="download-loading">⏳ তৈরি হচ্ছে...</span>
                    </button>
                    <button class="btn-download" id="downloadBothBtn" onclick="downloadBothCards()" disabled style="margin-top: 8px; background: linear-gradient(135deg, #4c1d95, #8b5cf6); box-shadow: 0 4px 16px rgba(139,92,246,0.3);">
                        <span class="download-ready"><i class="bi bi-file-earmark-image me-1"></i> উভয় কার্ড ডাউনলোড</span>
                        <span class="download-loading">⏳ তৈরি হচ্ছে...</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- RIGHT: Preview --}}
        <div class="idcard-preview-wrap">
            <div class="preview-label">লাইভ প্রিভিউ</div>
            <div id="id-card-canvas-wrap">

                {{-- ── FRONT ── --}}
                <div style="text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Front</div>
                    <div class="id-card card-front" id="idCardFront">
                        <!-- Punch slot -->
                        <div class="punch-slot-container">
                            <div class="punch-slot"></div>
                        </div>

                        <!-- Brand Header (Centered Company Name Only - No Logo) -->
                        <div class="card-brand-header" style="justify-content: center; width: 100%; display: flex; align-items: center; min-height: 48px; position: relative; z-index: 10;">
                            <div class="card-brand-text-wrap" style="text-align: center; width: 100%;">
                                <div class="card-brand-name" id="cardCompanyFront" style="font-size: 17px; font-weight: 800; color: #1e3a8a; text-align: center; text-transform: uppercase; letter-spacing: 0.5px;">{{ $gs->site_name ?? config('app.name') }}</div>
                                <div class="card-brand-tagline" style="font-size: 9px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; text-align: center; margin-top: 2px;">Employee Identity Card</div>
                            </div>
                        </div>

                        <!-- Vector Background SVG (100% PDF/Print Stable) -->
                        <svg class="card-bg-svg" viewBox="0 0 320 500">
                            <defs>
                                <linearGradient id="svgGradLeft1_front" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" class="svg-stop-primary" stop-color="#1e40af" />
                                    <stop offset="100%" class="svg-stop-secondary" stop-color="#3b82f6" />
                                </linearGradient>
                                <linearGradient id="svgGradLeft2_front" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" class="svg-stop-secondary" stop-color="#3b82f6" stop-opacity="0.6" />
                                    <stop offset="100%" class="svg-stop-primary" stop-color="#1e40af" stop-opacity="0.6" />
                                </linearGradient>
                                <linearGradient id="svgGradRight1_front" x1="100%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" class="svg-stop-primary" stop-color="#1e40af" />
                                    <stop offset="100%" class="svg-stop-secondary" stop-color="#3b82f6" />
                                </linearGradient>
                                <linearGradient id="svgGradRight2_front" x1="100%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" class="svg-stop-secondary" stop-color="#3b82f6" stop-opacity="0.6" />
                                    <stop offset="100%" class="svg-stop-primary" stop-color="#1e40af" stop-opacity="0.6" />
                                </linearGradient>
                            </defs>
                            <polygon points="0,0 65,0 25,320 0,290" fill="url(#svgGradLeft2_front)" />
                            <polygon points="0,0 45,0 12,260 0,230" fill="url(#svgGradLeft1_front)" />
                            <polygon points="320,0 255,0 295,320 320,290" fill="url(#svgGradRight2_front)" />
                            <polygon points="320,0 275,0 308,260 320,230" fill="url(#svgGradRight1_front)" />
                        </svg>

                        <!-- Photo Container -->
                        <div class="card-photo-container">
                            <div class="card-photo-frame">
                                <img src="https://ui-avatars.com/api/?name=Employee&background=1e40af&color=fff&size=200" id="cardPhoto" alt="Employee Photo" crossorigin="anonymous">
                            </div>
                        </div>

                        <!-- Name & Designation -->
                        <div class="card-emp-meta">
                            <div class="card-emp-name" id="cardName">কর্মী নির্বাচন করুন</div>
                            <div class="card-emp-designation" id="cardDesignation">DESIGNATION</div>
                        </div>

                        <!-- Details List (Sentence Case & Aligned Grid) -->
                        <div class="card-details-list">
                            <div class="card-detail-item">
                                <span class="card-detail-label">ID No.</span>
                                <span class="card-detail-separator">:</span>
                                <span class="card-detail-value" id="cardEmpId">#00000</span>
                            </div>
                            <div class="card-detail-item">
                                <span class="card-detail-label">Blood Group</span>
                                <span class="card-detail-separator">:</span>
                                <span class="card-detail-value" id="cardBlood">—</span>
                            </div>
                            <div class="card-detail-item">
                                <span class="card-detail-label">Email</span>
                                <span class="card-detail-separator">:</span>
                                <span class="card-detail-value" id="cardEmail">—</span>
                            </div>
                            <div class="card-detail-item">
                                <span class="card-detail-label">Phone</span>
                                <span class="card-detail-separator">:</span>
                                <span class="card-detail-value" id="cardPhone">017xxxxxxxx</span>
                            </div>
                        </div>

                        <!-- No QR Code on Front card as per design (it is on the Back card) -->

                        <!-- Footer Website Bar -->
                        <div class="card-footer-website" id="cardFooterFront">
                            <span id="cardWebsiteFront">www.yoursite.com</span>
                        </div>
                    </div>
                </div>

                {{-- ── BACK ── --}}
                <div style="text-align: center;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Back</div>
                    <div class="id-card card-back" id="idCardBack">
                        <!-- Punch slot -->
                        <div class="punch-slot-container">
                            <div class="punch-slot"></div>
                        </div>

                        <!-- Brand Header (Centered Company Name Only - No Logo) -->
                        <div class="card-brand-header" style="justify-content: center; width: 100%; display: flex; align-items: center; min-height: 48px; position: relative; z-index: 10;">
                            <div class="card-brand-text-wrap" style="text-align: center; width: 100%;">
                                <div class="card-brand-name" id="cardCompanyBack" style="font-size: 17px; font-weight: 800; color: #1e3a8a; text-align: center; text-transform: uppercase; letter-spacing: 0.5px;">{{ $gs->site_name ?? config('app.name') }}</div>
                                <div class="card-brand-tagline" style="font-size: 9px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; text-align: center; margin-top: 2px;">Official Identity Card</div>
                            </div>
                        </div>

                        <!-- Vector Background SVG (100% PDF/Print Stable) -->
                        <svg class="card-bg-svg" viewBox="0 0 320 500" style="opacity: 0.7;">
                            <defs>
                                <linearGradient id="svgGradLeft1_back" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" class="svg-stop-primary" stop-color="#1e40af" />
                                    <stop offset="100%" class="svg-stop-secondary" stop-color="#3b82f6" />
                                </linearGradient>
                                <linearGradient id="svgGradLeft2_back" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" class="svg-stop-secondary" stop-color="#3b82f6" stop-opacity="0.6" />
                                    <stop offset="100%" class="svg-stop-primary" stop-color="#1e40af" stop-opacity="0.6" />
                                </linearGradient>
                                <linearGradient id="svgGradRight1_back" x1="100%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" class="svg-stop-primary" stop-color="#1e40af" />
                                    <stop offset="100%" class="svg-stop-secondary" stop-color="#3b82f6" />
                                </linearGradient>
                                <linearGradient id="svgGradRight2_back" x1="100%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" class="svg-stop-secondary" stop-color="#3b82f6" stop-opacity="0.6" />
                                    <stop offset="100%" class="svg-stop-primary" stop-color="#1e40af" stop-opacity="0.6" />
                                </linearGradient>
                            </defs>
                            <polygon points="0,0 65,0 25,320 0,290" fill="url(#svgGradLeft2_back)" />
                            <polygon points="0,0 45,0 12,260 0,230" fill="url(#svgGradLeft1_back)" />
                            <polygon points="320,0 255,0 295,320 320,290" fill="url(#svgGradRight2_back)" />
                            <polygon points="320,0 275,0 308,260 320,230" fill="url(#svgGradRight1_back)" />
                        </svg>

                        <!-- QR Code Center (Large) -->
                        <div class="card-qr-container-back">
                            <div class="card-qr-box-back" id="qrBack"></div>
                        </div>

                        <!-- Name & Designation -->
                        <div class="card-emp-meta" style="margin-top: 10px;">
                            <div class="card-emp-name" id="backName">কর্মী নাম</div>
                            <div class="card-emp-designation" id="backDesig">DESIGNATION</div>
                        </div>

                        <!-- Details List (Sentence Case & Aligned Grid) -->
                        <div class="card-details-list" style="margin-top: 15px;">
                            <div class="card-detail-item">
                                <span class="card-detail-label">Joined Date</span>
                                <span class="card-detail-separator">:</span>
                                <span class="card-detail-value" id="backJoinDate">MM/DD/YEAR</span>
                            </div>
                            <div class="card-detail-item">
                                <span class="card-detail-label">Expire Date</span>
                                <span class="card-detail-separator">:</span>
                                <span class="card-detail-value" id="backExpireDate">MM/DD/YEAR</span>
                            </div>
                            <div class="card-detail-item">
                                <span class="card-detail-label">Emp ID</span>
                                <span class="card-detail-separator">:</span>
                                <span class="card-detail-value" id="backEmpId">00-0000</span>
                            </div>
                        </div>

                        <!-- Terms & Conditions (Bulleted List) -->
                        <ul class="card-terms-list">
                            <li>This card is official property and must be returned upon termination.</li>
                            <li>If found, please return to the nearest company office or mailbox.</li>
                        </ul>

                        <!-- Footer Text Bar -->
                        <div class="card-footer-text" id="cardFooterBack">
                            <span> UBS LOAN MANAGEMENT SYSTEM </span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="font-size: 12.5px; color: #94a3b8; text-align: center; font-weight: 500; margin-top: 8px;">
                <i class="bi bi-info-circle me-1"></i>
                কার্ড PNG ফরম্যাটে ডাউনলোড হবে — প্রিন্ট রেডি
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
// ─── State ───────────────────────────────────────────────────────
let currentEmployee = null;
let primaryColor   = '#1e40af';
let secondaryColor = '#3b82f6';
let qrFrontObj = null;
let qrBackObj  = null;

// ─── Init QR placeholders ────────────────────────────────────────
function initQR() {
    const qrBackEl = document.getElementById('qrBack');
    if (qrBackEl) {
        qrBackObj = new QRCode(qrBackEl, {
            text: window.location.origin,
            width: 80, height: 80,
            colorDark: '#0f172a', colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });
    }
}

function updateQR(text) {
    const qrBackEl = document.getElementById('qrBack');
    if (qrBackEl) {
        qrBackEl.innerHTML = '';
        new QRCode(qrBackEl, {
            text: text || window.location.origin,
            width: 80, height: 80,
            colorDark: '#0f172a', colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });
    }
}

// ─── Apply Theme ─────────────────────────────────────────────────
function applyTheme(p, s) {
    primaryColor   = p;
    secondaryColor = s;
    const grad = 'linear-gradient(135deg,' + p + ',' + s + ')';
    
    // Update footers
    const footers = ['cardFooterFront', 'cardFooterBack'];
    footers.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.background = grad;
    });
    
    // Update employee photo frame border and designation color
    document.querySelectorAll('.card-photo-frame').forEach(el => {
        el.style.borderColor = s;
    });
    document.querySelectorAll('.card-emp-designation').forEach(el => {
        el.style.color = s;
    });
    
    // Update SVG gradient stops
    document.querySelectorAll('.svg-stop-primary').forEach(el => {
        el.setAttribute('stop-color', p);
    });
    document.querySelectorAll('.svg-stop-secondary').forEach(el => {
        el.setAttribute('stop-color', s);
    });
    
    // Update company text color
    document.querySelectorAll('.card-brand-name').forEach(el => {
        el.style.color = p;
    });
    
    // Update download buttons
    document.getElementById('downloadFrontBtn').style.background = grad;
}

// ─── Populate Card ────────────────────────────────────────────────
function populateCard(emp) {
    currentEmployee = emp;
    
    // Pre-fill manual inputs with database details
    document.getElementById('manualName').value = emp.name;
    document.getElementById('manualDesignation').value = emp.designation || 'Staff';
    document.getElementById('manualId').value = String(emp.id).padStart(5, '0');
    document.getElementById('manualBlood').value = emp.blood_group && emp.blood_group !== '—' ? emp.blood_group : '';
    document.getElementById('manualEmail').value = emp.email && emp.email !== '—' ? emp.email : '';
    document.getElementById('manualPhone').value = emp.phone || '';
    document.getElementById('manualJoinDate').value = emp.join_date && emp.join_date !== '—' ? emp.join_date : '';
    document.getElementById('manualExpireDate').value = emp.expire_date && emp.expire_date !== '—' ? emp.expire_date : '';

    // Front
    set('cardName', emp.name);
    set('cardDesignation', emp.designation || 'Staff');
    set('cardPhone', emp.phone);
    set('cardBlood', emp.blood_group || '—');
    set('cardEmail', emp.email || '—');
    set('cardEmpId', '#' + String(emp.id).padStart(5, '0'));

    // Back
    set('backName', emp.name);
    set('backDesig', emp.designation || 'Staff');
    set('backJoinDate', emp.join_date || '—');
    set('backExpireDate', emp.expire_date || '—');
    set('backEmpId', '#' + String(emp.id).padStart(5, '0'));

    // Company / Website
    const company = document.getElementById('overrideCompany').value || 'Company';
    const website = document.getElementById('overrideWebsite').value || 'www.site.com';
    set('cardCompanyFront', company);
    set('cardCompanyBack', company);
    set('cardWebsiteFront', website);

    // Photo
    const photoEl = document.getElementById('cardPhoto');
    photoEl.crossOrigin = 'anonymous';
    photoEl.src = emp.image;

    // QR — encode employee info as JSON text
    const qrText = JSON.stringify({
        id: emp.id,
        name: emp.name,
        designation: emp.designation,
        phone: emp.phone,
        email: emp.email,
        company: company
    });
    updateQR(qrText);

    // Enable download
    ['downloadFrontBtn','downloadBackBtn','downloadBothBtn'].forEach(function(id) {
        document.getElementById(id).disabled = false;
    });

    // Automatically upload generated card images to the server in public/uploads/employeecard/
    setTimeout(() => {
        uploadCardToServer('front');
        uploadCardToServer('back');
    }, 1000);
}

function set(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val;
}

// ─── Upload Card to Server via AJAX ──────────────────────────────
async function uploadCardToServer(side) {
    if (!currentEmployee) return;
    const elId = side === 'front' ? 'idCardFront' : 'idCardBack';
    const el = document.getElementById(elId);

    try {
        const canvas = await html2canvas(el, {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: null,
            logging: false,
        });
        const dataUrl = canvas.toDataURL('image/png');

        const uploadUrl = '{{ request()->routeIs("admin.emplee.*") ? route("admin.emplee.id-card.upload") : route("admin.hrm.employees.id-card.upload") }}';
        await fetch(uploadUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                employee_id: currentEmployee.id,
                side: side,
                image: dataUrl
            })
        });
    } catch(e) {
        console.error('AJAX Card Upload failed for ' + side + ':', e);
    }
}

// ─── Download Card ────────────────────────────────────────────────
async function downloadCard(side) {
    const elId = side === 'front' ? 'idCardFront' : 'idCardBack';
    const btnId = side === 'front' ? 'downloadFrontBtn' : 'downloadBackBtn';
    const el = document.getElementById(elId);
    const btn = document.getElementById(btnId);
    const name = currentEmployee ? currentEmployee.name.replace(/\s+/,'_') : 'employee';

    btn.disabled = true;
    btn.querySelector('.download-ready').style.display = 'none';
    btn.querySelector('.download-loading').style.display = 'inline';

    try {
        const canvas = await html2canvas(el, {
            scale: 3,
            useCORS: true,
            allowTaint: true,
            backgroundColor: null,
            logging: false,
        });
        const link = document.createElement('a');
        link.download = name + '_id_card_' + side + '.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
        
        // Also ensure it is uploaded
        await uploadCardToServer(side);
    } catch(e) {
        alert('ডাউনলোড ব্যর্থ হয়েছে। পুনরায় চেষ্টা করুন।');
        console.error(e);
    }

    btn.disabled = false;
    btn.querySelector('.download-ready').style.display = 'inline';
    btn.querySelector('.download-loading').style.display = 'none';
}

async function downloadBothCards() {
    const btn = document.getElementById('downloadBothBtn');
    btn.disabled = true;
    btn.querySelector('.download-ready').style.display = 'none';
    btn.querySelector('.download-loading').style.display = 'inline';

    await downloadCard('front');
    await new Promise(r => setTimeout(r, 600));
    await downloadCard('back');

    btn.disabled = false;
    btn.querySelector('.download-ready').style.display = 'inline';
    btn.querySelector('.download-loading').style.display = 'none';
}

// ─── Employee Search ──────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    initQR();
    applyTheme(primaryColor, secondaryColor);

    const inp = document.getElementById('empSearchInput');
    const list = document.getElementById('empSearchList');
    const items = Array.from(list.querySelectorAll('.emp-search-item'));

    inp.addEventListener('focus', function() {
        list.classList.add('show');
    });

    inp.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        list.classList.add('show');
        items.forEach(function(item) {
            const txt = item.textContent.toLowerCase();
            item.style.display = txt.includes(q) ? '' : 'none';
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.emp-search-wrap')) {
            list.classList.remove('show');
        }
    });

    items.forEach(function(item) {
        item.addEventListener('click', function() {
            const emp = JSON.parse(this.getAttribute('data-employee'));
            inp.value = emp.name + ' — ' + (emp.designation || 'Staff');
            list.classList.remove('show');
            populateCard(emp);
        });
    });

    // Theme swatches
    document.querySelectorAll('.theme-swatch').forEach(function(sw) {
        sw.addEventListener('click', function() {
            document.querySelectorAll('.theme-swatch').forEach(s => s.classList.remove('selected'));
            this.classList.add('selected');
            applyTheme(this.dataset.primary, this.dataset.secondary);
        });
    });

    // Company / website live update
    document.getElementById('overrideCompany').addEventListener('input', function() {
        set('cardCompanyFront', this.value);
        set('cardCompanyBack', this.value);
    });
    document.getElementById('overrideWebsite').addEventListener('input', function() {
        set('cardWebsiteFront', this.value);
    });

    // --- MANUAL INPUT REAL-TIME BINDINGS ---
    function bindManualInput(inputId, elementId, defaultValue) {
        document.getElementById(inputId).addEventListener('input', function() {
            const val = this.value.trim() || defaultValue;
            set(elementId, val);
            
            // Enable download buttons if a name is input manually
            if (inputId === 'manualName') {
                set('backName', val);
                ['downloadFrontBtn','downloadBackBtn','downloadBothBtn'].forEach(function(id) {
                    document.getElementById(id).disabled = !val || val === defaultValue;
                });
            }
            if (inputId === 'manualDesignation') {
                set('backDesig', val);
            }
        });
    }

    bindManualInput('manualName', 'cardName', 'কর্মী নাম');
    bindManualInput('manualDesignation', 'cardDesignation', 'DESIGNATION');
    
    document.getElementById('manualId').addEventListener('input', function() {
        const val = this.value.trim() || '00000';
        const formatted = val.startsWith('#') ? val : '#' + val;
        set('cardEmpId', formatted);
        set('backEmpId', formatted);
    });
    
    bindManualInput('manualBlood', 'cardBlood', '—');
    bindManualInput('manualEmail', 'cardEmail', '—');
    bindManualInput('manualPhone', 'cardPhone', '017xxxxxxxx');
    bindManualInput('manualJoinDate', 'backJoinDate', '—');
    bindManualInput('manualExpireDate', 'backExpireDate', '—');

    // Manual photo local reader upload
    document.getElementById('manualPhoto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                document.getElementById('cardPhoto').src = evt.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Shape style live change listener
    document.getElementById('shapeStyleSelect').addEventListener('change', function() {
        const style = this.value;
        document.querySelectorAll('.shape-group').forEach(el => {
            el.style.display = 'none';
        });
        document.querySelectorAll('.shape-' + style).forEach(el => {
            el.style.display = 'block';
        });
    });

    // If employee ID passed via URL query param
    const params = new URLSearchParams(window.location.search);
    const empId = params.get('emp');
    if (empId) {
        const found = items.find(item => {
            const d = JSON.parse(item.getAttribute('data-employee'));
            return String(d.id) === String(empId);
        });
        if (found) {
            found.click();
        }
    }
});
</script>
@endsection
