@extends('admin.master')

@section('main-content')
<div class="page-wrapper" style="padding: 24px 30px;">
    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1e293b;">
                <i class="fas fa-file-contract text-primary me-2"></i>ঋণ চুক্তিপত্র স্ট্যাম্প
            </h4>
            <p class="text-muted small mb-0">লোন চুক্তিপত্রের জন্য স্ট্যাম্পের ছবি আপলোড এবং ব্যবস্থাপনা করুন</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background: #ecfdf5; color: #065f46;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Left Panel: Upload Form --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #ffffff;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color: #0f172a; font-size: 16px;">
                        <i class="fas fa-cloud-upload-alt text-primary me-2"></i>নতুন স্ট্যাম্প আপলোড
                    </h5>
                    
                    <form action="{{ route('admin.loan-contract-stamp.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted mb-2" style="font-size: 13.5px;">স্ট্যাম্প ইমেজ ফাইল সিলেক্ট করুন <span class="text-danger">*</span></label>
                            
                            {{-- Premium Standard File Input (Fixes hidden input validation bugs) --}}
                            <input class="form-control" type="file" name="stamp" accept="image/*" required onchange="previewNewUpload(this)" style="border-radius: 8px; padding: 10px 14px;">
                            
                            {{-- Image Preview Area --}}
                            <div id="new-upload-preview-container" class="mt-3 p-2 border rounded-3 text-center bg-light" style="display: none; border-style: dashed !important;">
                                <small class="text-muted d-block mb-2">ফাইল প্রিভিউ</small>
                                <img id="new-upload-preview" src="#" alt="Preview" style="max-height: 160px; max-width: 100%; object-fit: contain; border-radius: 6px;">
                            </div>
                        </div>
                        
                        {{-- Prominent Submit Button --}}
                        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold rounded-3 shadow-sm" style="font-size: 14.5px;">
                            <i class="fas fa-check-circle me-2"></i> সাবমিট করুন (Upload)
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Panel: Active Stamp Grid --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #ffffff;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #0f172a; font-size: 16px;">
                        <i class="fas fa-images text-primary me-2"></i>সংরক্ষিত স্ট্যাম্পসমূহ
                    </h5>

                    @if($stamps->isNotEmpty())
                        <div class="row g-4">
                            @foreach($stamps as $stamp)
                                <div class="col-md-6">
                                    <div class="card h-100 border shadow-sm" style="border-radius: 12px; overflow: hidden; background: #ffffff; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                                        
                                        {{-- Image Header Preview --}}
                                        <div class="position-relative bg-light d-flex align-items-center justify-content-center" style="height: 240px; overflow: hidden; border-bottom: 1px solid #f1f5f9;">
                                            <img src="{{ $stamp['url'] }}" alt="Stamp Preview" style="max-width: 100%; max-height: 100%; object-fit: contain; padding: 12px;">
                                            
                                            {{-- Zoom Quick View Button --}}
                                            <button class="btn btn-sm btn-dark position-absolute top-2 right-2 rounded-circle" data-bs-toggle="modal" data-bs-target="#stampModal{{ md5($stamp['filename']) }}" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; opacity: 0.85; transition: opacity 0.2s;" title="বড় করে দেখুন">
                                                <i class="fas fa-search-plus"></i>
                                            </button>
                                        </div>

                                        {{-- Card Body --}}
                                        <div class="card-body p-3">
                                            <div class="mb-3">
                                                <span class="d-block fw-bold text-truncate" style="font-size: 13.5px; color: #1e293b;" title="{{ $stamp['filename'] }}">{{ $stamp['filename'] }}</span>
                                                <small class="text-muted" style="font-size: 11px;">স্টোরেজ লিঙ্ক: uploads/information/{{ $stamp['filename'] }}</small>
                                            </div>

                                            <div class="d-flex align-items-center gap-2">
                                                {{-- Replace/Update Trigger Button --}}
                                                <button class="btn btn-sm btn-outline-primary flex-1 py-2 fw-600" data-bs-toggle="modal" data-bs-target="#replaceModal{{ md5($stamp['filename']) }}" title="নতুন ফাইল দিয়ে পরিবর্তন করুন">
                                                    <i class="fas fa-sync-alt me-1"></i> আপডেট
                                                </button>

                                                {{-- Delete Trigger Button --}}
                                                <form action="{{ route('admin.loan-contract-stamp.delete', ['filename' => $stamp['filename']]) }}" method="POST" class="d-inline flex-1" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই স্ট্যাম্প ইমেজটি মুছে ফেলতে চান?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100 py-2 fw-600">
                                                        <i class="fas fa-trash-alt me-1"></i> মুছে ফেলুন
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stamp Big Lightbox Modal -->
                                <div class="modal fade" id="stampModal{{ md5($stamp['filename']) }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 bg-dark text-white" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                                            <div class="modal-header border-0 p-3 bg-dark">
                                                <h6 class="modal-title fw-bold text-white-50"><i class="fas fa-file-image me-2"></i> {{ $stamp['filename'] }}</h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0 text-center bg-black d-flex align-items-center justify-content-center" style="min-height: 400px;">
                                                <img src="{{ $stamp['url'] }}" alt="Full Stamp View" style="max-width: 100%; max-height: 80vh; object-fit: contain; padding: 10px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Replace/Update Modal -->
                                <div class="modal fade" id="replaceModal{{ md5($stamp['filename']) }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.35);">
                                            <div class="modal-header bg-primary text-white border-0 p-3">
                                                <h6 class="modal-title fw-bold"><i class="fas fa-sync-alt me-2"></i>স্ট্যাম্প আপডেট করুন</h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.loan-contract-stamp.replace', ['filename' => $stamp['filename']]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body p-4">
                                                    <p class="text-muted small mb-3"><strong>{{ $stamp['filename'] }}</strong> স্ট্যাম্পটি নতুন ইমেজ ফাইল দিয়ে পরিবর্তন করতে নিচে ফাইল সিলেক্ট করুন।</p>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold text-muted mb-2">নতুন ইমেজ ফাইল <span class="text-danger">*</span></label>
                                                        <input type="file" name="stamp" class="form-control" accept="image/*" required style="border-radius: 8px; padding: 10px 14px;">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 p-3 bg-light d-flex gap-2">
                                                    <button type="button" class="btn btn-secondary flex-1 py-2 rounded-3" data-bs-dismiss="modal">বাতিল</button>
                                                    <button type="submit" class="btn btn-primary flex-1 py-2 rounded-3 fw-bold">সাবমিট করুন (Update)</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-image fs-1 d-block mb-3 opacity-25"></i>
                            <p class="mb-0">কোনো স্ট্যাম্প ইমেজ আপলোড করা নেই।</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Live preview of selected file before upload
    function previewNewUpload(input) {
        const previewContainer = document.getElementById('new-upload-preview-container');
        const previewImg = document.getElementById('new-upload-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewImg.src = '#';
            previewContainer.style.display = 'none';
        }
    }
</script>
@endsection
