@extends('admin.master')

@section('main-content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap');

    .bank-page {
        padding: 30px 24px;
        background: #f4f7fb;
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', 'Noto Sans Bengali', sans-serif;
    }

    .bank-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .bank-header h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
    }

    .bank-header p {
        margin: 4px 0 0;
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .bank-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 24px;
    }

    @media(max-width: 991px) {
        .bank-grid {
            grid-template-columns: 1fr;
        }
    }

    .bank-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .bank-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bank-card-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .bank-card-title i {
        color: #3b82f6;
        font-size: 18px;
    }

    .bank-card-body {
        padding: 24px;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }

    .form-group-custom label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-control-custom {
        width: 100%;
        padding: 10px 16px;
        font-size: 14px;
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

    .btn-submit {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14.5px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.35);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14.5px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
    }

    /* Table styles */
    .bank-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .bank-table th {
        background: #f8fafc;
        padding: 14px 20px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .bank-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .bank-table tr:last-child td {
        border-bottom: none;
    }

    .bank-table tr:hover td {
        background: #f8fafc;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .badge-active {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-inactive {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-edit {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-edit:hover {
        background: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
    }

    .btn-toggle {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }
</style>

<div class="bank-page">
    <div class="bank-header">
        <div>
            <h1>ব্যাংক ইনফরমেশন সেটআপ</h1>
            <p>লোন ফর্মে ড্রপডাউন ব্যাংকগুলোর তালিকা নিয়ন্ত্রণ করুন</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px; background: #d1fae5; color: #065f46;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px; background: #fee2e2; color: #991b1b;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="bank-grid">
        <!-- Add/Edit form card -->
        <div class="bank-card">
            <div class="bank-card-header">
                <h5 class="bank-card-title" id="form-title"><i class="bi bi-bank2"></i> ব্যাংক যুক্ত করুন</h5>
            </div>
            <div class="bank-card-body">
                <form id="bank-form" action="{{ route('admin.banks.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">

                    <div class="form-group-custom">
                        <label for="bank_name">ব্যাংকের নাম *</label>
                        <input type="text" name="name" id="bank_name" class="form-control-custom" placeholder="উদাঃ Sonali Bank" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-submit" id="submit-btn">
                            <i class="bi bi-plus-lg"></i> সংরক্ষণ করুন
                        </button>
                        <button type="button" class="btn-cancel d-none" id="cancel-edit-btn" onclick="resetForm()">
                            বাতিল
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Banks listing card -->
        <div class="bank-card">
            <div class="bank-card-header">
                <h5 class="bank-card-title"><i class="bi bi-list-check"></i> ব্যাংকের তালিকা</h5>
            </div>
            <div class="bank-card-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="bank-table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">ক্রমিক</th>
                                <th>ব্যাংকের নাম</th>
                                <th style="width: 120px;">স্ট্যাটাস</th>
                                <th style="width: 150px; text-align: center;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banks as $index => $bank)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-semibold bank-name-cell" id="bank-name-{{ $bank->id }}">{{ $bank->name }}</td>
                                    <td>
                                        <form action="{{ route('admin.banks.toggle-status', $bank->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-toggle" title="স্ট্যাটাস পরিবর্তন করতে ক্লিক করুন">
                                                @if($bank->is_active)
                                                    <span class="badge-status badge-active">সক্রিয়</span>
                                                @else
                                                    <span class="badge-status badge-inactive">নিষ্ক্রিয়</span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn-edit" title="সম্পাদনা করুন" onclick="editBank({{ $bank->id }}, '{{ $bank->name }}')">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            
                                            <form action="{{ route('admin.banks.destroy', $bank->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ব্যাংকটি মুছে ফেলতে চান?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" title="মুছে ফেলুন">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-info-circle me-1"></i> কোনো ব্যাংক পাওয়া যায়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editBank(id, name) {
        const form = document.getElementById('bank-form');
        const formTitle = document.getElementById('form-title');
        const formMethod = document.getElementById('form-method');
        const submitBtn = document.getElementById('submit-btn');
        const cancelEditBtn = document.getElementById('cancel-edit-btn');
        const nameInput = document.getElementById('bank_name');

        // Set route to update bank
        form.action = `/admin/banks/${id}`;
        formMethod.value = 'PUT';
        
        // Fill input
        nameInput.value = name;
        nameInput.focus();

        // Update UI labels
        formTitle.innerHTML = '<i class="bi bi-pencil-square"></i> ব্যাংক সংশোধন করুন';
        submitBtn.innerHTML = '<i class="bi bi-check-lg"></i> আপডেট করুন';
        cancelEditBtn.classList.remove('d-none');
    }

    function resetForm() {
        const form = document.getElementById('bank-form');
        const formTitle = document.getElementById('form-title');
        const formMethod = document.getElementById('form-method');
        const submitBtn = document.getElementById('submit-btn');
        const cancelEditBtn = document.getElementById('cancel-edit-btn');
        const nameInput = document.getElementById('bank_name');

        // Reset to original settings for store bank
        form.action = "{{ route('admin.banks.store') }}";
        formMethod.value = 'POST';
        nameInput.value = '';

        formTitle.innerHTML = '<i class="bi bi-bank2"></i> ব্যাংক যুক্ত করুন';
        submitBtn.innerHTML = '<i class="bi bi-plus-lg"></i> সংরক্ষণ করুন';
        cancelEditBtn.classList.add('d-none');
    }
</script>
@endsection
