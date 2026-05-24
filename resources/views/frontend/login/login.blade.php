<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $gs->site_name ?? 'UBS' }} — লগইন</title>
  @include('frontend.partials.favicon')

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    :root {
      --primary:      #5b4fd4;
      --accent:       #7c6be0;
      --page-bg:      #eeeef8;
    }
    * { box-sizing: border-box; }

    body {
      font-family: 'Hind Siliguri', sans-serif;
      background: var(--page-bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    /* ── Wrapper ── */
    .login-wrapper {
      width: 100%;
      max-width: 980px;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(80,70,180,.15);
      display: flex;
      min-height: 580px;
    }

    /* ══ LEFT ══ */
    .left-panel {
      background: #fff;
      flex: 0 0 46%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 2.5rem;
    }
    .form-inner { width: 100%; max-width: 340px; }

    /* Logo */
    .logo-ring {
      width: 68px; height: 68px;
      border-radius: 50%;
      border: 2.5px solid var(--primary);
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      color: var(--primary);
      font-weight: 700; line-height: 1.15;
      background: #fff;
    }
    .logo-ring .brand-code { font-size: 20px; font-weight: 800; }
    .logo-ring .brand-sub  { font-size: 8px; letter-spacing: 1px; font-weight: 500; }
    .auth-logo-img { max-height: 72px; max-width: 200px; object-fit: contain; }

    .welcome-title { font-size: 1.65rem; font-weight: 700; color: var(--primary); margin-bottom: .2rem; }
    .welcome-sub   { font-size: .875rem; color: #888; }

    /* Input */
    .field-label { font-size: .8rem; font-weight: 600; color: #444; margin-bottom: .35rem; }

    .custom-input-group {
      border: 1.5px solid #dddaf0;
      border-radius: 12px;
      overflow: hidden;
      display: flex; align-items: center;
      background: #fff;
      transition: border-color .2s;
    }
    .custom-input-group:focus-within {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(91,79,212,.12);
    }
    .input-icon  { padding: 0 12px; color: #aaa; font-size: 1.05rem; display: flex; align-items: center; }
    .custom-input-group input {
      border: none; outline: none; flex: 1;
      padding: 12px 0; font-size: .875rem;
      font-family: 'Hind Siliguri', sans-serif;
      background: transparent; color: #444;
    }
    .custom-input-group input::placeholder { color: #bbb; }
    .toggle-pw {
      background: none; border: none; padding: 0 12px;
      color: #aaa; cursor: pointer; font-size: 1rem;
      display: flex; align-items: center; transition: color .2s;
    }
    .toggle-pw:hover { color: var(--primary); }

    .hint-text { font-size: .75rem; color: #aaa; display: flex; align-items: center; gap: 4px; margin-top: 5px; }

    /* Error alert */
    .alert-custom {
      background: #fff0f0; border: 1px solid #f5c6c6;
      border-radius: 10px; padding: 10px 14px;
      font-size: .82rem; color: #c0392b;
      display: flex; align-items: flex-start; gap: 8px;
    }

    /* Button */
    .btn-login {
      background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
      color: #fff; border: none; border-radius: 12px;
      padding: 13px; font-size: 1rem; font-weight: 600;
      width: 100%; font-family: 'Hind Siliguri', sans-serif;
      transition: opacity .2s, transform .15s;
    }
    .btn-login:hover  { opacity: .92; }
    .btn-login:active { transform: scale(.98); }

    /* Divider */
    .or-divider { display: flex; align-items: center; gap: 10px; color: #ccc; font-size: .75rem; }
    .or-divider::before, .or-divider::after { content: ''; flex: 1; height: 1px; background: #ebebeb; }

    .footer-link { font-size: .82rem; color: #888; }
    .footer-link a { color: var(--primary); text-decoration: none; font-weight: 600; }
    .footer-link a:hover { text-decoration: underline; }
    .back-link {
      font-size: .82rem; color: #aaa; text-decoration: none;
      display: inline-flex; align-items: center; gap: 4px; transition: color .2s;
    }
    .back-link:hover { color: var(--primary); }

    /* ══ RIGHT ══ */
    .right-panel { flex: 1; position: relative; overflow: hidden; display: flex; align-items: center; }
    .right-bg-img {
      position: absolute; inset: 0;
      background: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=900&q=80') center/cover no-repeat;
      filter: brightness(.55) saturate(.6);
    }
    .right-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(91,79,212,.75) 0%, rgba(52,64,160,.70) 100%);
    }
    .right-content { position: relative; z-index: 2; padding: 3rem 2.5rem; color: #fff; }
    .right-heading { font-size: clamp(1.5rem,2.8vw,2.1rem); font-weight: 700; line-height: 1.35; margin-bottom: .5rem; }
    .right-sub { font-size: .95rem; color: rgba(255,255,255,.8); margin-bottom: 2.5rem; }

    .feature-card {
      background: rgba(255,255,255,.18);
      border: 1px solid rgba(255,255,255,.22);
      border-radius: 14px; padding: 1.1rem 1rem;
      text-align: center; color: #fff; flex: 1; min-width: 80px;
    }
    .feature-card .fi { font-size: 1.8rem; display: block; margin-bottom: 6px; }
    .feature-card span { font-size: .82rem; color: rgba(255,255,255,.9); }

    /* ══ RESPONSIVE ══ */
    @media (max-width: 767px) {
      .login-wrapper { flex-direction: column; border-radius: 18px; max-width: 440px; }
      .left-panel    { flex: none; padding: 2.5rem 1.75rem; }
      .right-panel   { min-height: 260px; flex: none; }
      .right-content { padding: 2rem 1.5rem; text-align: center; }
      .right-content .d-flex { justify-content: center !important; }
      .right-heading { font-size: 1.5rem; }
    }
  </style>
</head>
<body>

<div class="login-wrapper">

  {{-- ══ LEFT: FORM ══ --}}
  <div class="left-panel">
    <div class="form-inner">

      @include('frontend.partials.auth-logo')

      {{-- Heading --}}
      <div class="text-center mb-4">
        <p class="welcome-title mb-1">স্বাগতম আবার!</p>
        <p class="welcome-sub mb-0">আপনার অ্যাকাউন্টে লগইন করুন</p>
      </div>

      {{-- Error Messages --}}
      @if ($errors->any())
        <div class="alert-custom mb-3">
          <i class="bi bi-exclamation-circle-fill mt-1"></i>
          <div>
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
      @endif

      @if (session('error'))
        <div class="alert-custom mb-3">
          <i class="bi bi-exclamation-circle-fill mt-1"></i>
          <div>{{ session('error') }}</div>
        </div>
      @endif

      {{-- Success Message --}}
      @if (session('success'))
        <div class="alert-custom mb-3" style="background:#f0fff4;border-color:#b7ebc6;color:#1a6b3a;">
          <i class="bi bi-check-circle-fill mt-1"></i>
          <div>{{ session('success') }}</div>
        </div>
      @endif

      {{-- Login Form --}}
      <form method="POST" action="{{ route('customer.login.submit') }}" novalidate>
        @csrf

        {{-- Phone --}}
        <div class="mb-3">
          <div class="field-label">ফোন নম্বর (ইংরেজি)</div>
          <div class="custom-input-group">
            <span class="input-icon"><i class="bi bi-telephone"></i></span>
            <input
              type="tel"
              name="phone"
              placeholder="01XXXXXXXXX"
              autocomplete="tel"
              value="{{ old('phone') }}"
              maxlength="11"
            />
          </div>
          <div class="hint-text">
            <i class="bi bi-info-circle"></i> আপনার নিবন্ধিত ফোন নম্বর দিন
          </div>
        </div>

        {{-- Password --}}
        <div class="mb-4">
          <div class="field-label">পাসওয়ার্ড</div>
          <div class="custom-input-group">
            <span class="input-icon"><i class="bi bi-lock"></i></span>
            <input
              type="password"
              name="password"
              id="pwField"
              placeholder="••••••••"
              autocomplete="current-password"
            />
            <button type="button" class="toggle-pw" onclick="togglePw()" aria-label="পাসওয়ার্ড দেখুন">
              <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-login mb-3">
          লগইন করুন &nbsp;→
        </button>
      </form>

      <div class="or-divider mb-3">অথবা</div>

      <div class="text-center d-flex flex-column align-items-center gap-2">
        <p class="footer-link mb-0">
          অ্যাকাউন্ট নেই? <a href="{{ route('customer.register') }}">নিবন্ধন করুন</a>
        </p>
        <a href="{{ route('frontend') }}" class="back-link">
          <i class="bi bi-arrow-left"></i> হোমে ফিরে যান
        </a>
      </div>

    </div>
  </div>

  {{-- ══ RIGHT: HERO ══ --}}
  <div class="right-panel">
    <div class="right-bg-img"></div>
    <div class="right-overlay"></div>
    <div class="right-content">
      <p class="right-heading">আর্থিক স্বাধীনতা,<br>এখন হাতের মুঠোয়!</p>
      <p class="right-sub">সুরক্ষিত লগইন ব্যবস্থা!</p>
      <div class="d-flex gap-3 flex-wrap">
        <div class="feature-card">
          <i class="bi bi-shield-check fi"></i>
          <span>নিরাপদ</span>
        </div>
        <div class="feature-card">
          <i class="bi bi-lightning-charge fi"></i>
          <span>দ্রুত</span>
        </div>
        <div class="feature-card">
          <i class="bi bi-cash-stack fi"></i>
          <span>সহজ</span>
        </div>
      </div>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Phone: digits only
  document.querySelector('input[name="phone"]')?.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 11);
  });

  // Password toggle
  function togglePw() {
    const field = document.getElementById('pwField');
    const icon  = document.getElementById('eyeIcon');
    const show  = field.type === 'password';
    field.type      = show ? 'text' : 'password';
    icon.className  = show ? 'bi bi-eye-slash' : 'bi bi-eye';
  }
</script>
</body>
</html>
