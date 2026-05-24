<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payslip - {{ $payslip->employee->name }} - {{ Carbon\Carbon::create(null, $payslip->month, 1)->format('F Y') }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 40px;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .payslip-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
            padding: 40px;
            background: #ffffff;
            position: relative;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 24px;
            margin-bottom: 30px;
        }

        .company-details h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .company-details p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 13px;
        }

        .payslip-title {
            text-align: right;
        }

        .payslip-title h2 {
            margin: 0;
            font-size: 20px;
            color: #10b981;
            font-weight: 700;
            text-transform: uppercase;
        }

        .payslip-title p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .meta-box h3 {
            margin: 0 0 10px 0;
            font-size: 12px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .meta-label {
            color: #64748b;
            font-weight: 600;
        }

        .meta-value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
        }

        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .salary-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #cbd5e1;
        }

        .salary-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .salary-table tr.total-row td {
            font-size: 15px;
            font-weight: 800;
            background: #ecfdf5;
            color: #065f46;
            border-top: 1px solid #059669;
            border-bottom: 2px solid #059669;
        }

        .paid-stamp {
            position: absolute;
            top: 210px;
            right: 80px;
            border: 4px double #059669;
            color: #059669;
            font-size: 16px;
            font-weight: 900;
            padding: 8px 18px;
            transform: rotate(-12deg);
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(255,255,255,0.9);
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 80px;
            padding-top: 40px;
        }

        .sig-box {
            text-align: center;
            width: 200px;
        }

        .sig-line {
            border-top: 1.5px solid #94a3b8;
            margin-bottom: 6px;
        }

        .sig-text {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
        }

        @media print {
            body {
                padding: 0;
            }
            .payslip-container {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>

<div class="payslip-container">
    @if($payslip->status === 'paid')
        <div class="paid-stamp">PAID</div>
    @endif

    {{-- Company Details header --}}
    <div class="header-section">
        <div class="company-details">
            <h1>Habibi Baby Shop</h1>
            <p>Premium Baby Products & Accessories</p>
            <p>Dhaka, Bangladesh | Support: habibibabyshop.shop</p>
        </div>
        <div class="payslip-title">
            <h2>SALARY PAYSLIP</h2>
            <p>Statement for {{ Carbon\Carbon::create(null, $payslip->month, 1)->format('F Y') }}</p>
        </div>
    </div>

    {{-- Meta grid --}}
    <div class="meta-grid">
        <div class="meta-box">
            <h3>Employee Details</h3>
            <div class="meta-row">
                <span class="meta-label">Name:</span>
                <span class="meta-value">{{ $payslip->employee->name }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Phone:</span>
                <span class="meta-value">{{ $payslip->employee->phone }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Address:</span>
                <span class="meta-value">{{ $payslip->employee->district }}, {{ $payslip->employee->thana }}</span>
            </div>
        </div>
        <div class="meta-box">
            <h3>Payment Summary</h3>
            <div class="meta-row">
                <span class="meta-label">Slip Reference No:</span>
                <span class="meta-value">HRM-PAY-{{ sprintf('%05d', $payslip->id) }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Disbursement Date:</span>
                <span class="meta-value">{{ $payslip->paid_at ? $payslip->paid_at->format('d M Y, h:i A') : 'Pending' }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Payment Method:</span>
                <span class="meta-value">{{ $payslip->payment_method ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    {{-- Salary breakdown --}}
    <table class="salary-table">
        <thead>
            <tr>
                <th>Earnings & Deductions Description</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Basic Base Salary</strong></td>
                <td style="text-align: right; font-weight: 700;">৳{{ number_format($payslip->base_salary, 2) }}</td>
            </tr>
            
            @if($slip = $payslip) @endif
            
            {{-- Attendance metrics --}}
            <tr>
                <td style="color: #64748b; font-size: 12px; padding-left: 24px;">
                    * Attendance Log: {{ $payslip->present_days }} Days Present, {{ $payslip->absent_days }} Days Absent, {{ $payslip->leave_days }} Days Approved Leave
                </td>
                <td></td>
            </tr>

            {{-- Deductions --}}
            @if($payslip->deductions > 0)
                <tr>
                    <td style="color: #dc2626;"><strong>Total Deductions</strong> (Absent Penalty & Damage Charges)</td>
                    <td style="text-align: right; color: #dc2626; font-weight: 700;">- ৳{{ number_format($payslip->deductions, 2) }}</td>
                </tr>
            @endif

            @if($payslip->advances_drawn > 0)
                <tr>
                    <td style="color: #ea580c;"><strong>Salary Advances Deducted</strong> (Salary Drawdown in advance)</td>
                    <td style="text-align: right; color: #ea580c; font-weight: 700;">- ৳{{ number_format($payslip->advances_drawn, 2) }}</td>
                </tr>
            @endif

            {{-- Bonus --}}
            @if($payslip->bonus > 0)
                <tr>
                    <td style="color: #10b981;"><strong>Performance Bonus / Allowance</strong></td>
                    <td style="text-align: right; color: #10b981; font-weight: 700;">+ ৳{{ number_format($payslip->bonus, 2) }}</td>
                </tr>
            @endif

            {{-- Total row --}}
            <tr class="total-row">
                <td><strong>NET PAYABLE OUTFLOW</strong></td>
                <td style="text-align: right; font-weight: 900;">৳{{ number_format($payslip->net_salary, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Signature section --}}
    <div class="signatures">
        <div class="sig-box">
            <div class="sig-line"></div>
            <div class="sig-text">Employee Signature</div>
        </div>
        <div class="sig-box">
            <div class="sig-line"></div>
            <div class="sig-text">Authorized Signature</div>
        </div>
    </div>
</div>

<script>
    // Automatically launch print window when page is fully rendered
    window.onload = function() {
        window.print();
    }
</script>

</body>
</html>
