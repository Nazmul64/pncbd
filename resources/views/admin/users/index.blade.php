@extends('admin.master')

@section('main-content')
<style>
    .usr-page { padding: 30px 24px; background: #f4f7fb; min-height: 100vh; }
    .usr-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .usr-header-left h2 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }
    .usr-header-left p { margin: 4px 0 0; font-size: 14px; color: #64748b; }
    .usr-btn-primary { background: linear-gradient(135deg, #10b981, #059669); color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); transition: all 0.2s; border: none; }
    .usr-btn-primary:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3); }
    
    .usr-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 20px rgba(0,0,0,0.04); overflow: hidden; margin-bottom: 20px; }
    .usr-table-wrapper { overflow-x: auto; }
    .usr-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .usr-table th { background: #f8fafc; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
    .usr-table td { padding: 16px 20px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .usr-table tr:last-child td { border-bottom: none; }
    .usr-table tr:hover td { background: #f8fafc; }
    
    .usr-profile { display: flex; align-items: center; gap: 12px; }
    .usr-avatar { width: 40px; height: 40px; border-radius: 10px; object-fit: cover; background: #e2e8f0; }
    .usr-info h6 { margin: 0; font-size: 14px; font-weight: 600; color: #1e293b; }
    .usr-info p { margin: 2px 0 0; font-size: 12px; color: #64748b; }
    
    .usr-role-tag { display: inline-block; padding: 4px 10px; background: #f1f5f9; color: #475569; border-radius: 6px; font-size: 12px; font-weight: 600; margin: 2px; }
    .usr-role-admin { background: #eff6ff; color: #2563eb; }
    .usr-role-super { background: #faf5ff; color: #7c3aed; }
    
    .usr-status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; }
    .status-active { background: #ecfdf5; color: #059669; }
    .status-suspended { background: #fef2f2; color: #ef4444; }
    .status-inactive { background: #f8fafc; color: #64748b; }
    .status-pending { background: #fffbeb; color: #d97706; }

    .usr-actions { display: flex; gap: 8px; }
    .usr-btn-icon { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; transition: all 0.2s; border: none; cursor: pointer; text-decoration: none; }
    .usr-btn-edit { background: #ecfdf5; color: #059669; }
    .usr-btn-edit:hover { background: #059669; color: #fff; }
    .usr-btn-delete { background: #fef2f2; color: #ef4444; }
    .usr-btn-delete:hover { background: #ef4444; color: #fff; }
    .usr-btn-toggle { background: #f1f5f9; color: #475569; }
    .usr-btn-toggle:hover { background: #475569; color: #fff; }
    
    .pagination-wrapper { padding: 20px; display: flex; justify-content: center; background: #fff; border-top: 1px solid #f1f5f9; }
</style>
    <style>
    .offcanvas-custom { background: linear-gradient(135deg, #f0f4ff, #e0eaff); color: #1e293b; }
    .offcanvas-header { border-bottom: 1px solid rgba(0,0,0,.1); }
    .offcanvas-body { font-family: 'Inter', sans-serif; }
    </style>

<div class="usr-page">
    <div class="usr-header">
        <div class="usr-header-left">
            <h2>All Administrators & Staff</h2>
            <p>সিস্টেমের সকল অ্যাডমিন, ম্যানেজার ও স্টাফ মেম্বারদের তালিকা</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="usr-btn-primary">
            <i class="bi bi-person-plus-fill"></i> অ্যাডমিন / স্টাফ যুক্ত করুন
        </a>
    </div>
    <div class="usr-page-content" style="display:flex; gap:24px; flex-wrap:wrap;">
        <div class="logo-box-left" style="flex:0 0 200px; background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.05); padding:16px; text-align:center; display:flex; flex-direction:column; justify-content:center;">
            @if(!empty($gs->header_logo))
                <img src="{{ asset('storage/' . $gs->header_logo) }}" alt="Site Logo" style="max-width:100%; height:auto; margin-bottom:8px;">
            @else
                <div style="font-size:48px; font-weight:700; color:#333;">{{ strtoupper(substr($gs->site_name ?? 'PNCBD',0,2)) }}</div>
            @endif
            <div style="margin-top:8px; font-size:14px; color:#555;">{{ $gs->site_name ?? 'PNCBD' }}</div>
        </div>
        <div class="usr-content" style="flex:1; min-width:0;">


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px; margin-bottom: 24px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:12px; margin-bottom: 24px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="usr-card">
        <div class="usr-table-wrapper">
            <table class="usr-table">
                <thead>
                    <tr>
                        <th>নাম ও ইমেইল</th>
                        <th>ফোন নম্বর</th>
                        <th>ভূমিকা (Roles)</th>
                        <th>স্ট্যাটাস</th>
                        <th>যোগদানের তারিখ</th>
                        <th style="text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="usr-profile">
                                <img src="{{ $user->photo_url }}" alt="Avatar" class="usr-avatar">
                                <div class="usr-info">
                                    <h6>{{ $user->name }}</h6>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="fw-semibold text-secondary">
                            {{ $user->phone ?? 'N/A' }}
                        </td>
                        <td>
                            @forelse($user->roles as $role)
                                <span class="usr-role-tag {{ $role->slug === 'super-admin' ? 'usr-role-super' : ($role->slug === 'admin' ? 'usr-role-admin' : '') }}">
                                    <i class="bi bi-shield-check"></i> {{ $role->name }}
                                </span>
                            @empty
                                <span class="usr-role-tag" style="background:#f1f5f9; color:#64748b;">
                                    <i class="bi bi-shield-x"></i> ভূমিকা নেই
                                </span>
                            @endforelse
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="usr-status-badge status-active">
                                    <i class="bi bi-patch-check-fill"></i> Active
                                </span>
                            @elseif($user->status === 'suspended')
                                <span class="usr-status-badge status-suspended">
                                    <i class="bi bi-slash-circle-fill"></i> Suspended
                                </span>
                            @elseif($user->status === 'inactive')
                                <span class="usr-status-badge status-inactive">
                                    <i class="bi bi-x-circle-fill"></i> Inactive
                                </span>
                            @else
                                <span class="usr-status-badge status-pending">
                                    <i class="bi bi-hourglass-split"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="text-muted">
                            {{ $user->created_at->format('d M, Y') }}
                        </td>
                        <td style="text-align: right;">
                            <div class="usr-actions" style="justify-content: flex-end;">
                                {{-- Block/Unblock toggle --}}
                                @if(auth()->id() !== $user->id && !$user->isSuperAdmin())
                                <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="usr-btn-icon usr-btn-toggle" title="{{ $user->status === 'active' ? 'Block User' : 'Activate User' }}">
                                        <i class="bi {{ $user->status === 'active' ? 'bi-shield-slash' : 'bi-shield-fill-check' }}"></i>
                                    </button>
                                </form>
                                @endif

                                {{-- Edit Details --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="usr-btn-icon usr-btn-edit" title="Edit Admin">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- Delete --}}
                                @if(auth()->id() !== $user->id && !$user->isSuperAdmin())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('এই অ্যাডমিন/স্টাফ মেম্বারকে চিরতরে ডিলিট করতে চান?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="usr-btn-icon usr-btn-delete" title="Delete Admin">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif

                                {{-- Contract (চুক্তিপত্র) --}}
                                <button type="button" class="usr-btn-icon usr-btn-contract" data-bs-toggle="offcanvas" data-bs-target="#offcanvasContract{{ $user->id }}" title="চুক্তিপত্র">
                                    <i class="bi bi-file-earmark-text"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="bi bi-people" style="font-size: 32px; display: block; margin-bottom: 12px;"></i>
                            কোনো ইউজার পাওয়া যায়নি
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    {{-- Contract Modals for each user --}}
    @foreach($users as $user)
    <div class="offcanvas offcanvas-end offcanvas-custom" tabindex="-1" id="offcanvasContract{{ $user->id }}" aria-labelledby="offcanvasContractLabel{{ $user->id }}">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasContractLabel{{ $user->id }}">চুক্তিপত্র - {{ $user->name }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body" style="font-family: 'Inter', sans-serif; line-height:1.6;">
        <p>তারিখ: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p>প্রতি,</p>
        <p><strong>{{ $user->name }}</strong></p>
        <p>পদবী: {{ $user->roles->first()->name ?? 'স্টাফ' }}</p>
        <p>বিষয়: চাকরির চুক্তিপত্র</p>
        <p>প্রিয় {{ $user->name }},</p>
        <p>আমরা আনন্দের সঙ্গে জানাচ্ছি যে আপনি আমাদের প্রতিষ্ঠানে <strong>{{ $user->roles->first()->name ?? 'স্টাফ' }}</strong> পদে নিয়োগ পেয়েছেন। আপনার যোগ্যতা, অভিজ্ঞতা এবং অবদানকে আমরা মূল্যায়ন করি এবং আপনার সাথে দীর্ঘমেয়াদী সহযোগিতা কামনা করছি।</p>
        <p>নিয়োগের শর্তাবলী:</p>
        <ul>
          <li>শুরু তারিখ: {{ \Carbon\Carbon::now()->addDays(7)->format('d/m/Y') }}</li>
          <li>বেতন: TBD</li>
          <li>কাজের সময়: পূর্ণকালীন</li>
        </ul>
        <p>অনুগ্রহ করে এই চুক্তি স্বাক্ষর করে আমাদের জানান।</p>
        <p>ধন্যবাদ,<br/>প্রশাসন দল<br/>{{ $gs->site_name ?? 'PNCBD' }}</p>
        <div class="mt-3 d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">বন্ধ করুন</button>
          <button type="button" class="btn btn-primary">প্রিন্ট/ডাউনলোড</button>
        </div>
      </div>
    </div>
    @endforeach
        
        @if($users->hasPages())
        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
        @endif
    </div>
    </div>
    </div>
</div>
@endsection
