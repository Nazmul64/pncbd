@extends('admin.master')

@section('main-content')
<div class="container-fluid py-4">

    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">
                <i class="bi bi-bank2 me-2 text-primary"></i>ব্যাংক চেক অ্যাপ্রুভাল
            </h1>
            <p class="text-muted mb-0">যে সকল ঋণ আবেদনে ব্যাংক নির্বাচন করা হয়েছে সেগুলোর তালিকা</p>
        </div>
        <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> সকল আবেদন
        </a>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-primary border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 text-primary">
                        <i class="bi bi-bank fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">ব্যাংক আবেদন</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ $loans->total() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3 text-warning">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">অপেক্ষমান</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Loan::whereNotNull('bank_id')->where('status','pending')->count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3 text-success">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">অনুমোদিত</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Loan::whereNotNull('bank_id')->where('status','approved')->count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-danger border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3 text-danger">
                        <i class="bi bi-x-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">প্রত্যাখ্যাত</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Loan::whereNotNull('bank_id')->where('status','rejected')->count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-4">

        <!-- Header + Filters -->
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-3 border-bottom">

                <!-- Status Filters -->
                <div class="nav nav-pills gap-1">
                    <a href="{{ route('admin.bank-check-approvals') }}"
                       class="nav-link rounded-pill py-2 px-3 fw-bold {{ !request()->filled('status') ? 'active bg-primary' : 'bg-light text-secondary' }}">
                        সকল
                    </a>
                    <a href="{{ route('admin.bank-check-approvals', ['status' => 'pending']) }}"
                       class="nav-link rounded-pill py-2 px-3 fw-bold {{ request()->status === 'pending' ? 'active bg-warning text-dark' : 'bg-light text-secondary' }}">
                        অপেক্ষমান
                    </a>
                    <a href="{{ route('admin.bank-check-approvals', ['status' => 'approved']) }}"
                       class="nav-link rounded-pill py-2 px-3 fw-bold {{ request()->status === 'approved' ? 'active bg-success' : 'bg-light text-secondary' }}">
                        অনুমোদিত
                    </a>
                    <a href="{{ route('admin.bank-check-approvals', ['status' => 'rejected']) }}"
                       class="nav-link rounded-pill py-2 px-3 fw-bold {{ request()->status === 'rejected' ? 'active bg-danger' : 'bg-light text-secondary' }}">
                        প্রত্যাখ্যাত
                    </a>
                </div>

                <!-- Search -->
                <form action="{{ route('admin.bank-check-approvals') }}" method="GET" class="d-flex gap-2" style="max-width: 400px; width: 100%;">
                    @if(request()->filled('status'))
                        <input type="hidden" name="status" value="{{ request()->status }}">
                    @endif
                    <div class="input-group">
                        <input type="text" name="search" class="form-control border-end-0 border-light bg-light rounded-start-pill py-2 ps-3"
                               placeholder="নাম, ব্যাংক বা ফোন নম্বর..." value="{{ request()->search }}">
                        <button type="submit" class="btn btn-light border-start-0 border-light text-secondary rounded-end-pill pe-3">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    @if(request()->filled('search') || request()->filled('status'))
                        <a href="{{ route('admin.bank-check-approvals') }}" class="btn btn-outline-secondary rounded-pill py-2 px-3">রিসেট</a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card-body p-0">
            @if($loans->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width: 1000px;">
                        <thead class="table-light border-bottom-0">
                            <tr>
                                <th class="ps-4 py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">আইডি</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">আবেদনকারী</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">নির্বাচিত ব্যাংক</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">অ্যাকাউন্ট নম্বর</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">ঋণের পরিমাণ</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">মেয়াদ</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">অবস্থা</th>
                                <th class="pe-4 text-end py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $loan->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold me-3"
                                                 style="width: 40px; height: 40px; font-size: 1rem;">
                                                {{ substr($loan->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $loan->user->name ?? 'অজানা' }}</div>
                                                <div class="text-muted small">{{ $loan->user->phone ?? '—' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($loan->bank)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                                     style="width: 32px; height: 32px;">
                                                    <i class="bi bi-bank text-primary" style="font-size: 0.85rem;"></i>
                                                </div>
                                                <span class="fw-semibold text-dark">{{ $loan->bank->name }}</span>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">অজানা ব্যাংক</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark font-monospace">{{ $loan->account_number ?? '—' }}</span>
                                    </td>
                                    <td class="fw-bold text-success">৳{{ number_format($loan->amount, 2) }}</td>
                                    <td>{{ $loan->tenure }} মাস</td>
                                    <td>
                                        @if($loan->status === 'pending')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem;">
                                                <i class="bi bi-hourglass-half me-1"></i> অপেক্ষমান
                                            </span>
                                        @elseif($loan->status === 'approved')
                                            <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem;">
                                                <i class="bi bi-check-circle me-1"></i> অনুমোদিত
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem;">
                                                <i class="bi bi-x-circle me-1"></i> প্রত্যাখ্যাত
                                            </span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('admin.loans.show', $loan->id) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                            বিস্তারিত <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-white border-0 py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            মোট {{ $loans->total() }} টির মধ্যে {{ $loans->firstItem() ?? 0 }}-{{ $loans->lastItem() ?? 0 }} টি দেখানো হচ্ছে
                        </div>
                        <div>{{ $loans->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-primary mb-3"><i class="bi bi-bank2 fs-1"></i></div>
                    <h5 class="fw-bold text-dark">কোনো ব্যাংক আবেদন পাওয়া যায়নি</h5>
                    <p class="text-muted small">এই ফিল্টারে কোনো ব্যাংক লোন আবেদন নেই।</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
