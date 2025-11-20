@if(!\Illuminate\Support\Facades\Cookie::has(config('police.cookie_name')))
    @php
        $linkConfig = config('police.link');
        $linkUrl = is_array($linkConfig) && isset($linkConfig['route'])
            ? route($linkConfig['route'], $linkConfig['params'] ?? [])
            : $linkConfig;
    @endphp

    <div id="cookieBanner" style="position:fixed;bottom:20px;left:50%;transform:translateX(-50%);z-index:9999;max-width:800px;padding:15px;background:{{ config('police.banner_bg') }};color:{{ config('police.text_color') }};border-top:3px solid {{ config('police.border_color') }};border-radius:8px;display:flex;align-items:center;">
        <div style="flex:1;margin-right:10px;font-size:14px;">
            {!! config('police.text') !!}
            <a href="{{ $linkUrl }}" target="_blank">{{ config('police.link_text') }}</a>.
        </div>
        <button id="acceptCookies" style="background:{{ config('police.button_bg') }};color:#fff;border:none;padding:5px 10px;border-radius:5px;">{{ config('police.button_text') }}</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let banner = document.getElementById('cookieBanner');
            let btn = document.getElementById('acceptCookies');
            btn.addEventListener('click', function() {
                fetch('{{ url("/accept-cookies") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(res => {
                    if(res.ok) {
                        banner.style.transition = "opacity 0.5s";
                        banner.style.opacity = 0;
                        setTimeout(()=>banner.style.display='none',500);
                    }
                });
            });
        });
    </script>
@endif
