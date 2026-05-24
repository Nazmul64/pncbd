<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ডকুমেন্ট আপলোড করুন - {{ $gs->site_name ?? 'UBS' }}</title>
    <meta name="description" content="আপনার সকল প্রয়োজনীয় তথ্য এবং ডকুমেন্ট প্রদান করুন">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans Bengali', sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
        }

        /* ══════════ HEADER ══════════ */
        .top-navbar {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
            padding: 12px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-circle {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .nav-items {
            display: flex;
            gap: 28px;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .nav-items a {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
        }

        .nav-items a:hover, .nav-items a.active {
            color: #fff;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            border-radius: 50px;
            background: rgba(255,255,255,0.1);
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-profile:hover {
            background: rgba(255,255,255,0.2);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
        }

        .user-phone {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
        }

        /* ══════════ HERO SECTION ══════════ */
        .hero-section {
            text-align: center;
            padding: 40px 20px 10px;
        }

        .hero-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .hero-icon i {
            font-size: 1.8rem;
            color: white;
        }

        .hero-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .hero-subtitle {
            font-size: 1rem;
            color: #64748b;
            margin-bottom: 0;
        }

        /* ══════════ STEPPER ══════════ */
        .stepper-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            padding: 30px 20px 35px;
            max-width: 700px;
            margin: 0 auto;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .step-num.active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
        }

        .step-num.inactive {
            background: #e2e8f0;
            color: #94a3b8;
        }

        .step-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
        }

        .step-label.inactive {
            color: #94a3b8;
        }

        .step-line {
            flex: 1;
            height: 3px;
            margin: 0 10px;
            border-radius: 2px;
            min-width: 40px;
        }

        .step-line.active {
            background: linear-gradient(90deg, #10b981, #06b6d4);
        }

        .step-line.inactive {
            background: #e2e8f0;
        }

        /* ══════════ FORM SECTIONS ══════════ */
        .form-section {
            background: white;
            border-radius: 16px;
            padding: 28px 30px;
            margin-bottom: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        .form-section::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5px;
        }

        .form-section.green::before {
            background: linear-gradient(180deg, #10b981, #34d399);
        }

        .form-section.yellow::before {
            background: linear-gradient(180deg, #f59e0b, #fbbf24);
        }

        .form-section.blue::before {
            background: linear-gradient(180deg, #3b82f6, #60a5fa);
        }

        .form-section.orange::before {
            background: linear-gradient(180deg, #f97316, #fb923c);
        }

        .form-section.teal::before {
            background: linear-gradient(180deg, #14b8a6, #2dd4bf);
        }

        .form-section.rose::before {
            background: linear-gradient(180deg, #f43f5e, #fb7185);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: white;
            flex-shrink: 0;
        }

        .section-icon.green  { background: linear-gradient(135deg, #10b981, #059669); }
        .section-icon.yellow { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .section-icon.blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .section-icon.orange { background: linear-gradient(135deg, #f97316, #ea580c); }
        .section-icon.teal   { background: linear-gradient(135deg, #14b8a6, #0d9488); }
        .section-icon.rose   { background: linear-gradient(135deg, #f43f5e, #e11d48); }

        .section-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        /* ══════════ FORM FIELDS ══════════ */
        .field-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .field-label i {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .field-label .required {
            color: #ef4444;
        }

        .form-control-custom {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Noto Sans Bengali', sans-serif;
            font-size: 0.92rem;
            color: #334155;
            background: #f8fafc;
            transition: all 0.3s;
            outline: none;
        }

        .form-control-custom:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-control-custom::placeholder {
            color: #94a3b8;
        }

        textarea.form-control-custom {
            min-height: 80px;
            resize: vertical;
        }

        /* ══════════ FILE UPLOAD ══════════ */
        .file-upload-zone {
            border: 2px dashed #10b981;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f0fdf4;
            position: relative;
            min-height: 60px;
        }

        .file-upload-zone:hover {
            background: #dcfce7;
            border-color: #059669;
        }

        .file-upload-zone.has-file {
            background: #f0fdf4;
            border-color: #10b981;
        }

        .file-upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .file-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            color: #059669;
        }

        .file-placeholder i {
            font-size: 1.5rem;
        }

        .file-placeholder span {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .file-info {
            display: none;
            font-size: 0.82rem;
            color: #059669;
            font-weight: 600;
            word-break: break-all;
        }

        .file-info.visible {
            display: block;
        }

        .file-preview {
            display: none;
            margin-top: 10px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
            max-width: 120px;
        }

        .file-preview.visible {
            display: inline-block;
        }

        .file-preview img {
            width: 100%;
            height: auto;
            display: block;
        }

        .file-hint {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.78rem;
            color: #6b7280;
            margin-top: 8px;
        }

        .file-hint i {
            color: #3b82f6;
            font-size: 0.75rem;
        }

        .badge-optional {
            display: inline-block;
            background: #dbeafe;
            color: #2563eb;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 6px;
        }

        /* ══════════ SIGNATURE PAD ══════════ */
        .signature-container {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            border: 1.5px solid #e2e8f0;
        }

        .signature-info {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #3b82f6;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .signature-info i {
            font-size: 0.8rem;
        }

        #signatureCanvas {
            width: 100%;
            height: 180px;
            border: 2px solid #cbd5e1;
            border-radius: 10px;
            background: white;
            cursor: crosshair;
            touch-action: none;
        }

        .signature-actions {
            display: flex;
            gap: 12px;
            margin-top: 14px;
        }

        .sig-btn {
            flex: 1;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-family: 'Noto Sans Bengali', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .sig-btn.clear {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .sig-btn.clear:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .sig-btn.undo {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
        }

        .sig-btn.undo:hover {
            background: linear-gradient(135deg, #ea580c, #c2410c);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);
        }

        /* ══════════ SUBMIT BUTTON ══════════ */
        .submit-wrapper {
            text-align: center;
            padding: 10px 0 40px;
        }

        .submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 50px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Noto Sans Bengali', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        /* ══════════ VALIDATION ERRORS ══════════ */
        .is-invalid {
            border-color: #ef4444 !important;
        }

        .invalid-feedback {
            display: block;
            font-size: 0.8rem;
            color: #ef4444;
            margin-top: 4px;
        }

        .alert-errors {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }

        .alert-errors ul {
            margin: 0;
            padding-left: 18px;
        }

        .alert-errors li {
            color: #dc2626;
            font-size: 0.88rem;
            margin-bottom: 4px;
        }

        /* ══════════ RESPONSIVE ══════════ */
        @media (max-width: 992px) {
            .nav-items { display: none; }
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 1.4rem; }
            .form-section { padding: 20px 18px; }
            .stepper-wrapper { flex-wrap: wrap; gap: 8px; }
            .step-line { min-width: 20px; }
        }

        @media (max-width: 576px) {
            .stepper-wrapper { padding: 20px 10px 25px; }
            .step-label { font-size: 0.75rem; }
        }
    </style>
</head>
<body>
    @include('userdashboard.partials.customer-navbar', ['activeRoute' => 'information'])

    <div class="container" style="max-width: 800px;">

        <!-- ══════════ HERO ══════════ -->
        <div class="hero-section">
            <div class="hero-icon">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <h1 class="hero-title">ডকুমেন্ট আপলোড করুন</h1>
            <p class="hero-subtitle">আপনার সকল প্রয়োজনীয় তথ্য এবং ডকুমেন্ট প্রদান করুন</p>
        </div>

        <!-- ══════════ STEPPER ══════════ -->
        <div class="stepper-wrapper">
            <div class="step-item">
                <div class="step-num active">1</div>
                <span class="step-label">ব্যক্তিগত তথ্য</span>
            </div>
            <div class="step-line active"></div>
            <div class="step-item">
                <div class="step-num active">2</div>
                <span class="step-label">ঠিকানা</span>
            </div>
            <div class="step-line inactive"></div>
            <div class="step-item">
                <div class="step-num inactive">3</div>
                <span class="step-label inactive">ডকুমেন্ট</span>
            </div>
            <div class="step-line inactive"></div>
            <div class="step-item">
                <div class="step-num inactive">4</div>
                <span class="step-label inactive">সম্পন্ন</span>
            </div>
        </div>

        <!-- ══════════ VALIDATION ERRORS ══════════ -->
        @if($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- ══════════ FORM ══════════ -->
        <form action="{{ route('customer.information.store') }}" method="POST" enctype="multipart/form-data" id="infoForm">
            @csrf

            <!-- ── Section A: ব্যক্তিগত তথ্য ── -->
            <div class="form-section green">
                <div class="section-header">
                    <div class="section-icon green"><i class="fas fa-user"></i></div>
                    <h2 class="section-title">ব্যক্তিগত তথ্য</h2>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="field-label">
                            <i class="fas fa-user"></i> পূর্ণ নাম <span class="required">*</span>
                        </label>
                        <input type="text" name="full_name" class="form-control-custom @error('full_name') is-invalid @enderror" placeholder="আপনার পূর্ণ নাম লিখুন" value="{{ old('full_name', $user->name) }}" required>
                        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="field-label">
                            <i class="fas fa-id-card"></i> NID নম্বর <span class="required">*</span>
                        </label>
                        <input type="text" name="nid_number" class="form-control-custom @error('nid_number') is-invalid @enderror" placeholder="আপনার NID নম্বর লিখুন" value="{{ old('nid_number') }}" required>
                        @error('nid_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="field-label">
                            <i class="fas fa-phone"></i> ফোন নম্বর <span class="required">*</span>
                        </label>
                        <input type="text" name="phone_number" class="form-control-custom @error('phone_number') is-invalid @enderror" placeholder="আপনার ফোন নম্বর লিখুন" value="{{ old('phone_number', $user->phone) }}" required>
                        @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="field-label">
                            <i class="fas fa-briefcase"></i> পেশা <span class="required">*</span>
                        </label>
                        <input type="text" name="occupation" class="form-control-custom @error('occupation') is-invalid @enderror" placeholder="আপনার পেশা লিখুন" value="{{ old('occupation') }}" required>
                        @error('occupation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- ── Section B: ঠিকানা ── -->
            <div class="form-section yellow">
                <div class="section-header">
                    <div class="section-icon yellow"><i class="fas fa-map-marker-alt"></i></div>
                    <h2 class="section-title">ঠিকানা</h2>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="field-label">
                            <i class="fas fa-map-pin"></i> বর্তমান ঠিকানা <span class="required">*</span>
                        </label>
                        <textarea name="current_address" class="form-control-custom @error('current_address') is-invalid @enderror" placeholder="আপনার বর্তমান ঠিকানা লিখুন" required>{{ old('current_address') }}</textarea>
                        @error('current_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="field-label">
                            <i class="fas fa-home"></i> স্থায়ী ঠিকানা <span class="required">*</span>
                        </label>
                        <textarea name="permanent_address" class="form-control-custom @error('permanent_address') is-invalid @enderror" placeholder="আপনার স্থায়ী ঠিকানা লিখুন" required>{{ old('permanent_address') }}</textarea>
                        @error('permanent_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- ── Section C: ঋণের তথ্য ── -->
            <div class="form-section blue">
                <div class="section-header">
                    <div class="section-icon blue"><i class="fas fa-comment-dollar"></i></div>
                    <h2 class="section-title">ঋণের তথ্য</h2>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="field-label">
                            <i class="fas fa-comment-dots"></i> ঋণের কারণ <span class="required">*</span>
                        </label>
                        <textarea name="loan_reason" class="form-control-custom @error('loan_reason') is-invalid @enderror" placeholder="ঋণের কারণ বিস্তারিত লিখুন" required>{{ old('loan_reason') }}</textarea>
                        @error('loan_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- ── Section D: ডকুমেন্ট আপলোড ── -->
            <div class="form-section orange">
                <div class="section-header">
                    <div class="section-icon orange"><i class="fas fa-file-upload"></i></div>
                    <h2 class="section-title">ডকুমেন্ট আপলোড</h2>
                </div>
                <div class="row g-4">
                    <!-- Selfie -->
                    <div class="col-md-6">
                        <label class="field-label">
                            <i class="fas fa-camera"></i> সেলফি <span class="required">*</span>
                        </label>
                        <div class="file-upload-zone" id="selfieZone">
                            <input type="file" name="selfie" accept="image/*" onchange="handleFileSelect(this, 'selfie')" required>
                            <div class="file-placeholder" id="selfie_placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>ছবি আপলোড করুন</span>
                            </div>
                            <div class="file-info" id="selfie_info"></div>
                        </div>
                        <div class="file-preview" id="selfie_preview"><img src="" alt="Preview"></div>
                        <div class="file-hint"><i class="fas fa-info-circle"></i> সর্বোচ্চ ফাইল সাইজ: 10MB</div>
                        @error('selfie')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- NID Front -->
                    <div class="col-md-6">
                        <label class="field-label">
                            <i class="fas fa-id-card"></i> NID সামনের অংশ <span class="required">*</span>
                        </label>
                        <div class="file-upload-zone" id="nidFrontZone">
                            <input type="file" name="nid_front" accept="image/*" onchange="handleFileSelect(this, 'nid_front')" required>
                            <div class="file-placeholder" id="nid_front_placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>ছবি আপলোড করুন</span>
                            </div>
                            <div class="file-info" id="nid_front_info"></div>
                        </div>
                        <div class="file-preview" id="nid_front_preview"><img src="" alt="Preview"></div>
                        <div class="file-hint"><i class="fas fa-info-circle"></i> সর্বোচ্চ ফাইল সাইজ: 10MB</div>
                        @error('nid_front')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- NID Back -->
                    <div class="col-md-6">
                        <label class="field-label">
                            <i class="fas fa-id-card-alt"></i> NID পিছনের অংশ <span class="required">*</span>
                        </label>
                        <div class="file-upload-zone" id="nidBackZone">
                            <input type="file" name="nid_back" accept="image/*" onchange="handleFileSelect(this, 'nid_back')" required>
                            <div class="file-placeholder" id="nid_back_placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>ছবি আপলোড করুন</span>
                            </div>
                            <div class="file-info" id="nid_back_info"></div>
                        </div>
                        <div class="file-preview" id="nid_back_preview"><img src="" alt="Preview"></div>
                        <div class="file-hint"><i class="fas fa-info-circle"></i> সর্বোচ্চ ফাইল সাইজ: 10MB</div>
                        @error('nid_back')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Other Document -->
                    <div class="col-md-6">
                        <label class="field-label">
                            <i class="fas fa-paperclip"></i> অন্যান্য ডকুমেন্ট <span class="badge-optional">ঐচ্ছিক</span>
                        </label>
                        <div class="file-upload-zone" id="otherDocZone">
                            <input type="file" name="other_document" accept="image/*,.pdf,.doc,.docx" onchange="handleFileSelect(this, 'other_doc')">
                            <div class="file-placeholder" id="other_doc_placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>ফাইল আপলোড করুন</span>
                            </div>
                            <div class="file-info" id="other_doc_info"></div>
                        </div>
                        <div class="file-preview" id="other_doc_preview"><img src="" alt="Preview"></div>
                        <div class="file-hint"><i class="fas fa-info-circle"></i> ঐচ্ছিক</div>
                        @error('other_document')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- ── Section E: স্বাক্ষর ── -->
            <div class="form-section teal">
                <div class="section-header">
                    <div class="section-icon teal"><i class="fas fa-signature"></i></div>
                    <h2 class="section-title">স্বাক্ষর <span class="required">*</span></h2>
                </div>
                <div class="signature-container">
                    <div class="signature-info">
                        <i class="fas fa-info-circle"></i> নিচের বক্সে আপনার স্বাক্ষর করুন
                    </div>
                    <canvas id="signatureCanvas"></canvas>
                    <input type="hidden" name="signature" id="signatureData">
                    <div class="signature-actions">
                        <button type="button" class="sig-btn clear" onclick="clearSignature()">
                            <i class="fas fa-eraser"></i> মুছে ফেলুন
                        </button>
                        <button type="button" class="sig-btn undo" onclick="undoSignature()">
                            <i class="fas fa-undo"></i> আনডু
                        </button>
                    </div>
                </div>
                @error('signature')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- ── Section F: নমিনির তথ্য ── -->
            <div class="form-section rose">
                <div class="section-header">
                    <div class="section-icon rose"><i class="fas fa-user-friends"></i></div>
                    <h2 class="section-title">নমিনির তথ্য</h2>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="field-label">
                            <i class="fas fa-user"></i> নমিনির নাম <span class="required">*</span>
                        </label>
                        <input type="text" name="nominee_name" class="form-control-custom @error('nominee_name') is-invalid @enderror" placeholder="নমিনির নাম লিখুন" value="{{ old('nominee_name') }}" required>
                        @error('nominee_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="field-label">
                            <i class="fas fa-heart"></i> সম্পর্ক <span class="required">*</span>
                        </label>
                        <input type="text" name="nominee_relation" class="form-control-custom @error('nominee_relation') is-invalid @enderror" placeholder="যেমন: ভাই, বোন, স্ত্রী" value="{{ old('nominee_relation') }}" required>
                        @error('nominee_relation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="field-label">
                            <i class="fas fa-phone-alt"></i> ফোন নম্বর <span class="required">*</span>
                        </label>
                        <input type="text" name="nominee_phone" class="form-control-custom @error('nominee_phone') is-invalid @enderror" placeholder="নমিনির ফোন নম্বর" value="{{ old('nominee_phone') }}" required>
                        @error('nominee_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- ══════════ SUBMIT ══════════ -->
            <div class="submit-wrapper">
                <button type="submit" class="submit-btn" id="submitBtn">
                    <i class="fas fa-save"></i> সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // ══════════════════════════════════════════════════════════════
    // FILE UPLOAD HANDLER
    // ══════════════════════════════════════════════════════════════
    function handleFileSelect(input, fieldId) {
        const file = input.files[0];
        const placeholder = document.getElementById(fieldId + '_placeholder');
        const info = document.getElementById(fieldId + '_info');
        const preview = document.getElementById(fieldId + '_preview');

        if (!file) {
            placeholder.style.display = 'flex';
            info.classList.remove('visible');
            preview.classList.remove('visible');
            return;
        }

        // Show file info
        const sizeKB = (file.size / 1024).toFixed(2);
        placeholder.style.display = 'none';
        info.textContent = file.name + ' (' + sizeKB + ' KB)';
        info.classList.add('visible');

        // Show image preview
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.querySelector('img').src = e.target.result;
                preview.classList.add('visible');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.remove('visible');
        }
    }

    // ══════════════════════════════════════════════════════════════
    // SIGNATURE PAD
    // ══════════════════════════════════════════════════════════════
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;
    let strokes = [];
    let currentStroke = [];

    function resizeCanvas() {
        const rect = canvas.parentElement.getBoundingClientRect();
        const dpr = window.devicePixelRatio || 1;
        canvas.width = (rect.width - 40) * dpr;
        canvas.height = 180 * dpr;
        canvas.style.width = (rect.width - 40) + 'px';
        canvas.style.height = '180px';
        ctx.scale(dpr, dpr);
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = '#1e293b';
        redrawStrokes();
    }

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        return {
            x: clientX - rect.left,
            y: clientY - rect.top
        };
    }

    function startDrawing(e) {
        e.preventDefault();
        isDrawing = true;
        const pos = getPos(e);
        currentStroke = [pos];
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }

    function draw(e) {
        if (!isDrawing) return;
        e.preventDefault();
        const pos = getPos(e);
        currentStroke.push(pos);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    }

    function stopDrawing(e) {
        if (!isDrawing) return;
        e.preventDefault();
        isDrawing = false;
        if (currentStroke.length > 0) {
            strokes.push([...currentStroke]);
            currentStroke = [];
        }
        updateSignatureData();
    }

    function redrawStrokes() {
        const dpr = window.devicePixelRatio || 1;
        ctx.clearRect(0, 0, canvas.width / dpr, canvas.height / dpr);
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = '#1e293b';

        strokes.forEach(stroke => {
            if (stroke.length < 1) return;
            ctx.beginPath();
            ctx.moveTo(stroke[0].x, stroke[0].y);
            for (let i = 1; i < stroke.length; i++) {
                ctx.lineTo(stroke[i].x, stroke[i].y);
            }
            ctx.stroke();
        });
    }

    function clearSignature() {
        strokes = [];
        currentStroke = [];
        const dpr = window.devicePixelRatio || 1;
        ctx.clearRect(0, 0, canvas.width / dpr, canvas.height / dpr);
        document.getElementById('signatureData').value = '';
    }

    function undoSignature() {
        if (strokes.length > 0) {
            strokes.pop();
            redrawStrokes();
            updateSignatureData();
        }
    }

    function updateSignatureData() {
        if (strokes.length > 0) {
            document.getElementById('signatureData').value = canvas.toDataURL('image/png');
        } else {
            document.getElementById('signatureData').value = '';
        }
    }

    // Mouse events
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseleave', stopDrawing);

    // Touch events
    canvas.addEventListener('touchstart', startDrawing);
    canvas.addEventListener('touchmove', draw);
    canvas.addEventListener('touchend', stopDrawing);
    canvas.addEventListener('touchcancel', stopDrawing);

    // Initialize
    window.addEventListener('load', resizeCanvas);
    window.addEventListener('resize', resizeCanvas);

    // Form submission — make sure signature data is populated
    document.getElementById('infoForm').addEventListener('submit', function(e) {
        if (strokes.length === 0) {
            e.preventDefault();
            alert('অনুগ্রহ করে আপনার স্বাক্ষর দিন।');
            document.getElementById('signatureCanvas').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        updateSignatureData();
    });

    // ══════════════════════════════════════════════════════════════
    // STEPPER PROGRESS (scroll-based)
    // ══════════════════════════════════════════════════════════════
    const sections = document.querySelectorAll('.form-section');
    const stepNums = document.querySelectorAll('.step-num');
    const stepLabels = document.querySelectorAll('.step-label');
    const stepLines = document.querySelectorAll('.step-line');

    function updateStepper() {
        const scrollPos = window.scrollY + window.innerHeight * 0.5;
        let activeStep = 0;

        sections.forEach((section, index) => {
            if (scrollPos >= section.offsetTop) {
                if (index < 2) activeStep = 0;
                else if (index < 3) activeStep = 1;
                else if (index < 5) activeStep = 2;
                else activeStep = 3;
            }
        });

        stepNums.forEach((num, i) => {
            if (i <= activeStep) {
                num.classList.add('active');
                num.classList.remove('inactive');
            } else {
                num.classList.remove('active');
                num.classList.add('inactive');
            }
        });

        stepLabels.forEach((label, i) => {
            if (i <= activeStep) {
                label.classList.remove('inactive');
            } else {
                label.classList.add('inactive');
            }
        });

        stepLines.forEach((line, i) => {
            if (i < activeStep) {
                line.classList.add('active');
                line.classList.remove('inactive');
            } else {
                line.classList.remove('active');
                line.classList.add('inactive');
            }
        });
    }

    window.addEventListener('scroll', updateStepper);
    window.addEventListener('load', updateStepper);
    </script>
</body>
</html>
