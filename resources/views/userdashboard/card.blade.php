<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সদস্য পরিচয় কার্ড - {{ $gs->site_name ?? 'UBS' }}</title>
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
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
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
            background: #f1f5f9;
            cursor: pointer;
            transition: all 0.3s;
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

        /* Info Alert Box */
        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 16px;
            max-width: 750px;
            margin: 30px auto 10px auto;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-icon {
            font-size: 1.25rem;
            color: #3b82f6;
            margin-top: 2px;
        }

        .info-text-title {
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 4px;
        }

        .info-text-body {
            font-size: 0.95rem;
            color: #1e40af;
            margin: 0;
        }

        /* Card Container Styling */
        .card-wrapper-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px auto;
            padding: 10px;
        }

        /* Member Card Mockup */
        .member-card {
            width: 500px;
            height: 300px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(30, 64, 175, 0.25);
            position: relative;
            overflow: hidden;
            color: white;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Card Background Patterns */
        .member-card::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -100px;
            right: -80px;
            pointer-events: none;
        }

        .member-card::after {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            bottom: -200px;
            left: -100px;
            pointer-events: none;
        }

        .card-header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 10;
        }

        .card-system-title {
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-subtitle {
            font-size: 0.75rem;
            opacity: 0.85;
            letter-spacing: 1px;
            font-weight: 500;
            margin-top: 1px;
        }

        .card-chip {
            font-size: 1.7rem;
            opacity: 0.35;
        }

        .card-body-section {
            display: flex;
            gap: 20px;
            align-items: center;
            margin: 15px 0;
            position: relative;
            z-index: 10;
        }

        .card-photo-wrapper {
            width: 100px;
            height: 100px;
            border: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }

        .card-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-photo-placeholder {
            font-size: 3rem;
            color: rgba(255,255,255,0.7);
        }

        .card-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex-grow: 1;
        }

        .card-row-info {
            display: flex;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .card-label {
            width: 75px;
            opacity: 0.8;
            font-weight: 500;
            flex-shrink: 0;
        }

        .card-value {
            font-weight: 600;
            word-break: break-word;
        }

        .card-footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            position: relative;
            z-index: 10;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 10px;
        }

        .card-footer-item {
            display: flex;
            flex-direction: column;
        }

        .card-footer-label {
            font-size: 0.7rem;
            opacity: 0.75;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-footer-value {
            font-size: 0.9rem;
            font-weight: 700;
        }

        .card-footer-value.balance {
            font-size: 1.15rem;
            color: #10b981;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        /* Action Buttons styling */
        .actions-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 50px;
        }

        .btn-action {
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-download {
            background: #0f172a;
            color: white;
            border: none;
        }

        .btn-download:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
        }

        .btn-print {
            background: white;
            color: #334155;
            border: 1.5px solid #cbd5e1;
        }

        .btn-print:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            transform: translateY(-2px);
        }

        /* Floating Home Button */
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

        .btn-home i {
            font-size: 1.3rem;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: white !important;
            }
            .top-navbar, .info-box, .actions-container, .btn-home, .text-center {
                display: none !important;
            }
            .card-wrapper-container {
                margin: 0 !important;
                padding: 0 !important;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) scale(1.2);
            }
            .member-card {
                box-shadow: none !important;
                border: 1px solid #1e3a8a !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    @include('userdashboard.partials.customer-navbar', ['activeRoute' => 'card'])

    <!-- Content -->
    <div class="container py-4 flex-grow-1 d-flex flex-column justify-content-center">
        
        <div class="text-center mb-2">
            <h2 class="fw-bold text-dark">সদস্য পরিচয় কার্ড</h2>
            <p class="text-muted">আপনার ডিজিটাল সদস্যপদ কার্ড</p>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <i class="fa-solid fa-circle-info info-icon"></i>
            <div class="info-text">
                <div class="info-text-title">কার্ড ব্যবহার সংক্রান্ত তথ্য</div>
                <p class="info-text-body">এই কার্ডটি আপনার সদস্যপদের প্রমাণ হিসেবে ব্যবহৃত হবে। আপনি এটি ডাউনলোড বা প্রিন্ট করে রাখতে পারেন।</p>
            </div>
        </div>

        <!-- Card Mockup Section -->
        <div class="card-wrapper-container">
            <div class="member-card" id="member-card">
                
                <!-- Card Header -->
                <div class="card-header-section">
                    <div>
                        <div class="card-system-title">UBS Loan Management System</div>
                        <div class="card-subtitle">সদস্য পরিচয়পত্র</div>
                    </div>
                    <div class="card-chip">
                        <i class="fa-solid fa-id-badge"></i>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body-section">
                    <div class="card-photo-wrapper">
                        @if(auth()->user()->information && auth()->user()->information->selfie)
                            <img src="{{ asset(auth()->user()->information->selfie) }}" class="card-photo" alt="Photo">
                        @else
                            <i class="fa-solid fa-user card-photo-placeholder"></i>
                        @endif
                    </div>
                    
                    <div class="card-details">
                        <div class="card-row-info">
                            <span class="card-label">নাম</span>
                            <span class="card-value">: {{ auth()->user()->information->full_name ?? auth()->user()->name }}</span>
                        </div>
                        <div class="card-row-info">
                            <span class="card-label">ফোন নম্বর</span>
                            <span class="card-value">: {{ auth()->user()->information->phone_number ?? (auth()->user()->phone ?? 'N/A') }}</span>
                        </div>
                        <div class="card-row-info">
                            <span class="card-label">NID</span>
                            <span class="card-value">: {{ auth()->user()->information->nid_number ?? 'N/A' }}</span>
                        </div>
                        <div class="card-row-info">
                            <span class="card-label">ঠিকানা</span>
                            <span class="card-value">: {{ auth()->user()->information->current_address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer-section">
                    <div class="card-footer-item">
                        <span class="card-footer-label">সদস্য হওয়ার তারিখ</span>
                        <span class="card-footer-value">{{ auth()->user()->created_at ? auth()->user()->created_at->format('d M, Y') : date('d M, Y') }}</span>
                    </div>

                    <div class="card-footer-item text-end">
                        <span class="card-footer-label">ব্যালেন্স</span>
                        <span class="card-footer-value balance">৳{{ number_format(auth()->user()->loans->where('status', 'approved')->sum('amount'), 0) }}</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="actions-container">
            <button class="btn-action btn-print" onclick="window.print()">
                <i class="fa-solid fa-print"></i> প্রিন্ট করুন
            </button>
            <button class="btn-action btn-download" id="download-btn">
                <i class="fa-solid fa-download"></i> ডাউনলোড করুন
            </button>
        </div>

    </div>

    <!-- Floating Back Home Button -->
    <a href="{{ route('customer.dashboard') }}" class="btn-home" title="হোমে ফিরে যান">
        <i class="fa-solid fa-house"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- html2canvas script for high quality download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('download-btn').addEventListener('click', function () {
            const card = document.getElementById('member-card');
            
            // Generate beautiful image with higher resolution
            const options = {
                useCORS: true,
                scale: 2, // Double quality
                backgroundColor: null, // Transparent corners
            };

            html2canvas(card, options).then(canvas => {
                const link = document.createElement('a');
                link.download = 'UBS_Member_Card_{{ auth()->user()->id }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
    </script>
</body>
</html>
