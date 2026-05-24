@extends('admin.master')

@section('main-content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap');

.db-page {
    padding: 30px 24px;
    background: #f4f7fb;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', 'Noto Sans Bengali', sans-serif;
}

.db-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.db-header h1 {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
}

.db-header p {
    margin: 4px 0 0;
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

/* ── SEARCH BAR ── */
.search-container {
    background: #fff;
    border-radius: 14px;
    padding: 16px 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0,0,0,0.02);
    margin-bottom: 24px;
}

.search-input-group {
    display: flex;
    gap: 12px;
}

.search-control {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 14px;
    flex: 1;
    transition: all 0.3s;
}

.search-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.btn-search {
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 0 24px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-search:hover {
    background: #1d4ed8;
}

.btn-clear {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 0 20px;
    font-weight: 600;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-clear:hover {
    background: #e2e8f0;
    color: #0f172a;
}

/* ── DB CARD ── */
.db-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(0,0,0,0.02);
    overflow: hidden;
}

.db-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.db-card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 10px;
}
.db-card-title i { color: #3b82f6; font-size: 18px; }

/* ── TABLES ── */
.db-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.db-table th {
    background: #f8fafc;
    padding: 14px 24px;
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}
.db-table td {
    padding: 16px 24px;
    font-size: 14px;
    color: #1e293b;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.db-table tr:last-child td { border-bottom: none; }
.db-table tr:hover td { background: #f8fafc; }

/* ── AVATARS ── */
.customer-photo {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

.customer-meta {
    display: flex;
    align-items: center;
    gap: 12px;
}

.customer-name {
    font-weight: 700;
    color: #0f172a;
}

.customer-email {
    font-size: 12px;
    color: #64748b;
}

/* ── BUTTON ACTIONS ── */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-action-view {
    background: #e0f2fe;
    color: #0369a1;
    border: none;
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-action-view:hover {
    background: #0284c7;
    color: white;
}

.btn-action-delete {
    background: #fee2e2;
    color: #b91c1c;
    border: none;
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.btn-action-delete:hover {
    background: #dc2626;
    color: white;
}

.empty-state {
    padding: 60px 40px;
    text-align: center;
}

.empty-icon {
    font-size: 48px;
    color: #cbd5e1;
    margin-bottom: 16px;
}
</style>

<div class="db-page">
    
    {{-- Header --}}
    <div class="db-header">
        <div>
            <h1>ডকুমেন্টেশন</h1>
            <p>রেজিস্ট্রেশনের পর গ্রাহকরা যে তথ্য ও ডকুমেন্ট আপলোড করেছেন — সবার তালিকা</p>
        </div>
        <div style="font-size: 14px; font-weight: 600; color: #64748b; background: #fff; padding: 10px 16px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <i class="bi bi-file-earmark-person me-2"></i> মোট জমা: {{ $informations->total() }}টি
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search Bar --}}
    <div class="search-container">
        <form action="{{ route('admin.documentation.index') }}" method="GET">
            <div class="search-input-group">
                <input type="text" name="search" class="search-control" placeholder="নাম, ফোন নম্বর বা NID দিয়ে সার্চ করুন..." value="{{ request('search') }}">
                <button type="submit" class="btn-search"><i class="bi bi-search me-2"></i>সার্চ</button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.documentation.index') }}" class="btn-clear"><i class="bi bi-x-lg me-2"></i>মুছে ফেলুন</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Submissions Table Card --}}
    <div class="db-card">
        <div class="db-card-header">
            <h5 class="db-card-title">
                <i class="bi bi-person-lines-fill"></i> ডকুমেন্ট জমা দেওয়া গ্রাহকদের তালিকা
            </h5>
        </div>
        <div class="table-responsive">
            <table class="db-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">গ্রাহক বিবরণ</th>
                        <th style="width: 20%;">মোবাইল নম্বর</th>
                        <th style="width: 20%;">NID নম্বর</th>
                        <th style="width: 15%;">জমার তারিখ</th>
                        <th style="width: 15%; text-align: center;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($informations as $info)
                        <tr>
                            <td>
                                <div class="customer-meta">
                                    @if($info->selfie)
                                        <img src="{{ asset($info->selfie) }}" alt="Selfie" class="customer-photo">
                                    @else
                                        <div class="customer-photo d-flex align-items-center justify-content-center bg-light text-secondary fw-bold" style="font-size: 18px;">
                                            {{ substr($info->full_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="customer-name">{{ $info->full_name }}</div>
                                        <div class="customer-email">{{ $info->phone_number ?: ($info->user->phone ?? '—') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-secondary">{{ $info->phone_number }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-3 font-monospace">{{ $info->nid_number }}</span>
                            </td>
                            <td>
                                <div class="text-secondary small">{{ $info->created_at->format('d M Y') }}</div>
                                <div class="text-muted small" style="font-size: 11px;">{{ $info->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="action-buttons justify-content-center">
                                    <!-- View Details -->
                                    <a href="{{ route('admin.documentation.show', $info->id) }}" class="btn-action-view" title="বিস্তারিত ডকুমেন্ট দেখুন">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <!-- Delete -->
                                    <form action="{{ route('admin.user-informations.destroy', $info->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে আপনি এই গ্রাহকের ডকুমেন্ট এবং তথ্য স্থায়ীভাবে মুছে ফেলতে চান? এটি আর ফেরত আনা যাবে না!');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-delete" title="মুছে ফেলুন">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-0">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-file-earmark-lock2-fill"></i></div>
                                    <h5 class="fw-bold text-dark mb-1">কোনো ডকুমেন্ট পাওয়া যায়নি</h5>
                                    <p class="text-muted mb-0">গ্রাহকদের ডকুমেন্ট জমা দেওয়া হলে এখানে তালিকা আকারে দেখা যাবে।</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($informations->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $informations->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>
@endsection
