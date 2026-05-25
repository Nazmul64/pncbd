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

{{-- ══════════════════════════════════════════════════════════════════════════════
     LIVE SUPPORT CHAT WIDGET (Glassmorphism & Rich Premium Aesthetics)
     ══════════════════════════════════════════════════════════════════════════════ --}}
<style>
    /* Chat Widget Container */
    #ubs-live-chat {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999999;
        font-family: 'Hind Siliguri', 'Segoe UI', Roboto, sans-serif;
    }

    /* Floating Launcher Button */
    .ubs-chat-launcher {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff5e36 0%, #ff8000 100%);
        border: none;
        outline: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 28px rgba(255, 94, 0, 0.4);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
    }
    .ubs-chat-launcher:hover {
        transform: scale(1.1) translateY(-3px);
        box-shadow: 0 12px 35px rgba(255, 94, 0, 0.55);
    }
    .ubs-chat-launcher:active {
        transform: scale(0.95) translateY(0);
    }
    .ubs-chat-launcher i {
        color: #ffffff;
        font-size: 26px;
        transition: transform 0.3s ease;
    }
    .ubs-chat-launcher.active i {
        transform: rotate(90deg);
    }

    /* Launcher Ripple Effect Aura */
    .ubs-chat-launcher::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(255, 94, 0, 0.25);
        border-radius: 50%;
        top: 0;
        left: 0;
        z-index: -1;
        animation: ubs-pulse-aura 2.5s infinite;
    }

    @keyframes ubs-pulse-aura {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(1.6);
            opacity: 0;
        }
    }

    /* Unread Messages Badge */
    .ubs-unread-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        background: #dc3545;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ffffff;
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        animation: ubs-badge-bounce 0.5s ease-out;
    }

    @keyframes ubs-badge-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    /* Premium Glassmorphic Chat Window Card */
    .ubs-chat-card {
        width: 380px;
        height: 550px;
        max-height: 80vh;
        position: absolute;
        bottom: 80px;
        right: 0;
        background: rgba(15, 23, 42, 0.88);
        backdrop-filter: blur(24px) saturate(180%);
        -webkit-backdrop-filter: blur(24px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.45);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        transform-origin: bottom right;
        opacity: 0;
        transform: translateY(30px) scale(0.92);
        pointer-events: none;
    }
    .ubs-chat-card.show {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: all;
    }

    @media (max-width: 480px) {
        .ubs-chat-card {
            width: calc(100vw - 40px);
            right: -10px;
            bottom: 75px;
        }
    }

    /* Card Header */
    .ubs-chat-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    .ubs-chat-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .ubs-support-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }
    .ubs-support-avatar i {
        font-size: 20px;
        color: #ffffff;
    }
    .ubs-support-title {
        font-size: 15px;
        font-weight: 600;
        margin: 0;
        line-height: 1.2;
    }
    .ubs-support-status {
        font-size: 11px;
        opacity: 0.95;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 2px;
    }
    .ubs-status-dot {
        width: 7px;
        height: 7px;
        background-color: #34d399;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 rgba(52, 211, 153, 0.4);
        animation: ubs-dot-pulse 2s infinite;
    }

    @keyframes ubs-dot-pulse {
        0% { box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7); }
        70% { box-shadow: 0 0 0 5px rgba(52, 211, 153, 0); }
        100% { box-shadow: 0 0 0 0 rgba(52, 211, 153, 0); }
    }

    /* Header Action Buttons */
    .ubs-chat-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .ubs-chat-action-btn {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.85);
        font-size: 16px;
        cursor: pointer;
        padding: 4px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ubs-chat-action-btn:hover {
        color: #ffffff;
        transform: scale(1.15);
    }

    /* Card Scrollable Body */
    .ubs-chat-body {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        background: rgba(10, 15, 28, 0.65);
    }
    .ubs-chat-body::-webkit-scrollbar {
        width: 5px;
    }
    .ubs-chat-body::-webkit-scrollbar-track {
        background: transparent;
    }
    .ubs-chat-body::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    /* Guest Form Container */
    .ubs-guest-form-container {
        margin: auto 0;
        padding: 10px;
        animation: ubs-fade-in 0.4s ease;
    }
    .ubs-guest-form-title {
        color: #e2e8f0;
        font-size: 14.5px;
        text-align: center;
        margin-bottom: 24px;
        line-height: 1.6;
        font-weight: 500;
    }
    .ubs-chat-label {
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 6px;
        display: block;
        font-weight: 500;
    }
    .ubs-chat-input-field {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
        border-radius: 12px !important;
        padding: 11px 16px !important;
        font-size: 14px !important;
        transition: all 0.3s !important;
    }
    .ubs-chat-input-field:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 12px rgba(16, 185, 129, 0.25) !important;
        background: rgba(255, 255, 255, 0.08) !important;
        outline: none !important;
    }
    .ubs-chat-input-field::placeholder {
        color: #64748b !important;
    }

    /* Messages Area styling */
    .ubs-messages-area {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Message Bubbles layout */
    .ubs-msg-wrapper {
        display: flex;
        flex-direction: column;
        max-width: 80%;
    }
    .ubs-msg-wrapper.own {
        align-self: flex-end;
        align-items: flex-end;
    }
    .ubs-msg-wrapper.other {
        align-self: flex-start;
        align-items: flex-start;
    }

    .ubs-msg-sender {
        font-size: 11px;
        color: #64748b;
        margin-bottom: 4px;
        padding: 0 4px;
    }

    .ubs-msg-bubble {
        padding: 11px 16px;
        font-size: 13.5px;
        line-height: 1.55;
        border-radius: 18px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        word-break: break-word;
    }

    /* Styles for different sender types */
    .ubs-msg-wrapper.own .ubs-msg-bubble {
        background: #10b981;
        color: #ffffff;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    .ubs-msg-wrapper.other .ubs-msg-bubble {
        background: rgba(255, 255, 255, 0.08);
        color: #f1f5f9;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-bottom-left-radius: 4px;
    }

    .ubs-msg-time {
        font-size: 9.5px;
        color: #64748b;
        margin-top: 4px;
        padding: 0 4px;
    }

    /* Footer & message input wrapper */
    .ubs-chat-footer {
        padding: 14px 18px;
        background: rgba(15, 22, 38, 0.95);
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .ubs-chat-input-wrapper {
        flex: 1;
        position: relative;
        display: flex;
        align-items: center;
    }
    .ubs-chat-message-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 10px 48px 10px 18px;
        color: #ffffff;
        font-size: 13.5px;
        outline: none;
        resize: none;
        max-height: 100px;
        min-height: 40px;
        line-height: 1.4;
        transition: all 0.3s;
    }
    .ubs-chat-message-input:focus {
        border-color: rgba(16, 185, 129, 0.6);
        background: rgba(255, 255, 255, 0.06);
    }
    .ubs-chat-message-input::placeholder {
        color: #475569;
    }
    .ubs-chat-send-btn {
        position: absolute;
        right: 5px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #10b981;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 13px;
        transition: all 0.25s;
    }
    .ubs-chat-send-btn:hover {
        background: #059669;
        transform: scale(1.08);
    }
    .ubs-chat-send-btn:active {
        transform: scale(0.95);
    }

    /* Keyframe Animations */
    @keyframes ubs-fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div id="ubs-live-chat">
    <!-- Chat Toggle Launcher Button -->
    <button class="ubs-chat-launcher" id="ubs-launcher" onclick="toggleUbsChat()" aria-label="Toggle Live Chat">
        <i class="fas fa-comment-dots" id="ubs-launcher-icon"></i>
        <span class="ubs-unread-badge" id="ubs-unread-count" style="display: none;">0</span>
    </button>

    <!-- Chat Card Window Panel -->
    <div class="ubs-chat-card" id="ubs-chat-card">
        <!-- Header -->
        <div class="ubs-chat-header">
            <div class="ubs-chat-header-info">
                <div class="ubs-support-avatar">
                    <i class="fas fa-headset"></i>
                </div>
                <div>
                    <h5 class="ubs-support-title">{{ $gs->site_name ?? 'UBS' }} Support</h5>
                    <span class="ubs-support-status">
                        <span class="ubs-status-dot"></span> অনলাইন আছেন
                    </span>
                </div>
            </div>
            <div class="ubs-chat-actions">
                <!-- Close / End session action -->
                <button class="ubs-chat-action-btn" id="ubs-end-chat-btn" onclick="endUbsChatSession()" title="কোপন শেষ করুন" style="display: none;">
                    <i class="fas fa-power-off"></i>
                </button>
                <!-- Minimize window -->
                <button class="ubs-chat-action-btn" onclick="toggleUbsChat()" title="লুকিয়ে রাখুন">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="ubs-chat-body" id="ubs-chat-body">
            <!-- Guest Registration Form -->
            <div class="ubs-guest-form-container" id="ubs-guest-form" style="display: none;">
                <p class="ubs-guest-form-title">আমাদের প্রতিনিধির সাথে সরাসরি কথা বলতে নিচের তথ্যগুলো দিন।</p>
                <form id="ubs-guest-chat-form" onsubmit="submitGuestChat(event)">
                    <div class="mb-3">
                        <label class="ubs-chat-label">আপনার নাম <span class="text-danger">*</span></label>
                        <input type="text" id="ubs-guest-name" class="form-control ubs-chat-input-field" placeholder="যেমন: কামাল হোসেন" required autocomplete="name">
                    </div>
                    <div class="mb-4">
                        <label class="ubs-chat-label">আপনার ইমেইল <span class="text-danger">*</span></label>
                        <input type="email" id="ubs-guest-email" class="form-control ubs-chat-input-field" placeholder="যেমন: kamal@example.com" required autocomplete="email">
                    </div>
                    <button type="submit" class="btn btn-gold w-100 py-2.5 font-medium rounded-3">চ্যাট শুরু করুন</button>
                </form>
            </div>

            <!-- Messages Area Container -->
            <div class="ubs-messages-area" id="ubs-messages-area" style="display: none;">
                <!-- Dynamically populated messages -->
            </div>
        </div>

        <!-- Footer -->
        <div class="ubs-chat-footer" id="ubs-chat-footer" style="display: none;">
            <div class="ubs-chat-input-wrapper">
                <textarea id="ubs-chat-message-input" class="ubs-chat-message-input" placeholder="আপনার বার্তা লিখুন..." rows="1" onkeydown="handleChatKeyPress(event)"></textarea>
                <button class="ubs-chat-send-btn" onclick="sendUbsMessage()" id="ubs-send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // ══════════════════════════════════════════════════════════════════════════════
    // LIVE CHAT ENGINE & CONTROLLER
    // ══════════════════════════════════════════════════════════════════════════════
    const ubsChatConfig = {
        csrfToken: '{{ csrf_token() }}',
        isLoggedIn: @auth true @else false @endauth,
        startUrl: '{{ route('chat.start') }}',
        sendUrl: '{{ route('chat.send') }}',
        messagesUrl: '{{ route('chat.messages') }}',
        closeUrl: '{{ route('chat.close') }}'
    };

    let ubsChatSessionUuid = localStorage.getItem('ubs_chat_uuid');
    let ubsLastMsgId = 0;
    let ubsPollingInterval = null;
    let ubsUnreadCount = 0;
    let ubsIsChatActive = false;

    // Run automatically on page load
    document.addEventListener("DOMContentLoaded", function() {
        initUbsChat();
    });

    function initUbsChat() {
        if (ubsChatConfig.isLoggedIn) {
            // Logged-in user: directly load their session silently to pull unread messages
            resumeUbsSession();
        } else if (ubsChatSessionUuid) {
            // Guest user with existing session UUID: resume silently
            resumeUbsSession();
        } else {
            // Guest user, no session: Show guest form when they open the window
            document.getElementById('ubs-guest-form').style.display = 'block';
        }
    }

    // Toggle Chat Window Visibility
    function toggleUbsChat() {
        const chatCard = document.getElementById('ubs-chat-card');
        const launcher = document.getElementById('ubs-launcher');
        const icon = document.getElementById('ubs-launcher-icon');
        
        const isShown = chatCard.classList.toggle('show');
        launcher.classList.toggle('active', isShown);

        if (isShown) {
            icon.className = "fas fa-times";
            ubsIsChatActive = true;
            // Clear unread badge
            setUnreadCount(0);

            // If we have an active session, pull latest messages and scroll to bottom
            if (ubsChatSessionUuid || ubsChatConfig.isLoggedIn) {
                pollUbsMessages();
                setTimeout(scrollUbsChatToBottom, 150);
            }
            // Auto focus input
            const inputField = document.getElementById('ubs-chat-message-input');
            if (inputField && document.getElementById('ubs-chat-footer').style.display !== 'none') {
                inputField.focus();
            }
        } else {
            icon.className = "fas fa-comment-dots";
            ubsIsChatActive = false;
        }
    }

    // Resume an active chat session on page load
    function resumeUbsSession() {
        const payload = {};
        if (ubsChatSessionUuid) {
            payload.session_uuid = ubsChatSessionUuid;
        }

        fetch(ubsChatConfig.startUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': ubsChatConfig.csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                ubsChatSessionUuid = data.session_uuid;
                localStorage.setItem('ubs_chat_uuid', data.session_uuid);
                
                // Show action close button
                document.getElementById('ubs-end-chat-btn').style.display = 'block';
                
                // Render and load messages
                renderInitialMessages(data.messages);
                
                // Setup layouts
                document.getElementById('ubs-guest-form').style.display = 'none';
                document.getElementById('ubs-messages-area').style.display = 'flex';
                document.getElementById('ubs-chat-footer').style.display = 'flex';
                
                // Calculate initial unread messages count if chat window is closed
                let unreadCount = 0;
                data.messages.forEach(m => {
                    if (m.sender_type === 'admin' && !m.is_read) {
                        unreadCount++;
                    }
                });
                if (unreadCount > 0 && !ubsIsChatActive) {
                    setUnreadCount(unreadCount);
                }

                // Start active polling
                startUbsPolling();
            }
        })
        .catch(err => console.error("Error resuming chat session:", err));
    }

    // Submit guest registration form
    function submitGuestChat(event) {
        event.preventDefault();
        
        const guestName = document.getElementById('ubs-guest-name').value.trim();
        const guestEmail = document.getElementById('ubs-guest-email').value.trim();
        
        if (!guestName || !guestEmail) return;

        const submitBtn = event.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> শুরু হচ্ছে...';

        fetch(ubsChatConfig.startUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': ubsChatConfig.csrfToken
            },
            body: JSON.stringify({
                guest_name: guestName,
                guest_email: guestEmail
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                ubsChatSessionUuid = data.session_uuid;
                localStorage.setItem('ubs_chat_uuid', data.session_uuid);
                
                // Show action close button
                document.getElementById('ubs-end-chat-btn').style.display = 'block';
                
                // Reset form layout
                document.getElementById('ubs-guest-form').style.display = 'none';
                document.getElementById('ubs-messages-area').style.display = 'flex';
                document.getElementById('ubs-chat-footer').style.display = 'flex';
                
                renderInitialMessages([]);
                
                // Start polling
                startUbsPolling();

                // Focus message input
                setTimeout(() => {
                    const input = document.getElementById('ubs-chat-message-input');
                    if (input) input.focus();
                }, 100);
            } else {
                submitBtn.disabled = false;
                submitBtn.innerText = 'চ্যাট শুরু করুন';
                alert("চ্যাট শুরু করা যায়নি। আবার চেষ্টা করুন।");
            }
        })
        .catch(err => {
            console.error("Error starting guest chat:", err);
            submitBtn.disabled = false;
            submitBtn.innerText = 'চ্যাট শুরু করুন';
        });
    }

    // Render messages returned on startup
    function renderInitialMessages(messages) {
        const area = document.getElementById('ubs-messages-area');
        area.innerHTML = '';
        
        if (messages && messages.length > 0) {
            messages.forEach(msg => {
                appendMsgHtml(msg);
                if (msg.id > ubsLastMsgId) {
                    ubsLastMsgId = msg.id;
                }
            });
        }
        scrollUbsChatToBottom();
    }

    // HTML Markup generator for a message bubble
    function appendMsgHtml(msg) {
        const area = document.getElementById('ubs-messages-area');
        
        const wrapper = document.createElement('div');
        wrapper.className = `ubs-msg-wrapper ${msg.is_own ? 'own' : 'other'}`;
        wrapper.id = `ubs-msg-${msg.id}`;

        // Add sender label if from admin/support
        if (!msg.is_own) {
            const sender = document.createElement('div');
            sender.className = 'ubs-msg-sender';
            sender.innerText = msg.sender_name;
            wrapper.appendChild(sender);
        }

        // Bubble content
        const bubble = document.createElement('div');
        bubble.className = 'ubs-msg-bubble';
        bubble.innerText = msg.message;
        wrapper.appendChild(bubble);

        // Time stamp
        const time = document.createElement('div');
        time.className = 'ubs-msg-time';
        time.innerText = msg.time;
        wrapper.appendChild(time);

        area.appendChild(wrapper);
    }

    // Send a message
    function sendUbsMessage() {
        const input = document.getElementById('ubs-chat-message-input');
        const text = input.value.trim();
        if (!text) return;

        // Clear input early for high UX response
        input.value = '';
        input.style.height = '40px';

        // Optimistically render message in UI immediately
        const tempId = Date.now();
        const now = new Date();
        let timeStr = now.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit', hour12: true });
        
        const optimisticMsg = {
            id: tempId,
            message: text,
            is_own: true,
            time: timeStr
        };
        
        appendMsgHtml(optimisticMsg);
        scrollUbsChatToBottom();

        // Send payload via API
        fetch(ubsChatConfig.sendUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': ubsChatConfig.csrfToken
            },
            body: JSON.stringify({
                message: text,
                session_uuid: ubsChatSessionUuid
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update temporary optimistic bubble with real backend model ID
                const wrapper = document.getElementById(`ubs-msg-${tempId}`);
                if (wrapper) {
                    wrapper.id = `ubs-msg-${data.message.id}`;
                }
                if (data.message.id > ubsLastMsgId) {
                    ubsLastMsgId = data.message.id;
                }
            } else {
                alert("বার্তাটি পাঠানো যায়নি।");
            }
        })
        .catch(err => {
            console.error("Error sending message:", err);
            // Show error indicator on message bubble
            const bubble = document.querySelector(`#ubs-msg-${tempId} .ubs-msg-bubble`);
            if (bubble) {
                bubble.style.opacity = '0.7';
                bubble.innerText += " (ব্যর্থ হয়েছে)";
            }
        });
    }

    // Key Press handler (Enter to send, Shift+Enter for newline)
    function handleChatKeyPress(event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            sendUbsMessage();
        }
    }

    // Auto-grow input field
    const txtInput = document.getElementById('ubs-chat-message-input');
    if (txtInput) {
        txtInput.addEventListener('input', function() {
            this.style.height = '40px';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }

    // Soft, premium double synth chime for instant clean user feedback (Web Audio API)
    function playUbsNotificationSound() {
        try {
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextClass) return;
            const ctx = new AudioContextClass();
            
            // Resume context if browser suspended it (required by standard security policy)
            if (ctx.state === 'suspended') {
                ctx.resume();
            }

            // Note 1 (C5 - clean sine sound)
            const osc1 = ctx.createOscillator();
            const gain1 = ctx.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(523.25, ctx.currentTime);
            gain1.gain.setValueAtTime(0.08, ctx.currentTime);
            gain1.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.35);
            osc1.connect(gain1);
            gain1.connect(ctx.destination);
            osc1.start();
            osc1.stop(ctx.currentTime + 0.35);

            // Note 2 (E5 - harmonious second chime note, slightly delayed)
            setTimeout(() => {
                const osc2 = ctx.createOscillator();
                const gain2 = ctx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(659.25, ctx.currentTime);
                gain2.gain.setValueAtTime(0.06, ctx.currentTime);
                gain2.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.45);
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.start();
                osc2.stop(ctx.currentTime + 0.45);
            }, 80);

            // Note 3 (G5 - high pleasant finish note, slightly delayed)
            setTimeout(() => {
                const osc3 = ctx.createOscillator();
                const gain3 = ctx.createGain();
                osc3.type = 'sine';
                osc3.frequency.setValueAtTime(783.99, ctx.currentTime);
                gain3.gain.setValueAtTime(0.05, ctx.currentTime);
                gain3.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.55);
                osc3.connect(gain3);
                gain3.connect(ctx.destination);
                osc3.start();
                osc3.stop(ctx.currentTime + 0.55);
            }, 160);
        } catch (e) {
            console.warn("HTML5 AudioContext chime failed:", e);
        }
    }

    // Poll for new messages from the admin panel
    function pollUbsMessages() {
        if (!ubsChatSessionUuid && !ubsChatConfig.isLoggedIn) return;

        let url = `${ubsChatConfig.messagesUrl}?after_id=${ubsLastMsgId}`;
        if (ubsChatSessionUuid) {
            url += `&session_uuid=${ubsChatSessionUuid}`;
        }

        fetch(url, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': ubsChatConfig.csrfToken
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.messages && data.messages.length > 0) {
                let hasNewAdminMsg = false;
                
                data.messages.forEach(msg => {
                    // Double check to make sure we aren't showing own duplicate messages
                    if (!document.getElementById(`ubs-msg-${msg.id}`)) {
                        appendMsgHtml(msg);
                        
                        if (msg.id > ubsLastMsgId) {
                            ubsLastMsgId = msg.id;
                        }
                        
                        if (!msg.is_own) {
                            hasNewAdminMsg = true;
                        }
                    }
                });

                if (hasNewAdminMsg) {
                    scrollUbsChatToBottom();
                    playUbsNotificationSound();
                    
                    // Increment launcher unread badge if chat window is closed
                    if (!ubsIsChatActive) {
                        setUnreadCount(ubsUnreadCount + 1);
                        
                        // Play a elegant notification micro-sound or vibration
                        if (navigator.vibrate) {
                            navigator.vibrate([100, 50, 100]);
                        }
                    }
                }
            }
        })
        .catch(err => console.error("Error polling chat messages:", err));
    }

    // Start background polling
    function startUbsPolling() {
        if (ubsPollingInterval) clearInterval(ubsPollingInterval);
        
        // Poll every 3 seconds for active messaging experience
        ubsPollingInterval = setInterval(pollUbsMessages, 3000);
    }

    // Stop background polling
    function stopUbsPolling() {
        if (ubsPollingInterval) {
            clearInterval(ubsPollingInterval);
            ubsPollingInterval = null;
        }
    }

    // Set value of unread message badge
    function setUnreadCount(count) {
        ubsUnreadCount = count;
        const badge = document.getElementById('ubs-unread-count');
        if (count > 0) {
            badge.innerText = count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    // Scroll chat messages area directly to bottom
    function scrollUbsChatToBottom() {
        const body = document.getElementById('ubs-chat-body');
        body.scrollTop = body.scrollHeight;
    }

    // End/Close the entire chat session entirely
    function endUbsChatSession() {
        if (!confirm("আপনি কি চ্যাট সেশনটি বন্ধ করতে চান? এর ফলে পূর্ববর্তী বার্তাগুলো মুছে যাবে।")) return;

        const payload = {};
        if (ubsChatSessionUuid) {
            payload.session_uuid = ubsChatSessionUuid;
        }

        fetch(ubsChatConfig.closeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': ubsChatConfig.csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Terminate state completely
                stopUbsPolling();
                ubsChatSessionUuid = null;
                localStorage.removeItem('ubs_chat_uuid');
                ubsLastMsgId = 0;
                setUnreadCount(0);

                // Reset layout templates
                document.getElementById('ubs-messages-area').style.display = 'none';
                document.getElementById('ubs-messages-area').innerHTML = '';
                document.getElementById('ubs-chat-footer').style.display = 'none';
                document.getElementById('ubs-end-chat-btn').style.display = 'none';
                
                // Show guest form if not logged in
                if (!ubsChatConfig.isLoggedIn) {
                    document.getElementById('ubs-guest-form').style.display = 'block';
                    document.getElementById('ubs-guest-chat-form').reset();
                    const submitBtn = document.querySelector('#ubs-guest-chat-form button[type="submit"]');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'চ্যাট শুরু করুন';
                } else {
                    // Logged in user: resume brand new clean session
                    resumeUbsSession();
                }
            }
        })
        .catch(err => console.error("Error closing chat session:", err));
    }
</script>
</body>
</html>

