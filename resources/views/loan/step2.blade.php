<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ঋণের বিবরণ - {{ $gs->site_name ?? 'Pncbd' }}</title>
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
            width: 50%;
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

        .step-item.completed .step-label,
        .step-item.active .step-label {
            color: #1e3a8a;
            font-weight: 700;
        }

        /* Step Content Layout */
        .calculator-layout {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 30px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .calc-panel {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        /* Quick Grid */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 15px 0 25px 0;
        }

        .quick-btn {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 5px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .quick-btn:hover, .quick-btn.active {
            background: #e0f2fe;
            border-color: #7dd3fc;
            color: #0369a1;
        }

        /* Side Summary styling matching Screen 4 */
        .calc-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 25px;
        }

        .calc-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .calc-row {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 20px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .calc-row-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
        }

        .calc-row-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .calc-row-value.blue {
            color: #2563eb;
        }

        .calc-row-value.orange {
            color: #ea580c;
        }

        .calc-row-value.purple {
            color: #7c3aed;
        }

        .calc-row.highlight-green {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        .calc-row.highlight-green .calc-row-label,
        .calc-row.highlight-green .calc-row-value {
            color: white;
            font-size: 1.2rem;
        }

        .calc-row.highlight-blue {
            background: #2563eb;
            border-color: #2563eb;
            color: white;
        }

        .calc-row.highlight-blue .calc-row-label,
        .calc-row.highlight-blue .calc-row-value {
            color: white;
            font-size: 1.2rem;
        }

        /* Dynamic Alerts */
        .info-alert {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #78350f;
            margin-top: 15px;
            font-weight: 600;
        }

        /* Buttons matching style */
        .btn-calc {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .btn-calc:hover {
            background: #059669;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            max-width: 1100px;
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

        @media (max-width: 992px) {
            .calculator-layout {
                grid-template-columns: 1fr;
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
                <div class="step-progress" style="width: 50%;"></div>
                
                <div class="step-item completed">
                    <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                    <div class="step-label">ব্যাংক তথ্য</div>
                </div>
                
                <div class="step-item active">
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
            <h2 class="fw-bold" style="color: #1e3a8a;">ঋণের পরিমাণ নির্বাচন করুন</h2>
            <p class="text-muted">আপনার প্রয়োজনীয় ঋণের পরিমাণ এবং মেয়াদ নির্বাচন করুন</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mx-auto" style="max-width: 1100px;">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('loan.step2.post') }}" method="POST">
            @csrf

            <div class="calculator-layout">
                
                <!-- Left Input Panel -->
                <div class="calc-panel">
                    <h5 class="fw-bold mb-4" style="color: #1e3a8a;"><i class="fa-solid fa-money-check-dollar me-2"></i> ঋণের পরিমাণ নির্বাচন</h5>
                    
                    <div class="mb-4">
                        <label for="amount" class="form-label fw-bold" style="color: #475569;">ঋণের পরিমাণ (টাকা) *</label>
                        <input type="number" name="amount" id="amount" class="form-control" style="padding: 12px; font-size: 1.1rem; border-radius: 10px;" value="{{ old('amount', $sessionData['amount'] ?? '50000') }}" min="5000" max="5000000" required>
                    </div>

                    <!-- Quick buttons grid -->
                    <div class="quick-grid">
                        <div class="quick-btn" data-value="50000">৳৫০,০০০</div>
                        <div class="quick-btn" data-value="100000">৳১,০০,০০০</div>
                        <div class="quick-btn" data-value="150000">৳১,৫০,০০০</div>
                        <div class="quick-btn" data-value="200000">৳২,০০,০০০</div>
                        <div class="quick-btn" data-value="300000">৳৩,০০,০০০</div>
                        <div class="quick-btn" data-value="400000">৳৪,০০,০০০</div>
                        <div class="quick-btn" data-value="500000">৳৫,০০,০০০</div>
                        <div class="quick-btn" data-value="600000">৳৬,০০,০০০</div>
                        <div class="quick-btn" data-value="700000">৳৭,০০,০০০</div>
                        <div class="quick-btn" data-value="800000">৳৮,০০,০০০</div>
                        <div class="quick-btn" data-value="900000">৳৯,০০,০০০</div>
                        <div class="quick-btn" data-value="1000000">৳১০,০০,০০০</div>
                        <div class="quick-btn" data-value="1100000">৳১১,০০,০০০</div>
                        <div class="quick-btn" data-value="1200000">৳১২,০০,০০০</div>
                        <div class="quick-btn" data-value="1300000">৳১৩,০০,০০০</div>
                        <div class="quick-btn" data-value="1400000">৳১৪,০০,০০০</div>
                        <div class="quick-btn" data-value="1500000">৳১৫,০০,০০০</div>
                        <div class="quick-btn" data-value="1600000">৳১৬,০০,০০০</div>
                        <div class="quick-btn" data-value="1700000">৳১৭,০০,০০০</div>
                        <div class="quick-btn" data-value="1800000">৳১৮,০০,০০০</div>
                        <div class="quick-btn" data-value="1900000">৳১৯,০০,০০০</div>
                        <div class="quick-btn" data-value="2000000">৳২০,০০,০০০</div>
                        <div class="quick-btn" data-value="2500000">৳২৫,০০,০০০</div>
                        <div class="quick-btn" data-value="3000000">৳৩০,০০,০০০</div>
                    </div>

                    <div class="mb-4">
                        <label for="tenure" class="form-label fw-bold" style="color: #475569;">মেয়াদ (মাস) *</label>
                        <select name="tenure" id="tenure" class="form-select" style="padding: 12px; border-radius: 10px;">
                            <option value="12" {{ old('tenure', $sessionData['tenure'] ?? '') == 12 ? 'selected' : '' }}>১২ মাস</option>
                            <option value="18" {{ old('tenure', $sessionData['tenure'] ?? '18') == 18 ? 'selected' : '' }}>১৮ মাস</option>
                            <option value="24" {{ old('tenure', $sessionData['tenure'] ?? '') == 24 ? 'selected' : '' }}>২৪ মাস</option>
                            <option value="36" {{ old('tenure', $sessionData['tenure'] ?? '') == 36 ? 'selected' : '' }}>৩৬ মাস</option>
                            <option value="48" {{ old('tenure', $sessionData['tenure'] ?? '') == 48 ? 'selected' : '' }}>৪৮ মাস</option>
                        </select>
                    </div>

                    <button type="button" class="btn-calc" id="btn-calculate">
                        <i class="fa-solid fa-calculator"></i> হিসাব করুন
                    </button>
                </div>

                <!-- Right Side Calculation Box -->
                <div class="calc-box">
                    <h5 class="calc-title"><i class="fa-solid fa-file-invoice-dollar text-primary"></i> ঋণ হিসাব</h5>
                    
                    <div class="calc-row">
                        <div class="calc-row-label">মূল ঋণ</div>
                        <div class="calc-row-value blue" id="lbl-principal">৳০.০০</div>
                    </div>

                    <div class="calc-row">
                        <div class="calc-row-label">সুদ (২.৪%)</div>
                        <div class="calc-row-value orange" id="lbl-interest">৳০.০০</div>
                    </div>

                    <div class="calc-row">
                        <div class="calc-row-label">মেয়াদ</div>
                        <div class="calc-row-value purple" id="lbl-tenure">০ মাস</div>
                    </div>

                    <div class="calc-row highlight-green">
                        <div class="calc-row-label">মোট পরিশোধযোগ্য</div>
                        <div class="calc-row-value" id="lbl-total-payable">৳০.০০</div>
                    </div>

                    <div class="calc-row highlight-blue">
                        <div class="calc-row-label">মাসিক কিস্তি (EMI)</div>
                        <div class="calc-row-value" id="lbl-emi">৳০.০০</div>
                    </div>

                    <div class="info-alert" id="lbl-alert">
                        প্রতি মাসে ৳০.০০ করে ০ মাস পরিশোধ করতে হবে
                    </div>
                </div>

            </div>

            <!-- Bottom Buttons -->
            <div class="nav-buttons">
                <a href="{{ route('loan.step1') }}" class="btn-cancel">
                    <i class="fa-solid fa-arrow-left"></i> পিছনে
                </a>
                <button type="submit" class="btn-next">
                    পরবর্তী <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Live calculations Javascript code -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount');
            const tenureSelect = document.getElementById('tenure');
            const calculateBtn = document.getElementById('btn-calculate');
            const quickBtns = document.querySelectorAll('.quick-btn');

            // Summary Labels
            const lblPrincipal = document.getElementById('lbl-principal');
            const lblInterest = document.getElementById('lbl-interest');
            const lblTenure = document.getElementById('lbl-tenure');
            const lblTotalPayable = document.getElementById('lbl-total-payable');
            const lblEMI = document.getElementById('lbl-emi');
            const lblAlert = document.getElementById('lbl-alert');

            // Format numbers to BDT
            function formatBDT(amount) {
                return '৳' + Number(amount).toLocaleString('bn-BD', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // Convert numbers to Bengali letters/numerals for UI text
            function toBanglaNumerals(num) {
                const banglaDigits = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
                return num.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
            }

            // Calculation function
            function doCalculation() {
                const amount = parseFloat(amountInput.value) || 0;
                const tenure = parseInt(tenureSelect.value) || 12;
                const interestRate = 2.4; // flat barshik rate

                const interestAmount = amount * (interestRate / 100) * (tenure / 12);
                const totalPayable = amount + interestAmount;
                const emi = totalPayable / tenure;

                // Update UI Labels
                lblPrincipal.innerText = formatBDT(amount);
                lblInterest.innerText = formatBDT(interestAmount);
                lblTenure.innerText = toBanglaNumerals(tenure) + ' মাস';
                lblTotalPayable.innerText = formatBDT(totalPayable);
                lblEMI.innerText = formatBDT(emi);

                // Update Info Alert block
                lblAlert.innerText = 'প্রতি মাসে ' + formatBDT(emi) + ' করে ' + toBanglaNumerals(tenure) + ' মাস পরিশোধ করতে হবে';
            }

            // Attach events
            calculateBtn.addEventListener('click', doCalculation);
            amountInput.addEventListener('input', doCalculation);
            tenureSelect.addEventListener('change', doCalculation);

            // Quick select grid setup
            quickBtns.forEach(btn => {
                const val = btn.getAttribute('data-value');
                
                // Highlight initially selected
                if(amountInput.value === val) {
                    btn.classList.add('active');
                }

                btn.addEventListener('click', function() {
                    quickBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    amountInput.value = val;
                    doCalculation();
                });
            });

            // Initial run on page load
            doCalculation();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
