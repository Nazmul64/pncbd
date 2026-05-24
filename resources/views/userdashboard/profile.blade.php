<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>প্রোফাইল আপডেট - {{ $gs->site_name ?? 'UBS' }}</title>
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

        /* Header */
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e3a8a;
        }

        .nav-items {
            display: flex;
            gap: 30px;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .nav-items a {
            color: #4b5563;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s;
        }

        .nav-items a:hover {
            color: #3b82f6;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px;
            border-radius: 50px;
            background: #f3f4f6;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-profile:hover {
            background: #e5e7eb;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .user-details {
            text-align: left;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1f2937;
            line-height: 1.2;
        }

        .user-phone {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Profile Header Banner */
        .profile-header-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(30, 58, 138, 0.15);
        }

        .profile-header-banner::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -100px;
            right: -50px;
        }

        .profile-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .profile-photo-container {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-photo-container i {
            font-size: 3.5rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .profile-info-text h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .profile-info-text p {
            font-size: 1.05rem;
            opacity: 0.9;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: white;
            border: 1px solid rgba(229, 231, 235, 0.7);
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.3s;
        }

        .glass-card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
        }

        .card-title-custom {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 12px;
        }

        .card-title-custom i {
            color: #3b82f6;
        }

        /* Custom Form Inputs */
        .form-label-custom {
            font-size: 0.95rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 8px;
        }

        .form-control-custom {
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control-custom:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .form-textarea-custom {
            min-height: 100px;
            resize: vertical;
        }

        .photo-upload-box {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .photo-upload-box:hover {
            border-color: #3b82f6;
            background: #f0f7ff;
        }

        .photo-upload-icon {
            font-size: 2rem;
            color: #64748b;
            margin-bottom: 10px;
        }

        .photo-upload-text {
            font-size: 0.9rem;
            color: #475569;
            font-weight: 500;
        }

        .photo-upload-hint {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 4px;
        }

        /* Buttons */
        .btn-save {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: white;
        }

        .btn-back {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back:hover {
            background: #e5e7eb;
            color: #1f2937;
        }

        /* Image Preview Circle inside Form */
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

        @media (max-width: 768px) {
            .profile-header-content {
                flex-direction: column;
                text-align: center;
            }

            .profile-header-banner {
                padding: 25px;
            }

            .nav-items {
                display: none;
            }
        }
    </style>
</head>
<body>

    @include('userdashboard.partials.customer-navbar', ['activeRoute' => 'profile'])

    <!-- Main Content Container -->
    <div class="container py-4">
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Profile Header Banner -->
        <div class="profile-header-banner">
            <div class="profile-header-content">
                <div class="profile-photo-container">
                    @if(auth()->user()->information && auth()->user()->information->selfie)
                        <img id="header-selfie-preview" src="{{ asset(auth()->user()->information->selfie) }}" alt="Selfie">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
                <div class="profile-info-text">
                    <h1>{{ auth()->user()->information->full_name ?? $user->name }}</h1>
                    <p><i class="fas fa-phone"></i> {{ auth()->user()->information->phone_number ?? ($user->phone ?? 'N/A') }}</p>
                    <p><i class="fas fa-envelope" style="font-size: 0.9rem;"></i> {{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Edit Profile Form -->
            <div class="col-lg-8">
                <div class="glass-card">
                    <h3 class="card-title-custom">
                        <i class="fas fa-user-edit"></i> প্রোফাইল তথ্য পরিবর্তন করুন
                    </h3>

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
                                    <i class="fas fa-camera photo-upload-icon"></i>
                                    <div class="photo-upload-text">সেলফি ছবি পরিবর্তন করুন</div>
                                    <div class="photo-upload-hint">JPG, PNG, WEBP (সর্বোচ্চ 10MB)</div>
                                    <input type="file" id="photo-upload-input" name="photo" style="display: none;" accept="image/*" onchange="previewSelfie(this)">
                                </label>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Full Name -->
                            <div class="col-md-6">
                                <label class="form-label form-label-custom">পূর্ণ নাম <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-custom" value="{{ old('name', auth()->user()->information->full_name ?? $user->name) }}" required placeholder="আপনার পূর্ণ নাম লিখুন">
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <label class="form-label form-label-custom">ফোন নম্বর <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control form-control-custom" value="{{ old('phone', auth()->user()->information->phone_number ?? $user->phone) }}" required placeholder="আপনার মোবাইল নম্বর লিখুন">
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6">
                                <label class="form-label form-label-custom">ইমেইল ঠিকানা <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-custom" value="{{ old('email', $user->email) }}" required placeholder="আপনার ইমেইল ঠিকানা">
                            </div>

                            <!-- Occupation -->
                            <div class="col-md-6">
                                <label class="form-label form-label-custom">পেশা <span class="text-danger">*</span></label>
                                <input type="text" name="occupation" class="form-control form-control-custom" value="{{ old('occupation', auth()->user()->information->occupation ?? '') }}" required placeholder="যেমন: ব্যবসা, চাকরি, ইত্যাদি">
                            </div>

                            <!-- Current Address -->
                            <div class="col-12">
                                <label class="form-label form-label-custom">বর্তমান ঠিকানা <span class="text-danger">*</span></label>
                                <textarea name="current_address" class="form-control form-control-custom form-textarea-custom" required placeholder="গ্রাম, ডাকঘর, উপজেলা, জেলা">{{ old('current_address', auth()->user()->information->current_address ?? '') }}</textarea>
                            </div>

                            <!-- Permanent Address -->
                            <div class="col-12">
                                <label class="form-label form-label-custom">স্থায়ী ঠিকানা <span class="text-danger">*</span></label>
                                <textarea name="permanent_address" class="form-control form-control-custom form-textarea-custom" required placeholder="গ্রাম, ডাকঘর, উপজেলা, জেলা">{{ old('permanent_address', auth()->user()->information->permanent_address ?? '') }}</textarea>
                            </div>

                            <div class="col-12 mt-4 d-flex justify-content-between align-items-center">
                                <a href="{{ route('customer.dashboard') }}" class="btn-back">
                                    <i class="fas fa-arrow-left"></i> ড্যাশবোর্ডে ফিরে যান
                                </a>
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save me-2"></i> তথ্য সংরক্ষণ করুন
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Change Password -->
            <div class="col-lg-4">
                <div class="glass-card">
                    <h3 class="card-title-custom">
                        <i class="fas fa-lock"></i> পাসওয়ার্ড পরিবর্তন
                    </h3>

                    <form action="{{ route('customer.profile.password') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label form-label-custom">বর্তমান পাসওয়ার্ড</label>
                            <input type="password" name="current_password" class="form-control form-control-custom" required placeholder="••••••••">
                        </div>

                        <div class="mb-3">
                            <label class="form-label form-label-custom">নতুন পাসওয়ার্ড</label>
                            <input type="password" name="password" class="form-control form-control-custom" required placeholder="••••••••">
                        </div>

                        <div class="mb-3">
                            <label class="form-label form-label-custom">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-custom" required placeholder="••••••••">
                        </div>

                        <div class="mb-4">
                            <p style="font-size: 0.8rem; color: #64748b;" class="mb-0">
                                <i class="fas fa-info-circle me-1"></i> পাসওয়ার্ড অবশ্যই ন্যূনতম ৮ অক্ষরের হতে হবে।
                            </p>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-key me-2"></i> পাসওয়ার্ড আপডেট করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewSelfie(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('form-selfie-preview').src = e.target.result;
                    const headerPreview = document.getElementById('header-selfie-preview');
                    if (headerPreview) {
                        headerPreview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
