@extends('admin.master')

@section('main-content')
<style>
/* ══ Wrapper ══ */
.sc-wrapper {
    display: flex;
    height: calc(100vh - 110px);
    min-height: 400px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.08);
}

/* ══ Left Sidebar ══ */
.sc-sidebar {
    width: 260px;
    flex-shrink: 0;
    border-right: 1px solid #e5e7eb;
    overflow-y: auto;
    overflow-x: hidden;
    background: #fff;
    scrollbar-width: thin;
    display: flex;
    flex-direction: column;
    transition: transform .28s cubic-bezier(.4,0,.2,1);
}

/* ══ Right Chat Area ══ */
.sc-main {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    background: #f8fafc;
    overflow: hidden;
}

/* ══ Sidebar Items ══ */
.sc-item {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 14px; cursor: pointer;
    border-bottom: 1px solid #f1f5f9;
    text-decoration: none; color: inherit;
    transition: background .15s; min-width: 0;
}
.sc-item:hover  { background: #f8fafc; }
.sc-item.active { background: #eff6ff; border-left: 3px solid #3b82f6; }
.sc-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 13px; color: #fff; flex-shrink: 0;
}
.sc-badge {
    margin-left: auto; flex-shrink: 0;
    background: #ef4444; color: #fff;
    border-radius: 999px; font-size: 11px; padding: 2px 7px; font-weight: 700;
}

/* ══ Chat Header ══ */
.sc-chat-header {
    padding: 12px 16px; background: #fff;
    border-bottom: 1px solid #e5e7eb;
    display: flex; align-items: center; gap: 10px;
    flex-shrink: 0; min-width: 0;
}

/* ══ Messages Area ══ */
.sc-messages {
    flex: 1; min-height: 0;
    overflow-y: auto; overflow-x: hidden;
    padding: 16px;
    display: flex; flex-direction: column; gap: 10px;
    scrollbar-width: thin;
}

/* ══ Input Bar ══ */
.sc-input-bar {
    padding: 12px 16px; background: #fff;
    border-top: 1px solid #e5e7eb;
    display: flex; align-items: flex-end; gap: 10px; flex-shrink: 0;
}
.sc-input-bar textarea {
    flex: 1; min-width: 0;
    border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 10px 14px; font-size: 14px; resize: none; outline: none;
    max-height: 120px; line-height: 1.5;
    transition: border-color .2s; font-family: inherit;
}
.sc-input-bar textarea:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.12); }
.sc-send-btn {
    flex-shrink: 0; width: 44px; height: 44px;
    background: #3b82f6; color: #fff; border: none;
    border-radius: 12px; font-size: 18px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, transform .1s;
}
.sc-send-btn:hover  { background: #2563eb; }
.sc-send-btn:active { transform: scale(.95); }

/* ══ Chat Bubbles ══ */
.sc-bubble-wrap { display:flex; align-items:flex-end; gap:8px; max-width:100%; min-width:0; }
.sc-bubble-wrap.own { flex-direction: row-reverse; }
.sc-bubble {
    max-width: clamp(160px, 70%, 480px);
    padding: 10px 14px; border-radius: 18px;
    font-size: 14px; line-height: 1.55;
    word-break: break-word; word-wrap: break-word;
    overflow-wrap: break-word; white-space: pre-wrap;
}
.sc-bubble.other { background:#fff; border:1px solid #e5e7eb; border-bottom-left-radius:4px; color:#1e293b; }
.sc-bubble.own   { background:#3b82f6; color:#fff; border-bottom-right-radius:4px; }
.sc-bubble-meta  { font-size:11px; color:#94a3b8; margin-top:3px; }
.sc-bubble-wrap.own .sc-bubble-meta { text-align:right; }
.sc-tiny-avatar  {
    width:28px; height:28px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:11px; font-weight:700; color:#fff; flex-shrink:0;
}

/* ══ Staff ID chip ══ */
.staff-id-chip { font-size:11px; background:#eff6ff; color:#3b82f6; border-radius:6px; padding:2px 8px; font-weight:600; letter-spacing:.3px; flex-shrink:0; }

/* ══ Mobile sidebar toggle ══ */
.sc-sidebar-toggle {
    display: none; flex-shrink: 0;
    background: #eff6ff; color: #3b82f6; border: 1px solid #bfdbfe;
    border-radius: 8px; padding: 5px 10px; font-size: 16px; cursor: pointer;
    align-items: center; gap: 4px;
}
.sc-sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.4); z-index: 1049;
}

/* ══ Responsive ══ */
@media (max-width: 900px) {
    .sc-sidebar { width: 220px; }
    .sc-bubble   { max-width: clamp(140px, 75%, 360px); }
}

@media (max-width: 640px) {
    .sc-wrapper { height: calc(100vh - 80px); border-radius: 0; }

    /* Sidebar slides in from left on mobile */
    .sc-sidebar {
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 1050;
        width: 80vw; max-width: 300px;
        transform: translateX(-100%);
        box-shadow: 4px 0 24px rgba(0,0,0,.18);
    }
    .sc-sidebar.mob-open { transform: translateX(0); }
    .sc-sidebar.mob-open ~ .sc-sidebar-overlay { display: block; }

    .sc-sidebar-toggle { display: flex; }

    .sc-bubble { max-width: 88%; font-size: 13px; padding: 8px 12px; }
    .sc-messages { padding: 10px; gap: 8px; }
    .sc-chat-header { padding: 10px 12px; gap: 8px; }
    .sc-input-bar   { padding: 8px 10px; }
    .sc-tiny-avatar { width: 24px; height: 24px; font-size: 10px; }
}
</style>

</style>

<div class="sc-wrapper rounded-3 shadow-sm overflow-hidden">

    {{-- ══ Left Sidebar — Staff List A-Z ══ --}}
    <div class="sc-sidebar">
        <div class="p-3 border-bottom">
            <p class="fw-bold mb-0 small text-uppercase text-muted" style="letter-spacing:.5px">
                <i class="bi bi-people-fill me-1"></i>Staff Members
            </p>
        </div>
        @forelse($staffList as $staff)
        @php
            $colors = ['#3b82f6','#8b5cf6','#10b981','#f59e0b','#ef4444','#06b6d4'];
            $color  = $colors[$staff->id % count($colors)];
        @endphp
        <a href="{{ route('admin.staff-chat.show', $staff->id) }}"
           class="sc-item {{ $staff->id == $staffUser->id ? 'active' : '' }}">
            <div class="sc-avatar" style="background:{{ $color }}">
                {{ strtoupper(substr($staff->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0" style="flex:1;min-width:0">
                <p class="mb-0 fw-semibold small text-truncate">{{ $staff->name }}</p>
                <span class="staff-id-chip">STF-{{ str_pad($staff->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
            @if($staff->unread_admin > 0)
            <span class="sc-badge">{{ $staff->unread_admin }}</span>
            @endif
        </a>
        @empty
        <p class="text-muted small p-3 mb-0">কোনো staff নেই।</p>
        @endforelse
    </div>

    {{-- ══ Right — Chat Window ══ --}}
    <div class="sc-main">

        {{-- Chat Header --}}
        <div class="sc-chat-header">
            @php
                $colors2 = ['#3b82f6','#8b5cf6','#10b981','#f59e0b','#ef4444','#06b6d4'];
                $hColor  = $colors2[$staffUser->id % count($colors2)];
            @endphp
            <div class="sc-avatar" style="background:{{ $hColor }};width:44px;height:44px;font-size:16px">
                {{ strtoupper(substr($staffUser->name, 0, 1)) }}
            </div>
            <div>
                <h6 class="mb-0 fw-bold">{{ $staffUser->name }}</h6>
                <div class="d-flex align-items-center gap-2 mt-1">
                    <span class="staff-id-chip">STF-{{ str_pad($staffUser->id, 4, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-muted small">{{ $staffUser->phone }}</span>
                </div>
            </div>
            <a href="{{ route('admin.staff-chat.index') }}" class="ms-auto btn btn-sm btn-light">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>

        {{-- Messages --}}
        <div class="sc-messages" id="scMessages">
            @forelse($messages as $msg)
            @php $isOwn = $msg->sender_type === 'admin'; @endphp
            <div class="sc-bubble-wrap {{ $isOwn ? 'own' : '' }}" data-msg-id="{{ $msg->id }}">
                @if(!$isOwn)
                <div class="sc-tiny-avatar" style="background:{{ $hColor }}">
                    {{ strtoupper(substr($staffUser->name, 0, 1)) }}
                </div>
                @endif
                <div>
                    <div class="sc-bubble {{ $isOwn ? 'own' : 'other' }}">{{ $msg->message }}</div>
                    <div class="sc-bubble-meta">{{ $msg->created_at->format('g:i A') }}</div>
                </div>
                @if($isOwn)
                <div class="sc-tiny-avatar" style="background:#3b82f6">A</div>
                @endif
            </div>
            @empty
            <div class="text-center text-muted mt-auto mb-auto">
                <i class="bi bi-chat-square-dots-fill" style="font-size:48px;opacity:.15"></i>
                <p class="mt-2 small">কথোপকথন শুরু করুন। Staff শুধু নিজের chat দেখতে পাবে।</p>
            </div>
            @endforelse
        </div>

        {{-- Input Bar --}}
        <div class="sc-input-bar">
            <textarea id="scInput" rows="1" placeholder="Staff-কে message লিখুন…" onkeydown="handleEnter(event)"></textarea>
            <button class="sc-send-btn" onclick="sendMsg()">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>
</div>

<script>
const REPLY_URL     = @json(route('admin.staff-chat.reply',    $staffUser->id));
const MESSAGES_URL  = @json(route('admin.staff-chat.messages', $staffUser->id));
const STAFF_COLOR   = @json($hColor);
const STAFF_INITIAL = @json(strtoupper(substr($staffUser->name, 0, 1)));

let lastId = @json($messages->last()?->id ?? 0);

// ── Scroll to bottom ──────────────────────────────────────────────────────────
function scrollBottom() {
    const box = document.getElementById('scMessages');
    box.scrollTop = box.scrollHeight;
}
scrollBottom();

// ── Append bubble ─────────────────────────────────────────────────────────────
function appendBubble(msg) {
    const box  = document.getElementById('scMessages');

    // Remove empty state if present
    const empty = box.querySelector('.text-center.text-muted');
    if (empty) empty.remove();

    const wrap = document.createElement('div');
    wrap.className = `sc-bubble-wrap ${msg.is_own ? 'own' : ''}`;
    wrap.dataset.msgId = msg.id;

    const avatarHtml = msg.is_own
        ? `<div class="sc-tiny-avatar" style="background:#3b82f6">A</div>`
        : `<div class="sc-tiny-avatar" style="background:${STAFF_COLOR}">${STAFF_INITIAL}</div>`;

    wrap.innerHTML = `
        ${!msg.is_own ? avatarHtml : ''}
        <div>
            <div class="sc-bubble ${msg.is_own ? 'own' : 'other'}">${escHtml(msg.message)}</div>
            <div class="sc-bubble-meta">${msg.time}</div>
        </div>
        ${msg.is_own ? avatarHtml : ''}
    `;
    box.appendChild(wrap);
    scrollBottom();
    if (msg.id > lastId) lastId = msg.id;
}

function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
}

// ── Notification Sound (Web Audio API) ───────────────────────────────────────
function playNotifSound() {
    try {
        const Ctx = window.AudioContext || window.webkitAudioContext;
        if (!Ctx) return;
        const ctx = new Ctx();
        if (ctx.state === 'suspended') ctx.resume();

        const notes = [
            { freq: 880.00, start: 0.00, dur: 0.18, gain: 0.10 }, // A5
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

// ── Send message ──────────────────────────────────────────────────────────────
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

// ── Auto-resize textarea ──────────────────────────────────────────────────────
document.getElementById('scInput').addEventListener('input', function () {
    this.style.height = '';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// ── Poll for new messages every 5s ───────────────────────────────────────────
let isFirstPoll = true;
function pollMessages() {
    fetch(`${MESSAGES_URL}?after_id=${lastId}`)
        .then(r => r.json())
        .then(d => {
            if (d.success && d.messages.length) {
                let hasIncoming = false;
                d.messages.forEach(m => {
                    const exists = document.querySelector(`[data-msg-id="${m.id}"]`);
                    if (!exists) {
                        appendBubble(m);
                        // Play sound only for incoming (staff) messages, not own
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
