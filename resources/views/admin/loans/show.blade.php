@extends('admin.master')

@section('main-content')
<div class="container-fluid py-4">

    <!-- Back button & Title -->
    <div class="mb-4">
        <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary rounded-pill px-3 mb-3 fw-bold">
            <i class="fa-solid fa-arrow-left me-1"></i> আবেদনে ফিরে যান
        </a>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 text-gray-800 fw-bold">ঋণ আবেদন বিস্তারিত (#{{ $loan->id }})</h1>
                <p class="text-muted mb-0">গ্রাহকের ব্যাংক তথ্য এবং ঋণের হিসাব পর্যালোচনা করুন</p>
            </div>

            <!-- Current Status Badge -->
            <div>
                                    @if($loan->status === 'pending')
                        <span class="badge bg-warning text-dark rounded-pill px-4 py-2 fs-6 fw-bold border border-warning border-opacity-25 shadow-sm">
                            <i class="fa-solid fa-hourglass-half me-1"></i> অপেক্ষমান (Pending)
                        </span>
                    @elseif($loan->status === 'approved')
                        <span class="badge bg-success text-white rounded-pill px-4 py-2 fs-6 fw-bold border border-success border-opacity-25 shadow-sm">
                            <i class="fa-solid fa-check-circle me-1"></i> অনুমোদিত (Approved)
                        </span>
                        @if(file_exists(public_path('uploads/loan-stamps/stamp.png')))
    <div class="mt-3 text-center">
        <a href="#" data-bs-toggle="modal" data-bs-target="#stampModal">
            <img src="{{ asset('uploads/loan-stamps/stamp.png') }}" alt="Loan Stamp" class="img-fluid" style="max-height:200px; border:2px solid #fff; border-radius:8px; cursor:pointer; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"/>
        </a>
    </div>
    <!-- Stamp Modal -->
    <div class="modal fade" id="stampModal" tabindex="-1" aria-labelledby="stampModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white" style="border-radius:12px; overflow:hidden;">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="stampModalLabel">ঋণ চুক্তিপত্র স্ট্যাম্প</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center" style="background: linear-gradient(135deg, #ff7e5f, #feb47b);">
                    <img src="{{ asset('uploads/loan-stamps/stamp.png') }}" alt="Loan Stamp" class="img-fluid" style="max-width:100%; max-height:80vh;"/>
                </div>
            </div>
        </div>
    </div>
@endif                        </div>
                    @else
                        <span class="badge bg-danger text-white rounded-pill px-4 py-2 fs-6 fw-bold border border-danger border-opacity-25 shadow-sm">
                            <i class="fa-solid fa-circle-xmark me-1"></i> প্রত্যাখ্যাত (Rejected)
                        </span>
                    @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">

        <!-- Left Column: Details Grid -->
        <div class="col-lg-8">
            <div class="row g-4">

                <!-- Applicant Profile Details -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">
                            <i class="fa-solid fa-user-tie me-2"></i> আবেদনকারীর প্রোফাইল তথ্য
                        </h5>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <span class="text-muted d-block small fw-bold text-uppercase">আবেদনকারীর নাম</span>
                                <span class="text-dark fw-bold fs-6">{{ $loan->user->name ?? 'অজানা' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block small fw-bold text-uppercase">মোবাইল নম্বর</span>
                                <span class="text-dark fw-bold fs-6">{{ $loan->user->phone ?? 'ফোন নম্বর নেই' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block small fw-bold text-uppercase">ইমেইল অ্যাড্রেস</span>
                                <span class="text-dark fw-bold fs-6">{{ $loan->user->email ?? 'ইমেইল নেই' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block small fw-bold text-uppercase">প্রোফাইল তৈরির তারিখ</span>
                                <span class="text-dark fw-bold fs-6">{{ $loan->user->created_at ? $loan->user->created_at->format('d M, Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Info details -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">
                            <i class="fa-solid fa-building-columns me-2"></i> ব্যাংক / পেমেন্ট বিবরণ
                        </h5>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <span class="text-muted d-block small fw-bold text-uppercase">পেমেন্ট পদ্ধতি</span>
                                <span class="badge {{ $loan->payment_method === 'bank' ? 'bg-primary' : 'bg-danger' }} rounded-pill px-3 py-1 fw-bold fs-7 mt-1">
                                    @if($loan->payment_method === 'bikash')
                                        বিকাশ (Mobile Banking)
                                    @elseif($loan->payment_method === 'nagad')
                                        নগদ (Mobile Banking)
                                    @else
                                        ব্যাংক ট্রান্সফার (Bank Transfer)
                                    @endif
                                </span>
                            </div>

                            @if($loan->payment_method === 'bank')
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small fw-bold text-uppercase">ব্যাংকের নাম</span>
                                    <span class="text-dark fw-bold fs-6">
                                        @if($loan->bank)
                                            {{ $loan->bank->name }}
                                        @else
                                            <span class="badge bg-warning text-dark">অজানা</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small fw-bold text-uppercase">অ্যাকাউন্ট হোল্ডারের নাম</span>
                                    <span class="text-dark fw-bold fs-6">{{ $loan->account_holder_name ?? '-' }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small fw-bold text-uppercase">অ্যাকাউন্ট নম্বর</span>
                                    <span class="text-dark fw-bold fs-6">{{ $loan->account_number ?? '-' }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small fw-bold text-uppercase">শাখা (Branch)</span>
                                    <span class="text-dark fw-bold fs-6">{{ $loan->branch ?? '-' }}</span>
                                </div>
                            @else
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small fw-bold text-uppercase">মোবাইল ব্যাংকিং নম্বর</span>
                                    <span class="text-dark fw-bold fs-6">{{ $loan->account_number ?? '-' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Column: Calculations and Status Updates -->
        <div class="col-lg-4">
            <div class="row g-4">

                <!-- Calculations Card -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">
                            <i class="fa-solid fa-calculator me-2"></i> ঋণের হিসাব সারাংশ
                        </h5>

                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="text-muted fw-semibold">ঋণের মূল পরিমাণ</span>
                            <span class="text-success fw-bold fs-5">৳{{ number_format($loan->amount, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="text-muted fw-semibold">ঋণের মেয়াদ</span>
                            <span class="text-dark fw-bold">{{ $loan->tenure }} মাস</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="text-muted fw-semibold">বার্ষিক সুদের হার</span>
                            <span class="text-danger fw-bold">{{ $loan->interest_rate }}% (Flat)</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="text-muted fw-semibold">মোট সুদের পরিমাণ</span>
                            <span class="text-dark fw-bold">৳{{ number_format($loan->interest_amount, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="text-muted fw-semibold">মোট পরিশোধযোগ্য পরিমাণ</span>
                            <span class="text-dark fw-bold">৳{{ number_format($loan->total_payable, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between p-3 rounded-3 bg-light border border-primary border-opacity-25 mt-4">
                            <span class="text-primary fw-bold">মাসিক কিস্তি (EMI)</span>
                            <span class="text-primary fw-extrabold fs-4">৳{{ number_format($loan->monthly_installment, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($loan->screenshot)
                    <!-- Payment Screenshot Card -->
                    <div class="col-md-12 mb-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                            <h5 class="fw-bold mb-3 text-success border-bottom pb-2">
                                <i class="fa-solid fa-receipt me-2"></i> গ্রাহকের পেমেন্ট স্ক্রিনশট
                            </h5>
                            <div class="text-center">
                                <a href="{{ asset($loan->screenshot) }}" target="_blank" title="ক্লিক করে বড় ছবি দেখুন">
                                    <img src="{{ asset($loan->screenshot) }}" class="img-fluid rounded-3 border" style="max-height: 250px; cursor: pointer; object-fit: contain;">
                                </a>
                                <p class="text-muted small mt-2 mb-0">পেমেন্ট স্লিপের সত্যতা যাচাই করতে ছবিতে ক্লিক করুন</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Admin Action Card -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">
                            <i class="fa-solid fa-gavel me-2"></i> আবেদন পর্যালোচনা অ্যাকশন
                        </h5>

                        <form action="{{ route('admin.loans.updateStatus', $loan->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে স্থিতি পরিবর্তন করতে চান?')">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="status-select" class="form-label fw-bold text-muted small text-uppercase">আবেদনের স্থিতি নির্বাচন করুন</label>
                                <select name="status" id="status-select" class="form-select border-light bg-light rounded-3 p-3">
                                    <option value="pending" {{ $loan->status === 'pending' ? 'selected' : '' }}>অপেক্ষমান রাখুন (Pending)</option>
                                    <option value="approved" {{ $loan->status === 'approved' ? 'selected' : '' }}>অনুমোদন করুন (Approve)</option>
                                    <option value="rejected" {{ $loan->status === 'rejected' ? 'selected' : '' }}>প্রত্যাখ্যান করুন (Reject)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="admin-message" class="form-label fw-bold text-muted small text-uppercase">প্রশাসনিক বার্তা (Administrative Message)</label>
                                <textarea name="admin_message" id="admin-message" class="form-control border-light bg-light rounded-3 p-3" rows="3" placeholder="যেমন: পেমেন্ট সম্পন্ন হয়েছে বা কোনো নির্দেশনা...">{{ old('admin_message', $loan->admin_message) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                                স্থিতি আপডেট করুন <i class="fa-solid fa-circle-chevron-right ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection
