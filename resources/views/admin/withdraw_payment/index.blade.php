@extends('admin.master')

@section('main-content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.wp-page {
    padding: 30px 24px;
    background: #f4f7fb;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', 'Noto Sans Bengali', sans-serif;
}

.wp-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 16px;
}

.wp-header h1 {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.wp-header h1 .icon-box {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    flex-shrink: 0;
}

.wp-header p {
    margin: 4px 0 0;
    font-size: 13.5px;
    color: #64748b;
}

/* Alert messages */
.wp-alert {
    padding: 14px 18px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    border: none;
}
.wp-alert.success { background: #ecfdf5; color: #065f46; }
.wp-alert.error   { background: #fef2f2; color: #991b1b; }

/* Layout grid */
.wp-layout {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 24px;
    align-items: start;
}
@media (max-width: 1100px) { .wp-layout { grid-template-columns: 1fr; } }

/* Card */
.wp-card {
    background: white;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    overflow: hidden;
}

.wp-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.wp-card-title {
    font-size: 15.5px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
}

.wp-card-title i { color: #6366f1; font-size: 18px; }

.wp-card-body { padding: 24px; }

/* Form fields */
.wp-form-group { margin-bottom: 16px; }
.wp-form-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 6px;
}
.wp-form-label span { color: #ef4444; }

.wp-form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    color: #1e293b;
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}
.wp-form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
}

select.wp-form-control { cursor: pointer; }

/* Toggle switch */
.wp-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    margin-bottom: 16px;
}
.wp-toggle-label {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 8px;
}

.wp-switch {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 26px;
}
.wp-switch input { opacity: 0; width: 0; height: 0; }
.wp-switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #cbd5e1;
    border-radius: 50px;
    transition: .3s;
}
.wp-switch-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    border-radius: 50%;
    transition: .3s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.18);
}
.wp-switch input:checked + .wp-switch-slider { background-color: #6366f1; }
.wp-switch input:checked + .wp-switch-slider:before { transform: translateX(22px); }

/* Buttons */
.btn-wp-primary {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    border: none;
    padding: 11px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(99,102,241,0.25);
}
.btn-wp-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99,102,241,0.35);
}

.btn-wp-sm {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    font-family: inherit;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s;
    text-decoration: none;
}
.btn-wp-edit    { background: #dbeafe; color: #1d4ed8; }
.btn-wp-edit:hover { background: #bfdbfe; }
.btn-wp-del     { background: #fee2e2; color: #b91c1c; }
.btn-wp-del:hover { background: #fecaca; }
.btn-wp-toggle-on  { background: #d1fae5; color: #065f46; }
.btn-wp-toggle-on:hover  { background: #a7f3d0; }
.btn-wp-toggle-off { background: #fef3c7; color: #92400e; }
.btn-wp-toggle-off:hover { background: #fde68a; }

/* Table */
.wp-table-wrap { overflow-x: auto; }
.wp-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13.5px;
}
.wp-table th {
    background: #f8fafc;
    padding: 13px 16px;
    font-size: 11px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.wp-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #1e293b;
}
.wp-table tr:last-child td { border-bottom: none; }
.wp-table tr:hover td { background: #f8fafc; }

/* Method badges */
.method-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    white-space: nowrap;
}
.method-bkash  { background: #fce7f3; color: #be185d; }
.method-nagad  { background: #ffedd5; color: #c2410c; }
.method-rocket { background: #ede9fe; color: #6d28d9; }
.method-bank   { background: #dbeafe; color: #1d4ed8; }

.status-on  { background: #d1fae5; color: #065f46; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.status-off { background: #fee2e2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }

/* Account number display */
.account-number-cell {
    font-family: 'Courier New', monospace;
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: 0.5px;
}

/* PIN display */
.pin-badge {
    background: #fef3c7;
    color: #92400e;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    font-family: 'Courier New', monospace;
    letter-spacing: 1px;
}

/* Group name */
.group-chip {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
}

/* Empty state */
.wp-empty {
    text-align: center;
    padding: 50px 20px;
    color: #94a3b8;
}
.wp-empty i {
    font-size: 42px;
    display: block;
    margin-bottom: 12px;
    opacity: 0.5;
}
.wp-empty p { font-size: 14px; margin: 0; }

/* Edit Modal */
.wp-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.wp-modal-overlay.show { display: flex; }
.wp-modal {
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    overflow: hidden;
}
.wp-modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
}
.wp-modal-header h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: white;
}
.wp-modal-close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
    transition: background 0.2s;
}
.wp-modal-close:hover { background: rgba(255,255,255,0.3); }
.wp-modal-body { padding: 24px; max-height: 70vh; overflow-y: auto; }
</style>

<div class="wp-page">

    {{-- HEADER --}}
    <div class="wp-header">
        <div>
            <h1>
                <span class="icon-box"><i class="bi bi-phone-fill"></i></span>
                উইথড্র পেমেন্ট সেটআপ
            </h1>
            <p>কাস্টমারদের ঋণ পরিশোধের জন্য পেমেন্ট নম্বর সেটআপ করুন</p>
        </div>
        <div style="font-size: 13px; color: #64748b; background: white; padding: 10px 16px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <i class="bi bi-info-circle me-1"></i> এই নম্বরগুলো কাস্টমারের ঋণ পেইজে দেখানো হবে
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="wp-alert success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="wp-alert error">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    <div class="wp-layout">

        {{-- LEFT: Add New Number Form --}}
        <div>
            <div class="wp-card">
                <div class="wp-card-header">
                    <h5 class="wp-card-title">
                        <i class="bi bi-plus-circle-fill"></i>
                        নতুন নম্বর যোগ করুন
                    </h5>
                </div>
                <div class="wp-card-body">
                    <form method="POST" action="{{ route('admin.withdraw-payment.store') }}">
                        @csrf

                        <div class="wp-form-group">
                            <label class="wp-form-label">গ্রুপ নাম <span>*</span></label>
                            <input type="text" name="group_name" class="wp-form-control"
                                   placeholder="যেমন: বিকাশ গ্রুপ-১, নগদ অফিস"
                                   value="{{ old('group_name') }}" required>
                            @error('group_name')
                                <small style="color:#ef4444;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="wp-form-group">
                            <label class="wp-form-label">পেমেন্ট পদ্ধতি <span>*</span></label>
                            <select name="payment_method" class="wp-form-control" required>
                                <option value="">-- নির্বাচন করুন --</option>
                                <option value="bkash"  {{ old('payment_method') === 'bkash'  ? 'selected' : '' }}>📱 বিকাশ (bKash)</option>
                                <option value="nagad"  {{ old('payment_method') === 'nagad'  ? 'selected' : '' }}>📱 নগদ (Nagad)</option>
                                <option value="rocket" {{ old('payment_method') === 'rocket' ? 'selected' : '' }}>📱 রকেট (Rocket)</option>
                                <option value="bank"   {{ old('payment_method') === 'bank'   ? 'selected' : '' }}>🏦 ব্যাংক (Bank)</option>
                            </select>
                        </div>

                        <div class="wp-form-group">
                            <label class="wp-form-label">অ্যাকাউন্ট নম্বর <span>*</span></label>
                            <input type="text" name="account_number" class="wp-form-control"
                                   placeholder="01xxxxxxxxx"
                                   value="{{ old('account_number') }}" required>
                        </div>

                        <div class="wp-form-group">
                            <label class="wp-form-label">অ্যাকাউন্ট হোল্ডারের নাম</label>
                            <input type="text" name="account_holder" class="wp-form-control"
                                   placeholder="নাম লিখুন (ঐচ্ছিক)"
                                   value="{{ old('account_holder') }}">
                        </div>

                        <div class="wp-form-group">
                            <label class="wp-form-label">উইথড্র পিন</label>
                            <input type="text" name="pin" class="wp-form-control"
                                   placeholder="পিন নম্বর (ঐচ্ছিক)"
                                   value="{{ old('pin') }}" maxlength="10">
                        </div>

                        <div class="wp-form-group">
                            <label class="wp-form-label">ক্রম (Sort Order)</label>
                            <input type="number" name="sort_order" class="wp-form-control"
                                   placeholder="0" value="{{ old('sort_order', 0) }}" min="0">
                        </div>

                        <div class="wp-toggle-row">
                            <span class="wp-toggle-label">
                                <i class="bi bi-eye-fill" style="color:#6366f1;"></i>
                                সক্রিয় (কাস্টমারকে দেখাবে)
                            </span>
                            <label class="wp-switch">
                                <input type="checkbox" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="wp-switch-slider"></span>
                            </label>
                        </div>

                        <button type="submit" class="btn-wp-primary">
                            <i class="bi bi-plus-circle-fill"></i> নম্বর যোগ করুন
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT: Number List Table --}}
        <div>
            <div class="wp-card">
                <div class="wp-card-header">
                    <h5 class="wp-card-title">
                        <i class="bi bi-list-ul"></i>
                        সকল পেমেন্ট নম্বর
                    </h5>
                    <span style="font-size: 13px; font-weight: 600; color: #64748b; background: #f1f5f9; padding: 4px 12px; border-radius: 20px;">
                        মোট: {{ $numbers->count() }}টি
                    </span>
                </div>

                <div class="wp-table-wrap">
                    @if($numbers->count() > 0)
                    <table class="wp-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>গ্রুপ</th>
                                <th>পদ্ধতি</th>
                                <th>নম্বর</th>
                                <th>হোল্ডার</th>
                                <th>পিন</th>
                                <th>স্ট্যাটাস</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($numbers as $num)
                            <tr>
                                <td style="font-weight: 700; color: #94a3b8;">{{ $loop->iteration }}</td>
                                <td><span class="group-chip">{{ $num->group_name }}</span></td>
                                <td>
                                    <span class="method-badge method-{{ $num->payment_method }}">
                                        @if($num->payment_method === 'bkash')  📱 বিকাশ
                                        @elseif($num->payment_method === 'nagad') 📱 নগদ
                                        @elseif($num->payment_method === 'rocket') 📱 রকেট
                                        @else 🏦 ব্যাংক
                                        @endif
                                    </span>
                                </td>
                                <td class="account-number-cell">{{ $num->account_number }}</td>
                                <td style="font-size: 13px; color: #475569;">{{ $num->account_holder ?? '—' }}</td>
                                <td>
                                    @if($num->pin)
                                        <span class="pin-badge">{{ $num->pin }}</span>
                                    @else
                                        <span style="color:#cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($num->is_active)
                                        <span class="status-on">✓ সক্রিয়</span>
                                    @else
                                        <span class="status-off">✗ বন্ধ</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                        {{-- Edit --}}
                                        <button class="btn-wp-sm btn-wp-edit"
                                                onclick="openEditModal({{ $num->id }}, '{{ addslashes($num->group_name) }}', '{{ $num->payment_method }}', '{{ $num->account_number }}', '{{ addslashes($num->account_holder ?? '') }}', '{{ $num->pin ?? '' }}', {{ $num->sort_order }}, {{ $num->is_active ? 'true' : 'false' }})">
                                            <i class="bi bi-pencil-fill"></i> এডিট
                                        </button>

                                        {{-- Toggle --}}
                                        <form method="POST" action="{{ route('admin.withdraw-payment.toggle', $num->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-wp-sm {{ $num->is_active ? 'btn-wp-toggle-on' : 'btn-wp-toggle-off' }}"
                                                    onclick="return confirm('স্ট্যাটাস পরিবর্তন করবেন?')">
                                                <i class="bi bi-{{ $num->is_active ? 'eye-slash' : 'eye' }}-fill"></i>
                                                {{ $num->is_active ? 'বন্ধ করুন' : 'চালু করুন' }}
                                            </button>
                                        </form>

                                        {{-- Delete --}}
                                        <form method="POST" action="{{ route('admin.withdraw-payment.destroy', $num->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-wp-sm btn-wp-del"
                                                    onclick="return confirm('এই নম্বরটি মুছে ফেলবেন?')">
                                                <i class="bi bi-trash-fill"></i> মুছুন
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="wp-empty">
                            <i class="bi bi-phone-vibrate"></i>
                            <p>এখনো কোনো পেমেন্ট নম্বর যোগ করা হয়নি।<br>বাম পাশের ফর্ম থেকে নতুন নম্বর যোগ করুন।</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Edit Modal --}}
<div class="wp-modal-overlay" id="editModal">
    <div class="wp-modal">
        <div class="wp-modal-header">
            <h5><i class="bi bi-pencil-square me-2"></i> পেমেন্ট নম্বর এডিট করুন</h5>
            <button class="wp-modal-close" onclick="closeEditModal()">✕</button>
        </div>
        <div class="wp-modal-body">
            <form method="POST" id="editForm">
                @csrf
                @method('POST')

                <div class="wp-form-group">
                    <label class="wp-form-label">গ্রুপ নাম <span>*</span></label>
                    <input type="text" name="group_name" id="edit_group_name" class="wp-form-control" required>
                </div>

                <div class="wp-form-group">
                    <label class="wp-form-label">পেমেন্ট পদ্ধতি <span>*</span></label>
                    <select name="payment_method" id="edit_payment_method" class="wp-form-control" required>
                        <option value="bkash">📱 বিকাশ (bKash)</option>
                        <option value="nagad">📱 নগদ (Nagad)</option>
                        <option value="rocket">📱 রকেট (Rocket)</option>
                        <option value="bank">🏦 ব্যাংক (Bank)</option>
                    </select>
                </div>

                <div class="wp-form-group">
                    <label class="wp-form-label">অ্যাকাউন্ট নম্বর <span>*</span></label>
                    <input type="text" name="account_number" id="edit_account_number" class="wp-form-control" required>
                </div>

                <div class="wp-form-group">
                    <label class="wp-form-label">অ্যাকাউন্ট হোল্ডারের নাম</label>
                    <input type="text" name="account_holder" id="edit_account_holder" class="wp-form-control">
                </div>

                <div class="wp-form-group">
                    <label class="wp-form-label">উইথড্র পিন</label>
                    <input type="text" name="pin" id="edit_pin" class="wp-form-control" maxlength="10">
                </div>

                <div class="wp-form-group">
                    <label class="wp-form-label">ক্রম (Sort Order)</label>
                    <input type="number" name="sort_order" id="edit_sort_order" class="wp-form-control" min="0">
                </div>

                <div class="wp-toggle-row" style="margin-bottom: 20px;">
                    <span class="wp-toggle-label">
                        <i class="bi bi-eye-fill" style="color:#6366f1;"></i>
                        সক্রিয়
                    </span>
                    <label class="wp-switch">
                        <input type="checkbox" name="is_active" id="edit_is_active">
                        <span class="wp-switch-slider"></span>
                    </label>
                </div>

                <button type="submit" class="btn-wp-primary">
                    <i class="bi bi-save-fill"></i> পরিবর্তন সেভ করুন
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(id, group_name, payment_method, account_number, account_holder, pin, sort_order, is_active) {
    document.getElementById('edit_group_name').value      = group_name;
    document.getElementById('edit_payment_method').value  = payment_method;
    document.getElementById('edit_account_number').value  = account_number;
    document.getElementById('edit_account_holder').value  = account_holder;
    document.getElementById('edit_pin').value             = pin;
    document.getElementById('edit_sort_order').value      = sort_order;
    document.getElementById('edit_is_active').checked     = is_active;
    document.getElementById('editForm').action            = '/admin/withdraw-payment-setup/' + id + '/update';
    document.getElementById('editModal').classList.add('show');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('show');
}

// Close modal on overlay click
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endsection
