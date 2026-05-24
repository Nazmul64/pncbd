<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $gs->site_name ?? 'UBS' }} - সহজ, দ্রুত ও নিরাপদ লোন</title>
    @include('frontend.partials.favicon')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <style>
        :root {
            --gold: {{ $gs->primary_color ?? '#c9a84c' }};
            --gold-light: {{ $gs->button_bg_color ?? ($gs->primary_color ?? '#e8c97a') }};
        }
        .btn-gold {
            background: linear-gradient(135deg, {{ $gs->button_bg_color ?? $gs->primary_color ?? '#c9a84c' }} 0%, {{ $gs->primary_color ?? '#e8c97a' }} 100%);
            color: {{ $gs->button_text_color ?? '#07111f' }};
        }
    </style>
</head>
<body>

<section class="hero">
    <div class="hero-inner">

        {{-- ── Logo (General Settings — শুধু লোগো অথবা সাইট নাম) ── --}}
        <div class="logo-wrap">
            @if(!empty($gs->header_logo))
                <img src="{{ asset($gs->header_logo) }}" alt="{{ $gs->site_name ?? 'UBS' }}" class="hero-logo-img">
            @else
                <div class="logo-ring">
                    <span class="logo-symbol">{{ mb_substr($gs->site_name ?? 'U', 0, 1) }}</span>
                </div>
                <span class="logo-name-main">{{ $gs->site_name ?? 'UBS' }}</span>
            @endif
        </div>

        {{-- ── Live badge ── --}}
        <div class="live-badge">
            <span class="live-dot"></span>
            বাংলাদেশে এখন উপলব্ধ
        </div>

        {{-- ── Heading ── --}}
        <h1 class="main-title">
            সহজ, দ্রুত ও <span class="hl">নিরাপদ লোন</span><br>
            আপনার দোরগোড়ায়
        </h1>






        {{-- ── CTA Buttons ── --}}
        <div class="cta-group">
            <button class="btn-gold" onclick="handleApply()">
                <i class="fas fa-file-alt"></i>
                লোনের জন্য আবেদন করুন
            </button>
            <button class="btn-outline" onclick="handleDownload()">
                <i class="fas fa-download"></i>
                অ্যাপ ডাউনলোড করুন
            </button>
        </div>

        {{-- ── Login / Dashboard ── --}}
        @auth
            @if(auth()->user()->hasRole('customer'))
                <a href="{{ route('customer.dashboard') }}" class="login-link">
                    <i class="fas fa-arrow-right"></i>
                    আমার ড্যাশবোর্ডে যান
                </a>
            @endif
        @else
            <a href="{{ route('customer.login') }}" class="login-link">
                <i class="fas fa-arrow-right"></i>
                ইতিমধ্যে অ্যাকাউন্ট আছে? লগইন করুন
            </a>
        @endauth

        {{-- ── Feature Cards ── --}}
        <div class="feat-grid">
            <div class="feat-card">
                <div class="feat-icon"><i class="fas fa-bolt"></i></div>
                <div class="feat-title">দ্রুত অনুমোদন</div>
                <div class="feat-desc">মাত্র ২৪ ঘণ্টায় লোন পান</div>
            </div>
            <div class="feat-card">
                <div class="feat-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="feat-title">সম্পূর্ণ নিরাপদ</div>
                <div class="feat-desc">ব্যাংক গ্রেড এনক্রিপশন</div>
            </div>
            <div class="feat-card">
                <div class="feat-icon"><i class="fas fa-percent"></i></div>
                <div class="feat-title">কম সুদের হার</div>
                <div class="feat-desc">মাত্র ৯.৫% থেকে শুরু</div>
            </div>
            <div class="feat-card">
                <div class="feat-icon"><i class="fas fa-headset"></i></div>
                <div class="feat-title">২৪/৭ সাপোর্ট</div>
                <div class="feat-desc">সবসময় আপনার পাশে</div>
            </div>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function handleApply() {
        @auth
            @if(auth()->user()->hasRole('customer'))
                window.location.href = '{{ route('loan.step1') }}';
            @else
                window.location.href = '{{ route('customer.login') }}';
            @endif
        @else
            window.location.href = '{{ route('customer.login') }}';
        @endauth
    }
    function handleDownload() {
        window.location.href = '#';
    }
</script>
</body>
</html>
