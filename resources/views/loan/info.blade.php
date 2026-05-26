<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ঋণ আবেদন সারাংশ - {{ $gs->site_name ?? 'Pncbd' }}</title>
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

        /* Steps Stepper Indicator */
        .stepper-container {
            max-width: 800px;
            margin: 30px auto 40px auto;
        }

        .stepper {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 5%;
            right: 5%;
            height: 4px;
            background: #e2e8f0;
            z-index: 1;
        }

        .step-progress {
            position: absolute;
            top: 20px;
            left: 5%;
            width: 100%;
            height: 4px;
            background: #10b981;
            z-index: 2;
            transition: width 0.4s ease;
        }

        .step-item {
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 30%;
        }

        .step-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #f1f5f9;
            border: 3px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 8px;
            transition: all 0.3s;
        }

        .step-item.active .step-circle {
            background: #3b82f6;
            border-color: #3b82f6;
            color: white;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.4);
        }

        .step-item.completed .step-circle {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        .step-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            text-align: center;
        }

        .step-item.active .step-label {
            color: #1e3a8a;
            font-weight: 700;
        }

        .step-item.completed .step-label {
            color: #10b981;
        }

        /* Summary Container layout */
        .summary-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            max-width: 1000px;
            margin: 0 auto 30px auto;
        }

        .summary-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header-custom {
            border-bottom: 1.5px solid #f1f5f9;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #f1f5f9;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            color: #64748b;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .info-value {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: right;
        }

        /* Calculations Row styled */
        .calc-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto 30px auto;
        }

        .calc-box {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .calc-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08);
        }

        .calc-box.highlight {
            border-color: #3b82f6;
            background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%);
        }

        .calc-box.interest {
            border-color: #a855f7;
            background: linear-gradient(180deg, #ffffff 0%, #faf5ff 100%);
        }

        .calc-box.payable {
            border-color: #10b981;
            background: linear-gradient(180deg, #ffffff 0%, #ecfdf5 100%);
        }

        .calc-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            font-size: 1.4rem;
        }

        .calc-icon.blue {
            background: #dbeafe;
            color: #3b82f6;
        }

        .calc-icon.purple {
            background: #f3e8ff;
            color: #a855f7;
        }

        .calc-icon.green {
            background: #d1fae5;
            color: #10b981;
        }

        .calc-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .calc-val {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1f2937;
        }

        .calc-box.highlight .calc-val {
            color: #2563eb;
        }

        .calc-box.payable .calc-val {
            color: #059669;
        }

        .calc-box.interest .calc-val {
            color: #7e22ce;
        }

        /* Terms & Checkbox styling */
        .terms-panel {
            max-width: 1000px;
            margin: 0 auto 30px auto;
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .terms-list {
            list-style: none;
            padding: 0;
            margin-bottom: 25px;
        }

        .terms-list li {
            position: relative;
            padding-left: 30px;
            margin-bottom: 12px;
            font-size: 0.95rem;
            color: #475569;
            line-height: 1.6;
        }

        .terms-list li::before {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 2px;
            color: #10b981;
            font-size: 0.9rem;
        }

        .custom-checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px 20px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .custom-checkbox-container:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .custom-checkbox-container input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 3px;
            cursor: pointer;
        }

        .custom-checkbox-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e293b;
            user-select: none;
            cursor: pointer;
        }

        /* Navigation buttons */
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            max-width: 1000px;
            margin: 0 auto;
        }

        .btn-cancel {
            background: #fff;
            color: #475569;
            border: 1.5px solid #e2e8f0;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background: #f8fafc;
            color: #1e293b;
        }

        .btn-submit {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: #059669;
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
            transform: translateY(-2px);
        }

        @media (max-width: 992px) {
            .summary-layout {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .calc-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

    @include('userdashboard.partials.customer-navbar', ['activeRoute' => 'loan'])

    <!-- Main Container -->
    <div class="container py-5">
        
        <!-- Stepper Indicator -->
        <div class="stepper-container">
            <div class="stepper">
                <div class="step-progress" style="width: 100%;"></div>
                
                <div class="step-item completed">
                    <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                    <div class="step-label">ব্যাংক তথ্য</div>
                </div>
                
                <div class="step-item completed">
                    <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                    <div class="step-label">ঋণের বিবরণ</div>
                </div>
                
                <div class="step-item active">
                    <div class="step-circle">৩</div>
                    <div class="step-label">সারাংশ</div>
                </div>
            </div>
        </div>

        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #1e3a8a;">ঋণ আবেদন সারাংশ</h2>
            <p class="text-muted">আপনার আবেদনের সকল বিবরণ যাচাই করে আবেদনটি চূড়ান্ত করুন</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mx-auto mb-4" style="max-width: 1000px;">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('loan.submit') }}" method="POST">
            @csrf

            <!-- Details Layout -->
            <div class="summary-layout">
                
                <!-- Left Card: Bank Info -->
                <div class="summary-card">
                    <div class="card-header-custom">
                        <h5 class="fw-bold m-0" style="color: #1e3a8a;">
                            <i class="fa-solid fa-building-columns me-2"></i> ব্যাংক / পেমেন্ট তথ্য
                        </h5>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">পেমেন্ট পদ্ধতি</span>
                        <span class="info-value text-primary font-weight-bold">
                            @if(($loan['payment_method'] ?? '') === 'bikash')
                                বিকাশ (Mobile Banking)
                            @elseif(($loan['payment_method'] ?? '') === 'nagad')
                                নগদ (Mobile Banking)
                            @else
                                ব্যাংক ট্রান্সফার (Bank Transfer)
                            @endif
                        </span>
                    </div>

                    @if(($loan['payment_method'] ?? '') === 'bank')
                        <div class="info-row">
                            <span class="info-label">অ্যাকাউন্ট হোল্ডারের নাম</span>
                            <span class="info-value">{{ $loan['account_holder_name'] ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">অ্যাকাউন্ট নম্বর</span>
                            <span class="info-value">{{ $loan['account_number'] ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">ব্যাংকের নাম</span>
                            <span class="info-value">
                                @if(($loan['bank_name'] ?? '') === 'Sonali Bank') سونালী ব্যাংক
                                @elseif(($loan['bank_name'] ?? '') === 'Dutch-Bangla Bank') ডাচ-বাংলা ব্যাংক
                                @elseif(($loan['bank_name'] ?? '') === 'BRAC Bank') ব্র্যাক ব্যাংক
                                @elseif(($loan['bank_name'] ?? '') === 'Islami Bank') ইসলামী ব্যাংক
                                @elseif(($loan['bank_name'] ?? '') === 'The City Bank') সিটি ব্যাংক
                                @else {{ $loan['bank_name'] ?? '-' }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">শাখা</span>
                            <span class="info-value">{{ $loan['branch'] ?? '-' }}</span>
                        </div>
                    @else
                        <div class="info-row">
                            <span class="info-label">মোবাইল ব্যাংকিং নম্বর</span>
                            <span class="info-value">{{ $loan['account_number'] ?? '-' }}</span>
                        </div>
                    @endif
                </div>

                <!-- Right Card: Loan Info -->
                <div class="summary-card">
                    <div class="card-header-custom">
                        <h5 class="fw-bold m-0" style="color: #1e3a8a;">
                            <i class="fa-solid fa-money-check-dollar me-2"></i> ঋণের বিবরণ
                        </h5>
                    </div>

                    <div class="info-row">
                        <span class="info-label">ঋণের পরিমাণ</span>
                        <span class="info-value text-success font-weight-bold" style="font-size: 1.1rem;">৳{{ number_format($loan['amount'] ?? 0, 2) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ঋণের মেয়াদ</span>
                        <span class="info-value">{{ $loan['tenure'] ?? '-' }} মাস</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">বার্ষিক সুদের হার</span>
                        <span class="info-value text-danger">২.৪% (Flat Rate)</span>
                    </div>
                </div>

            </div>

            <!-- Calculation Boxes -->
            <div class="calc-row">
                
                <!-- Box 1: Interest -->
                <div class="calc-box interest">
                    <div class="calc-icon purple">
                        <i class="fa-solid fa-percent"></i>
                    </div>
                    <div class="calc-label">মোট সুদের পরিমাণ</div>
                    <div class="calc-val">৳{{ number_format($loan['interest_amount'] ?? 0, 2) }}</div>
                </div>

                <!-- Box 2: Total Payable -->
                <div class="calc-box payable">
                    <div class="calc-icon green">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div class="calc-label">মোট পরিশোধযোগ্য পরিমাণ</div>
                    <div class="calc-val">৳{{ number_format($loan['total_payable'] ?? 0, 2) }}</div>
                </div>

                <!-- Box 3: Monthly EMI -->
                <div class="calc-box highlight">
                    <div class="calc-icon blue">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="calc-label">মাসিক কিস্তি (EMI)</div>
                    <div class="calc-val" style="font-size: 1.8rem;">৳{{ number_format($loan['monthly_installment'] ?? 0, 2) }}</div>
                </div>

            </div>

            <!-- Terms & Consent -->
            <div class="terms-panel">
                <h5 class="fw-bold mb-4" style="color: #1e3a8a;"><i class="fa-solid fa-shield-halved me-2"></i> নিয়ম ও শর্তাবলী</h5>
                
                <ul class="terms-list">
                    <li>আমি নিশ্চিত করছি যে উপরে প্রদত্ত সকল ব্যাংক/পেমেন্ট এবং ঋণের তথ্য সম্পূর্ণ সত্য ও সঠিক।</li>
                    <li>আমি বার্ষিক ২.৪% ফ্ল্যাট রেট সুদে উপরে উল্লেখিত মেয়াদের জন্য ঋণ গ্রহণ করতে সম্মত আছি।</li>
                    <li>আমি প্রতি মাসের নির্ধারিত তারিখে মাসিক কিস্তির (EMI) সমপরিমাণ টাকা পরিশোধ করতে অঙ্গীকারবদ্ধ।</li>
                    <li>কোনো তথ্য ভুল, অসত্য বা বিভ্রান্তিকর প্রমাণিত হলে কর্তৃপক্ষ আইনগত বা প্রশাসনিক ব্যবস্থা গ্রহণ করতে পারবেন।</li>
                    <li>ঋণের টাকা পরিশোধে ব্যর্থ হলে বা অনিয়ম করলে কর্তৃপক্ষ প্রচলিত আইন অনুযায়ী ব্যবস্থা নিতে পারবেন।</li>
                </ul>

                <label class="custom-checkbox-container" for="agree-check">
                    <input type="checkbox" name="agree" id="agree-check" value="1" required>
                    <span class="custom-checkbox-label">আমি নিয়ম ও শর্তাবলী মনোযোগ সহকারে পড়েছি এবং এতে সম্মতি জ্ঞাপন করছি। *</span>
                </label>
            </div>

            <!-- Navigation Buttons -->
            <div class="nav-buttons">
                <a href="{{ route('loan.step2') }}" class="btn-cancel">
                    <i class="fa-solid fa-arrow-left"></i> পূর্ববর্তী
                </a>
                <button type="submit" class="btn-submit">
                    আবেদন সম্পন্ন করুন <i class="fa-solid fa-circle-check"></i>
                </button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
