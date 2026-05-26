@extends('admin.master')

@section('main-content')
<div class="page-wrapper" style="padding: 24px 30px;">
    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1e293b;">
                <i class="fas fa-award text-success me-2"></i>ঋণ অনুমোদন সার্টিফিকেট স্ট্যাম্প ও সিল সেটিংস
            </h4>
            <p class="text-muted small mb-0">সার্টিফিকেট লেআউটের বিভিন্ন সিল ও লোগো ইমেজসমূহ আপলোড এবং ব্যবস্থাপনা করুন</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background: #ecfdf5; color: #065f46;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background: #fef2f2; color: #991b1b;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @foreach($seals as $key => $seal)
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 16px; background: #ffffff; overflow: hidden;">
                    {{-- Visual Indicator of Status --}}
                    <div class="position-relative bg-light d-flex align-items-center justify-content-center p-3" style="height: 180px; border-bottom: 1px solid #f1f5f9; background: radial-gradient(circle, #f8fafc 0%, #f1f5f9 100%) !important;">
                        @if($seal['url'])
                            <img src="{{ $seal['url'] }}" alt="{{ $seal['title'] }}" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-image fs-1 d-block mb-2 opacity-25"></i>
                                <span class="small d-block text-uppercase fw-bold text-secondary">ডিফল্ট সিল সক্রিয়</span>
                            </div>
                        @endif
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #0f172a; font-size: 14.5px;">{{ $seal['title'] }}</h6>
                            <p class="text-muted small mb-3">ফাইলনেম: <code class="text-success">{{ $seal['filename'] }}</code></p>
                        </div>

                        <div>
                            {{-- Upload Form --}}
                            <form action="{{ route('admin.certificate-stamp.upload') }}" method="POST" enctype="multipart/form-data" class="mb-2">
                                @csrf
                                <input type="hidden" name="seal_type" value="{{ $key }}">
                                <div class="mb-2">
                                    <input class="form-control form-control-sm" type="file" name="seal_file" accept="image/*" required style="border-radius: 6px;">
                                </div>
                                <button type="submit" class="btn btn-sm btn-success w-100 py-1.5 fw-bold rounded-2">
                                    <i class="fas fa-cloud-upload-alt me-1"></i> আপলোড / পরিবর্তন
                                </button>
                            </form>

                            {{-- Delete Form (only show if uploaded) --}}
                            @if($seal['url'])
                                <form action="{{ route('admin.certificate-stamp.delete', ['sealType' => $key]) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই সিল ইমেজটি মুছে ফেলতে চান?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100 py-1.5 fw-bold rounded-2">
                                        <i class="fas fa-trash-alt me-1"></i> ডিলিট করুন (ডিফল্ট ফিরিয়ে আনুন)
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
