<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>স্টাফ প্যানেল - {{ $gs->site_name ?? 'PNCBD' }} - লোন ম্যানেজমেন্ট সিস্টেম</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: #0f172a; /* Deep Slate dark mode */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
            padding: 20px;
            color: #f8fafc;
            position: relative;
            overflow-x: hidden;
        }

        /* Abstract glowing blobs for premium feel */
        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
            top: -100px;
            left: -100px;
            z-index: 0;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 70%);
            bottom: -100px;
            right: -100px;
            z-index: 0;
        }

        .login-container {
            width: 100%;
            max-width: 960px;
            z-index: 10;
        }

        .brand-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #3b82f6;
            margin-bottom: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
        }

        .brand-section h1 {
            font-size: 32px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .brand-section p {
            font-size: 14px;
            color: #94a3b8;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .split-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        @media (max-width: 768px) {
            .split-grid {
                grid-template-columns: 1fr;
            }
        }

        .premium-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .premium-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.3);
        }

        .card-title-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .card-title-section h3 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .card-title-section p {
            font-size: 14px;
            color: #64748b;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 24px;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 16px;
            z-index: 10;
        }

        .form-control-custom {
            width: 100%;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px 12px 46px;
            font-size: 15px;
            color: #0f172a;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #3b82f6;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn-login-custom {
            width: 100%;
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            transition: all 0.2s ease;
        }

        .btn-login-custom:hover {
            background: #1d4ed8;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            transform: translateY(-1px);
        }

        .btn-login-custom:active {
            transform: translateY(0);
        }

        /* Scrollable Staff list styling */
        .staff-list {
            max-height: 280px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .staff-list::-webkit-scrollbar {
            width: 6px;
        }

        .staff-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .staff-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .staff-item:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .staff-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .staff-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
        }

        .staff-name {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
        }

        .status-badge {
            font-size: 18px;
            color: #10b981;
        }

        .footer-link-wrapper {
            text-align: center;
            margin-top: 30px;
            z-index: 10;
        }

        .footer-link-wrapper a {
            color: #94a3b8;
            font-size: 14px;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .footer-link-wrapper a:hover {
            color: #3b82f6;
        }
    </style>
</head>
<body>

<div class="login-container">
    {{-- Header --}}
    <div class="brand-section">
        <div class="brand-icon-wrapper">
            @if(!empty($gs->header_logo))
                <img src="{{ asset($gs->header_logo) }}" alt="{{ $gs->site_name ?? 'PNCBD' }}" style="width: 60px; height: 60px; object-fit: contain; border-radius: 12px;">
            @else
                <i class="fa-solid fa-building-columns"></i>
            @endif
        </div>
        <h1>{{ $gs->site_name ?? 'PNCBD' }}</h1>
        <p>Loan Management System — Staff Panel</p>
    </div>

    {{-- Grid containing cards --}}
    <div class="split-grid">
        
        {{-- Left: Login Card --}}
        <div class="premium-card">
            <div>
                <div class="card-title-section">
                    <h3>স্টাফ লগইন</h3>
                    <p>আপনার স্টাফ অ্যাকাউন্টে প্রবেশ করুন</p>
                </div>

                {{-- Alert for errors --}}
                @if($errors->any())
                    <div class="alert alert-danger p-3 mb-4" style="border-radius:12px; font-size:14px;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Alert for success --}}
                @if(session('success'))
                    <div class="alert alert-success p-3 mb-4" style="border-radius:12px; font-size:14px;">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('emplee.login.submit') }}" method="POST">
                    @csrf

                    {{-- Phone Input --}}
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fa-solid fa-phone"></i> ফোন নম্বর
                        </label>
                        <div class="input-group-custom">
                            <i class="fa-solid fa-phone input-icon"></i>
                            <input 
                                type="text" 
                                name="phone" 
                                class="form-control-custom" 
                                placeholder="ফোন নম্বর" 
                                value="{{ old('phone') }}"
                                required 
                                autofocus
                            />
                        </div>
                    </div>

                    {{-- Password Input --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fa-solid fa-lock"></i> পাসওয়ার্ড
                        </label>
                        <div class="input-group-custom">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control-custom" 
                                placeholder="পাসওয়ার্ড" 
                                required
                            />
                        </div>
                    </div>

                    {{-- Submit button --}}
                    <button type="submit" class="btn-login-custom">
                        <i class="fa-solid fa-right-to-bracket"></i> লগইন করুন
                    </button>
                </form>
            </div>
        </div>

        {{-- Right: Staff List Card --}}
        <div class="premium-card">
            <div>
                <div class="card-title-section">
                    <h3>স্টাফ তালিকা</h3>
                    <p>সক্রিয় স্টাফ সদস্য</p>
                </div>

                <div class="staff-list">
                    @forelse($staffMembers as $member)
                        <div class="staff-item">
                            <div class="staff-profile">
                                <div class="staff-avatar">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div class="staff-name">
                                    {{ $member->name }}
                                </div>
                            </div>
                            <div class="status-badge">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                    @empty
                        {{-- Mock list for high premium aesthetics if no database records --}}
                        <div class="staff-item">
                            <div class="staff-profile">
                                <div class="staff-avatar">P</div>
                                <div class="staff-name">Pascal Roth</div>
                            </div>
                            <div class="status-badge"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                        <div class="staff-item">
                            <div class="staff-profile">
                                <div class="staff-avatar">C</div>
                                <div class="staff-name">Chiara Suter</div>
                            </div>
                            <div class="status-badge"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                        <div class="staff-item">
                            <div class="staff-profile">
                                <div class="staff-avatar">A</div>
                                <div class="staff-name">Adrian Vogel</div>
                            </div>
                            <div class="status-badge"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                        <div class="staff-item">
                            <div class="staff-profile">
                                <div class="staff-avatar">E</div>
                                <div class="staff-name">Elisa Maurer</div>
                            </div>
                            <div class="status-badge"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- Footer link --}}
    <div class="footer-link-wrapper">
        <a href="/">
            <i class="fa-solid fa-arrow-left"></i> হোমে ফিরে যান
        </a>
    </div>
</div>

</body>
</html>
