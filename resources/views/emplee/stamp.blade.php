@extends('emplee.master')

@section('content')

{{-- ────────────────────────────────────────────────────────── --}}
{{-- External libraries & Fonts                                  --}}
{{-- ────────────────────────────────────────────────────────── --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
/* ═══════════════════════════════════════════════════════════
   PAGE WRAPPER
═══════════════════════════════════════════════════════════ */
.stamp-page-wrap {
    padding: 28px 32px;
    background: #f1f5f9;
    min-height: 100vh;
    font-family: 'Hind Siliguri', 'Outfit', sans-serif;
}

/* ── Topbar ─────────────────────────────────────────────── */
.stamp-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
}
.stamp-topbar-left { display: flex; align-items: center; gap: 14px; }
.stamp-topbar-icon {
    width: 52px; height: 52px;
    background: linear-gradient(135deg, #f97316, #ea580c);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; color: #fff;
    box-shadow: 0 4px 14px rgba(249,115,22,.3);
}
.stamp-topbar-title { font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; }
.stamp-topbar-sub   { font-size: 13px; color: #64748b; margin: 2px 0 0; }
.btn-back-dash {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 22px;
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 10px; font-weight: 600; font-size: 14px;
    color: #475569; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    transition: all .2s;
}
.btn-back-dash:hover { background: #f8fafc; color: #0f172a; }

/* ── Two-col layout ──────────────────────────────────────── */
.stamp-grid { display: grid; grid-template-columns: 340px 1fr; gap: 24px; align-items: start; }

/* ── Form card ───────────────────────────────────────────── */
.stamp-form-card {
    background: #fff; border-radius: 20px;
    border: 1.5px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0,0,0,.05);
    padding: 26px;
    position: sticky; top: 20px;
}
.stamp-form-card h5 {
    font-size: 15px; font-weight: 700; color: #0f172a;
    margin-bottom: 18px;
    display: flex; align-items: center; gap: 8px;
}
.stamp-form-card .form-label { font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 5px; }
.stamp-form-card .form-control,
.stamp-form-card .form-select {
    border-radius: 8px; border: 1.5px solid #e2e8f0;
    padding: 9px 13px; font-size: 13.5px;
    transition: border-color .2s;
}
.stamp-form-card .form-control:focus,
.stamp-form-card .form-select:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.1); }
.stamp-divider {
    text-align: center; color: #94a3b8; font-size: 11.5px;
    font-weight: 600; border-bottom: 1px solid #f1f5f9;
    padding-bottom: 10px; margin: 12px 0;
}
.btn-download-pdf {
    width: 100%; background: linear-gradient(135deg, #10b981, #059669);
    border: none; padding: 13px; border-radius: 10px;
    font-weight: 700; font-size: 15px; color: #fff;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(16,185,129,.25);
    cursor: pointer; transition: all .2s;
}
.btn-download-pdf:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(16,185,129,.35); }
.btn-print {
    width: 100%; background: linear-gradient(135deg, #475569, #334155);
    border: none; padding: 10px; border-radius: 10px;
    font-weight: 700; font-size: 14px; color: #fff;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    cursor: pointer; transition: all .2s;
    margin-top: 8px;
}
.btn-print:hover { background: #1e293b; }

/* ── Preview card ────────────────────────────────────────── */
.stamp-preview-card {
    background: #fff; border-radius: 20px;
    border: 1.5px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0,0,0,.05);
    padding: 28px;
}
.stamp-preview-card > h5 {
    font-size: 17px; font-weight: 700; color: #0f172a;
    margin-bottom: 20px;
    display: flex; align-items: center; gap: 8px;
}

/* ═══════════════════════════════════════════════════════════
   DEED DOCUMENT
═══════════════════════════════════════════════════════════ */
#stampPrintArea {
    font-family: 'Hind Siliguri', 'Noto Serif Bengali', serif;
}

/* Outer parchment */
.deed-doc {
    background: #fdf8f0;
    border: 2px solid #b8a76c;
    border-radius: 4px;
    padding: 0;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,.12), inset 0 0 80px rgba(184,167,108,.05);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.deed-doc:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.18), inset 0 0 80px rgba(184,167,108,.05);
}
.deed-download-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.45);
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 100;
}
.deed-doc:hover .deed-download-overlay {
    opacity: 1;
}
.deed-download-overlay-btn {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    padding: 12px 24px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 15px;
    box-shadow: 0 4px 15px rgba(37,99,235,0.4);
    display: flex;
    align-items: center;
    gap: 8px;
    transform: scale(0.9);
    transition: transform 0.3s ease;
}
.deed-doc:hover .deed-download-overlay-btn {
    transform: scale(1);
}

/* ── STAMP HEADER (Bangladesh Non-Judicial style) ────────── */
.stamp-official-header {
    background: linear-gradient(180deg, #2d6a4f 0%, #1b4332 50%, #2d6a4f 100%);
    position: relative;
    overflow: hidden;
}

/* Decorative border rows */
.stamp-border-row {
    height: 10px;
    background: repeating-linear-gradient(
        90deg,
        #40916c 0px, #40916c 8px,
        #1b4332 8px, #1b4332 16px,
        #52b788 16px, #52b788 20px,
        #1b4332 20px, #1b4332 28px
    );
}

.stamp-header-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    gap: 10px;
}

/* Left/Right denomination boxes */
.stamp-denom-box {
    background: linear-gradient(135deg, #40916c, #52b788);
    border: 2px solid #74c69d;
    border-radius: 6px;
    width: 90px; height: 80px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    box-shadow: inset 0 0 12px rgba(0,0,0,.2), 0 2px 6px rgba(0,0,0,.2);
    flex-shrink: 0;
}
.stamp-denom-taka {
    font-size: 22px; font-weight: 800; color: #d8f3dc;
    font-family: 'Hind Siliguri', serif;
    line-height: 1;
    text-shadow: 0 1px 3px rgba(0,0,0,.3);
}
.stamp-denom-sub { font-size: 10px; color: #95d5b2; font-weight: 600; letter-spacing: .5px; margin-top: 2px; }

/* Center emblem area */
.stamp-center-emblem {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.stamp-govt-title {
    font-size: 20px; font-weight: 700;
    color: #d8f3dc;
    font-family: 'Hind Siliguri', serif;
    text-align: center;
    text-shadow: 0 1px 4px rgba(0,0,0,.4);
    letter-spacing: .5px;
    line-height: 1.2;
}

/* Site logo circle */
.stamp-logo-circle {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: radial-gradient(circle, #ffffff 60%, #d8f3dc 100%);
    border: 3px solid #74c69d;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    box-shadow: 0 0 0 2px #40916c, 0 4px 12px rgba(0,0,0,.3);
    flex-shrink: 0;
}
.stamp-logo-circle img { width: 100%; height: 100%; object-fit: contain; padding: 6px; }
.stamp-logo-circle .stamp-logo-text {
    font-size: 11px; font-weight: 800; color: #1b4332;
    text-align: center; letter-spacing: -.5px;
    line-height: 1.1;
}

/* Bottom header row */
.stamp-header-footer {
    background: linear-gradient(90deg, #1b4332, #2d6a4f, #1b4332);
    text-align: center;
    padding: 6px 20px;
    font-size: 15px; font-weight: 700;
    color: #d8f3dc;
    letter-spacing: 1px;
    font-family: 'Hind Siliguri', serif;
    border-top: 1px solid #40916c;
}

/* ── Body of deed ────────────────────────────────────────── */
.deed-body {
    padding: 28px 24px 32px;
    position: relative;
}

/* Details row (logo + table) */
.deed-details-row {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 1.5px dashed #c8a96a;
}

/* Details table */
.deed-info-table { flex: 1; }
.deed-info-row { display: flex; align-items: flex-start; gap: 6px; margin-bottom: 3px; font-size: 13px; }
.deed-info-label { font-weight: 700; color: #475569; min-width: 140px; flex-shrink: 0; }
.deed-info-val   { font-weight: 600; color: #0f172a; }
.deed-info-val.blue  { color: #1d4ed8; }
.deed-info-val.orange{ color: #c2410c; }

/* Stamp photo (top-right of body) */
.deed-stamp-photo {
    width: 90px; height: 110px;
    border: 1.5px dashed #94a3b8;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; background: #f8fafc; flex-shrink: 0;
}
.deed-stamp-photo img { width: 100%; height: 100%; object-fit: cover; }
.deed-stamp-photo-label { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; text-align: center; }

/* Section heading */
.deed-section-title {
    text-align: center;
    font-size: 15px; font-weight: 700;
    color: #1b4332;
    margin-bottom: 8px;
    position: relative;
}
.deed-section-title::before,
.deed-section-title::after {
    content: '——';
    color: #b8a76c;
    margin: 0 8px;
}

/* Body paragraphs */
.deed-para {
    font-size: 13px; line-height: 1.55;
    color: #374151; text-align: justify;
    margin-bottom: 6px;
}

/* Signature row */
.deed-sig-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-top: 30px;
    padding: 0 10px;
}
.deed-sig-box { text-align: center; display: flex; flex-direction: column; align-items: center; }
.deed-sig-img  { height: 38px; display: flex; align-items: flex-end; justify-content: center; margin-bottom: 4px; }
.deed-sig-img img { max-height: 38px; max-width: 140px; object-fit: contain; }
.deed-sig-line  { border-top: 1.5px solid #64748b; width: 160px; margin-bottom: 4px; }
.deed-sig-label { font-size: 12px; font-weight: 700; color: #475569; }

/* Footer note */
.deed-footer-note {
    margin-top: 14px;
    border-top: 1px solid #e5d9b6;
    padding-top: 10px;
    text-align: center;
    font-size: 12px; color: #6b7280; font-weight: 600;
}
.deed-footer-quote {
    font-size: 14px; font-weight: 800; color: #1b4332;
    margin-top: 6px;
}
</style>

<div class="stamp-page-wrap">

    {{-- Top Bar --}}
    <div class="stamp-topbar">
        <div class="stamp-topbar-left">
            <div class="stamp-topbar-icon"><i class="fa-solid fa-stamp"></i></div>
            <div>
                <p class="stamp-topbar-title">ঋণ চুক্তিপত্র স্ট্যাম্প জেনারেটর</p>
                <p class="stamp-topbar-sub">চুক্তিপত্র তৈরি করুন ও ডাউনলোড করুন</p>
            </div>
        </div>
        <a href="{{ route('admin.emplee.dashboard') }}" class="btn-back-dash">
            <i class="fa-solid fa-arrow-left"></i> ড্যাশবোর্ডে ফিরুন
        </a>
    </div>

    <div class="stamp-grid">

        {{-- ══════════ LEFT: FORM ══════════ --}}
        <div class="stamp-form-card">
            <h5><i class="fa-solid fa-file-signature text-warning"></i> তথ্য দিন</h5>

            {{-- Loan selector --}}
            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-search text-secondary me-1"></i> অনুমোদিত লোন নির্বাচন</label>
                <select id="stampLoanSelect" class="form-select" onchange="onStampLoanSelected(this)">
                    <option value="">অনুমোদিত লোন সিলেক্ট করুন...</option>
                    @foreach($approvedLoansList as $appLoan)
                        @php
                            $nid     = $appLoan->user->information?->nid_number    ?? '';
                            $address = $appLoan->user->information?->current_address ?? '';
                            $installment = $appLoan->monthly_installment
                                ?? (($appLoan->amount + ($appLoan->amount * 0.024 * ($appLoan->tenure / 12))) / $appLoan->tenure);
                            $d = json_encode([
                                'name'        => $appLoan->user->name,
                                'nid'         => $nid,
                                'address'     => $address,
                                'amount'      => $appLoan->amount,
                                'tenure'      => $appLoan->tenure,
                                'installment' => $installment,
                            ]);
                        @endphp
                        <option value="{{ $d }}">
                            {{ $appLoan->user->name }} — {{ $appLoan->user->phone }} — ৳{{ number_format($appLoan->amount) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="stamp-divider">অথবা ম্যানুয়ালি তথ্য দিন</div>

            <div class="mb-2">
                <label class="form-label">ঋণগ্রহীতার নাম <span class="text-muted" style="font-size: 11px; font-weight: normal;">(এখানে আপনার নিজের নাম লিখুন)</span></label>
                <input type="text" id="stampFormName" class="form-control" placeholder="ঋণগ্রহীতার নাম" oninput="updateStampPreview()">
            </div>
            <div class="mb-2">
                <label class="form-label">এনআইডি নম্বর</label>
                <input type="text" id="stampFormNid" class="form-control" placeholder="এনআইডি নম্বর" oninput="updateStampPreview()">
            </div>
            <div class="mb-2">
                <label class="form-label">পিতার নাম <span class="text-muted" style="font-size: 11px; font-weight: normal;">(এখানে আপনার পিতার নাম লিখুন)</span></label>
                <input type="text" id="stampFormFather" class="form-control" placeholder="পিতার নাম" oninput="updateStampPreview()">
            </div>
            <div class="mb-2">
                <label class="form-label">ঠিকানা</label>
                <textarea id="stampFormAddress" class="form-control" rows="2" placeholder="ঠিকানা" oninput="updateStampPreview()"></textarea>
            </div>
            <div class="mb-2">
                <label class="form-label">ঋণের পরিমাণ (৳)</label>
                <input type="number" id="stampFormAmount" class="form-control" value="50000" oninput="updateStampPreview()">
            </div>
            <div class="mb-2">
                <label class="form-label">ঋণের মেয়াদ (মাস)</label>
                <input type="number" id="stampFormTenure" class="form-control" value="12" oninput="updateStampPreview()">
            </div>
            <div class="mb-3">
                <label class="form-label">মাসিক কিস্তি (৳)</label>
                <input type="text"   id="stampFormEMI"    class="form-control" value="4266.67" oninput="updateStampPreview()">
            </div>
            <div class="mb-2">
                <label class="form-label">স্ট্যাম্প ছবি আপলোড করুন</label>
                <input type="file" id="stampFormImage" class="form-control" accept="image/*" onchange="onStampPhotoUploaded(this)">
            </div>
            <div class="mb-4">
                <label class="form-label">স্বাক্ষর ছবি আপলোড করুন</label>
                <input type="file" id="stampFormSignature" class="form-control" accept="image/*" onchange="onStampSignatureUploaded(this)">
            </div>

            <div class="d-flex flex-column mt-3">
                <button class="btn-download-pdf" onclick="downloadPDF()">
                    <i class="fa-solid fa-file-pdf"></i> পিডিএফ ডাউনলোড করুন
                </button>
                <button class="btn-print" onclick="printStamp()">
                    <i class="fa-solid fa-print"></i> প্রিন্ট করুন
                </button>
            </div>
        </div>

        {{-- ══════════ RIGHT: LIVE PREVIEW ══════════ --}}
        <div class="stamp-preview-card">
            <h5><i class="fa-solid fa-eye text-primary"></i> লাইভ প্রিভিউ</h5>

            <div id="stampPrintArea">

                <div class="deed-doc" onclick="downloadPDF()" style="cursor: pointer;" title="পিডিএফ ডাউনলোড করতে ক্লিক করুন">
                    
                    {{-- Hover Download Overlay --}}
                    <div class="deed-download-overlay">
                        <div class="deed-download-overlay-btn">
                            <i class="fa-solid fa-file-pdf"></i> চুক্তিপত্রটি ডাউনলোড করুন
                        </div>
                    </div>

                    {{-- ── OFFICIAL STAMP HEADER ── --}}
                    @if($activeStampUrl)
                        {{-- Admin-uploaded stamp image --}}
                        <img src="{{ $activeStampUrl }}" alt="Stamp" style="width:100%; height:auto; display:block;">
                    @else
                        {{-- Programmatic Bangladesh Non-Judicial Stamp --}}
                        <div class="stamp-official-header">
                            <div class="stamp-border-row"></div>
                            <div class="stamp-header-inner">
                                {{-- Left denomination --}}
                                <div class="stamp-denom-box">
                                    <div class="stamp-denom-taka">৳১০০</div>
                                    <div class="stamp-denom-sub">NON-JUDICIAL</div>
                                </div>

                                {{-- Center --}}
                                <div class="stamp-center-emblem">
                                    {{-- Site Logo Circle --}}
                                    <div class="stamp-logo-circle">
                                        @if(!empty($siteLogo))
                                            <img src="{{ $siteLogo }}" alt="{{ $siteName ?? 'Logo' }}">
                                        @else
                                            <span class="stamp-logo-text">{{ $siteName ?? 'PNCBD' }}</span>
                                        @endif
                                    </div>
                                    <div class="stamp-govt-title">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</div>
                                </div>

                                {{-- Right denomination --}}
                                <div class="stamp-denom-box">
                                    <div class="stamp-denom-taka">৳১০০</div>
                                    <div class="stamp-denom-sub">NON-JUDICIAL</div>
                                </div>
                            </div>
                            <div class="stamp-border-row"></div>
                            <div class="stamp-header-footer">একশত টাকা</div>
                        </div>
                    @endif

                    {{-- ── DEED BODY ── --}}
                    <div class="deed-body">

                        <div class="deed-details-row">

                            {{-- Info table --}}
                            <div class="deed-info-table">
                                
                                {{-- Brand Logo (Brand Identity inside marked blue oval) --}}
                                <div style="margin-bottom: 22px; text-align: left; display: block;">
                                    @if(!empty($siteLogo))
                                        <img src="{{ $siteLogo }}" alt="{{ $siteName ?? 'Logo' }}" style="max-height: 48px; max-width: 170px; object-fit: contain;">
                                    @else
                                        <span style="font-size: 20px; font-weight: 800; color: #1b4332; font-family: 'Hind Siliguri', sans-serif; letter-spacing: 0.5px;">{{ $siteName ?? 'Pncbd' }}</span>
                                    @endif
                                </div>
                                <div class="deed-info-row">
                                    <span class="deed-info-label">ঋণগ্রহীতার নাম:</span>
                                    <span class="deed-info-val" id="prevStampName">—</span>
                                </div>
                                <div class="deed-info-row">
                                    <span class="deed-info-label">এনআইডি নম্বর:</span>
                                    <span class="deed-info-val" id="prevStampNid">—</span>
                                </div>
                                <div class="deed-info-row">
                                    <span class="deed-info-label">পিতার নাম:</span>
                                    <span class="deed-info-val" id="prevStampFather">—</span>
                                </div>
                                <div class="deed-info-row">
                                    <span class="deed-info-label">ঠিকানা:</span>
                                    <span class="deed-info-val" id="prevStampAddress">—</span>
                                </div>
                                <div class="deed-info-row">
                                    <span class="deed-info-label">ঋণের পরিমাণ:</span>
                                    <span class="deed-info-val blue" id="prevStampAmount">৫০,০০০</span>&nbsp;টাকা
                                </div>
                                <div class="deed-info-row">
                                    <span class="deed-info-label">ঋণের মেয়াদ:</span>
                                    <span class="deed-info-val" id="prevStampTenure">১২</span>&nbsp;মাস
                                </div>
                                <div class="deed-info-row">
                                    <span class="deed-info-label">মাসিক কিস্তি:</span>
                                    <span class="deed-info-val orange" id="prevStampEMI">৪,২৬৬.৬৭</span>&nbsp;টাকা
                                </div>
                            </div>

                            {{-- Stamp photo (top right) --}}
                            <div class="deed-stamp-photo" id="stampPhotoContainer">
                                <img id="prevStampPhoto" src="#" alt="স্ট্যাম্প" style="display:none;">
                                <span class="deed-stamp-photo-label" id="prevStampPhotoPlaceholder">স্ট্যাম্প</span>
                            </div>
                        </div>

                        {{-- Section title --}}
                        <div class="deed-section-title">গুরুত্বপূর্ণ তথ্য ও শর্তাবলী</div>

                        {{-- Paragraphs --}}
                        <p class="deed-para">
                            আমি <strong id="deedBodyName">—</strong>, পিতা - <strong id="deedBodyFather">—</strong>, গ্রাম - <strong id="deedBodyAddress">—</strong>। আমি {{ $siteName ?? 'Pncbd' }} ব্যাংকের পক্ষ থেকে <strong id="deedBodyAmount">৫০,০০০</strong> টাকা ঋণগ্রহণে সম্মত হয়েছি, যার মেয়াদকাল <strong id="deedBodyTenure">১২</strong> মাস। প্রতিমাসে নির্ধারিত কিস্তি <strong id="deedBodyEMI">৪,২৬৬.৬৭</strong> টাকা করে ঋণের কিস্তি প্রদানের ক্ষেত্রে আমাকে প্রতি মাসের এক তারিখ থেকে দশ তারিখের মধ্যে নির্ধারিত অনলাইন পদ্ধতির মাধ্যমে কিস্তি জমা দিতে হবে। কোনো কারণে কিস্তি প্রদানে বিলম্ব হলে তা ব্যাংক কর্তৃপক্ষকে অবিলম্বে জানাতে হবে এবং ব্যাংকের নির্দেশনা অনুযায়ী বকেয়া পরিশোধ করতে হবে। এই শর্ত লঙ্ঘন করা হলে ব্যাংক প্রয়োজনীয় আইনানুগ ব্যবস্থা নিতে পারবে।
                        </p>

                        <p class="deed-para">
                            {{ $siteName ?? 'Pncbd' }} ব্যাংক আমার প্রদত্ত তথ্য, আর্থিক অবস্থা এবং ঋণ গ্রহণের যোগ্যতা যাচাই করে এই ঋণ অনুমোদন করেছে। আমি দৃঢ়ভাবে প্রতিশ্রুতি দিচ্ছি যে ব্যাংকের দেওয়া সব শর্ত ও নিয়মাবলী আমি যথাযথভাবে পালন করব। আমার পক্ষ থেকে দেওয়া তথ্য যদি পরবর্তীতে ভুল প্রমাণিত হয় বা আমি চুক্তি ভঙ্গ করি, তবে ব্যাংক আইনি ব্যবস্থা গ্রহণ করতে সম্পূর্ণ স্বাধীন থাকবে।
                        </p>

                        {{-- Signatures --}}
                        <div class="deed-sig-row">
                            {{-- Bank authority sig --}}
                            <div class="deed-sig-box">
                                <div class="deed-sig-img">
                                    {{-- placeholder space --}}
                                </div>
                                <div class="deed-sig-line"></div>
                                <div class="deed-sig-label">ব্যাংক কর্তৃপক্ষের স্বাক্ষর</div>
                            </div>

                            {{-- Borrower sig (uploaded) --}}
                            <div class="deed-sig-box">
                                <div class="deed-sig-img">
                                    <img id="prevStampSignature" src="#" alt="স্বাক্ষর" style="display:none;">
                                </div>
                                <div class="deed-sig-line"></div>
                                <div class="deed-sig-label">ঋণগ্রহীতার স্বাক্ষর</div>
                            </div>
                        </div>

                        {{-- Footer note --}}
                        <div class="deed-footer-note">
                            বিঃদ্রঃ ঋণের শর্তাবলী পালন না করলে ব্যাংক কর্তৃপক্ষ আইনানুগ ব্যবস্থা নিতে বাধ্য থাকিবে।
                            <div class="deed-footer-quote">"দেশপ্রেমের শপথ নিন, দুর্নীতিকে বিদায় দিন"</div>
                        </div>

                    </div>{{-- /deed-body --}}
                </div>{{-- /deed-doc --}}

            </div>{{-- /stampPrintArea --}}
        </div>{{-- /stamp-preview-card --}}

    </div>{{-- /stamp-grid --}}
</div>{{-- /stamp-page-wrap --}}

{{-- ══════════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════════ --}}
<script>
    /* ── Bangla numerals ────────────────────────────────── */
    function toBangla(str) {
        const m = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        return String(str).replace(/[0-9]/g, d => m[d]);
    }

    /* ── Dropdown select ────────────────────────────────── */
    function onStampLoanSelected(sel) {
        if (!sel.value) return;
        try {
            const d = JSON.parse(sel.value);
            document.getElementById('stampFormName').value    = d.name;
            document.getElementById('stampFormNid').value     = d.nid;
            document.getElementById('stampFormAddress').value = d.address;
            document.getElementById('stampFormAmount').value  = d.amount;
            document.getElementById('stampFormTenure').value  = d.tenure;
            document.getElementById('stampFormEMI').value     = (parseFloat(d.installment)||0).toFixed(2);
            document.getElementById('stampFormFather').value  = '';
            updateStampPreview();
        } catch(e) { console.error(e); }
    }

    /* ── Stamp photo ────────────────────────────────────── */
    function onStampPhotoUploaded(inp) {
        if (!inp.files || !inp.files[0]) return;
        const r = new FileReader();
        r.onload = e => {
            const img = document.getElementById('prevStampPhoto');
            img.src = e.target.result;
            img.style.display = 'block';
            const ph = document.getElementById('prevStampPhotoPlaceholder');
            if (ph) ph.style.display = 'none';
        };
        r.readAsDataURL(inp.files[0]);
    }

    /* ── Signature ──────────────────────────────────────── */
    function onStampSignatureUploaded(inp) {
        if (!inp.files || !inp.files[0]) return;
        const r = new FileReader();
        r.onload = e => {
            const img = document.getElementById('prevStampSignature');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        r.readAsDataURL(inp.files[0]);
    }

    /* ── Live preview update ────────────────────────────── */
    function updateStampPreview() {
        const name    = document.getElementById('stampFormName').value    || '—';
        const nid     = document.getElementById('stampFormNid').value     || '—';
        const father  = document.getElementById('stampFormFather').value  || '—';
        const address = document.getElementById('stampFormAddress').value || '—';
        const amount  = parseFloat(document.getElementById('stampFormAmount').value) || 0;
        const tenure  = parseFloat(document.getElementById('stampFormTenure').value) || 0;
        const emiRaw  = document.getElementById('stampFormEMI').value || '0';

        let fEMI;
        if (/^\d+(\.\d+)?$/.test(emiRaw.trim())) {
            fEMI = toBangla(parseFloat(emiRaw).toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2}));
        } else { fEMI = toBangla(emiRaw); }

        const fAmount = amount > 0 ? toBangla(amount.toLocaleString('en-IN')) : '০';
        const fTenure = tenure > 0 ? toBangla(tenure.toString()) : '০';
        const fNid    = toBangla(nid);

        document.getElementById('prevStampName').textContent    = name;
        document.getElementById('prevStampNid').textContent     = fNid;
        document.getElementById('prevStampFather').textContent  = father;
        document.getElementById('prevStampAddress').textContent = address;
        document.getElementById('prevStampAmount').textContent  = fAmount;
        document.getElementById('prevStampTenure').textContent  = fTenure;
        document.getElementById('prevStampEMI').textContent     = fEMI;

        document.getElementById('deedBodyName').textContent    = name;
        document.getElementById('deedBodyFather').textContent  = father;
        document.getElementById('deedBodyAddress').textContent = address;
        document.getElementById('deedBodyAmount').textContent  = fAmount;
        document.getElementById('deedBodyTenure').textContent  = fTenure;
        document.getElementById('deedBodyEMI').textContent     = fEMI;
    }

    /* ── Direct PDF Download (html2pdf.js) ──────────────── */
    function downloadPDF() {
        const element = document.getElementById('stampPrintArea');
        
        // Hide the hover overlay temporarily
        const overlays = element.querySelectorAll('.deed-download-overlay');
        overlays.forEach(o => o.style.setProperty('display', 'none', 'important'));
        
        const opt = {
            margin:       [8, 12, 8, 12], // optimal margins
            filename:     'loan_agreement_' + (document.getElementById('stampFormName').value || 'document') + '.pdf',
            image:        { type: 'jpeg', quality: 1.0 },
            html2canvas:  { 
                scale: 3, // Premium quality
                useCORS: true,
                letterRendering: true,
                scrollX: 0,
                scrollY: 0
            },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        
        // Generate and download
        html2pdf().set(opt).from(element).save().then(() => {
            // Restore overlay display
            overlays.forEach(o => o.style.removeProperty('display'));
        }).catch(err => {
            console.error('PDF Generation Error:', err);
            overlays.forEach(o => o.style.removeProperty('display'));
        });
    }

    /* ── Print / Download ───────────────────────────────── */
    function printStamp() {
        const content = document.getElementById('stampPrintArea').innerHTML;
        const w = window.open('', '_blank', 'height=1050,width=820');
        w.document.write(`<!DOCTYPE html><html><head>
            <meta charset="UTF-8">
            <title>ঋণ চুক্তিপত্র</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;600;700&display=swap" rel="stylesheet">
            <style>
                *{box-sizing:border-box; margin:0; padding:0;}
                body{font-family:'Hind Siliguri',serif; background:#fff; padding:18px; -webkit-print-color-adjust:exact; print-color-adjust:exact;}
                .deed-doc{background:#fdf8f0; border:2px solid #b8a76c; border-radius:4px; overflow:hidden; box-shadow:none;}
                .stamp-official-header{background:linear-gradient(180deg,#2d6a4f 0%,#1b4332 50%,#2d6a4f 100%); position:relative;}
                .stamp-border-row{height:10px; background:repeating-linear-gradient(90deg,#40916c 0px,#40916c 8px,#1b4332 8px,#1b4332 16px,#52b788 16px,#52b788 20px,#1b4332 20px,#1b4332 28px);}
                .stamp-header-inner{display:flex; align-items:center; justify-content:space-between; padding:10px 20px; gap:10px;}
                .stamp-denom-box{background:linear-gradient(135deg,#40916c,#52b788); border:2px solid #74c69d; border-radius:6px; width:90px; height:80px; display:flex; flex-direction:column; align-items:center; justify-content:center; box-shadow:inset 0 0 12px rgba(0,0,0,.2);}
                .stamp-denom-taka{font-size:22px; font-weight:800; color:#d8f3dc; line-height:1;}
                .stamp-denom-sub{font-size:10px; color:#95d5b2; font-weight:600; margin-top:2px;}
                .stamp-center-emblem{flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;}
                .stamp-govt-title{font-size:20px; font-weight:700; color:#d8f3dc; text-align:center; text-shadow:0 1px 4px rgba(0,0,0,.4);}
                .stamp-logo-circle{width:64px; height:64px; border-radius:50%; background:radial-gradient(circle,#fff 60%,#d8f3dc 100%); border:3px solid #74c69d; display:flex; align-items:center; justify-content:center; overflow:hidden; box-shadow:0 0 0 2px #40916c;}
                .stamp-logo-circle img{width:100%; height:100%; object-fit:contain; padding:6px;}
                .stamp-logo-text{font-size:11px; font-weight:800; color:#1b4332; text-align:center;}
                .stamp-header-footer{background:linear-gradient(90deg,#1b4332,#2d6a4f,#1b4332); text-align:center; padding:6px 20px; font-size:15px; font-weight:700; color:#d8f3dc; letter-spacing:1px; border-top:1px solid #40916c;}
                .deed-body{padding:18px 24px 18px; position:relative;}
                .deed-details-row{display:flex; gap:20px; align-items:flex-start; margin-bottom:12px; padding-bottom:10px; border-bottom:1.5px dashed #c8a96a;}
                .deed-download-overlay { display: none !important; }
                .deed-info-table{flex:1;}
                .deed-info-row{display:flex; align-items:flex-start; gap:6px; margin-bottom:3px; font-size:13px;}
                .deed-info-label{font-weight:700; color:#475569; min-width:140px; flex-shrink:0;}
                .deed-info-val{font-weight:600; color:#0f172a;}
                .deed-info-val.blue{color:#1d4ed8;}
                .deed-info-val.orange{color:#c2410c;}
                .deed-stamp-photo{width:90px; height:110px; border:1.5px dashed #94a3b8; border-radius:6px; display:flex; align-items:center; justify-content:center; overflow:hidden; background:#f8fafc; flex-shrink:0;}
                .deed-stamp-photo img{width:100%; height:100%; object-fit:cover;}
                .deed-stamp-photo-label{font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; text-align:center;}
                .deed-section-title{text-align:center; font-size:15px; font-weight:700; color:#1b4332; margin-bottom:8px;}
                .deed-section-title::before,.deed-section-title::after{content:'——'; color:#b8a76c; margin:0 8px;}
                .deed-para{font-size:13px; line-height:1.55; color:#374151; text-align:justify; margin-bottom:6px;}
                .deed-sig-row{display:flex; justify-content:space-between; align-items:flex-end; margin-top:30px; padding:0 10px;}
                .deed-sig-box{text-align:center; display:flex; flex-direction:column; align-items:center;}
                .deed-sig-img{height:38px; display:flex; align-items:flex-end; justify-content:center; margin-bottom:4px;}
                .deed-sig-img img{max-height:38px; max-width:140px; object-fit:contain;}
                .deed-sig-line{border-top:1.5px solid #64748b; width:160px; margin-bottom:4px;}
                .deed-sig-label{font-size:12px; font-weight:700; color:#475569;}
                .deed-footer-note{margin-top:14px; border-top:1px solid #e5d9b6; padding-top:10px; text-align:center; font-size:12px; color:#6b7280; font-weight:600;}
                .deed-footer-quote{font-size:14px; font-weight:800; color:#1b4332; margin-top:4px;}
                @media print{body{padding:8px;}}
            </style>
        </head><body>${content}</body></html>`);
        w.document.close();
        w.focus();
        setTimeout(() => { w.print(); w.close(); }, 600);
    }

    /* ── Init ───────────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', updateStampPreview);
</script>

@endsection
