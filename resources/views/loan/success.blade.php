<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আবেদন সফল - {{ $gs->site_name ?? 'Pncbd' }}</title>
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
        }

        /* Header Layout matching Dashboard */
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

        /* Success Card Styling */
        .success-container {
            max-width: 650px;
            margin: 50px auto;
            background: white;
            border-radius: 24px;
            border: 1px solid #e2e8f0;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        .success-badge {
            width: 90px;
            height: 90px;
            background: #d1fae5;
            color: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 25px auto;
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .success-title {
            color: #1e3a8a;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .success-desc {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Detail summary table inside success card */
        .loan-summary-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 35px;
            text-align: left;
        }

        .summary-header {
            font-weight: 700;
            color: #1e3a8a;
            font-size: 1.05rem;
            border-bottom: 1.5px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-badge-pending {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            border-top: 1px dashed #e2e8f0;
            padding-top: 12px;
        }

        .row-label {
            color: #64748b;
            font-weight: 500;
        }

        .row-value {
            color: #1e293b;
            font-weight: 600;
        }

        .btn-dashboard {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-dashboard:hover {
            background: #2563eb;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        @keyframes scaleIn {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

    @include('userdashboard.partials.customer-navbar', ['activeRoute' => 'loan'])

    <!-- Main Content -->
    <div class="container">
        
        <div class="success-container">
            
            <div class="success-badge">
                <i class="fa-solid fa-check"></i>
            </div>

            <h1 class="success-title">আবেদন সফলভাবে সম্পন্ন হয়েছে</h1>
            
            <p class="success-desc">
                আপনার ঋণ আবেদনটি সফলভাবে সিস্টেমে জমা হয়েছে। আমাদের ঋণ যাচাইকরণ টিম খুব শীঘ্রই আপনার আবেদনটি পর্যালোচনা করবে। সাধারণত ২৪ ঘণ্টার মধ্যে সিদ্ধান্ত জানানো হয়।
            </p>

            <!-- Loan Details Card -->
            <div class="loan-summary-box">
                <div class="summary-header">
                    <span>ঋণ আবেদনের বিবরণ</span>
                    <span class="status-badge-pending">
                        <i class="fa-solid fa-hourglass-half me-1"></i> অপেক্ষমান (Pending)
                    </span>
                </div>

                <div class="summary-row">
                    <span class="row-label">পেমেন্ট পদ্ধতি:</span>
                    <span class="row-value">
                        @if($loan->payment_method === 'bikash')
                            বিকাশ
                        @elseif($loan->payment_method === 'nagad')
                            নগদ
                        @else
                            ব্যাংক ট্রান্সফার ({{ $loan->bank_name }})
                        @endif
                    </span>
                </div>

                <div class="summary-row">
                    <span class="row-label">অ্যাকাউন্ট/মোবাইল নম্বর:</span>
                    <span class="row-value">{{ $loan->account_number }}</span>
                </div>

                <div class="summary-row">
                    <span class="row-label">ঋণের পরিমাণ:</span>
                    <span class="row-value text-success font-weight-bold">৳{{ number_format($loan->amount, 2) }}</span>
                </div>

                <div class="summary-row">
                    <span class="row-label">মেয়াদ:</span>
                    <span class="row-value">{{ $loan->tenure }} মাস</span>
                </div>

                <div class="summary-row">
                    <span class="row-label">মাসিক কিস্তি (EMI):</span>
                    <span class="row-value text-primary font-weight-bold">৳{{ number_format($loan->monthly_installment, 2) }}</span>
                </div>
            </div>

            <a href="{{ route('customer.dashboard') }}" class="btn-dashboard">
                ড্যাশবোর্ডে ফিরে যান <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
