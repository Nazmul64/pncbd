<div class="text-center mb-4">
    @if(!empty($gs->header_logo))
        <img src="{{ asset($gs->header_logo) }}" alt="{{ $gs->site_name ?? 'UBS' }}" class="auth-logo-img">
    @else
        <div class="logo-ring mx-auto">
            <span class="brand-code">{{ mb_substr($gs->site_name ?? 'U', 0, 1) }}</span>
            <span class="brand-sub">{{ $gs->site_name ?? 'UBS' }}</span>
        </div>
    @endif
</div>
