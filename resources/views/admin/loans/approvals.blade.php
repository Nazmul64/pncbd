@extends('admin.master')

@section('main-content')
<div class="container-fluid py-4">

    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">
                <i class="bi bi-check2-square me-2 text-success"></i>লোন অ্যাপ্রুভাল তালিকা
            </h1>
            <p class="text-muted mb-0">অনুমোদিত সকল ঋণ আবেদনের তালিকা</p>
        </div>
        <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> সকল আবেদন
        </a>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3 text-success">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">মোট অনুমোদিত</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Loan::where('status', 'approved')->count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-primary border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 text-primary">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">মোট অনুমোদিত পরিমাণ</h6>
                        <h4 class="mb-0 fw-bold text-dark">৳{{ number_format(\App\Models\Loan::where('status', 'approved')->sum('amount'), 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-info border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3 text-info">
                        <i class="bi bi-list-check fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">এই পাতায়</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ $loans->count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-4">

        <!-- Search -->
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success fs-6 px-3 py-2 rounded-pill fw-bold">
                        <i class="bi bi-check-circle me-1"></i> Approved Loans
                    </span>
                </div>
                <form action="{{ route('admin.loan-approvals') }}" method="GET" class="d-flex gap-2" style="max-width: 400px; width: 100%;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control border-end-0 border-light bg-light rounded-start-pill py-2 ps-3"
                               placeholder="নাম, ফোন বা অ্যাকাউন্ট নম্বর..." value="{{ request()->search }}">
                        <button type="submit" class="btn btn-light border-start-0 border-light text-secondary rounded-end-pill pe-3">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    @if(request()->filled('search'))
                        <a href="{{ route('admin.loan-approvals') }}" class="btn btn-outline-secondary rounded-pill py-2 px-3">রিসেট</a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card-body p-0">
            @if($loans->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                        <thead class="table-light border-bottom-0">
                            <tr>
                                <th class="ps-4 py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">আইডি</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">আবেদনকারী</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">ঋণের পরিমাণ</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">মেয়াদ</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">পেমেন্ট পদ্ধতি</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">অনুমোদনের তারিখ</th>
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
                                            <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center fw-bold me-3"
                                                 style="width: 40px; height: 40px; font-size: 1rem;">
                                                {{ substr($loan->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $loan->user->name ?? 'অজানা' }}</div>
                                                <div class="text-muted small">{{ $loan->user->phone ?? '—' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-success">৳{{ number_format($loan->amount, 2) }}</td>
                                    <td>{{ $loan->tenure }} মাস</td>
                                    <td>
                                        @if($loan->payment_method === 'bikash')
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">বিকাশ</span>
                                        @elseif($loan->payment_method === 'nagad')
                                            <span class="badge bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-pill px-3 py-1" style="color: #d97706;">নগদ</span>
                                        @else
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1">ব্যাংক</span>
                                        @endif
                                    </td>
                                    <td>{{ $loan->updated_at->format('d M, Y') }}</td>
                                    <td>
                                        <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem;">
                                            <i class="bi bi-check-circle me-1"></i> অনুমোদিত
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        @if($loan->screenshot)
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold me-2" onclick="showScreenshotModal('{{ asset($loan->screenshot) }}', '{{ $loan->id }}')">
                                                <i class="bi bi-image me-1"></i> স্ক্রিনশট
                                            </button>
                                        @endif
                                        <a href="{{ route('admin.loans.show', $loan->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">
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
                    <div class="text-success mb-3"><i class="bi bi-check-circle fs-1"></i></div>
                    <h5 class="fw-bold text-dark">কোনো অনুমোদিত আবেদন নেই</h5>
                    <p class="text-muted small">এখনো কোনো ঋণ অনুমোদন করা হয়নি।</p>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Screenshot Modal -->
<div class="modal fade" id="adminScreenshotModal" tabindex="-1" aria-labelledby="adminScreenshotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="adminScreenshotModalLabel"><i class="bi bi-receipt me-2 text-success"></i>পেমেন্ট স্লিপ স্ক্রিনশট</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center bg-light">
                <img id="modalScreenshotImage" src="" alt="Payment Receipt" class="img-fluid rounded-3 border shadow-sm" style="max-height: 70vh; object-fit: contain; max-width: 100%;">
            </div>
            <div class="modal-footer border-0 bg-white py-3">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showScreenshotModal(url, loanId) {
        document.getElementById('modalScreenshotImage').src = url;
        document.getElementById('adminScreenshotModalLabel').innerHTML = '<i class="bi bi-receipt me-2 text-success"></i>পেমেন্ট স্লিপ স্ক্রিনশট (আবেদন #' + loanId + ')';
        var myModal = new bootstrap.Modal(document.getElementById('adminScreenshotModal'));
        myModal.show();
    }
</script>
@endsection
