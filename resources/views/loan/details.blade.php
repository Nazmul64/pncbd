<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ঋণের বিস্তারিত তথ্য - {{ $gs->site_name ?? 'UBS' }}</title>
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
        }

        /* Nav layout matching site */
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
        }

        /* Detail Cards and Sections */
        .details-wrapper {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 15px;
        }

        .header-title-section {
            background: white;
            border-radius: 16px;
            padding: 24px 30px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }

        .loan-status-badge {
            font-weight: 700;
            font-size: 0.95rem;
            padding: 8px 20px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .loan-status-badge.pending {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
        }

        .loan-status-badge.approved {
            background: #ecfdf5;
            color: #10b981;
            border: 1px solid #a7f3d0;
        }

        .loan-status-badge.rejected {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fca5a5;
        }

        .admin-msg-card {
            background: #eff6ff;
            border: 1.5px solid #bfdbfe;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(59,130,246,0.05);
        }

        .admin-msg-title {
            color: #1e3a8a;
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .admin-msg-body {
            color: #1e40af;
            font-size: 0.98rem;
            line-height: 1.6;
        }

        /* 2-Column Grid Layout */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        .info-card {
            background: white;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .info-card-header {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1.5px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-card-header i {
            color: #3b82f6;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #f1f5f9;
            font-size: 0.95rem;
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            color: #64748b;
            font-weight: 500;
        }

        .info-value {
            color: #1e293b;
            font-weight: 700;
        }

        .info-value.amount {
            color: #3b82f6;
            font-size: 1.4rem;
        }

        .copy-button {
            border: 1px solid #cbd5e1;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
            outline: none;
        }

        .copy-button:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        .caution-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 16px;
            margin-top: auto;
            font-size: 0.88rem;
            color: #78350f;
            line-height: 1.6;
        }

        .caution-title {
            font-weight: 700;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Screenshot upload block */
        .upload-section {
            background: white;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            margin-bottom: 30px;
        }

        .btn-upload {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(37,99,235,0.25);
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37,99,235,0.35);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
        }

        .preview-box {
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 15px;
            background: #f8fafc;
            text-align: center;
            max-width: 250px;
            margin: 15px auto 0 auto;
        }

        .preview-box img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
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

        .btn-home i {
            font-size: 1.3rem;
        }
    </style>
</head>
<body>

    @include('userdashboard.partials.customer-navbar', ['activeRoute' => 'loan'])

    <div class="details-wrapper">

        <!-- Flash messages -->
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

        <!-- Title Header -->
        <div class="header-title-section">
            <div>
                <h2 class="fw-bold m-0" style="color: #0f172a;">ঋণের বিস্তারিত তথ্য</h2>
                <p class="text-muted m-0 mt-1" style="font-size: 0.9rem;">
                    আবেদন নম্বর: #{{ $loan->id }} | আবেদনের তারিখ: {{ $loan->created_at->format('d M, Y') }}
                </p>
            </div>

            <!-- Status Badge -->
            <div>
                @if($loan->status === 'pending')
                    <span class="loan-status-badge pending">
                        <i class="fas fa-hourglass-half"></i> অপেক্ষমান
                    </span>
                @elseif($loan->status === 'approved')
                    <span class="loan-status-badge approved">
                        <i class="fas fa-check-circle"></i> Approved
                    </span>
                @else
                    <span class="loan-status-badge rejected">
                        <i class="fas fa-times-circle"></i> প্রত্যাখ্যাত
                    </span>
                @endif
            </div>
        </div>

        <!-- Administrative Message (প্রশাসনিক বার্তা) -->
        <div class="admin-msg-card">
            <div class="admin-msg-title">
                <i class="fa-solid fa-message"></i> প্রশাসনিক বার্তা
            </div>
            <div class="admin-msg-body">
                @if(!empty($loan->admin_message))
                    <strong>{{ $loan->admin_message }}</strong>
                @else
                    কোনো প্রশাসনিক বার্তা বা বিশেষ নির্দেশনা এখনও প্রদান করা হয়নি। অনুগ্রহ করে অপেক্ষা করুন অথবা বিস্তারিত পেমেন্টের তথ্য দেখুন।
                @endif
            </div>
        </div>

        <!-- Grid calculations / guidelines -->
        <div class="info-grid">
            
            <!-- Column 1: Loan detail stats -->
            <div class="info-card">
                <div class="info-card-header">
                    <i class="fa-solid fa-file-invoice-dollar"></i> ঋণের তথ্য
                </div>

                <div class="info-row">
                    <span class="info-label">মোট ঋণের পরিমাণ</span>
                    <span class="info-value amount">৳{{ number_format($loan->amount, 2) }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">ঋণের মেয়াদ</span>
                    <span class="info-value">{{ $loan->tenure }} মাস</span>
                </div>

                <div class="info-row">
                    <span class="info-label">বার্ষিক সুদের হার</span>
                    <span class="info-value text-danger">{{ $loan->interest_rate }}% (Flat)</span>
                </div>

                <div class="info-row">
                    <span class="info-label">সুদের পরিমাণ</span>
                    <span class="info-value">৳{{ number_format($loan->interest_amount, 2) }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">মোট পরিশোধযোগ্য পরিমাণ</span>
                    <span class="info-value">৳{{ number_format($loan->total_payable, 2) }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">মাসিক কিস্তি (EMI)</span>
                    <span class="info-value text-primary font-weight-bold">৳{{ number_format($loan->monthly_installment, 2) }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">অনুমোদনের তারিখ</span>
                    <span class="info-value">{{ $loan->status === 'approved' ? $loan->updated_at->format('d M, Y') : 'অনুমোদনহীন' }}</span>
                </div>
            </div>

            <!-- Column 2: Payment guidelines -->
            <div class="info-card">
                <div class="info-card-header">
                    <i class="fa-solid fa-wallet"></i> পেমেন্ট তথ্য
                </div>

                @if($loan->payment_method === 'bikash' || $loan->payment_method === 'nagad')
                    @php 
                        $methodTitle = $loan->payment_method === 'bikash' ? 'বিকাশ পার্সোনাল নম্বর (সেন্ড মানি)' : 'নগদ পার্সোনাল নম্বর (সেন্ড মানি)';
                        $methodColor = $loan->payment_method === 'bikash' ? 'bg-danger' : 'bg-warning text-dark';
                        $num1 = $gs->bikash_number_1 ?? '01894048720';
                        $num2 = $gs->bikash_number_2 ?? '01605711923';
                    @endphp

                    <div class="mb-4">
                        <span class="badge {{ $methodColor }} mb-3 px-3 py-2 fw-bold" style="font-size:0.85rem; border-radius:50px;">
                            {{ $loan->payment_method === 'bikash' ? 'বিকাশ পেমেন্ট' : 'নগদ পেমেন্ট' }}
                        </span>
                    </div>

                    <div class="info-row align-items-center">
                        <div>
                            <div class="fw-bold mb-1" style="font-size: 0.9rem; color:#475569;">{{ $methodTitle }}</div>
                            <div class="fw-extrabold text-dark fs-5" id="numVal1">{{ $num1 }}</div>
                        </div>
                        <button class="btn btn-light copy-button" onclick="copyText('{{ $num1 }}', this)">
                            <i class="fa-solid fa-copy"></i> নম্বর কপি করুন
                        </button>
                    </div>

                    <div class="info-row align-items-center">
                        <div>
                            <div class="fw-bold mb-1" style="font-size: 0.9rem; color:#475569;">{{ $methodTitle }}</div>
                            <div class="fw-extrabold text-dark fs-5" id="numVal2">{{ $num2 }}</div>
                        </div>
                        <button class="btn btn-light copy-button" onclick="copyText('{{ $num2 }}', this)">
                            <i class="fa-solid fa-copy"></i> নম্বর কপি করুন
                        </button>
                    </div>
                @else
                    {{-- Bank details display --}}
                    <div class="info-row">
                        <span class="info-label">ব্যাংকের নাম</span>
                        <span class="info-value">{{ $loan->bank->name ?? 'ডাচ-বাংলা ব্যাংক' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">অ্যাকাউন্ট হোল্ডারের নাম</span>
                        <span class="info-value">{{ $loan->account_holder_name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">অ্যাকাউন্ট নম্বর</span>
                        <span class="info-value">{{ $loan->account_number ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">শাখা (Branch)</span>
                        <span class="info-value">{{ $loan->branch ?? '-' }}</span>
                    </div>
                @endif

                <!-- Warning box matching screenshot layout -->
                <div class="caution-box">
                    <div class="caution-title">
                        <i class="fas fa-exclamation-triangle"></i> গুরুত্বপূর্ণ সতর্কতা
                    </div>
                    <div>
                        শুধু সাইটে দেওয়া অফিশিয়াল নাম্বারে লেনদেন করুন। সাইটের বাইরে বা ব্যক্তিগত লেনদেনের দায়ভার UBS কর্তৃপক্ষ নেবে না।
                    </div>
                </div>
            </div>

        </div>

        <!-- Screenshot Upload block -->
        <div class="upload-section">
            <h4 class="fw-bold text-dark mb-4 border-bottom pb-2" style="font-size: 1.2rem;">
                <i class="fa-solid fa-cloud-upload-alt text-primary me-2"></i> স্ক্রিনশট আপলোড করুন
            </h4>

            <form action="{{ route('loan.screenshot.upload', $loan->id) }}" method="POST" enctype="multipart/form-data" class="row align-items-center g-3">
                @csrf
                <div class="col-md-8">
                    <label class="form-label fw-bold text-secondary mb-2" style="font-size: 0.95rem;">পেমেন্টের স্ক্রিনশট নির্বাচন করুন</label>
                    <input type="file" name="screenshot" class="form-control" accept="image/*" required style="border-radius:10px; padding:10px;">
                </div>
                <div class="col-md-4 pt-4">
                    <button type="submit" class="btn btn-upload w-100">
                        <i class="fa-solid fa-circle-check me-1"></i> আপলোড করুন
                    </button>
                </div>
            </form>

            <!-- Preview uploaded screenshot if already submitted -->
            @if($loan->screenshot)
                <div class="mt-4 border-top pt-4 text-center text-md-start">
                    <h5 class="fw-bold text-secondary mb-3" style="font-size: 0.95rem;">ইতিমধ্যে আপলোডকৃত পেমেন্ট স্লিপ/স্ক্রিনশট:</h5>
                    <div class="preview-box mx-auto mx-md-0">
                        <a href="{{ asset($loan->screenshot) }}" target="_blank" title="ক্লিক করে বড় ছবি দেখুন">
                            <img src="{{ asset($loan->screenshot) }}" alt="Payment Receipt Screenshot">
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- Floating Back Home Button -->
    <a href="{{ route('customer.dashboard') }}" class="btn-home" title="হোমে ফিরে যান">
        <i class="fa-solid fa-house"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyText(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check"></i> কপি হয়েছে!';
                btn.classList.remove('btn-light');
                btn.classList.add('btn-success', 'text-white');
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.classList.remove('btn-success', 'text-white');
                    btn.classList.add('btn-light');
                }, 2000);
            }).catch(err => {
                alert('কপি ব্যর্থ হয়েছে! অনুগ্রহ করে নিজে কপি করুন।');
            });
        }
    </script>
</body>
</html>
