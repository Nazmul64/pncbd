@extends('admin.master')

@section('main-content')
<div class="container-fluid py-4">
    
    <!-- Title and Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold"><i class="fa-solid fa-hand-holding-dollar me-2 text-primary"></i>ঋণ আবেদনসমূহ</h1>
            <p class="text-muted mb-0">গ্রাহকদের ঋণ আবেদন পর্যালোচনা, অনুমোদন এবং প্রত্যাখ্যানের তালিকা</p>
        </div>
    </div>

    <!-- Stats summary row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-primary border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 text-primary">
                        <i class="fa-solid fa-list-check fa-xl"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">মোট আবেদন</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Loan::count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3 text-warning">
                        <i class="fa-solid fa-clock-rotate-left fa-xl"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">অপেক্ষমান</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Loan::where('status', 'pending')->count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3 text-success">
                        <i class="fa-solid fa-circle-check fa-xl"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">অনুমোদিত</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Loan::where('status', 'approved')->count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-danger border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3 text-danger">
                        <i class="fa-solid fa-circle-xmark fa-xl"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">প্রত্যাখ্যাত</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Loan::where('status', 'rejected')->count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-4">
        
        <!-- Header with filters and search -->
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-3 border-bottom">
                
                <!-- Status Filters -->
                <div class="nav nav-pills gap-1">
                    <a href="{{ route('admin.loans.index') }}" class="nav-link rounded-pill py-2 px-3 fw-bold {{ !request()->filled('status') ? 'active bg-primary' : 'bg-light text-secondary' }}">
                        সকল আবেদন
                    </a>
                    <a href="{{ route('admin.loans.index', ['status' => 'pending']) }}" class="nav-link rounded-pill py-2 px-3 fw-bold {{ request()->status === 'pending' ? 'active bg-warning text-dark' : 'bg-light text-secondary' }}">
                        অপেক্ষমান
                    </a>
                    <a href="{{ route('admin.loans.index', ['status' => 'approved']) }}" class="nav-link rounded-pill py-2 px-3 fw-bold {{ request()->status === 'approved' ? 'active bg-success' : 'bg-light text-secondary' }}">
                        অনুমোদিত
                    </a>
                    <a href="{{ route('admin.loans.index', ['status' => 'rejected']) }}" class="nav-link rounded-pill py-2 px-3 fw-bold {{ request()->status === 'rejected' ? 'active bg-danger' : 'bg-light text-secondary' }}">
                        প্রত্যাখ্যাত
                    </a>
                </div>

                <!-- Search Form -->
                <form action="{{ route('admin.loans.index') }}" method="GET" class="d-flex gap-2" style="max-width: 400px; width: 100%;">
                    @if(request()->filled('status'))
                        <input type="hidden" name="status" value="{{ request()->status }}">
                    @endif
                    <div class="input-group">
                        <input type="text" name="search" class="form-control border-end-0 border-light bg-light rounded-start-pill py-2 ps-3" placeholder="নাম, ফোন বা অ্যাকাউন্ট নম্বর লিখুন..." value="{{ request()->search }}">
                        <button type="submit" class="btn btn-light border-start-0 border-light text-secondary rounded-end-pill pe-3">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    @if(request()->filled('search') || request()->filled('status'))
                        <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary rounded-pill py-2 px-3">
                            রিসেট
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table Body -->
        <div class="card-body p-0">
            @if($loans->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width: 1000px;">
                        <thead class="table-light py-3 border-bottom-0">
                            <tr>
                                <th class="ps-4 py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">আইডি</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">আবেদনকারী</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">ঋণের পরিমাণ</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">মেয়াদ</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">পেমেন্ট পদ্ধতি</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">অ্যাকাউন্ট বিবরণ</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">তারিখ</th>
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
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                                {{ substr($loan->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $loan->user->name ?? 'অজানা গ্রাহক' }}</div>
                                                <div class="text-muted small" style="font-size: 0.78rem;">{{ $loan->user->phone ?? 'ফোন নেই' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-success fw-bold">৳{{ number_format($loan->amount, 2) }}</td>
                                    <td>{{ $loan->tenure }} মাস</td>
                                    <td>
                                        @if($loan->payment_method === 'bikash')
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.8rem;">বিকাশ</span>
                                        @elseif($loan->payment_method === 'nagad')
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.8rem; color: #d97706 !important;">নগদ</span>
                                        @else
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.8rem;">ব্যাংক</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($loan->payment_method === 'bank')
                                            <div class="fw-semibold text-dark">
                                                @if($loan->bank)
                                                    {{ $loan->bank->name }}
                                                @else
                                                    <span class="badge bg-warning text-dark">অজানা</span>
                                                @endif
                                            </div>
                                            <div class="text-muted small" style="font-size: 0.78rem;">A/C: {{ $loan->account_number }}</div>
                                        @else
                                            <div class="fw-semibold text-dark">{{ $loan->account_number }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $loan->created_at->format('d M, Y') }}</td>
                                    <td>
                                        @if($loan->status === 'pending')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-hourglass-half me-1"></i> অপেক্ষমান
                                            </span>
                                        @elseif($loan->status === 'approved')
                                            <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-check-circle me-1"></i> অনুমোদিত
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-circle-xmark me-1"></i> প্রত্যাখ্যাত
                                            </span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('admin.loans.show', $loan->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                            বিস্তারিত <i class="fa-solid fa-arrow-right ms-1"></i>
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
                        <div>
                            {{ $loans->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-muted mb-3"><i class="fa-regular fa-folder-open fa-3x"></i></div>
                    <h5 class="fw-bold text-dark">কোনো ঋণ আবেদন পাওয়া যায়নি</h5>
                    <p class="text-muted small">এই ক্যাটাগরিতে পর্যালোচনার জন্য কোনো আবেদন নেই।</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
