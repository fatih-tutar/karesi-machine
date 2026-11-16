@php
    $navActive = isset($navActive) ? (string) $navActive : '';
    $navHome = url('/') . '/';
    $navIsHome = ($navActive === 'home');
@endphp
<nav class="navbar navbar-light navbar-expand-md idx2-nav fixed-top">
    <div class="container-fluid px-3">
        <div class="idx2-nav-shell w-100 d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-2">
        <a class="navbar-brand py-0 idx2-nav-brand me-md-3" href="{{ $navHome }}">
            <img src="{{ asset('img/mavilogo-2.png') }}" alt="Karesi Makine" width="127" height="50" class="d-block" decoding="async">
        </a>
        <button class="navbar-toggler border-0 ms-auto d-md-none" type="button" aria-controls="idx2Nav" aria-expanded="false" aria-label="Menü">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-md-end mt-2 mt-md-0" id="idx2Nav">
            <ul class="navbar-nav gap-md-3 align-items-md-center mt-1 mt-md-0">
                <li class="nav-item idx2-nav-item">
                    <a class="nav-link idx2-nav-link{{ $navActive === 'urun' ? ' is-active' : '' }}" href="{{ $navIsHome ? '#urun' : $navHome . '#urun' }}"><i class="bi bi-box-seam"></i><span>Ürünler</span></a>
                </li>
                <li class="nav-item idx2-nav-item">
                    <a class="nav-link idx2-nav-link{{ $navActive === 'deneme' ? ' is-active' : '' }}" href="{{ url('/deneme') }}"><i class="bi bi-gear"></i><span>Deneme</span></a>
                </li>
                <li class="nav-item idx2-nav-item">
                    <a class="nav-link idx2-nav-link{{ $navActive === 'referanslar' ? ' is-active' : '' }}" href="{{ url('/referanslar') }}"><i class="bi bi-star"></i><span>Referanslar</span></a>
                </li>
                <li class="nav-item idx2-nav-item">
                    <a class="nav-link idx2-nav-link{{ $navActive === 'iletisim' ? ' is-active' : '' }}" href="{{ url('/iletisim') }}"><i class="bi bi-telephone"></i><span>İletişim</span></a>
                </li>
                <li class="nav-item ms-md-2">
                    <a class="btn idx2-cta-wa idx2-nav-wa px-3" href="https://wa.me/905315426368" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-1"></i>WhatsApp</a>
                </li>
            </ul>
        </div>
        </div>
    </div>
</nav>
