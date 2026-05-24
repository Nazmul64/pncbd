@php
    $faviconSetting = $websitefavicon ?? \App\Models\Websitefavicon::getSettings();
    $faviconUrl = $faviconSetting->favicon_logo ?? ($gs->header_logo ?? null);
@endphp
@if($faviconUrl)
    <link rel="icon" type="image/png" href="{{ asset($faviconUrl) }}">
@endif
