<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ব্যাংক তথ্য - {{ $gs->site_name ?? 'UBS' }}</title>
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

        .top-navbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
        }

        .bank-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 0 20px;
            text-align: center;
        }

        .bank-icon-header {
            font-size: 4rem;
            color: #3b82f6;
            margin-bottom: 15px;
            text-shadow: 0 4px 10px rgba(59, 130, 246, 0.1);
        }

        .bank-title-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 40px;
        }

        /* 2-Column and 3-Column Premium Cards Layout */
        .cards-row-1 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .cards-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        @media (max-width: 768px) {
            .cards-row-1, .cards-row-2 {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        .bank-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .bank-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.05);
        }

        .card-label {
            font-size: 0.88rem;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2563eb;
            line-height: 1.3;
        }

        .card-value.dark {
            color: #0f172a;
        }

        .card-value.green {
            color: #10b981;
        }

        .card-value.purple {
            color: #8b5cf6;
        }

        /* Account number with Copy styling */
        .account-number-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .btn-copy-icon {
            background: #eff6ff;
            color: #3b82f6;
            border: 1px solid #bfdbfe;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            outline: none;
        }

        .btn-copy-icon:hover {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
            transform: scale(1.05);
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

    @include('userdashboard.partials.customer-navbar', ['activeRoute' => 'profile'])

    <div class="bank-container">
        
        <!-- Header Building Icon and Title -->
        <div class="bank-icon-header">
            <i class="fa-solid fa-building-columns"></i>
        </div>
        <h2 class="bank-title-text">ব্যাংক তথ্য</h2>

        <!-- First Row: 2 Column Cards -->
        <div class="cards-row-1">
            
            <!-- Card 1: Bank/Method -->
            <div class="bank-card">
                <div class="card-label">ব্যাংক/পদ্ধতি</div>
                <div class="card-value">
                    @if($loan->payment_method === 'bank')
                        {{ $loan->bank->name ?? 'Dutch-Bangla Bank' }}
                    @elseif($loan->payment_method === 'bikash' || $loan->payment_method === 'bkash')
                        বিকাশ (Mobile Wallet)
                    @elseif($loan->payment_method === 'nagad')
                        নগদ (Mobile Wallet)
                    @else
                        {{ ucfirst($loan->payment_method) }}
                    @endif
                </div>
            </div>

            <!-- Card 2: Account Number -->
            <div class="bank-card">
                <div class="card-label">অ্যাকাউন্ট নম্বর</div>
                <div class="account-number-wrapper">
                    <div class="card-value dark" id="account-number-text">{{ $loan->account_number }}</div>
                    <button class="btn btn-copy-icon" onclick="copyAccountNumber('{{ $loan->account_number }}', this)" title="কপি করুন">
                        <i class="fa-solid fa-copy"></i>
                    </button>
                </div>
            </div>

        </div>

        <!-- Second Row: 3 Column Cards -->
        <div class="cards-row-2">
            
            <!-- Card 3: Loan Amount -->
            <div class="bank-card">
                <div class="card-label">ঋণের পরিমাণ</div>
                <div class="card-value">৳{{ number_format($loan->amount, 2) }}</div>
            </div>

            <!-- Card 4: Tenure -->
            <div class="bank-card">
                <div class="card-label">মেয়াদ</div>
                <div class="card-value purple">{{ $loan->tenure }} মাস</div>
            </div>

            <!-- Card 5: Status -->
            <div class="bank-card">
                <div class="card-label">অবস্থা</div>
                <div class="card-value green">
                    @if($loan->status === 'pending')
                        <span style="color: #d97706;">Pending</span>
                    @elseif($loan->status === 'approved')
                        <span style="color: #10b981;">Approved</span>
                    @else
                        <span style="color: #ef4444;">Rejected</span>
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
        function copyAccountNumber(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                btn.style.background = '#10b981';
                btn.style.color = '#ffffff';
                btn.style.borderColor = '#10b981';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.style.background = '#eff6ff';
                    btn.style.color = '#3b82f6';
                    btn.style.borderColor = '#bfdbfe';
                }, 2000);
            }).catch(err => {
                alert('কপি করতে ব্যর্থ হয়েছে! অনুগ্রহ করে নিজে কপি করুন।');
            });
        }
    </script>
</body>
</html>
