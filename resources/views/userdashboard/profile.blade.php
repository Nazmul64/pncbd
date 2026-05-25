<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>প্রোফাইল সেন্টার - {{ $gs->site_name ?? 'UBS' }}</title>
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
            background: #f9fafb;
            min-height: 100vh;
        }

        /* Nav and layout */
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 0;
        }

        .profile-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 15px;
        }

        .page-title {
            text-align: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .page-title i {
            color: #3b82f6;
        }

        /* 6-Card Grid Layout matching exact screenshot */
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        @media (max-width: 992px) {
            .profile-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        .profile-card {
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .profile-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .profile-card.blue {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .profile-card.purple {
            background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%);
        }

        .profile-card.green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .profile-card.orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .profile-card.teal {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
        }

        .profile-card.pink {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        }

        .profile-card-icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .profile-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .profile-card-desc {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        /* Quick Info Table Block at bottom */
        .quick-info-section {
            background: white;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            margin-bottom: 40px;
        }

        .quick-info-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
            border-bottom: 1.5px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .quick-info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .quick-info-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }

        @media (max-width: 480px) {
            .quick-info-grid {
                grid-template-columns: 1fr;
            }
        }

        .quick-info-label {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quick-info-value {
            font-size: 1.15rem;
            font-weight: 700;
            color: #111827;
        }

        .quick-info-value.balance {
            color: #10b981;
        }

        .quick-info-value.incomplete {
            color: #a855f7;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .quick-info-value.complete {
            color: #10b981;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        /* Editing forms custom panels */
        .action-panel {
            background: white;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            margin-bottom: 30px;
            display: none;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-label-custom {
            font-size: 0.92rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 8px;
        }

        .form-control-custom {
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: #f8fafc;
            outline: none;
        }

        .form-control-custom:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .preview-circle-form {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 15px;
            border: 3px solid #3b82f6;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
        }

        .preview-circle-form img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-upload-box {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.3s;
        }

        .photo-upload-box:hover {
            border-color: #3b82f6;
            background: #f0f7ff;
        }

        .btn-save {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.98rem;
            transition: all 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(37,99,235,0.2);
            color: white;
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

        /* Floating Home button */
        .btn-home {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 50px;
            height: 50px;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            transition: all 0.3s;
            z-index: 1000;
        }

        .btn-home:hover {
            background: #2563eb;
            transform: scale(1.1);
            color: white;
        }
    </style>
</head>
<body>

    @include('userdashboard.partials.customer-navbar', ['activeRoute' => 'profile'])

    <div class="profile-container">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4 border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4 border-0 shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4 border-0 shadow-sm" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Title -->
        <h2 class="page-title">
            <i class="fa-solid fa-circle-user"></i> প্রোফাইল সেন্টার
        </h2>

        <!-- 6-Card Action Dashboard Grid -->
        <div class="profile-grid">
            
            <!-- Card 1: View Profile -->
            <div class="profile-card blue" data-bs-toggle="modal" data-bs-target="#viewProfileModal">
                <div class="profile-card-icon"><i class="fa-solid fa-id-card-clip"></i></div>
                <div class="profile-card-title">প্রোফাইল দেখুন</div>
                <div class="profile-card-desc">আপনার সম্পূর্ণ প্রোফাইল দেখুন</div>
            </div>

            <!-- Card 2: Edit Profile -->
            <div class="profile-card purple" onclick="togglePanel('editProfilePanel')">
                <div class="profile-card-icon"><i class="fa-solid fa-user-pen"></i></div>
                <div class="profile-card-title">প্রোফাইল সম্পাদনা</div>
                <div class="profile-card-desc">তথ্য আপডেট করুন</div>
            </div>

            <!-- Card 3: Change Password -->
            <div class="profile-card green" onclick="togglePanel('changePasswordPanel')">
                <div class="profile-card-icon"><i class="fa-solid fa-key"></i></div>
                <div class="profile-card-title">পাসওয়ার্ড পরিবর্তন</div>
                <div class="profile-card-desc">নতুন পাসওয়ার্ড সেট করুন</div>
            </div>

            <!-- Card 4: View Card -->
            <a href="{{ route('customer.card') }}" class="profile-card orange">
                <div class="profile-card-icon"><i class="fa-solid fa-address-card"></i></div>
                <div class="profile-card-title">কার্ড দেখুন</div>
                <div class="profile-card-desc">আপনার পরিচয় কার্ড</div>
            </a>

            <!-- Card 5: Bank Info -->
            <div class="profile-card teal" data-bs-toggle="modal" data-bs-target="#viewBankInfoModal">
                <div class="profile-card-icon"><i class="fa-solid fa-building-columns"></i></div>
                <div class="profile-card-title">ব্যাংক তথ্য</div>
                <div class="profile-card-desc">ব্যাংক বিবরণ দেখুন</div>
            </div>

            <!-- Card 6: Loan Info -->
            <a href="{{ route('customer.dashboard') }}#loan-section" class="profile-card pink">
                <div class="profile-card-icon"><i class="fa-solid fa-money-bill-transfer"></i></div>
                <div class="profile-card-title">ঋণ তথ্য</div>
                <div class="profile-card-desc">ঋণ বিবরণ দেখুন</div>
            </a>

        </div>

        <!-- Collapsible 1: Edit Profile Form -->
        <div class="action-panel" id="editProfilePanel">
            <h4 class="fw-bold mb-4 border-bottom pb-2 text-dark" style="font-size: 1.25rem;">
                <i class="fa-solid fa-user-pen text-primary me-2"></i> প্রোফাইল তথ্য সংশোধন করুন
            </h4>

            <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="text-center mb-4">
                    <div class="preview-circle-form">
                        @if(auth()->user()->information && auth()->user()->information->selfie)
                            <img id="form-selfie-preview" src="{{ asset(auth()->user()->information->selfie) }}" alt="Selfie">
                        @else
                            <img id="form-selfie-preview" src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2364748b'><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>" alt="Selfie">
                        @endif
                    </div>
                    
                    <div class="d-inline-block">
                        <label for="photo-upload-input" class="photo-upload-box">
                            <i class="fas fa-camera text-secondary me-2"></i>
                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">ছবি পরিবর্তন করুন</span>
                            <input type="file" id="photo-upload-input" name="photo" style="display: none;" accept="image/*" onchange="previewSelfie(this)">
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-custom">পূর্ণ নাম <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-custom w-100" value="{{ old('name', auth()->user()->information->full_name ?? auth()->user()->name) }}" required placeholder="পূর্ণ নাম">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-custom">ফোন নম্বর <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control form-control-custom w-100" value="{{ old('phone', auth()->user()->information->phone_number ?? auth()->user()->phone) }}" required placeholder="মোবাইল নম্বর">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-custom">ইমেইল ঠিকানা <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-custom w-100" value="{{ old('email', auth()->user()->email) }}" required placeholder="ইমেইল">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-custom">পেশা <span class="text-danger">*</span></label>
                        <input type="text" name="occupation" class="form-control form-control-custom w-100" value="{{ old('occupation', auth()->user()->information->occupation ?? '') }}" required placeholder="যেমন: ব্যবসা, চাকরি">
                    </div>

                    <div class="col-12">
                        <label class="form-label form-label-custom">বর্তমান ঠিকানা <span class="text-danger">*</span></label>
                        <textarea name="current_address" class="form-control form-control-custom w-100" rows="3" required placeholder="গ্রাম, ডাকঘর, থানা, জেলা">{{ old('current_address', auth()->user()->information->current_address ?? '') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label form-label-custom">স্থায়ী ঠিকানা <span class="text-danger">*</span></label>
                        <textarea name="permanent_address" class="form-control form-control-custom w-100" rows="3" required placeholder="গ্রাম, ডাকঘর, থানা, জেলা">{{ old('permanent_address', auth()->user()->information->permanent_address ?? '') }}</textarea>
                    </div>

                    <div class="col-12 mt-4 d-flex gap-3 justify-content-end">
                        <button type="button" class="btn btn-cancel" onclick="hideAllPanels()">বাতিল করুন</button>
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save me-1"></i> সংরক্ষণ করুন
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Collapsible 2: Change Password Form -->
        <div class="action-panel" id="changePasswordPanel">
            <h4 class="fw-bold mb-4 border-bottom pb-2 text-dark" style="font-size: 1.25rem;">
                <i class="fa-solid fa-lock text-primary me-2"></i> পাসওয়ার্ড পরিবর্তন করুন
            </h4>

            <form action="{{ route('customer.profile.password') }}" method="POST" class="row g-3">
                @csrf
                
                <div class="col-md-12">
                    <label class="form-label form-label-custom">বর্তমান পাসওয়ার্ড</label>
                    <input type="password" name="current_password" class="form-control form-control-custom w-100" required placeholder="••••••••">
                </div>

                <div class="col-md-6">
                    <label class="form-label form-label-custom">নতুন পাসওয়ার্ড</label>
                    <input type="password" name="password" class="form-control form-control-custom w-100" required placeholder="••••••••">
                </div>

                <div class="col-md-6">
                    <label class="form-label form-label-custom">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-custom w-100" required placeholder="••••••••">
                </div>

                <div class="col-12 mt-4 d-flex gap-3 justify-content-end">
                    <button type="button" class="btn btn-cancel" onclick="hideAllPanels()">বাতিল করুন</button>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-key me-1"></i> পাসওয়ার্ড আপডেট করুন
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Info Summary Grid at bottom -->
        <div class="quick-info-section">
            <div class="quick-info-title">
                <i class="fa-solid fa-chart-simple text-primary me-2"></i> দ্রুত তথ্য
            </div>

            <div class="quick-info-grid">
                
                <div>
                    <div class="quick-info-label">নাম</div>
                    <div class="quick-info-value">{{ auth()->user()->information->full_name ?? auth()->user()->name }}</div>
                </div>

                <div>
                    <div class="quick-info-label">ফোন</div>
                    <div class="quick-info-value">{{ auth()->user()->information->phone_number ?? (auth()->user()->phone ?? 'N/A') }}</div>
                </div>

                <div>
                    <div class="quick-info-label">ব্যালেন্স</div>
                    <div class="quick-info-value balance">
                        ৳{{ number_format(auth()->user()->loans->where('status', 'approved')->sum('amount'), 2) }}
                    </div>
                </div>

                <div>
                    <div class="quick-info-label">প্রোফাইল</div>
                    <div class="quick-info-value">
                        @if(auth()->user()->information)
                            <span class="quick-info-value complete">
                                সম্পূর্ণ <i class="fas fa-check-circle" style="font-size:0.95rem;"></i>
                            </span>
                        @else
                            <span class="quick-info-value incomplete">
                                অসম্পূর্ণ <i class="fas fa-exclamation-triangle" style="font-size:0.95rem;"></i>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- ── Interactive Modal 1: View Profile ── -->
    <div class="modal fade" id="viewProfileModal" tabindex="-1" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 15px 35px rgba(0,0,0,0.15);">
                <div class="modal-header border-0 pb-0" style="padding:25px 25px 0 25px;">
                    <h5 class="modal-title fw-bold text-primary fs-5" id="viewProfileModalLabel">
                        <i class="fa-solid fa-address-card me-2"></i> আপনার সম্পূর্ণ প্রোফাইল তথ্য
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:25px; max-height:80vh; overflow-y:auto;">
                    @if(auth()->user()->information)
                        @php $info = auth()->user()->information; @endphp
                        
                        <div class="text-center mb-4">
                            <div class="mx-auto border" style="width:120px; height:120px; border-radius:50%; overflow:hidden; border:3px solid #3b82f6 !important; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                                @if($info->selfie)
                                    <img src="{{ asset($info->selfie) }}" style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    <i class="fas fa-user-circle text-muted" style="font-size:120px; line-height:1;"></i>
                                @endif
                            </div>
                            <h4 class="fw-bold mt-3 mb-1">{{ $info->full_name }}</h4>
                            <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $info->occupation }}</span>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6 border-bottom pb-2">
                                <span class="text-muted d-block small fw-bold">NID নম্বর</span>
                                <strong class="text-dark">{{ $info->nid_number }}</strong>
                            </div>
                            <div class="col-md-6 border-bottom pb-2">
                                <span class="text-muted d-block small fw-bold">মোবাইল নম্বর</span>
                                <strong class="text-dark">{{ $info->phone_number }}</strong>
                            </div>
                            <div class="col-md-6 border-bottom pb-2">
                                <span class="text-muted d-block small fw-bold">বর্তমান ঠিকানা</span>
                                <strong class="text-dark">{{ $info->current_address }}</strong>
                            </div>
                            <div class="col-md-6 border-bottom pb-2">
                                <span class="text-muted d-block small fw-bold">স্থায়ী ঠিকানা</span>
                                <strong class="text-dark">{{ $info->permanent_address }}</strong>
                            </div>
                            
                            @if($info->loan_reason)
                                <div class="col-md-12 border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">ঋণ গ্রহণের কারণ</span>
                                    <strong class="text-dark">{{ $info->loan_reason }}</strong>
                                </div>
                            @endif

                            <div class="col-md-6 border-bottom pb-2">
                                <span class="text-muted d-block small fw-bold">নমিনির নাম</span>
                                <strong class="text-dark">{{ $info->nominee_name }} ({{ $info->nominee_relation }})</strong>
                            </div>
                            <div class="col-md-6 border-bottom pb-2">
                                <span class="text-muted d-block small fw-bold">নমিনির ফোন নম্বর</span>
                                <strong class="text-dark">{{ $info->nominee_phone }}</strong>
                            </div>

                            {{-- Signatures & Docs scans --}}
                            @if($info->signature)
                                <div class="col-md-6 pt-3">
                                    <span class="text-muted d-block small fw-bold mb-2">গ্রাহকের স্বাক্ষর</span>
                                    <div class="border rounded p-2 text-center bg-light" style="max-width:180px;">
                                        <img src="{{ asset($info->signature) }}" style="max-height:80px; max-width:100%; object-fit:contain;">
                                    </div>
                                </div>
                            @endif

                            @if($info->nid_front)
                                <div class="col-md-6 pt-3">
                                    <span class="text-muted d-block small fw-bold mb-2">NID সামনের ও পিছনের স্ক্যান</span>
                                    <div class="d-flex gap-2">
                                        <a href="{{ asset($info->nid_front) }}" target="_blank" class="border rounded p-1 text-center bg-light" style="width:90px; height:60px; overflow:hidden; display:inline-block;">
                                            <img src="{{ asset($info->nid_front) }}" style="width:100%; height:100%; object-fit:cover;">
                                        </a>
                                        @if($info->nid_back)
                                            <a href="{{ asset($info->nid_back) }}" target="_blank" class="border rounded p-1 text-center bg-light" style="width:90px; height:60px; overflow:hidden; display:inline-block;">
                                                <img src="{{ asset($info->nid_back) }}" style="width:100%; height:100%; object-fit:cover;">
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- KYC documents form redirect request -->
                        <div class="text-center py-4">
                            <i class="fa-solid fa-file-excel text-muted mb-3" style="font-size:3.5rem;"></i>
                            <h5 class="fw-bold">কোনো প্রোফাইল বা ডকুমেন্ট তথ্য আপলোড করা হয়নি!</h5>
                            <p class="text-muted small">ঋণের আবেদন করতে এবং পূর্ণ প্রোফাইল সক্রিয় করতে দয়া করে আপনার KYC ডকুমেন্টস আপলোড করুন।</p>
                            <a href="{{ route('customer.information.create') }}" class="btn btn-primary rounded-pill px-4 mt-2" style="background:#3b82f6; border:none;">
                                <i class="fa-solid fa-cloud-upload-alt me-1"></i> ডকুমেন্ট আপলোড করুন
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ── Interactive Modal 2: Bank Info ── -->
    <div class="modal fade" id="viewBankInfoModal" tabindex="-1" aria-labelledby="viewBankInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 15px 35px rgba(0,0,0,0.15);">
                <div class="modal-header border-0 pb-0" style="padding:25px 25px 0 25px;">
                    <h5 class="modal-title fw-bold text-primary fs-5" id="viewBankInfoModalLabel">
                        <i class="fa-solid fa-building-columns me-2"></i> ব্যাংক বা মোবাইল ওয়ালেট তথ্য
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:25px;">
                    @php 
                        $latestLoan = auth()->user()->loans->first(); 
                        $hasBankInfo = auth()->user()->bank_name || auth()->user()->bank_account_number || $latestLoan;
                    @endphp

                    @if($hasBankInfo)
                        <div class="d-flex flex-column gap-3">
                            @if($latestLoan && $latestLoan->payment_method === 'bank')
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">পেমেন্ট পদ্ধতি</span>
                                    <span class="badge bg-primary px-3 py-1 mt-1 fs-7">ব্যাংক ট্রান্সফার</span>
                                </div>
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">ব্যাংকের নাম</span>
                                    <strong class="text-dark">{{ $latestLoan->bank->name ?? ' Dutch-Bangla Bank ' }}</strong>
                                </div>
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">অ্যাকাউন্ট হোল্ডারের নাম</span>
                                    <strong class="text-dark">{{ $latestLoan->account_holder_name ?? '-' }}</strong>
                                </div>
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">অ্যাকাউন্ট নম্বর</span>
                                    <strong class="text-dark">{{ $latestLoan->account_number ?? '-' }}</strong>
                                </div>
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">শাখা (Branch)</span>
                                    <strong class="text-dark">{{ $latestLoan->branch ?? '-' }}</strong>
                                </div>
                            @elseif($latestLoan && ($latestLoan->payment_method === 'bikash' || $latestLoan->payment_method === 'nagad'))
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">পেমেন্ট পদ্ধতি</span>
                                    <span class="badge bg-danger px-3 py-1 mt-1 fs-7">
                                        {{ $latestLoan->payment_method === 'bikash' ? 'বিকাশ পেমেন্ট' : 'নগদ পেমেন্ট' }}
                                    </span>
                                </div>
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">মোবাইল ব্যাংকিং নম্বর</span>
                                    <strong class="text-dark fs-5">{{ $latestLoan->account_number }}</strong>
                                </div>
                            @else
                                {{-- Fallback to user columns --}}
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">ব্যাংকের নাম</span>
                                    <strong class="text-dark">{{ auth()->user()->bank_name ?? '-' }}</strong>
                                </div>
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">অ্যাকাউন্ট হোল্ডারের নাম</span>
                                    <strong class="text-dark">{{ auth()->user()->bank_account_name ?? '-' }}</strong>
                                </div>
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">অ্যাকাউন্ট নম্বর</span>
                                    <strong class="text-dark">{{ auth()->user()->bank_account_number ?? '-' }}</strong>
                                </div>
                                <div class="border-bottom pb-2">
                                    <span class="text-muted d-block small fw-bold">মোবাইল ব্যাংকিং নম্বর</span>
                                    <strong class="text-dark fs-5">{{ auth()->user()->mobile_banking_number ?? '-' }}</strong>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fa-solid fa-university text-muted mb-3" style="font-size:3.5rem;"></i>
                            <h5 class="fw-bold">কোনো ব্যাংক বা পেমেন্ট তথ্য পাওয়া যায়নি!</h5>
                            <p class="text-muted small">আপনি যখন কোনো ঋণের জন্য আবেদন করবেন, আবেদন করার সময় যে ব্যাংক বা মোবাইল ওয়ালেট নম্বর প্রদান করবেন তা এখানে স্বয়ংক্রিয়ভাবে দেখাবে।</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Back Home button -->
    <a href="{{ route('customer.dashboard') }}" class="btn-home" title="হোমে ফিরে যান">
        <i class="fa-solid fa-house"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePanel(panelId) {
            const editPanel = document.getElementById('editProfilePanel');
            const passwordPanel = document.getElementById('changePasswordPanel');
            
            // Hide all first
            editPanel.style.display = 'none';
            passwordPanel.style.display = 'none';
            
            // Show target
            const targetPanel = document.getElementById(panelId);
            targetPanel.style.display = 'block';
            
            // Scroll smoothly
            targetPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function hideAllPanels() {
            document.getElementById('editProfilePanel').style.display = 'none';
            document.getElementById('changePasswordPanel').style.display = 'none';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function previewSelfie(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('form-selfie-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
