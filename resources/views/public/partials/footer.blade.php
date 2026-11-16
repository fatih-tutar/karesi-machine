@php
    $navHome = url('/') . '/';
@endphp
<footer class="idx2-foot" id="iletisim-alt">
    <div class="container">
        <div class="row align-items-start gy-4">
            <div class="col-lg-4 text-lg-start text-center">
                <img src="{{ asset('img/mavilogo-2.png') }}" alt="Karesi Makine" width="127" height="50" class="idx2-foot-logo mb-3" loading="lazy" decoding="async">
                <p class="small mb-0" style="color: var(--muted);">Endüstriyel simit ve unlu mamul ekipmanları.</p>
            </div>
            <div class="col-lg-8 text-lg-end text-center">
                <div class="idx2-follow-title mb-3">Bizi sosyal medyada takip edin</div>
                <div class="d-flex flex-wrap justify-content-lg-end justify-content-center gap-3 align-items-center">
                    <a href="https://www.facebook.com/karesimakina" target="_blank" rel="noopener noreferrer"><img src="{{ asset('img/social/facebookicon.png') }}" alt="Facebook" width="32" height="32" loading="lazy" decoding="async"></a>
                    <a href="https://www.instagram.com/karesimakine" target="_blank" rel="noopener noreferrer"><img src="{{ asset('img/social/instagramicon.png') }}" alt="Instagram" width="32" height="32" loading="lazy" decoding="async"></a>
                    <a href="https://www.youtube.com/@karesimakina" target="_blank" rel="noopener noreferrer"><img src="{{ asset('img/social/youtubeicon.png') }}" alt="YouTube" width="32" height="32" loading="lazy" decoding="async"></a>
                    <a href="https://wa.me/905315426368" target="_blank" rel="noopener noreferrer"><img src="{{ asset('img/social/whatsappicon.png') }}" alt="WhatsApp" width="32" height="32" loading="lazy" decoding="async"></a>
                </div>
            </div>
        </div>
        <hr class="my-4 border-secondary opacity-50">
        <div class="small text-center" style="color: var(--muted);">
            <a href="{{ $navHome }}">Ana sayfa</a>
            <span class="mx-2">·</span>
            <a href="{{ url('/deneme') }}">Deneme</a>
            <span class="mx-2">·</span>
            <a href="{{ url('/referanslar') }}">Referanslar</a>
            <span class="mx-2">·</span>
            <a href="{{ url('/iletisim') }}">İletişim</a>
            <span class="mx-2">·</span>
            <span>&copy; {{ date('Y') }} Karesi Makine</span>
        </div>
    </div>
</footer>
