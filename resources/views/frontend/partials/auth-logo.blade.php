<div class="text-center mb-4">
    @if(!empty($gs->header_logo))
        <img src="{{ asset($gs->header_logo) }}" alt="{{ $gs->site_name ?? 'Pncbd' }}" class="auth-logo-img">
    @else
        <div class="logo-ring mx-auto">
            <span class="brand-code">{{ mb_substr($gs->site_name ?? 'P', 0, 1) }}</span>
            <span class="brand-sub">{{ $gs->site_name ?? 'Pncbd' }}</span>
        </div>
    @endif
</div>
