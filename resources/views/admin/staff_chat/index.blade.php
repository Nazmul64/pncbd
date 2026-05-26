@extends('admin.master')

@section('main-content')
<style>
.sc-sidebar {
    height: calc(100vh - 160px);
    overflow-y: auto;
    border-right: 1px solid #e5e7eb;
    scrollbar-width: thin;
}
.sc-staff-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
    text-decoration: none;
    color: inherit;
}
.sc-staff-item:hover { background: #f8fafc; }
.sc-staff-item.active { background: #eff6ff; border-left: 3px solid #3b82f6; }
.sc-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 15px; color: #fff; flex-shrink: 0;
}
.sc-unread-badge {
    margin-left: auto;
    background: #ef4444;
    color: #fff;
    border-radius: 999px;
    font-size: 11px;
    padding: 2px 7px;
    font-weight: 700;
}
.sc-staff-id {
    font-size: 10px;
    color: #94a3b8;
    letter-spacing: .3px;
}
.sc-empty-state {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; height: 100%;
    color: #94a3b8; text-align: center;
}
.sc-empty-state i { font-size: 64px; margin-bottom: 16px; opacity: .3; }
</style>

<div class="page-wrapper">
    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-person-lines-fill text-primary me-2"></i>Admin ↔ Staff Chat
            </h4>
            <p class="text-muted small mb-0">Admin থেকে সরাসরি Staff-কে message করুন। Staff নিজের chat ছাড়া অন্যটি দেখতে পাবে না।</p>
        </div>
        @if($totalUnread > 0)
        <span class="badge bg-danger fs-6 px-3 py-2">
            <i class="bi bi-bell-fill me-1"></i>{{ $totalUnread }} unread
        </span>
        @endif
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th>Staff ID</th>
                            <th>নাম</th>
                            <th>ভূমিকা</th>
                            <th>ফোন</th>
                            <th class="text-center" width="100">Unread</th>
                            <th class="text-center" width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffList as $i => $staff)
                        <tr class="{{ $staff->unread_admin > 0 ? 'table-warning' : '' }}">
                            <td class="text-muted small">{{ $i + 1 }}</td>

                            {{-- Staff ID (A-Z sorted, display as padded number) --}}
                            <td>
                                <code class="bg-light px-2 py-1 rounded text-primary fw-bold" style="font-size:12px">
                                    STF-{{ str_pad($staff->id, 4, '0', STR_PAD_LEFT) }}
                                </code>
                            </td>

                            {{-- Name + Avatar --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @php
                                        $colors = ['#3b82f6','#8b5cf6','#10b981','#f59e0b','#ef4444','#06b6d4'];
                                        $color  = $colors[$staff->id % count($colors)];
                                    @endphp
                                    <div class="sc-avatar" style="background:{{ $color }};width:36px;height:36px;font-size:13px">
                                        {{ strtoupper(substr($staff->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold small">{{ $staff->name }}</p>
                                        <small class="text-muted">{{ $staff->email }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- Role --}}
                            <td>
                                @foreach($staff->roles as $role)
                                <span class="badge bg-secondary me-1">{{ $role->name }}</span>
                                @endforeach
                            </td>

                            {{-- Phone --}}
                            <td class="text-muted small">{{ $staff->phone ?? '—' }}</td>

                            {{-- Unread --}}
                            <td class="text-center">
                                @if($staff->unread_admin > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $staff->unread_admin }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Open Chat --}}
                            <td class="text-center">
                                <a href="{{ route('admin.staff-chat.show', $staff->id) }}"
                                   class="btn btn-sm {{ $staff->unread_admin > 0 ? 'btn-danger' : 'btn-primary' }}">
                                    <i class="bi bi-chat-fill me-1"></i>Chat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                                কোনো staff member পাওয়া যায়নি।
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh unread badge in sidebar every 10s
setInterval(() => {
    fetch('{{ route('admin.staff-chat.unread') }}')
        .then(r => r.json())
        .then(d => {
            if (d.count > 0) location.reload();
        }).catch(() => {});
}, 10000);
</script>
@endsection
