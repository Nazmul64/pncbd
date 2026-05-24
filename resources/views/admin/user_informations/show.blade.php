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

.btn-back-custom {
    background: white;
    color: #4b5563;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}

.btn-back-custom:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #94a3b8;
}

/* ── LAYOUT CARDS ── */
.info-card {
    background: #white;
    background: white;
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,0.02);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
    overflow: hidden;
}

.info-card-header {
    padding: 18px 24px;
    border-bottom: 1px solid #f1f5f9;
    background: #fff;
    display: flex;
    align-items: center;
    gap: 12px;
}

.info-card-header i {
    font-size: 18px;
    color: #3b82f6;
}

.info-card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
}

.info-card-body {
    padding: 24px;
}

/* ── PROFILE PROFILE BLOCK ── */
.profile-block {
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-selfie {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #3b82f6;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s;
}

.profile-selfie:hover {
    transform: scale(1.05);
}

.profile-details h2 {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 6px;
}

.profile-details p {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 4px;
}

/* ── DATA LABEL VALUE GRID ── */
.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
}

.detail-item {
    background: #f8fafc;
    border-radius: 12px;
    padding: 14px 18px;
    border: 1px solid #e2e8f0;
}

.detail-label {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 700;
    color: #64748b;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.detail-value {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}

/* ── ADDRESS AREA ── */
.address-box {
    background: #f8fafc;
    border-left: 4px solid #3b82f6;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
}

/* ── DOCUMENT PREVIEW CONTAINER ── */
.doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.doc-card {
    background: #f8fafc;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    padding: 16px;
    text-align: center;
    position: relative;
}

.doc-card-title {
    font-size: 14px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 12px;
}

.doc-img-wrapper {
    height: 180px;
    border-radius: 8px;
    overflow: hidden;
    background: #e2e8f0;
    cursor: pointer;
    border: 1px solid #cbd5e1;
    position: relative;
    transition: all 0.3s;
}

.doc-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s;
}

.doc-img-wrapper:hover img {
    transform: scale(1.08);
}

.doc-img-wrapper::after {
    content: '\F64D Zoom';
    font-family: 'bootstrap-icons';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(15, 23, 42, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 16px;
    opacity: 0;
    transition: all 0.3s;
}

.doc-img-wrapper:hover::after {
    opacity: 1;
}

.signature-img-wrapper {
    height: 120px;
    background: white;
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}

.signature-img-wrapper img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

/* ── LIGHTBOX ── */
.lightbox-modal {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(15, 23, 42, 0.95);
    z-index: 1080;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: all 0.3s ease;
}

.lightbox-modal.active {
    opacity: 1;
    pointer-events: auto;
}

.lightbox-img {
    max-width: 90%;
    max-height: 85%;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    transform: scale(0.9);
    transition: all 0.3s ease;
}

.lightbox-modal.active .lightbox-img {
    transform: scale(1);
}

.lightbox-close {
    position: absolute;
    top: 24px;
    right: 24px;
    background: rgba(255,255,255,0.1);
    color: white;
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.lightbox-close:hover {
    background: rgba(255,255,255,0.25);
    transform: rotate(90deg);
}

.lightbox-caption {
    position: absolute;
    bottom: 24px;
    color: rgba(255,255,255,0.8);
    font-size: 15px;
    font-weight: 500;
    background: rgba(0,0,0,0.4);
    padding: 8px 18px;
    border-radius: 20px;
}
</style>

<div class="db-page">
    
    {{-- Header --}}
    <div class="db-header">
        <div>
            <h1>গ্রাহক ডকুমেন্টের বিস্তারিত বিবরণ</h1>
            <p>গ্রাহক {{ $information->full_name }} এর পাঠানো সকল তথ্য ও ডকুমেন্ট ভেরিফাই করুন</p>
        </div>
        <div>
            <a href="{{ route('admin.documentation.index') }}" class="btn-back-custom">
                <i class="bi bi-arrow-left"></i> তালিকায় ফিরে যান
            </a>
        </div>
    </div>

    {{-- Submission Basic Header --}}
    <div class="info-card p-4">
        <div class="profile-block">
            @if($information->selfie)
                <img src="{{ asset($information->selfie) }}" alt="Selfie" class="profile-selfie" onclick="openLightbox('{{ asset($information->selfie) }}', 'Selfie - {{ $information->full_name }}')">
            @else
                <div class="profile-selfie d-flex align-items-center justify-content-center bg-light text-secondary fw-bold" style="font-size: 32px;">
                    {{ substr($information->full_name, 0, 1) }}
                </div>
            @endif
            <div class="profile-details">
                <h2>{{ $information->full_name }}</h2>
                <p><i class="bi bi-telephone-fill me-2"></i> {{ $information->phone_number }}</p>
                <p><i class="bi bi-envelope-fill me-2"></i> {{ $information->user->email ?? 'N/A' }}</p>
                <p><i class="bi bi-clock-fill me-2"></i> সাবমিট হয়েছে: {{ $information->created_at->format('d M Y, h:i A') }} ({{ $information->created_at->diffForHumans() }})</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Personal and Nominee details -->
        <div class="col-lg-6">
            {{-- Personal Details --}}
            <div class="info-card">
                <div class="info-card-header">
                    <i class="bi bi-person-fill"></i>
                    <h5 class="info-card-title">ব্যক্তিগত তথ্য বিবরণী</h5>
                </div>
                <div class="info-card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">পূর্ণ নাম</div>
                            <div class="detail-value">{{ $information->full_name }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">মোবাইল নম্বর</div>
                            <div class="detail-value">{{ $information->phone_number }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">NID নম্বর</div>
                            <div class="detail-value font-monospace">{{ $information->nid_number }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">পেশা</div>
                            <div class="detail-value">{{ $information->occupation }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nominee Details --}}
            <div class="info-card">
                <div class="info-card-header">
                    <i class="bi bi-people-fill"></i>
                    <h5 class="info-card-title">নমিনি (উত্তরাধিকারী) তথ্য বিবরণী</h5>
                </div>
                <div class="info-card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">নমিনির নাম</div>
                            <div class="detail-value">{{ $information->nominee_name }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">সম্পর্ক</div>
                            <div class="detail-value">{{ $information->nominee_relation }}</div>
                        </div>
                        <div class="detail-item" style="grid-column: span 2;">
                            <div class="detail-label">নমিনির ফোন নম্বর</div>
                            <div class="detail-value">{{ $information->nominee_phone }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            {{-- Addresses --}}
            <div class="info-card" style="height: calc(100% - 24px);">
                <div class="info-card-header">
                    <i class="bi bi-geo-alt-fill"></i>
                    <h5 class="info-card-title">ঠিকানা বিবরণ</h5>
                </div>
                <div class="info-card-body">
                    <h6 class="fw-bold text-dark mb-2">বর্তমান ঠিকানা</h6>
                    <div class="address-box mb-4">
                        <p class="mb-0 text-secondary" style="font-size: 14px; line-height: 1.6;">{{ $information->current_address }}</p>
                    </div>

                    <h6 class="fw-bold text-dark mb-2">স্থায়ী ঠিকানা</h6>
                    <div class="address-box">
                        <p class="mb-0 text-secondary" style="font-size: 14px; line-height: 1.6;">{{ $information->permanent_address }}</p>
                    </div>

                    @if($information->loan_reason)
                        <h6 class="fw-bold text-dark mt-4 mb-2">ঋণ নেওয়ার মূল কারণ</h6>
                        <div class="bg-light border rounded-3 p-3 text-secondary" style="font-size: 14px; line-height: 1.6;">
                            {{ $information->loan_reason }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Documents Section --}}
    <div class="info-card mt-4">
        <div class="info-card-header">
            <i class="bi bi-file-earmark-image"></i>
            <h5 class="info-card-title">সংযুক্ত ডকুমেন্টসমূহ এবং স্বাক্ষর</h5>
        </div>
        <div class="info-card-body">
            <div class="doc-grid">
                
                {{-- NID Front --}}
                <div class="doc-card">
                    <div class="doc-card-title">NID কার্ডের সামনের অংশ</div>
                    @if($information->nid_front)
                        <div class="doc-img-wrapper" onclick="openLightbox('{{ asset($information->nid_front) }}', 'NID Front - {{ $information->full_name }}')">
                            <img src="{{ asset($information->nid_front) }}" alt="NID Front">
                        </div>
                    @else
                        <div class="text-muted py-5 border rounded-3 bg-light"><i class="bi bi-image me-2"></i>নেই</div>
                    @endif
                </div>

                {{-- NID Back --}}
                <div class="doc-card">
                    <div class="doc-card-title">NID কার্ডের পিছনের অংশ</div>
                    @if($information->nid_back)
                        <div class="doc-img-wrapper" onclick="openLightbox('{{ asset($information->nid_back) }}', 'NID Back - {{ $information->full_name }}')">
                            <img src="{{ asset($information->nid_back) }}" alt="NID Back">
                        </div>
                    @else
                        <div class="text-muted py-5 border rounded-3 bg-light"><i class="bi bi-image me-2"></i>নেই</div>
                    @endif
                </div>

                {{-- Other Document --}}
                <div class="doc-card">
                    <div class="doc-card-title">অন্যান্য প্রয়োজনীয় ডকুমেন্ট (ঐচ্ছিক)</div>
                    @if($information->other_document)
                        @php $ext = pathinfo($information->other_document, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                            <div class="doc-img-wrapper" onclick="openLightbox('{{ asset($information->other_document) }}', 'Other Document - {{ $information->full_name }}')">
                                <img src="{{ asset($information->other_document) }}" alt="Other Document">
                            </div>
                        @else
                            <div class="py-5 border rounded-3 bg-light d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size: 3rem;"></i>
                                <a href="{{ asset($information->other_document) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 fw-bold">ডাউনলোড করুন</a>
                            </div>
                        @endif
                    @else
                        <div class="text-muted py-5 border rounded-3 bg-light d-flex align-items-center justify-content-center" style="height: 180px;"><i class="bi bi-file-earmark-lock2 me-2"></i>ডকুমেন্ট সংযুক্ত করা হয়নি</div>
                    @endif
                </div>

                {{-- Signature --}}
                <div class="doc-card">
                    <div class="doc-card-title">গ্রাহকের স্বাক্ষর (Signature)</div>
                    @if($information->signature)
                        <div class="signature-img-wrapper shadow-sm mt-3" style="cursor: pointer;" onclick="openLightbox('{{ asset($information->signature) }}', 'Signature - {{ $information->full_name }}')">
                            <img src="{{ asset($information->signature) }}" alt="Customer Signature">
                        </div>
                    @else
                        <div class="text-muted py-5 border rounded-3 bg-light"><i class="bi bi-pencil-fill me-2"></i>স্বাক্ষর নেই</div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

{{-- Lightbox Modal --}}
<div class="lightbox-modal" id="lightboxModal" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="event.stopPropagation(); closeLightbox()"><i class="bi bi-x-lg"></i></button>
    <img class="lightbox-img" id="lightboxImage" src="" alt="Zoomed view" onclick="event.stopPropagation()">
    <div class="lightbox-caption" id="lightboxCaption"></div>
</div>

<script>
function openLightbox(src, caption) {
    const modal = document.getElementById('lightboxModal');
    const img = document.getElementById('lightboxImage');
    const cap = document.getElementById('lightboxCaption');
    
    img.src = src;
    cap.innerText = caption;
    modal.classList.add('active');
    
    // Add escape key listener
    document.addEventListener('keydown', handleEscapeKey);
}

function closeLightbox() {
    const modal = document.getElementById('lightboxModal');
    modal.classList.remove('active');
    document.removeEventListener('keydown', handleEscapeKey);
}

function handleEscapeKey(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
}
</script>
@endsection
