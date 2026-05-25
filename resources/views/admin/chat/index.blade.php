@php
    $layout = request()->routeIs('manager.*') ? 'manager.master' : (request()->routeIs('emplee.*') ? 'emplee.master' : 'admin.master');
    $contentSection = request()->routeIs('admin.*') ? 'main-content' : 'content';
    $showRoute = request()->routeIs('manager.*') ? 'manager.chat.show' : (request()->routeIs('emplee.*') ? 'emplee.chat.show' : 'admin.chat.show');
    $unreadRoute = request()->routeIs('manager.*') ? 'manager.chat.unread' : (request()->routeIs('emplee.*') ? 'emplee.chat.unread' : 'admin.chat.unread');
@endphp

@extends($layout)

@section($contentSection)
<div class="page-wrapper">

    {{-- ══ Header ══ --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-chat-dots-fill text-success me-2"></i>Live Chat Sessions
            </h4>
            <p class="text-muted small mb-0">Manage all incoming customer chat conversations</p>
        </div>
        <span class="badge bg-danger fs-6 px-3 py-2" id="globalUnreadBadge" style="display:none">
            <i class="bi bi-bell-fill me-1"></i><span id="globalUnreadNum">0</span> unread
        </span>
    </div>

    {{-- ══ Session Table ══ --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Last Active</th>
                            <th width="100" class="text-center">Unread</th>
                            <th width="120" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $session)
                        <tr class="{{ $session->unread_count > 0 ? 'table-warning' : '' }}">
                            <td class="text-muted small">{{ $session->id }}</td>

                            {{-- Customer name + avatar --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                         style="width:36px;height:36px;font-size:13px;
                                                background:{{ $session->user_id ? '#3b82f6' : '#64748b' }}">
                                        {{ strtoupper(substr($session->display_name ?? 'G', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold small">
                                            {{ $session->display_name ?? ($session->guest_name ?? 'Guest') }}
                                        </p>
                                        <small class="text-muted">Session #{{ $session->id }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="text-muted small">
                                {{ $session->user?->email ?? $session->guest_email ?? '—' }}
                            </td>

                            {{-- Type badge --}}
                            <td>
                                @if($session->user_id)
                                    <span class="badge bg-primary">Registered</span>
                                @else
                                    <span class="badge bg-secondary">Guest</span>
                                @endif
                            </td>

                            {{-- Status badge --}}
                            <td>
                                @php
                                    $statusColor = match($session->status) {
                                        'active'  => 'success',
                                        'pending' => 'warning',
                                        default   => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }}">
                                    {{ ucfirst($session->status) }}
                                </span>
                            </td>

                            {{-- Last activity --}}
                            <td class="text-muted small">
                                {{ $session->last_activity_at?->diffForHumans() ?? '—' }}
                            </td>

                            {{-- Unread count --}}
                            <td class="text-center">
                                @if($session->unread_count > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $session->unread_count }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Open button --}}
                            <td class="text-center">
                                <a href="{{ route($showRoute, $session->id) }}"
                                   class="btn btn-sm {{ $session->unread_count > 0 ? 'btn-danger' : 'btn-success' }}">
                                    <i class="bi bi-chat-fill me-1"></i>Open
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-chat-square-dots fs-1 d-block mb-2 opacity-25"></i>
                                No chat sessions yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($sessions->hasPages())
        <div class="card-footer bg-white">
            {{ $sessions->links() }}
        </div>
        @endif
    </div>

</div>

<script>
// ── Soft, premium synth chime for admin list page unread feedback ────────
function playAdminNotificationSound() {
    try {
        const AudioContextClass = window.AudioContext || window.webkitAudioContext;
        if (!AudioContextClass) return;
        const ctx = new AudioContextClass();
        if (ctx.state === 'suspended') {
            ctx.resume();
        }

        // Tone 1 (C5)
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

        // Tone 2 (E5, delayed)
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

        // Tone 3 (G5, delayed)
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
        console.warn("List page chime failed:", e);
    }
}

// ── Poll global unread count every 8 seconds ──
let previousUnreadCount = 0;
let isFirstUnreadCheck = true;

function refreshUnreadBadge() {
    fetch('{{ route($unreadRoute) }}')
        .then(r => r.json())
        .then(d => {
            const badge  = document.getElementById('globalUnreadBadge');
            const numEl  = document.getElementById('globalUnreadNum');
            
            // Check if unread count increased
            if (!isFirstUnreadCheck && d.count > previousUnreadCount) {
                playAdminNotificationSound();
            }
            isFirstUnreadCheck = false;
            previousUnreadCount = d.count;

            if (d.count > 0) {
                numEl.textContent  = d.count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(() => {});
}
refreshUnreadBadge();
setInterval(refreshUnreadBadge, 8000);
</script>
@endsection
