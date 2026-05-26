<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ব্যাংক/পেমেন্ট তথ্য - {{ $gs->site_name ?? 'UBS' }}</title>
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
            width: 0%;
            height: 4px;
            background: #3b82f6;
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

        /* Method Cards styling */
        .method-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 30px 0;
        }

        .method-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 25px 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            user-select: none;
        }

        .method-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }

        .method-card.selected {
            border-color: #3b82f6;
            background: #f0f9ff;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.1);
        }

        .method-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            font-size: 1.5rem;
            transition: all 0.3s;
        }

        /* Pink for bKash */
        .method-card[data-method="bikash"] .method-icon {
            background: #fdf2f8;
            color: #db2777;
        }
        .method-card[data-method="bikash"].selected .method-icon {
            background: #db2777;
            color: white;
        }

        /* Orange for Nagad */
        .method-card[data-method="nagad"] .method-icon {
            background: #fff7ed;
            color: #ea580c;
        }
        .method-card[data-method="nagad"].selected .method-icon {
            background: #ea580c;
            color: white;
        }

        /* Blue for Bank */
        .method-card[data-method="bank"] .method-icon {
            background: #eff6ff;
            color: #2563eb;
        }
        .method-card[data-method="bank"].selected .method-icon {
            background: #2563eb;
            color: white;
        }

        .method-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .method-subtitle {
            font-size: 0.75rem;
            color: #64748b;
        }

        .form-section {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            max-width: 800px;
            margin: 0 auto;
        }

        .input-group-custom {
            margin-bottom: 20px;
        }

        .input-group-custom label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 16px;
            font-size: 0.95rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #f8fafc;
            transition: all 0.3s;
        }

        .form-control-custom:focus {
            border-color: #3b82f6;
            background: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        /* Navigation buttons */
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            max-width: 800px;
            margin: 30px auto 0 auto;
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

        .btn-next {
            background: #3b82f6;
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

        .btn-next:hover {
            background: #2563eb;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .method-container {
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
                <div class="step-progress" style="width: 0%;"></div>
                
                <div class="step-item active">
                    <div class="step-circle">১</div>
                    <div class="step-label">ব্যাংক তথ্য</div>
                </div>
                
                <div class="step-item">
                    <div class="step-circle">২</div>
                    <div class="step-label">ঋণের বিবরণ</div>
                </div>
                
                <div class="step-item">
                    <div class="step-circle">৩</div>
                    <div class="step-label">সারাংশ</div>
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">ব্যাংক/পেমেন্ট তথ্য</h2>
            <p class="text-muted">আপনার ব্যাংক বা মোবাইল ব্যাংকিং তথ্য প্রদান করুন</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mx-auto" style="max-width: 800px;">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('loan.step1.post') }}" method="POST">
            @csrf
            
            <input type="hidden" name="payment_method" id="selected-method" value="{{ old('payment_method', $sessionData['payment_method'] ?? 'bikash') }}">

            <div class="mx-auto" style="max-width: 800px;">
                <!-- Card selection -->
                <div class="method-container">
                    <div class="method-card {{ old('payment_method', $sessionData['payment_method'] ?? 'bikash') === 'bikash' ? 'selected' : '' }}" data-method="bikash">
                        <div class="method-icon">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>
                        <div class="method-title">বিকাশ</div>
                        <div class="method-subtitle">মোবাইল ব্যাংকিং</div>
                    </div>

                    <div class="method-card {{ old('payment_method', $sessionData['payment_method'] ?? '') === 'nagad' ? 'selected' : '' }}" data-method="nagad">
                        <div class="method-icon">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>
                        <div class="method-title">নগদ</div>
                        <div class="method-subtitle">মোবাইল ব্যাংকিং</div>
                    </div>

                    <div class="method-card {{ old('payment_method', $sessionData['payment_method'] ?? '') === 'bank' ? 'selected' : '' }}" data-method="bank">
                        <div class="method-icon">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div class="method-title">ব্যাংক</div>
                        <div class="method-subtitle">ব্যাংক অ্যাকাউন্ট</div>
                    </div>
                </div>

                <!-- Form Inputs -->
                <div class="form-section">
                    
                    <!-- bKash / Nagad conditional fields -->
                    <div id="mobile-banking-fields" class="form-fields">
                        <div class="input-group-custom">
                            <label for="mobile_number" id="mobile-label">মোবাইল ব্যাংকিং নম্বর *</label>
                            <input type="text" name="mobile_number" id="mobile_number" class="form-control-custom" placeholder="মোবাইল নম্বর লিখুন" value="{{ old('mobile_number', $sessionData['account_number'] ?? '') }}">
                        </div>
                    </div>

                    <!-- Bank Account conditional fields -->
                    <div id="bank-fields" class="form-fields d-none">
                        <h5 class="fw-bold mb-4" style="color: #1e3a8a;"><i class="fa-solid fa-building-columns me-2"></i> ব্যাংক অ্যাকাউন্ট তথ্য</h5>
                        
                        <div class="input-group-custom">
                            <label for="account_holder_name">অ্যাকাউন্ট হোল্ডারের নাম *</label>
                            <input type="text" name="account_holder_name" id="account_holder_name" class="form-control-custom" placeholder="অ্যাকাউন্ট হোল্ডারের পূর্ণ নাম" value="{{ old('account_holder_name', $sessionData['account_holder_name'] ?? '') }}">
                        </div>

                        <div class="input-group-custom">
                            <label for="account_number">অ্যাকাউন্ট নম্বর *</label>
                            <input type="text" name="account_number" id="account_number" class="form-control-custom" placeholder="অ্যাকাউন্ট নম্বর লিখুন" value="{{ old('account_number', $sessionData['account_number'] ?? '') }}">
                        </div>

                        <div class="input-group-custom">
                            <label for="bank_id">ব্যাংকের নাম *</label>
                            <select name="bank_id" id="bank_id" class="form-control-custom">
                                <option value="">-- ব্যাংক নির্বাচন করুন --</option>
                                @forelse($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ old('bank_id', $sessionData['bank_id'] ?? '') == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->name }}
                                    </option>
                                @empty
                                    <option value="" disabled>এডমিন প্যানেলে কোনো সক্রিয় ব্যাংক নেই</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="input-group-custom">
                            <label for="branch">শাখা *</label>
                            <input type="text" name="branch" id="branch" class="form-control-custom" placeholder="শাখা লিখুন" value="{{ old('branch', $sessionData['branch'] ?? '') }}">
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="nav-buttons">
                    <a href="{{ route('customer.dashboard') }}" class="btn-cancel">
                        <i class="fa-solid fa-arrow-left"></i> বাতিল
                    </a>
                    <button type="submit" class="btn-next">
                        পরবর্তী <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Script for Dynamic Card toggles -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.method-card');
            const selectedMethodInput = document.getElementById('selected-method');
            const mobileFields = document.getElementById('mobile-banking-fields');
            const bankFields = document.getElementById('bank-fields');
            const mobileLabel = document.getElementById('mobile-label');
            const mobileInput = document.getElementById('mobile_number');
            const bankIdSelect = document.getElementById('bank_id');

            function updateFields(method) {
                if (method === 'bank') {
                    mobileFields.classList.add('d-none');
                    bankFields.classList.remove('d-none');
                    // prevent browser validation errors on mobile field if bank is selected
                    mobileInput.required = false;
                    if (bankIdSelect) bankIdSelect.required = true;
                } else {
                    bankFields.classList.add('d-none');
                    mobileFields.classList.remove('d-none');
                    mobileInput.required = true;
                    if (bankIdSelect) bankIdSelect.required = false;
                    if (method === 'bikash') {
                        mobileLabel.innerText = 'বিকাশ নম্বর *';
                        mobileInput.placeholder = 'বিকাশ নম্বর লিখুন';
                    } else {
                        mobileLabel.innerText = 'নগদ নম্বর *';
                        mobileInput.placeholder = 'নগদ নম্বর লিখুন';
                    }
                }
            }

            cards.forEach(card => {
                card.addEventListener('click', function() {
                    cards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    const method = this.getAttribute('data-method');
                    selectedMethodInput.value = method;
                    updateFields(method);
                });
            });

            // Initialize field values on load
            updateFields(selectedMethodInput.value);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
