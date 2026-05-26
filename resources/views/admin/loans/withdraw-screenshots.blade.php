@extends('admin.master')

@section('main-content')
<div class="container-fluid py-4">

    <!-- Title and Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">
                <i class="bi bi-image-fill me-2 text-danger"></i>উইথড্র স্ক্রিনশট তালিকা
            </h1>
            <p class="text-muted mb-0">ব্যবহারকারীদের পাঠানো সকল পেমেন্ট/উইথড্র স্ক্রিনশট এবং রিসিভ স্লট পর্যালোচনা করুন</p>
        </div>
        <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> সকল ঋণ আবেদন
        </a>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-danger border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3 text-danger">
                        <i class="bi bi-images fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">মোট স্ক্রিনশট</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Loan::whereNotNull('screenshot')->count() }} টি</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3 text-success">
                        <i class="bi bi-currency-bangladeshi fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">সংশ্লিষ্ট লোন পরিমাণ</h6>
                        <h4 class="mb-0 fw-bold text-dark">৳{{ number_format(\App\Models\Loan::whereNotNull('screenshot')->sum('amount'), 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-info border-5">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3 text-info">
                        <i class="bi bi-people fs-4"></i>
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
                    <span class="badge bg-danger text-white fs-6 px-3 py-2 rounded-pill fw-bold">
                        <i class="bi bi-image me-1"></i> Screenshot Slips
                    </span>
                </div>
                <form action="{{ route('admin.loans.withdraw-screenshots') }}" method="GET" class="d-flex gap-2" style="max-width: 400px; width: 100%;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control border-end-0 border-light bg-light rounded-start-pill py-2 ps-3"
                               placeholder="নাম, ফোন বা অ্যাকাউন্ট নম্বর..." value="{{ request()->search }}">
                        <button type="submit" class="btn btn-light border-start-0 border-light text-secondary rounded-end-pill pe-3">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    @if(request()->filled('search'))
                        <a href="{{ route('admin.loans.withdraw-screenshots') }}" class="btn btn-outline-secondary rounded-pill py-2 px-3">রিসেট</a>
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
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">পেমেন্ট পদ্ধতি</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">অবস্থা</th>
                                <th class="py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">আপলোডের তারিখ</th>
                                <th class="pe-4 text-end py-3" style="font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $loan->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center fw-bold me-3"
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
                                    <td>
                                        @if($loan->payment_method === 'bikash')
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">বিকাশ</span>
                                        @elseif($loan->payment_method === 'nagad')
                                            <span class="badge bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-pill px-3 py-1" style="color: #d97706;">নগদ</span>
                                        @else
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1">ব্যাংক</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($loan->status === 'approved')
                                            <span class="badge bg-success rounded-pill px-3 py-1"><i class="bi bi-check-circle me-1"></i>অনুমোদিত</span>
                                        @elseif($loan->status === 'rejected')
                                            <span class="badge bg-danger rounded-pill px-3 py-1"><i class="bi bi-x-circle me-1"></i>বাতিল</span>
                                        @else
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1"><i class="bi bi-hourglass-split me-1"></i>অপেক্ষমান</span>
                                        @endif
                                    </td>
                                    <td>{{ $loan->updated_at->format('d M, Y (h:i A)') }}</td>
                                    <td class="pe-4 text-end">
                                        <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fw-bold me-2" onclick="showScreenshotModal('{{ asset($loan->screenshot) }}', '{{ $loan->id }}')">
                                            <i class="bi bi-image me-1"></i> স্ক্রিনশট দেখুন
                                        </button>
                                        <a href="{{ route('admin.loans.show', $loan->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
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
                            Showing {{ $loans->firstItem() }} to {{ $loans->lastItem() }} of {{ $loans->total() }} screenshots
                        </div>
                        <div>
                            {{ $loans->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-images fs-1 d-block mb-3 text-light" style="opacity: 0.5;"></i>
                    <p class="mb-0">কোনো উইথড্র স্ক্রিনশট পাওয়া যায়নি।</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Structure for Screenshots -->
<div class="modal fade" id="screenshotQuickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-danger text-white border-0 py-3 px-4">
                <h5 class="modal-title fw-bold" id="screenshotModalTitle">
                    <i class="bi bi-image me-2"></i>উইথড্র পেমেন্ট স্লিপ (#<span id="modalLoanId"></span>)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 bg-light">
                <div class="d-inline-block rounded-4 overflow-hidden border border-light shadow-sm bg-white p-2 w-100">
                    <img id="screenshotImageElement" src="" alt="Payment Receipt" class="img-fluid rounded-3" style="max-height: 65vh; object-fit: contain; width: 100%;">
                </div>
            </div>
            <div class="modal-footer border-0 bg-white py-3 px-4 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">বন্ধ করুন</button>
                <a id="modalDownloadBtn" href="" download class="btn btn-danger rounded-pill px-4 fw-bold">
                    <i class="bi bi-download me-1"></i> ডাউনলোড করুন
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function showScreenshotModal(url, id) {
    document.getElementById('modalLoanId').innerText = id;
    document.getElementById('screenshotImageElement').src = url;
    document.getElementById('modalDownloadBtn').href = url;
    
    // Show the modal
    const modalEl = document.getElementById('screenshotQuickViewModal');
    const bsModal = new bootstrap.Modal(modalEl);
    bsModal.show();
}
</script>
@endsection
