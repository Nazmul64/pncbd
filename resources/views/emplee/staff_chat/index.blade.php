@extends('emplee.master')

@section('content')
<style>
/* ── Chat Layout ── */
.sc-chat-page   { display:flex; flex-direction:column; height:calc(100vh - 140px); background:#fff; border-radius:12px; box-shadow:0 1px 8px rgba(0,0,0,.08); overflow:hidden; }
.sc-chat-header { padding:16px 20px; background:linear-gradient(135deg,#1e3a5f,#2563eb); color:#fff; display:flex; align-items:center; gap:12px; flex-shrink:0; }
.sc-avatar      { width:44px; height:44px; border-radius:50%; background:rgba(255,255,255,.25); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:18px; }
.sc-messages    { flex:1; overflow-y:auto; padding:20px; display:flex; flex-direction:column; gap:10px; background:#f8fafc; scrollbar-width:thin; }
.sc-input-bar   { padding:14px 18px; background:#fff; border-top:1px solid #e5e7eb; display:flex; gap:10px; flex-shrink:0; }

/* ── Bubbles ── */
.sc-bubble-wrap      { display:flex; align-items:flex-end; gap:8px; }
.sc-bubble-wrap.own  { flex-direction:row-reverse; }
.sc-bubble {
    max-width: 70%;
    padding: 10px 14px;
    border-radius: 18px;
    font-size: 14px;
    line-height: 1.55;
    word-break: break-word;
}
.sc-bubble.other { background:#fff; border:1px solid #e2e8f0; border-bottom-left-radius:4px; color:#1e293b; }
.sc-bubble.own   { background:#2563eb; color:#fff; border-bottom-right-radius:4px; }
.sc-bubble-meta  { font-size:11px; color:#94a3b8; margin-top:3px; }
.sc-bubble-wrap.own .sc-bubble-meta { text-align:right; }
.sc-mini-av { width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:#fff; flex-shrink:0; }

/* ── Input ── */
.sc-input-bar textarea {
    flex:1; border:1px solid #e2e8f0; border-radius:12px;
    padding:10px 14px; font-size:14px; resize:none; outline:none;
    transition:border-color .2s; max-height:120px; line-height:1.5;
}
.sc-input-bar textarea:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.sc-send-btn {
    background:#2563eb; color:#fff; border:none; border-radius:12px;
    padding:0 18px; font-size:20px; cursor:pointer; transition:background .15s;
    display:flex; align-items:center; justify-content:center;
}
.sc-send-btn:hover { background:#1d4ed8; }

/* ── Unread dot in sidebar (injected via JS) ── */
#staffChatSidebarBadge { display:none; }
</style>

<div class="page-content">
    <div class="container-fluid">

        {{-- Page Title --}}
        <div class="row mb-3">
            <div class="col">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-chat-heart-fill text-primary me-2"></i>Admin Chat
                </h5>
                <p class="text-muted small mb-0">শুধুমাত্র আপনার এবং Admin-এর মধ্যে private conversation।</p>
            </div>
            <div class="col-auto">
                <span class="badge bg-info text-dark">
                    STF-{{ str_pad(auth()->id(), 4, '0', STR_PAD_LEFT) }}
                </span>
            </div>
        </div>

        {{-- Chat Box --}}
        <div class="sc-chat-page">

            {{-- Header --}}
            <div class="sc-chat-header">
                <div class="sc-avatar">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Admin / Support</h6>
                    <small style="opacity:.8">আপনার পক্ষ থেকে শুধু আপনিই দেখতে পাচ্ছেন</small>
                </div>
                <div class="ms-auto d-flex align-items-center gap-2">
                    <span class="badge bg-success bg-opacity-25 text-success" style="font-size:12px">
                        <i class="bi bi-circle-fill me-1" style="font-size:8px"></i>Active
                    </span>
                </div>
            </div>

            {{-- Messages --}}
            <div class="sc-messages" id="scMessages">
                @forelse($messages as $msg)
                @php $isOwn = $msg->sender_type === 'staff'; @endphp
                <div class="sc-bubble-wrap {{ $isOwn ? 'own' : '' }}" data-msg-id="{{ $msg->id }}">
                    @if(!$isOwn)
                    <div class="sc-mini-av" style="background:#2563eb">
                        <i class="bi bi-shield-fill-check" style="font-size:11px"></i>
                    </div>
                    @endif
                    <div>
                        <div class="sc-bubble {{ $isOwn ? 'own' : 'other' }}">{{ $msg->message }}</div>
                        <div class="sc-bubble-meta">
                            {{ $msg->sender_type === 'admin' ? 'Admin' : 'আপনি' }}
                            · {{ $msg->created_at->format('g:i A') }}
                        </div>
                    </div>
                    @if($isOwn)
                    <div class="sc-mini-av" style="background:#10b981">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center text-muted m-auto">
                    <i class="bi bi-chat-square-heart-fill" style="font-size:56px;opacity:.15"></i>
                    <p class="mt-3 small">Admin আপনাকে message করলে এখানে দেখতে পাবেন।<br>আপনিও message পাঠাতে পারেন।</p>
                </div>
                @endforelse
            </div>

            {{-- Input --}}
            <div class="sc-input-bar">
                <textarea id="scInput" rows="1" placeholder="Admin-কে message লিখুন…" onkeydown="handleEnter(event)"></textarea>
                <button class="sc-send-btn" onclick="sendMsg()">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>

    </div>
</div>

<script>
const REPLY_URL    = @json(route('admin.emplee.staff-chat.reply'));
const MESSAGES_URL = @json(route('admin.emplee.staff-chat.messages'));
const MY_INITIAL   = @json(strtoupper(substr(auth()->user()->name, 0, 1)));

let lastId = @json($messages->last()?->id ?? 0);

function scrollBottom() {
    const box = document.getElementById('scMessages');
    box.scrollTop = box.scrollHeight;
}
scrollBottom();

function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
}

// ── Notification Sound (Web Audio API) ──────────────────────────────────────
function playNotifSound() {
    try {
        const Ctx = window.AudioContext || window.webkitAudioContext;
        if (!Ctx) return;
        const ctx = new Ctx();
        if (ctx.state === 'suspended') ctx.resume();

        const notes = [
            { freq: 880.00,  start: 0.00, dur: 0.18, gain: 0.10 }, // A5
            { freq: 1108.73, start: 0.12, dur: 0.22, gain: 0.08 }, // C#6
            { freq: 1318.51, start: 0.24, dur: 0.30, gain: 0.06 }, // E6
        ];

        notes.forEach(n => {
            const osc  = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type  = 'sine';
            osc.frequency.setValueAtTime(n.freq, ctx.currentTime + n.start);
            gain.gain.setValueAtTime(n.gain, ctx.currentTime + n.start);
            gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + n.start + n.dur);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start(ctx.currentTime + n.start);
            osc.stop(ctx.currentTime + n.start + n.dur + 0.05);
        });
    } catch(e) { /* silent fail */ }
}

function appendBubble(msg) {
    const box   = document.getElementById('scMessages');
    const empty = box.querySelector('.text-center.text-muted');
    if (empty) empty.remove();

    const wrap = document.createElement('div');
    wrap.className = `sc-bubble-wrap ${msg.is_own ? 'own' : ''}`;
    wrap.dataset.msgId = msg.id;

    const adminAv = `<div class="sc-mini-av" style="background:#2563eb"><i class="bi bi-shield-fill-check" style="font-size:11px"></i></div>`;
    const staffAv = `<div class="sc-mini-av" style="background:#10b981">${MY_INITIAL}</div>`;
    const label   = msg.sender_type === 'admin' ? 'Admin' : 'আপনি';

    wrap.innerHTML = `
        ${!msg.is_own ? adminAv : ''}
        <div>
            <div class="sc-bubble ${msg.is_own ? 'own' : 'other'}">${escHtml(msg.message)}</div>
            <div class="sc-bubble-meta">${label} · ${msg.time}</div>
        </div>
        ${msg.is_own ? staffAv : ''}
    `;
    box.appendChild(wrap);
    scrollBottom();
    if (msg.id > lastId) lastId = msg.id;
}

function sendMsg() {
    const input = document.getElementById('scInput');
    const text  = input.value.trim();
    if (!text) return;
    input.value = '';
    input.style.height = '';

    fetch(REPLY_URL, {
        method : 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body   : JSON.stringify({ message: text }),
    })
    .then(r => r.json())
    .then(d => { if (d.success) appendBubble(d.message); })
    .catch(console.error);
}

function handleEnter(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMsg(); }
}

document.getElementById('scInput').addEventListener('input', function () {
    this.style.height = '';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// Poll every 5s for new admin messages
let isFirstPoll = true;
function pollMessages() {
    fetch(`${MESSAGES_URL}?after_id=${lastId}`)
        .then(r => r.json())
        .then(d => {
            if (d.success && d.messages.length) {
                let hasIncoming = false;
                d.messages.forEach(m => {
                    if (!document.querySelector(`[data-msg-id="${m.id}"]`)) {
                        appendBubble(m);
                        // Play sound only when admin sends (not own messages)
                        if (!m.is_own) hasIncoming = true;
                    }
                });
                if (hasIncoming && !isFirstPoll) playNotifSound();
            }
            isFirstPoll = false;
        }).catch(() => {});
}
setInterval(pollMessages, 5000);
</script>
@endsection
