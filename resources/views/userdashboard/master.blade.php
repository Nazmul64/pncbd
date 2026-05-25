<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ডাশবোর্ড - {{ $gs->site_name ?? 'PNCBD' }} Loan</title>
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
        }

        /* Header */
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
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

        /* Hero Section */
        .hero-banner {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            border-radius: 20px;
            padding: 50px 40px;
            margin: 25px 0;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -150px;
            right: -100px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .hero-avatar {
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
            width: 130px;
            height: 130px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        .hero-avatar i {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Stats Cards */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-icon.green {
            background: #d1fae5;
            color: #10b981;
        }

        .stat-icon.blue {
            background: #dbeafe;
            color: #3b82f6;
        }

        .stat-icon.purple {
            background: #e9d5ff;
            color: #a855f7;
        }

        .stat-info {
            flex: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #10b981;
        }

        .stat-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
        }

        .stat-warning {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #f59e0b;
        }

        /* Section Title */
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-card {
            background: white;
            border-radius: 15px;
            padding: 35px 25px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
            text-decoration: none;
        }

        .action-card.blue {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .action-card.purple {
            background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);
            color: white;
        }

        .action-card.orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
        }

        .action-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .action-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .action-text {
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Withdraw Section */
        .withdraw-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #e5e7eb;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .section-icon {
            width: 45px;
            height: 45px;
            background: #d1fae5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #10b981;
            font-size: 1.5rem;
        }

        .section-heading {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .warning-box {
            background: #fffbeb;
            border: 2px solid #fde68a;
            border-left: 5px solid #f59e0b;
            border-radius: 12px;
            padding: 20px;
        }

        .warning-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .warning-icon {
            font-size: 1.5rem;
            color: #f59e0b;
        }

        .warning-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #92400e;
            margin: 0;
        }

        .warning-text {
            font-size: 0.95rem;
            color: #78350f;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .help-btn {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .help-btn:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        /* No Loan Section */
        .no-loan-section {
            background: white;
            border-radius: 15px;
            padding: 60px 30px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }

        .empty-icon {
            font-size: 5rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 10px;
        }

        .empty-subtitle {
            font-size: 0.95rem;
            color: #6b7280;
            margin-bottom: 25px;
        }

        .new-loan-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 14px 35px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .new-loan-btn:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }

        @media (max-width: 992px) {
            .hero-avatar {
                display: none;
            }

            .nav-items {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .stats-section,
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="top-navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="logo-section">
                    <div class="logo-circle">U$S</div>
                    <span class="logo-text">{{ $gs->site_name ?? 'PNCBD' }}</span>
                </a>

                <ul class="nav-items">
                    <li><a href="#"><i class="fas fa-home"></i> ডাশবোর্ড</a></li>
                    <li><a href="#"><i class="fas fa-money-bill-wave"></i> ঋণ</a></li>
                    <li><a href="#"><i class="fas fa-question-circle"></i> সাহায্য</a></li>
                    <li><a href="#"><i class="fas fa-graduation-cap"></i> শিক্ষারকী</a></li>
                </ul>

                <div class="user-profile">
                    <div class="user-avatar">N</div>
                    <div class="user-details">
                        <div class="user-name">Nazmul Hossain</div>
                        <div class="user-phone">01705648864</div>
                    </div>
                    <i class="fas fa-chevron-down" style="color: #9ca3af;"></i>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Hero Banner -->
        <div class="hero-banner">
            <div class="hero-content">
                <h1 class="hero-title">স্বাগতম, Nazmul Hossain!</h1>
                <p class="hero-subtitle">আপনার আকাউন্টে ভ্যাবসায়িক স্বাগতম</p>
            </div>
            <div class="hero-avatar">
                <i class="fas fa-user"></i>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">মোট ব্যালেন্স</div>
                    <div class="stat-value">৳০.০০</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">ঋণের অবস্থা</div>
                    <div class="stat-text">কোনো ঋণ নেই</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">প্রোফাইল স্ট্যাটাস</div>
                    <div class="stat-warning">
                        অসম্পূর্ণ <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <h2 class="section-title">দ্রুত অ্যাকশন</h2>
        <div class="quick-actions">
            <a href="#" class="action-card blue">
                <div class="action-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="action-text">ঋণ আবেদন করুন</div>
            </a>

            <a href="#" class="action-card purple">
                <div class="action-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="action-text">প্রোফাইল</div>
            </a>

            <a href="#" class="action-card orange">
                <div class="action-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="action-text">কার্ড দেখুন</div>
            </a>
        </div>

        <!-- Withdraw Section -->
        <div class="withdraw-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h2 class="section-heading">Withdraw করুন</h2>
            </div>

            <div class="warning-box">
                <div class="warning-header">
                    <i class="fas fa-exclamation-triangle warning-icon"></i>
                    <h3 class="warning-title">পিন সেট করা নেই</h3>
                </div>
                <p class="warning-text">
                    টাকা উত্তোলনের জন্য আপনার একটি ৬ ডিজিটের উত্তোলন পিন প্রয়োজন। পিন সেট করতে অনুগ্রহ করে আমাদের প্রতিনিধির সাথে যোগাযোগ করুন।
                </p>
                <button class="help-btn" onclick="contactSupport()">
                    <i class="fas fa-headset"></i>
                    সাহায্য কেন্দ্র
                </button>
            </div>
        </div>

        <!-- No Loan Application -->
        <div class="no-loan-section">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h2 class="empty-title">কোনো ঋণ আবেদন নেই</h2>
            <p class="empty-subtitle">এখনও কোনো ঋণ আবেদন করা হয়নি</p>
            <a href="Loan.html" class="new-loan-btn">
                <i class="fas fa-plus"></i>
                নতুন ঋণ আবেদন করুন
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function contactSupport() {
            alert('সাহায্য কেন্দ্রে পুনর্নির্দেশিত করা হচ্ছে...');
            // window.location.href = '/support';
        }

        function applyLoan() {
            alert('ঋণ আবেদন পৃষ্ঠায় পুনর্নির্দেশিত করা হচ্ছে...');
            // window.location.href = '/apply-loan';
        }
    </script>
</body>
</html>
