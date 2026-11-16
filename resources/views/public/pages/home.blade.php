@extends('public.layouts.public', ['bodyClass' => 'index2'])

@section('content')
<section class="idx2-hero" id="urun">
    <div class="idx2-hero-bg" aria-hidden="true">
        <div class="idx2-hero-bg-blob-tr"></div>
        <div class="idx2-hero-bg-blob-bl"></div>
        <div class="idx2-hero-bg-dots"></div>
        <div class="idx2-hero-bg-line"></div>
    </div>
    <div class="container py-3 pt-4 pb-3">
        <div class="row align-items-center g-4 g-lg-5 idx2-hero-main">
            <div class="col-lg-6 order-lg-2">
                <div class="idx2-hero-visual">
                    <picture>
                        <source media="(min-width: 992px)" srcset="{{ asset('img/makina-1100.png') }}" type="image/png">
                        <source media="(max-width: 991.98px)" srcset="{{ asset('img/makina-720.png') }}" type="image/png">
                        <img src="{{ asset('img/makina-720.png') }}"
                             srcset="{{ asset('img/makina-720.png') }} 720w, {{ asset('img/makina-1100.png') }} 1100w"
                             sizes="(max-width: 991.98px) 100vw, 50vw"
                             alt="Simit bağlama makinesi"
                             width="720"
                             height="442"
                             loading="eager"
                             fetchpriority="high"
                             decoding="async">
                    </picture>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <h1 class="idx2-hero-title mb-3">
                    <span class="idx2-hero-title-line">Karesi Makine</span>
                    <span class="idx2-hero-title-main">Simit Bağlama Makinesi</span>
                </h1>
                <p class="lead mb-4 idx2-hero-lead">
                    Üretimde makineleşerek eleman maliyetinden kurtulurken kazancınızı arttırın.
                </p>
                <div class="d-none d-md-flex flex-wrap gap-2 mb-4">
                    <a class="btn idx2-hero-primary px-4" href="#deneme"><i class="bi bi-gear me-2" aria-hidden="true"></i>Deneme Fırsatı</a>
                    <a class="btn idx2-hero-secondary px-4" href="#videolar"><i class="bi bi-play-btn me-2" aria-hidden="true"></i>Videolar</a>
                </div>
            </div>
        </div>
        <div class="idx2-hero-bottom-strip d-none d-lg-block">
            <div class="idx2-spec-strip row row-cols-1 row-cols-lg-4 g-2">
                <div class="col idx2-spec-col">
                    <div class="idx2-spec-cell">
                        <span class="idx2-spec-icon" aria-hidden="true"><i class="bi bi-speedometer2"></i></span>
                        <span>
                            <span class="idx2-spec-val">Saatlik Üretim</span>
                            <span class="idx2-spec-desc">3000 adet/saat kapasiteyle tempo ve yoğun talepte hattınıza destek.</span>
                        </span>
                    </div>
                </div>
                <div class="col idx2-spec-col">
                    <div class="idx2-spec-cell">
                        <span class="idx2-spec-icon" aria-hidden="true"><i class="bi bi-bounding-box"></i></span>
                        <span>
                            <span class="idx2-spec-val">Ölçüler</span>
                            <span class="idx2-spec-desc">220 × 40 × 90 cm kompakt gövde ile tezgâh ve hatta yerleşim ve planlama.</span>
                        </span>
                    </div>
                </div>
                <div class="col idx2-spec-col">
                    <div class="idx2-spec-cell">
                        <span class="idx2-spec-icon" aria-hidden="true"><i class="bi bi-layers"></i></span>
                        <span>
                            <span class="idx2-spec-val">Gram Aralığı</span>
                            <span class="idx2-spec-desc">25–150 gr siparişe özel; hedefe 20 gr toleransla dar aralık, stabil üretim.</span>
                        </span>
                    </div>
                </div>
                <div class="col idx2-spec-col">
                    <div class="idx2-spec-cell">
                        <span class="idx2-spec-icon" aria-hidden="true"><i class="bi bi-cash-stack"></i></span>
                        <span>
                            <span class="idx2-spec-val">Uygun Fiyat</span>
                            <span class="idx2-spec-desc">Uygun maliyet ve taksit için teklif almak üzere bizimle iletişime geçebilirsiniz.</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="idx2-mid-stack d-flex flex-column">
<section class="idx2-section alt order-1" id="videolar">
    <div class="container">
        <h2 class="text-center mb-3 idx2-ref-section-title">Referanslar</h2>
        <p class="text-center mb-3">
            <a class="idx2-ref-all-link" href="{{ url('/referanslar') }}">Tüm videoları görüntüle</a>
        </p>
        <div class="idx2-now-playing-track text-center mb-0 pb-3" id="idx2NowPlayingTrack" role="status" aria-live="polite">
            <p class="idx2-now-playing idx2-now-playing-line idx2-label-card--active" id="idx2NowPlayingA"></p>
            <p class="idx2-now-playing idx2-now-playing-line" id="idx2NowPlayingB"></p>
        </div>
    </div>
    <div class="idx2-cinema-viewport">
    <div class="idx2-cinema-shell" id="idx2CinemaShell">
        <div class="idx2-cinema-row" id="idx2CinemaRow" role="group" aria-label="Referanslar">
            <button type="button" class="idx2-cinema-slide idx2-side--L2 idx2-slot idx2-slot--l2 idx2-slot--empty" id="idx2SlotL2" aria-hidden="true" tabindex="-1">
                <span class="idx2-cinema-thumb idx2-slot-thumb"></span>
            </button>
            <button type="button" class="idx2-cinema-slide idx2-side--L1 idx2-slot idx2-slot--l1 idx2-slot--empty" id="idx2SlotL1" aria-hidden="true" tabindex="-1">
                <span class="idx2-cinema-thumb idx2-slot-thumb"></span>
            </button>
            <div class="idx2-cinema-slide is-selected idx2-slot idx2-slot--center" id="idx2SlotC" aria-hidden="false">
                <div class="idx2-cinema-slot">
                    <div class="idx2-video-track" id="idx2VideoTrack">
                        <div class="idx2-main-wrap" id="idx2VideoCardA" data-idx2-card="a">
                            <div class="idx2-video-stage" id="idx2VideoStageA">
                                <div class="idx2-video-stage-bg" id="idx2VideoStageBgA" aria-hidden="true"></div>
                                <iframe id="idx2MainIframeA"
                                        title="Seçili video"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                                        allowfullscreen
                                        webkitallowfullscreen
                                        mozallowfullscreen
                                        playsinline></iframe>
                            </div>
                        </div>
                        <div class="idx2-main-wrap" id="idx2VideoCardB" data-idx2-card="b">
                            <div class="idx2-video-stage" id="idx2VideoStageB">
                                <div class="idx2-video-stage-bg" id="idx2VideoStageBgB" aria-hidden="true"></div>
                                <iframe id="idx2MainIframeB"
                                        title="Seçili video"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                                        allowfullscreen
                                        webkitallowfullscreen
                                        mozallowfullscreen
                                        playsinline></iframe>
                            </div>
                        </div>
                        <div class="idx2-video-swipe-layer idx2-video-swipe-layer--left d-lg-none" id="idx2VideoSwipeLayerLeft" aria-hidden="true"></div>
                        <div class="idx2-video-swipe-layer idx2-video-swipe-layer--right d-lg-none" id="idx2VideoSwipeLayerRight" aria-hidden="true"></div>
                        <button type="button" class="idx2-video-fs-btn idx2-video-fs-btn--enter d-lg-none" id="idx2MobileFullscreen" aria-label="Videoyu tam ekran izle">
                            <i class="bi bi-arrows-fullscreen" aria-hidden="true"></i>
                            <span>Tam ekran</span>
                        </button>
                        <button type="button" class="idx2-video-fs-btn idx2-video-fs-btn--exit d-lg-none" id="idx2MobileFullscreenExit" aria-label="Tam ekrandan çık">
                            <i class="bi bi-x-lg" aria-hidden="true"></i>
                            <span>Kapat</span>
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" class="idx2-cinema-slide idx2-side--R1 idx2-slot idx2-slot--r1 idx2-slot--empty" id="idx2SlotR1" aria-hidden="true" tabindex="-1">
                <span class="idx2-cinema-thumb idx2-slot-thumb"></span>
            </button>
            <button type="button" class="idx2-cinema-slide idx2-side--R2 idx2-slot idx2-slot--r2 idx2-slot--empty" id="idx2SlotR2" aria-hidden="true" tabindex="-1">
                <span class="idx2-cinema-thumb idx2-slot-thumb"></span>
            </button>
        </div>
        <button type="button" class="idx2-cinema-arrow idx2-cinema-arrow--prev d-none d-lg-grid" id="idx2TwitchPrev" aria-label="Önceki video">‹</button>
        <button type="button" class="idx2-cinema-arrow idx2-cinema-arrow--next d-none d-lg-grid" id="idx2TwitchNext" aria-label="Sonraki video">›</button>
    </div>
    </div>
    <div class="container idx2-video-mobile-nav d-lg-none px-3">
        <div class="idx2-video-mobile-nav-inner" id="idx2MobileNavInner">
            <button type="button" class="btn idx2-video-nav-btn idx2-video-nav-btn--prev" id="idx2MobilePrev" aria-label="Önceki video">
                <i class="bi bi-chevron-left" aria-hidden="true"></i>
                <span>Önceki</span>
            </button>
            <div class="idx2-video-mobile-pagination" id="idx2MobilePagination" aria-live="polite" aria-label="Video sırası"></div>
            <button type="button" class="btn idx2-video-nav-btn idx2-video-nav-btn--next" id="idx2MobileNext" aria-label="Sonraki video">
                <span>Sonraki</span>
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</section>

<div id="idx2VideoFullscreen" class="idx2-video-fullscreen d-lg-none" hidden aria-hidden="true" role="dialog" aria-modal="true" aria-label="Video tam ekran">
    <div class="idx2-video-fullscreen-inner">
        <button type="button" class="idx2-video-fullscreen-close" id="idx2FullscreenClose" aria-label="Tam ekrandan çık">
            <i class="bi bi-x-lg me-1" aria-hidden="true"></i>Kapat
        </button>
        <div class="idx2-video-fullscreen-player" id="idx2FullscreenPlayerHost"></div>
    </div>
</div>

<div class="container d-lg-none idx2-post-video-specs">
    <div class="idx2-hero-bottom-strip">
        <div class="idx2-spec-strip row row-cols-1 g-2">
            <div class="col idx2-spec-col">
                <div class="idx2-spec-cell">
                    <span class="idx2-spec-icon" aria-hidden="true"><i class="bi bi-speedometer2"></i></span>
                    <span>
                        <span class="idx2-spec-val">Saatlik Üretim</span>
                        <span class="idx2-spec-desc">3000 adet/saat kapasiteyle tempo ve yoğun talepte hattınıza destek.</span>
                    </span>
                </div>
            </div>
            <div class="col idx2-spec-col">
                <div class="idx2-spec-cell">
                    <span class="idx2-spec-icon" aria-hidden="true"><i class="bi bi-bounding-box"></i></span>
                    <span>
                        <span class="idx2-spec-val">Ölçüler</span>
                        <span class="idx2-spec-desc">220 × 40 × 90 cm kompakt gövde ile tezgâh ve hatta yerleşim ve planlama.</span>
                    </span>
                </div>
            </div>
            <div class="col idx2-spec-col">
                <div class="idx2-spec-cell">
                    <span class="idx2-spec-icon" aria-hidden="true"><i class="bi bi-layers"></i></span>
                    <span>
                        <span class="idx2-spec-val">Gram Aralığı</span>
                        <span class="idx2-spec-desc">25–150 gr siparişe özel; hedefe 20 gr toleransla dar aralık, stabil üretim.</span>
                    </span>
                </div>
            </div>
            <div class="col idx2-spec-col">
                <div class="idx2-spec-cell">
                    <span class="idx2-spec-icon" aria-hidden="true"><i class="bi bi-cash-stack"></i></span>
                    <span>
                        <span class="idx2-spec-val">Uygun Fiyat</span>
                        <span class="idx2-spec-desc">Uygun maliyet ve taksit için teklif almak üzere bizimle iletişime geçebilirsiniz.</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="idx2-section alt order-2" id="deneme">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="idx2-deneme">
                    <div class="idx2-deneme-inner">
                        <div class="idx2-deneme-head">
                            <span class="idx2-deneme-icon" aria-hidden="true"><i class="bi bi-patch-check-fill"></i></span>
                            <h2>Önce deneyin, sonra karar verin</h2>
                        </div>
                        <div class="idx2-deneme-prose">
                            <p style="color: var(--muted);">
                                Birçok işletme, makineyi yerinde görmeden karar vermekte tereddüt edebiliyor. Bu noktada süreci kolaylaştırmak için
                                <strong class="text-white">cihazımızı işletmenizde test etme imkânı</strong> sunuyoruz. Böylece makinenin
                                <strong class="text-white">sizin hamurunuzda ve üretim hattınızda</strong> nasıl performans verdiğini birlikte değerlendirebiliriz.
                            </p>
                            <p style="color: var(--muted);">
                                Deneme sürecini planlamak için
                                <strong class="text-white">yalnızca ulaşım ve kurulumla ilgili giderleri</strong> karşılamak adına cüzi bir kapora talep ediyoruz.
                            </p>
                            <p class="mb-0" style="color: var(--muted);">
                                Tarih ve detaylar için bizi
                                <strong class="text-white">hemen arayabilirsiniz</strong>; üretim akışınıza uygun şekilde birlikte planlama yapalım.
                                Sürecin tamamı için <a href="{{ url('/deneme') }}" class="idx2-deneme-accent">deneme sayfamıza</a> göz atın.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if (!empty($idx2PromoVideos))
<section class="idx2-section order-3" id="tanitim-videolari">
    <div class="container">
        <h3 class="idx2-ref-section-title text-center mb-3">Tanıtım Filmleri</h3>
        <div class="idx2-promo-strip" id="idx2PromoStrip" aria-label="Tanıtım videoları">
            <div class="idx2-promo-track">
                @foreach ($idx2PromoVideos as $v)
@php
                    $vid = trim((string) ($v['id'] ?? ''));
                    if ($vid === '') {
                        continue;
                    }
                    $label = trim((string) ($v['label'] ?? 'Tanitim Videosu'));
                    $thumb = 'https://img.youtube.com/vi/' . rawurlencode($vid) . '/hqdefault.jpg';
@endphp
                    <button type="button"
                            class="idx2-promo-card js-open-promo-video"
                            data-video-id="{{ $vid }}"
                            data-video-title="{{ $label }}"
                            data-video-format="{{ (string) ($v['format'] ?? 'vertical') }}"
                            aria-label="{{ $label }}">
                        <span class="idx2-promo-thumb-wrap">
                            <img class="idx2-promo-thumb" src="{{ $thumb }}" alt="{{ $label }}" loading="lazy" decoding="async">
                            <span class="idx2-promo-play"><i class="bi bi-play-fill" aria-hidden="true"></i></span>
                        </span>
                        <span class="idx2-promo-label">{{ $label }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="idx2PromoVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered idx2-promo-modal-dialog" id="idx2PromoModalDialog">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title mb-0" id="idx2PromoVideoModalTitle">Tanıtım Videosu</h5>
                <button type="button" class="btn-close" id="idx2PromoModalCloseBtn" aria-label="Kapat"></button>
            </div>
            <div class="modal-body p-0">
                <div class="idx2-promo-player idx2-promo-player--horizontal bg-black" id="idx2PromoPlayer">
                    <iframe id="idx2PromoVideoIframe"
                            title="Tanıtım videosu"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                            allowfullscreen
                            webkitallowfullscreen
                            mozallowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
</div>

<section class="idx2-section" id="iletisim">
    <div class="container">
        <div class="text-center mb-4 mb-lg-5">
            <h2 class="idx2-ref-section-title mb-3">İletişim</h2>
            <p class="idx2-contact-lead col-lg-8 mx-auto mb-0">
                Simit bağlama makinesi için kapasite, yerleşim ve deneme takvimini netleştirelim.
                Detaylı bilgiler için <a href="{{ url('/iletisim') }}">iletişim sayfamızı</a> ziyaret edebilir; hızlı yanıt için arayabilir veya yazabilirsiniz.
            </p>
        </div>
        <div class="row g-3 g-lg-4 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <a class="idx2-contact-tile" href="tel:+905315426368">
                    <span class="idx2-contact-icon" aria-hidden="true"><i class="bi bi-telephone"></i></span>
                    <span class="idx2-contact-label">Telefon</span>
                    <span class="idx2-contact-val">(+90) 531 542 63 68</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a class="idx2-contact-tile" href="mailto:bilgi@karesimakine.com">
                    <span class="idx2-contact-icon" aria-hidden="true"><i class="bi bi-envelope"></i></span>
                    <span class="idx2-contact-label">E-posta</span>
                    <span class="idx2-contact-val">bilgi@karesimakine.com</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a class="idx2-contact-tile" href="https://maps.app.goo.gl/PCabcCgTYx7YZbFv5" target="_blank" rel="noopener">
                    <span class="idx2-contact-icon" aria-hidden="true"><i class="bi bi-geo-alt"></i></span>
                    <span class="idx2-contact-label">Adres</span>
                    <span class="idx2-contact-val">Marmara mah. 9. sk. Astro Rezidans<br>A Blok No:2/32</span>
                    <span class="idx2-contact-sub">Beylikdüzü / İstanbul</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@graph": [
        {
            "@@type": "Organization",
            "@@id": "{{ $seoSiteUrl }}/#organization",
            "name": "Karesi Makine",
            "url": "{{ $seoSiteUrl }}/",
            "logo": "{{ $seoSiteUrl }}/img/mavilogo-3.png",
            "email": "bilgi@karesimakine.com",
            "telephone": "+90-531-542-63-68",
            "address": {
                "@@type": "PostalAddress",
                "streetAddress": "Marmara mah. 9. sk. Astro Rezidans A Blok No:2/32",
                "addressLocality": "Beylikdüzü",
                "addressRegion": "İstanbul",
                "addressCountry": "TR"
            },
            "sameAs": [
                "https://www.facebook.com/karesimakina",
                "https://www.instagram.com/karesimakine",
                "https://www.youtube.com/@karesimakina"
            ]
        },
        {
            "@@type": "WebSite",
            "@@id": "{{ $seoSiteUrl }}/#website",
            "url": "{{ $seoSiteUrl }}/",
            "name": "Karesi Makine",
            "inLanguage": "tr-TR",
            "publisher": { "@@id": "{{ $seoSiteUrl }}/#organization" }
        },
        {
            "@@type": "WebPage",
            "@@id": "{{ $seoCanonical }}#webpage",
            "url": "{{ $seoCanonical }}",
            "name": {!! json_encode($seoTitle, JSON_UNESCAPED_UNICODE) !!},
            "description": {!! json_encode($seoDescription, JSON_UNESCAPED_UNICODE) !!},
            "isPartOf": { "@@id": "{{ $seoSiteUrl }}/#website" },
            "about": { "@@id": "{{ $seoSiteUrl }}/#product-simit" },
            "inLanguage": "tr-TR"
        },
        {
            "@@type": "Product",
            "@@id": "{{ $seoSiteUrl }}/#product-simit",
            "name": "Otomatik Simit Bağlama Makinesi",
            "alternateName": [
                "Simit Makinesi",
                "Simit Bağlama Makinesi",
                "Otomatik Simit Makinesi",
                "Simit Yapma Makinesi",
                "Simit Makineleri"
            ],
            "description": "Saatlik 3000 adete kadar üretim kapasiteli otomatik simit yapma ve simit bağlama makinesi. Simit makinesi fiyatları için teklif; işletmenizde deneme imkânı.",
            "image": "{{ $seoSiteUrl }}/img/makina-1100.png",
            "category": "Endüstriyel Gıda Makineleri",
            "brand": { "@@type": "Brand", "name": "Karesi Makine" },
            "manufacturer": { "@@id": "{{ $seoSiteUrl }}/#organization" },
            "offers": {
                "@@type": "Offer",
                "url": "{{ $seoCanonical }}#iletisim",
                "price": "{{ (int) $seoProductPrice }}",
                "priceCurrency": "TRY",
                "availability": "https://schema.org/InStock",
                "seller": { "@@id": "{{ $seoSiteUrl }}/#organization" }
            }
        },
        {
            "@@type": "FAQPage",
            "@@id": "{{ $seoCanonical }}#faq",
            "mainEntity": {!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
        }
    ]
}
</script>
@endpush

@push('scripts')
<script>
    (function () {
        const VIDEOS = {!! json_encode($idx2Videos, JSON_UNESCAPED_UNICODE) !!};
        const DEFAULT_ID = {!! json_encode($idx2DefaultId, JSON_UNESCAPED_UNICODE) !!};

        const videoTrack = document.getElementById('idx2VideoTrack');
        const CARDS = {
            a: {
                wrap: document.getElementById('idx2VideoCardA'),
                stage: document.getElementById('idx2VideoStageA'),
                bg: document.getElementById('idx2VideoStageBgA'),
                iframe: document.getElementById('idx2MainIframeA')
            },
            b: {
                wrap: document.getElementById('idx2VideoCardB'),
                stage: document.getElementById('idx2VideoStageB'),
                bg: document.getElementById('idx2VideoStageBgB'),
                iframe: document.getElementById('idx2MainIframeB')
            }
        };
        const SLIDE_CLASSES = [
            'idx2-slide-in-from-right',
            'idx2-slide-in-from-left',
            'idx2-slide-out-to-left',
            'idx2-slide-out-to-right'
        ];
        let activeCardKey = 'a';
        let isVideoTransitioning = false;
        let videoEmbedStarted = false;
        const LABELS = {
            a: { el: document.getElementById('idx2NowPlayingA') },
            b: { el: document.getElementById('idx2NowPlayingB') }
        };
        const labelTrack = document.getElementById('idx2NowPlayingTrack');
        const row = document.getElementById('idx2CinemaRow');
        const shell = document.getElementById('idx2CinemaShell');
        const swipeRoot = document.querySelector('.idx2-cinema-viewport') || shell;
        const mqMobile = window.matchMedia('(max-width: 991.98px)');
        const btnPrev = document.getElementById('idx2TwitchPrev');
        const btnNext = document.getElementById('idx2TwitchNext');
        const btnPrevMobile = document.getElementById('idx2MobilePrev');
        const btnNextMobile = document.getElementById('idx2MobileNext');
        const mobilePagination = document.getElementById('idx2MobilePagination');
        const mobileNavInner = document.getElementById('idx2MobileNavInner');
        const btnFullscreenMobile = document.getElementById('idx2MobileFullscreen');
        const btnFullscreenExit = document.getElementById('idx2MobileFullscreenExit');
        const videoSwipeLayerLeft = document.getElementById('idx2VideoSwipeLayerLeft');
        const videoSwipeLayerRight = document.getElementById('idx2VideoSwipeLayerRight');
        const fsOverlay = document.getElementById('idx2VideoFullscreen');
        const fsClose = document.getElementById('idx2FullscreenClose');
        const slotC = document.getElementById('idx2SlotC');

        const SLOT_DEFS = [
            { id: 'idx2SlotL2', rel: -2 },
            { id: 'idx2SlotL1', rel: -1 },
            { id: 'idx2SlotC', rel: 0 },
            { id: 'idx2SlotR1', rel: 1 },
            { id: 'idx2SlotR2', rel: 2 }
        ];

        function thumbUrl(id) {
            return 'https://img.youtube.com/vi/' + id + '/mqdefault.jpg';
        }

        function embedUrl(id, opts) {
            opts = opts || {};
            let allowFs = opts.allowFs !== false;
            if (mqMobile.matches) {
                allowFs = false;
            }
            let url = 'https://www.youtube.com/embed/' + id
                + '?rel=0&modestbranding=1&playsinline=1&controls=1&fs=' + (allowFs ? '1' : '0');
            if (window.location && window.location.origin) {
                url += '&origin=' + encodeURIComponent(window.location.origin);
            }
            return url;
        }

        function isFullscreenOpen() {
            return videoTrack && videoTrack.classList.contains('idx2-video-track--fs-active');
        }

        function getDocumentFullscreenElement() {
            return document.fullscreenElement || document.webkitFullscreenElement || document.msFullscreenElement || null;
        }

        function isOurFullscreenTarget(el) {
            if (!el) return false;
            if (videoTrack && (el === videoTrack || videoTrack.contains(el))) return true;
            if (fsOverlay && (el === fsOverlay || fsOverlay.contains(el))) return true;
            return false;
        }

        function requestElementFullscreen(el) {
            if (!el) return Promise.resolve(false);
            const fn = el.requestFullscreen
                || el.webkitRequestFullscreen
                || el.webkitEnterFullscreen
                || el.msRequestFullscreen;
            if (!fn) return Promise.resolve(false);
            try {
                const ret = fn.call(el);
                if (ret && typeof ret.then === 'function') {
                    return ret.then(function () { return true; }).catch(function () { return false; });
                }
                return Promise.resolve(true);
            } catch (e) {
                return Promise.resolve(false);
            }
        }

        function exitOverlayFullscreen() {
            const fn = document.exitFullscreen || document.webkitExitFullscreen || document.msExitFullscreen;
            if (!fn) return;
            try {
                const ret = fn.call(document);
                if (ret && typeof ret.catch === 'function') {
                    ret.catch(function () {});
                }
            } catch (e) {
            }
        }

        function applyFullscreenFallbackChrome() {
            document.documentElement.classList.add('idx2-fs-fallback');
            try {
                window.scrollTo(0, 1);
                window.setTimeout(function () { window.scrollTo(0, 0); }, 120);
            } catch (e) {
            }
        }

        function clearFullscreenFallbackChrome() {
            document.documentElement.classList.remove('idx2-fs-fallback');
        }

        function cardIframeIsPlaying(card) {
            if (!card || !card.iframe) return false;
            const src = card.iframe.getAttribute('src') || card.iframe.src || '';
            return src && src !== 'about:blank' && src.indexOf('about:') !== 0;
        }

        function syncMobileFullscreenUi() {
            if (!videoTrack) return;
            const fsEl = getDocumentFullscreenElement();
            if (fsEl && isOurFullscreenTarget(fsEl)) {
                videoTrack.classList.add('idx2-video-track--fs-active');
                document.body.classList.add('idx2-fs-open');
            }
        }

        function teardownMobileFullscreen() {
            clearFullscreenFallbackChrome();
            if (videoTrack) {
                videoTrack.classList.remove('idx2-video-track--fs-active');
            }
            document.body.classList.remove('idx2-fs-open');
        }

        function closeMobileFullscreen() {
            if (!isFullscreenOpen()) return;
            exitOverlayFullscreen();
            teardownMobileFullscreen();
        }

        let fsChangeDebounce = null;

        function startVideoEmbeds() {
            if (videoEmbedStarted || !VIDEOS.length) return;
            videoEmbedStarted = true;
            const card = getActiveCard();
            if (card) {
                setCardEmbed(card, currentId);
            }
        }

        function ensureVideoEmbeds() {
            if (!videoEmbedStarted) {
                startVideoEmbeds();
            }
        }

        function enterMobileFullscreenUi() {
            stopCardPlayback(getInactiveCard());
            clearFullscreenFallbackChrome();
            videoTrack.classList.add('idx2-video-track--fs-active');
            document.body.classList.add('idx2-fs-open');
            requestElementFullscreen(videoTrack).then(function (entered) {
                if (!entered) {
                    applyFullscreenFallbackChrome();
                }
            });
        }

        function openMobileFullscreen() {
            if (!currentId || !videoTrack || isFullscreenOpen()) return;
            ensureVideoEmbeds();
            const active = getActiveCard();
            if (!active) return;
            if (!cardIframeIsPlaying(active)) {
                if (active.iframe) {
                    active.iframe.addEventListener('load', function () {
                        if (cardIframeIsPlaying(active) && !isFullscreenOpen()) {
                            enterMobileFullscreenUi();
                        }
                    }, { once: true });
                }
                return;
            }
            enterMobileFullscreenUi();
        }

        function onDocumentFullscreenChange() {
            if (fsChangeDebounce) {
                window.clearTimeout(fsChangeDebounce);
            }
            fsChangeDebounce = window.setTimeout(function () {
                fsChangeDebounce = null;
                const fsEl = getDocumentFullscreenElement();
                if (fsEl && isOurFullscreenTarget(fsEl)) {
                    syncMobileFullscreenUi();
                    return;
                }
                if (isFullscreenOpen()) {
                    exitOverlayFullscreen();
                    teardownMobileFullscreen();
                }
            }, 100);
        }

        function applyMobileIframeFullscreenPolicy() {
            if (!mqMobile.matches) return;
            Object.keys(CARDS).forEach(function (key) {
                const iframe = CARDS[key].iframe;
                if (!iframe) return;
                iframe.removeAttribute('allowfullscreen');
                iframe.removeAttribute('webkitallowfullscreen');
                iframe.removeAttribute('mozallowfullscreen');
                iframe.setAttribute(
                    'allow',
                    'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
                );
            });
        }

        let centerIndex = 0;
        let currentId = DEFAULT_ID;

        function updateArrows() {
            const n = VIDEOS.length;
            const disablePrev = n <= 1 || centerIndex <= 0;
            const disableNext = n <= 1 || centerIndex >= n - 1;
            if (btnPrev) btnPrev.disabled = disablePrev;
            if (btnNext) btnNext.disabled = disableNext;
            if (btnPrevMobile) btnPrevMobile.disabled = disablePrev;
            if (btnNextMobile) btnNextMobile.disabled = disableNext;
        }

        function renderMobilePagination() {
            if (!mobilePagination || !VIDEOS.length) return;
            const n = VIDEOS.length;
            let maxVisible = Math.min(12, n);

            // Kalan alana göre dinamik adet: butonlar ne kadar yer kaplıyorsa
            // numaralar otomatik o kadar görünür.
            if (mobileNavInner && btnPrevMobile && btnNextMobile) {
                const navStyles = window.getComputedStyle(mobileNavInner);
                const navGap = parseFloat(navStyles.columnGap || navStyles.gap || '0') || 0;
                const navWidth = mobileNavInner.clientWidth || 0;
                const prevWidth = btnPrevMobile.offsetWidth || 0;
                const nextWidth = btnNextMobile.offsetWidth || 0;

                const probe = document.createElement('button');
                probe.type = 'button';
                probe.className = 'idx2-video-page-dot';
                probe.textContent = String(Math.max(99, n)); // 2-3 haneli senaryo payı
                probe.style.position = 'absolute';
                probe.style.visibility = 'hidden';
                probe.style.pointerEvents = 'none';
                mobilePagination.appendChild(probe);
                const dotWidth = probe.offsetWidth || 20;
                probe.remove();

                const paginationStyles = window.getComputedStyle(mobilePagination);
                const dotGap = parseFloat(paginationStyles.columnGap || paginationStyles.gap || '0') || 0;
                const available = Math.max(0, navWidth - prevWidth - nextWidth - (navGap * 2));
                const perDot = Math.max(1, dotWidth + dotGap);
                const fitCount = Math.floor((available + dotGap) / perDot);

                // Çok az olmasın, çok da taşmasın.
                maxVisible = Math.max(3, Math.min(n, fitCount));
            }

            // Simetrik görünüm için tek sayı tercih et.
            if (maxVisible > 3 && maxVisible % 2 === 0) {
                maxVisible -= 1;
            }
            let start = Math.max(0, centerIndex - Math.floor(maxVisible / 2));
            let end = start + maxVisible - 1;
            if (end >= n) {
                end = n - 1;
                start = Math.max(0, end - maxVisible + 1);
            }

            let html = '';
            for (let i = start; i <= end; i++) {
                const isActive = i === centerIndex;
                html += '<button type="button" class="idx2-video-page-dot'
                    + (isActive ? ' is-active' : '')
                    + '" data-video-index="' + i + '" aria-label="' + (i + 1) + '. videoya git">'
                    + (i + 1)
                    + '</button>';
            }
            mobilePagination.innerHTML = html;
        }

        function fillSideSlot(el, v) {
            const thumb = el.querySelector('.idx2-slot-thumb');
            if (thumb) thumb.style.backgroundImage = 'url(' + thumbUrl(v.id) + ')';
            el.setAttribute('title', v.label);
        }

        function syncSlots() {
            const n = VIDEOS.length;
            SLOT_DEFS.forEach(function (def) {
                const el = document.getElementById(def.id);
                if (!el) return;
                const vi = centerIndex + def.rel;
                if (def.rel === 0) {
                    el.classList.remove('idx2-slot--empty');
                    el.removeAttribute('data-video-index');
                    el.setAttribute('aria-hidden', 'false');
                    el.removeAttribute('tabindex');
                    return;
                }
                if (vi < 0 || vi >= n) {
                    el.classList.add('idx2-slot--empty');
                    el.removeAttribute('data-video-index');
                    el.removeAttribute('title');
                    el.setAttribute('aria-hidden', 'true');
                    el.setAttribute('tabindex', '-1');
                    const thumb = el.querySelector('.idx2-slot-thumb');
                    if (thumb) thumb.style.backgroundImage = '';
                    return;
                }
                el.classList.remove('idx2-slot--empty');
                el.setAttribute('data-video-index', String(vi));
                el.setAttribute('aria-hidden', 'false');
                el.removeAttribute('tabindex');
                fillSideSlot(el, VIDEOS[vi]);
            });
            updateArrows();
        }

        function getActiveCard() {
            return CARDS[activeCardKey];
        }

        function getInactiveCard() {
            return CARDS[activeCardKey === 'a' ? 'b' : 'a'];
        }

        function updateCardStack() {
            Object.keys(CARDS).forEach(function (key) {
                const card = CARDS[key];
                if (!card.wrap) return;
                card.wrap.classList.toggle('idx2-video-card--active', key === activeCardKey);
            });
        }

        function getActiveLabel() {
            return LABELS[activeCardKey];
        }

        function getInactiveLabel() {
            return LABELS[activeCardKey === 'a' ? 'b' : 'a'];
        }

        function updateLabelStack() {
            Object.keys(LABELS).forEach(function (key) {
                const label = LABELS[key];
                if (!label.el) return;
                label.el.classList.toggle('idx2-label-card--active', key === activeCardKey);
            });
        }

        function setLabelText(label, text) {
            if (label && label.el) {
                label.el.textContent = text || '';
            }
        }

        function applySlidePair(activeEl, inactiveEl, dir) {
            const enterClass = dir > 0 ? 'idx2-slide-in-from-right' : 'idx2-slide-in-from-left';
            const exitClass = dir > 0 ? 'idx2-slide-out-to-left' : 'idx2-slide-out-to-right';
            clearSlideClasses(activeEl);
            clearSlideClasses(inactiveEl);
            if (inactiveEl) inactiveEl.style.zIndex = '2';
            if (activeEl) activeEl.style.zIndex = '1';
            if (inactiveEl) void inactiveEl.offsetWidth;
            if (activeEl) activeEl.classList.add(exitClass);
            if (inactiveEl) inactiveEl.classList.add(enterClass);
        }

        function resetSlideEl(el) {
            if (!el) return;
            clearSlideClasses(el);
            el.style.zIndex = '';
            el.style.transform = '';
            el.style.opacity = '';
        }

        function resetSlidePair(activeEl, inactiveEl) {
            resetSlideEl(activeEl);
            resetSlideEl(inactiveEl);
        }

        function clearSlideClasses(el) {
            if (!el) return;
            SLIDE_CLASSES.forEach(function (cls) {
                el.classList.remove(cls);
            });
        }

        function setCardEmbed(card, id) {
            if (!card || !card.iframe) return;
            applyMobileIframeFullscreenPolicy();
            card.iframe.src = embedUrl(id);
        }

        function stopCardPlayback(card) {
            if (!card || !card.iframe) return;
            const src = card.iframe.getAttribute('src') || card.iframe.src || '';
            if (!src || src === 'about:blank') return;
            card.iframe.src = 'about:blank';
            if (card.stage) {
                card.stage.classList.remove('idx2-video-loaded');
            }
        }

        function onVideoIframeLoad(ev) {
            const iframeEl = ev.target;
            const src = iframeEl.getAttribute('src') || iframeEl.src || '';
            if (!src || src === 'about:blank' || src.indexOf('about:') === 0) return;
            let card = null;
            if (CARDS.a.iframe === iframeEl) {
                card = CARDS.a;
            } else if (CARDS.b.iframe === iframeEl) {
                card = CARDS.b;
            }
            if (card && card.stage) {
                card.stage.classList.add('idx2-video-loaded');
            }
        }

        if (CARDS.a.iframe) {
            CARDS.a.iframe.addEventListener('load', onVideoIframeLoad);
        }
        if (CARDS.b.iframe) {
            CARDS.b.iframe.addEventListener('load', onVideoIframeLoad);
        }

        function playVideoSlide(dir, videoId, outgoingVideoId, incomingLabel, outgoingLabel) {
            const active = getActiveCard();
            const inactive = getInactiveCard();
            const activeLabel = getActiveLabel();
            const inactiveLabel = getInactiveLabel();
            if (!active.wrap || !inactive.wrap || dir === 0) return;

            if (active.bg && outgoingVideoId) {
                active.bg.style.backgroundImage = 'url(' + thumbUrl(outgoingVideoId) + ')';
            }
            stopCardPlayback(active);
            setLabelText(activeLabel, outgoingLabel);
            setLabelText(inactiveLabel, incomingLabel);

            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (inactive.bg) {
                inactive.bg.style.backgroundImage = 'url(' + thumbUrl(videoId) + ')';
            }
            if (inactive.stage) {
                inactive.stage.classList.remove('idx2-video-loaded');
            }
            if (videoEmbedStarted) {
                setCardEmbed(inactive, videoId);
            }

            if (labelTrack) {
                labelTrack.classList.add('is-sliding');
            }

            if (reduceMotion) {
                activeCardKey = activeCardKey === 'a' ? 'b' : 'a';
                updateCardStack();
                updateLabelStack();
                if (labelTrack) {
                    labelTrack.classList.remove('is-sliding');
                }
                resetSlidePair(active.wrap, inactive.wrap);
                resetSlidePair(activeLabel.el, inactiveLabel.el);
                return;
            }

            if (isVideoTransitioning) return;
            isVideoTransitioning = true;

            applySlidePair(active.wrap, inactive.wrap, dir);
            applySlidePair(activeLabel.el, inactiveLabel.el, dir);

            let finished = false;
            function finishSlide() {
                if (finished) return;
                finished = true;
                stopCardPlayback(active);
                activeCardKey = activeCardKey === 'a' ? 'b' : 'a';
                updateCardStack();
                updateLabelStack();
                if (labelTrack) {
                    labelTrack.classList.remove('is-sliding');
                }
                resetSlidePair(active.wrap, inactive.wrap);
                resetSlidePair(activeLabel.el, inactiveLabel.el);
                isVideoTransitioning = false;
            }

            inactive.wrap.addEventListener('animationend', function onSlideEnd(ev) {
                if (ev.currentTarget !== inactive.wrap) return;
                if (ev.animationName !== 'idx2VideoSlideInRight' && ev.animationName !== 'idx2VideoSlideInLeft') return;
                finishSlide();
            }, { once: true });

            window.setTimeout(finishSlide, 700);
        }

        function setCenterIndex(newIdx) {
            const n = VIDEOS.length;
            if (n === 0 || newIdx < 0 || newIdx >= n) return;
            ensureVideoEmbeds();
            const prev = centerIndex;
            const dir = newIdx > prev ? 1 : (newIdx < prev ? -1 : 0);
            if (dir !== 0 && isVideoTransitioning) return;
            if (isFullscreenOpen()) {
                exitOverlayFullscreen();
                teardownMobileFullscreen();
            }
            centerIndex = newIdx;
            currentId = VIDEOS[centerIndex].id;
            const meta = VIDEOS[centerIndex];
            const prevMeta = VIDEOS[prev];
            if (dir !== 0) {
                const outgoingVideoId = prevMeta ? prevMeta.id : '';
                playVideoSlide(
                    dir,
                    currentId,
                    outgoingVideoId,
                    meta ? meta.label : '',
                    prevMeta ? prevMeta.label : ''
                );
            } else {
                const card = getActiveCard();
                if (videoEmbedStarted) {
                    setCardEmbed(card, currentId);
                } else if (card && card.bg) {
                    card.bg.style.backgroundImage = 'url(' + thumbUrl(currentId) + ')';
                }
                setLabelText(getActiveLabel(), meta ? meta.label : '');
            }
            syncSlots();
            if (slotC && meta) {
                slotC.setAttribute('title', meta.label);
            }
            renderMobilePagination();
        }

        function selectAdjacentVideo(delta) {
            setCenterIndex(centerIndex + delta);
        }

        (function init() {
            if (!VIDEOS.length) return;
            let j = VIDEOS.findIndex(function (v) { return v.id === DEFAULT_ID; });
            if (mqMobile.matches) j = 0;
            if (j < 0) j = 0;
            centerIndex = j;
            currentId = VIDEOS[j].id;
            const initCard = getActiveCard();
            if (initCard.bg) {
                initCard.bg.style.backgroundImage = 'url(' + thumbUrl(currentId) + ')';
            }
            const videoSection = document.getElementById('videolar');
            function bootVideoEmbeds() {
                startVideoEmbeds();
            }
            if (videoSection && 'IntersectionObserver' in window) {
                const videoIo = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            bootVideoEmbeds();
                            videoIo.disconnect();
                        }
                    });
                }, { rootMargin: '200px 0px', threshold: 0.01 });
                videoIo.observe(videoSection);
            } else {
                bootVideoEmbeds();
            }
            updateCardStack();
            setLabelText(getActiveLabel(), VIDEOS[j].label);
            updateLabelStack();
            syncSlots();
            if (slotC) {
                slotC.setAttribute('title', VIDEOS[j].label);
            }
            renderMobilePagination();
        })();

        if (row) {
            row.addEventListener('click', function (e) {
                const btn = e.target.closest('.idx2-slot');
                if (!btn || btn.classList.contains('idx2-slot--empty')) return;
                const raw = btn.getAttribute('data-video-index');
                if (raw === null || raw === '') {
                    return;
                }
                const vi = parseInt(raw, 10);
                if (vi === centerIndex) {
                    return;
                }
                setCenterIndex(vi);
            });
        }

        function wireVideoNav(btn, delta) {
            if (!btn) return;
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                selectAdjacentVideo(delta);
            });
        }

        wireVideoNav(btnPrev, -1);
        wireVideoNav(btnNext, 1);
        wireVideoNav(btnPrevMobile, -1);
        wireVideoNav(btnNextMobile, 1);

        if (mobilePagination) {
            mobilePagination.addEventListener('click', function (e) {
                const btn = e.target.closest('.idx2-video-page-dot');
                if (!btn) return;
                const raw = btn.getAttribute('data-video-index');
                if (raw === null || raw === '') return;
                const idx = parseInt(raw, 10);
                if (Number.isNaN(idx)) return;
                setCenterIndex(idx);
            });
        }

        if (btnFullscreenMobile) {
            btnFullscreenMobile.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                openMobileFullscreen();
            });
        }

        if (btnFullscreenExit) {
            btnFullscreenExit.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeMobileFullscreen();
            });
        }

        if (fsClose) {
            fsClose.addEventListener('click', function (e) {
                e.preventDefault();
                closeMobileFullscreen();
            });
        }

        document.addEventListener('fullscreenchange', onDocumentFullscreenChange);
        document.addEventListener('webkitfullscreenchange', onDocumentFullscreenChange);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isFullscreenOpen()) {
                closeMobileFullscreen();
            }
        });

        /* Mobil: yatay kaydırma — video üzerinde de aktif */
        (function bindMobileSwipe() {
            function attachSwipeZone(el) {
                if (!el) return;
                let startX = 0;
                let startY = 0;
                let active = false;

                el.addEventListener('touchstart', function (e) {
                    if (!mqMobile.matches || !VIDEOS.length || e.touches.length !== 1) return;
                    startX = e.touches[0].clientX;
                    startY = e.touches[0].clientY;
                    active = true;
                }, { passive: true });

                el.addEventListener('touchcancel', function () {
                    active = false;
                }, { passive: true });

                el.addEventListener('touchend', function (e) {
                    if (!active || !mqMobile.matches) {
                        active = false;
                        return;
                    }
                    active = false;
                    if (!e.changedTouches || !e.changedTouches.length) return;
                    const endX = e.changedTouches[0].clientX;
                    const endY = e.changedTouches[0].clientY;
                    const dx = endX - startX;
                    const dy = endY - startY;
                    const minSwipe = 28;
                    const maxDominantVertical = 90;
                    if (Math.abs(dy) > maxDominantVertical && Math.abs(dy) > Math.abs(dx)) return;
                    if (dx <= -minSwipe) {
                        e.preventDefault();
                        selectAdjacentVideo(1);
                    } else if (dx >= minSwipe) {
                        e.preventDefault();
                        selectAdjacentVideo(-1);
                    }
                }, { passive: false });
            }

            attachSwipeZone(swipeRoot);
            attachSwipeZone(videoSwipeLayerLeft);
            attachSwipeZone(videoSwipeLayerRight);
        })();

        let paginationResizeTimer = null;
        window.addEventListener('resize', function () {
            if (!mobilePagination) return;
            window.clearTimeout(paginationResizeTimer);
            paginationResizeTimer = window.setTimeout(function () {
                renderMobilePagination();
            }, 80);
        });
    })();
</script>
<script>
    (function () {
        const VIDEOS = {!! json_encode($idx2PromoVideos, JSON_UNESCAPED_UNICODE) !!};
        if (!VIDEOS || !VIDEOS.length) return;
        const modalEl = document.getElementById('idx2PromoVideoModal');
        const iframe = document.getElementById('idx2PromoVideoIframe');
        const modalTitleEl = document.getElementById('idx2PromoVideoModalTitle');
        const closeBtn = document.getElementById('idx2PromoModalCloseBtn');
        const promoPlayer = document.getElementById('idx2PromoPlayer');
        const cards = document.querySelectorAll('.js-open-promo-video');
        const mqMobile = window.matchMedia('(max-width: 991.98px)');
        if (!modalEl || !iframe || !modalTitleEl || !closeBtn || !promoPlayer || !cards.length) return;
        let isOpen = false;

        function embedUrl(videoId) {
            let url = 'https://www.youtube.com/embed/' + encodeURIComponent(videoId)
                + '?rel=0&modestbranding=1&playsinline=1&autoplay=1';
            if (window.location && window.location.origin) {
                url += '&origin=' + encodeURIComponent(window.location.origin);
            }
            return url;
        }

        function shortsUrl(videoId) {
            return 'https://www.youtube.com/shorts/' + encodeURIComponent(videoId);
        }

        function openModal() {
            isOpen = true;
            modalEl.style.display = 'block';
            modalEl.classList.add('show', 'idx2-promo-modal-open');
            modalEl.removeAttribute('aria-hidden');
            modalEl.setAttribute('aria-modal', 'true');
            document.body.classList.add('modal-open');
        }

        function closeModal() {
            if (!isOpen) return;
            isOpen = false;
            modalEl.classList.remove('show', 'idx2-promo-modal-open');
            modalEl.style.display = 'none';
            modalEl.setAttribute('aria-hidden', 'true');
            modalEl.removeAttribute('aria-modal');
            document.body.classList.remove('modal-open');
            iframe.src = 'about:blank';
            modalTitleEl.textContent = 'Tanıtım Videosu';
        }

        cards.forEach(function (card) {
            card.addEventListener('click', function (e) {
                e.preventDefault();
                const id = (card.getAttribute('data-video-id') || '').trim();
                if (!id) return;
                const format = (card.getAttribute('data-video-format') || '').trim().toLowerCase();
                if (mqMobile.matches && format === 'vertical') {
                    window.location.href = shortsUrl(id);
                    return;
                }
                const title = (card.getAttribute('data-video-title') || '').trim();
                modalTitleEl.textContent = title || 'Tanıtım Videosu';
                iframe.src = embedUrl(id);
                openModal();
            });
        });

        closeBtn.addEventListener('click', closeModal);
        modalEl.addEventListener('click', function (e) {
            if (e.target === modalEl) closeModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });
    })();
</script>
@endpush
