@extends('public.layouts.public', ['bodyClass' => 'index2 idx2-subpage'])

@push('head')
<link rel="preload" as="image" href="{{ $heroBgMobile }}" media="(max-width: 991.98px)" fetchpriority="high">
<link rel="preload" as="image" href="{{ $heroBg }}" media="(min-width: 992px)" fetchpriority="high">
@endpush

@section('content')
<section class="idx2-trial-hero" aria-label="İşletmede deneme">
    <div class="idx2-trial-hero-media" aria-hidden="true">
        <picture>
            <source media="(min-width: 992px)" srcset="{{ $heroBg }}" type="image/jpeg">
            <img src="{{ $heroBgMobile }}"
                 alt=""
                 width="1280"
                 height="720"
                 decoding="async"
                 fetchpriority="high">
        </picture>
        <div class="idx2-trial-hero-shade"></div>
    </div>
    <div class="container idx2-trial-hero-content">
        <nav class="idx2-breadcrumb idx2-breadcrumb--on-dark mb-3" aria-label="Sayfa konumu">
            <a href="{{ url('/') }}">Ana sayfa</a>
            <span aria-hidden="true">/</span>
            <span>Deneme</span>
        </nav>
        <p class="idx2-trial-brand">Karesi Makine</p>
        <h1 class="idx2-trial-title">Önce deneyin,<br>sonra karar verin</h1>
        <p class="idx2-trial-lead">
            Makineyi kendi işletmenizde, kendi hamurunuzda test edin.
            Üretim hattınıza uyumunu görmeden satın almak zorunda değilsiniz.
        </p>
        <div class="d-flex flex-wrap gap-2 idx2-trial-cta">
            <a class="btn idx2-hero-primary px-4" href="tel:+905315426368"><i class="bi bi-telephone me-2" aria-hidden="true"></i>Deneme için ara</a>
            <a class="btn idx2-hero-secondary px-4" href="#surec"><i class="bi bi-list-check me-2" aria-hidden="true"></i>Süreç nasıl işler</a>
        </div>
    </div>
</section>

<section class="idx2-section" id="surec">
    <div class="container">
        <div class="text-center mb-4 mb-lg-5">
            <h2 class="idx2-ref-section-title mb-3">Deneme süreci</h2>
            <p class="idx2-page-lead col-lg-8 mx-auto mb-0">
                Üç net adım: planla, yerinde çalıştır, birlikte değerlendir.
            </p>
        </div>
        <ol class="idx2-trial-steps row g-4 list-unstyled mb-0">
            <li class="col-md-4 idx2-trial-step">
                <span class="idx2-trial-step-num" aria-hidden="true">01</span>
                <h3 class="idx2-trial-step-title">Tarih planlanır</h3>
                <p class="idx2-trial-step-text mb-0">Üretim yoğunluğunuza uygun bir gün belirleriz; ulaşım ve kurulum için cüzi bir kapora alınır.</p>
            </li>
            <li class="col-md-4 idx2-trial-step">
                <span class="idx2-trial-step-num" aria-hidden="true">02</span>
                <h3 class="idx2-trial-step-title">İşletmenizde çalışır</h3>
                <p class="idx2-trial-step-text mb-0">Cihaz sizin hamurunuzda ve hattınızda test edilir; gerçek tempo ve kaliteyi yerinde görürsünüz.</p>
            </li>
            <li class="col-md-4 idx2-trial-step">
                <span class="idx2-trial-step-num" aria-hidden="true">03</span>
                <h3 class="idx2-trial-step-title">Karar netleşir</h3>
                <p class="idx2-trial-step-text mb-0">Performansı birlikte değerlendirirsiniz; satın alma kararı bu deneyimin üzerine oturur.</p>
            </li>
        </ol>
    </div>
</section>

<section class="idx2-trial-split" aria-label="Kendi hamurunuzda test">
    <div class="idx2-trial-split-visual">
        <img src="{{ $doughImg }}"
             alt="Fırından çıkmış taze simitler"
             width="1024"
             height="768"
             loading="lazy"
             decoding="async">
    </div>
    <div class="idx2-trial-split-copy">
        <h2 class="idx2-trial-split-title">Sizin hamurunuz,<br>sizin hattınız</h2>
        <p class="idx2-trial-split-text">
            Fuarlardaki kısa demolar yetmez. Asıl soru makinenin
            <strong>sizin reçetenizde</strong> ve günlük temponuzda nasıl çıktı verdiğidir.
            Deneme günü tam olarak bunu görmek içindir.
        </p>
        <ul class="idx2-trial-checks">
            <li>Gram aralığı ve form tutarlılığı</li>
            <li>Hattınıza yerleşim ve akış</li>
            <li>Eleman bağımlılığını azaltan pratik kullanım</li>
        </ul>
    </div>
</section>

<section class="idx2-trial-machine">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-6 order-lg-2">
                <div class="idx2-trial-machine-frame">
                    <img src="{{ $machineImg }}"
                         alt="Karesi Makine simit bağlama makinesi işletmede üretimde"
                         width="1024"
                         height="768"
                         loading="lazy"
                         decoding="async">
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <h2 class="idx2-ref-section-title text-start mb-3">Görmeden bağlanmayın</h2>
                <p class="idx2-page-lead px-0 mb-4">
                    Birçok işletme makineyi yerinde görmeden karar vermekte tereddüt eder.
                    Bu yüzden cihazı işletmenizde test etme imkânı sunuyoruz.
                </p>
                <div class="idx2-trial-kapora">
                    <span class="idx2-trial-kapora-label">Kapora</span>
                    <p class="mb-0">Yalnızca ulaşım ve kurulum giderleri için cüzi bir kapora talep ediyoruz. Amaç, deneme gününü planlı ve sorunsuz tamamlamak.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="idx2-trial-cta-band">
    <div class="container text-center">
        <h2 class="idx2-trial-cta-title mb-3">Deneme gününü birlikte planlayalım</h2>
        <p class="idx2-trial-cta-text mx-auto mb-4">
            Tarih ve detaylar için bizi hemen arayın; üretim akışınıza uygun şekilde ayarlayalım.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a class="btn idx2-hero-primary px-4" href="tel:+905315426368"><i class="bi bi-telephone me-2" aria-hidden="true"></i>(+90) 531 542 63 68</a>
            <a class="btn idx2-hero-secondary px-4" href="{{ $iletisimUrl }}">İletişim bilgileri</a>
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
            "@@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@@type": "ListItem",
                    "position": 1,
                    "name": "Ana sayfa",
                    "item": "{{ $seoSiteUrl }}/"
                },
                {
                    "@@type": "ListItem",
                    "position": 2,
                    "name": "Deneme",
                    "item": "{{ $seoCanonical }}"
                }
            ]
        },
        {
            "@@type": "WebPage",
            "@@id": "{{ $seoCanonical }}#webpage",
            "url": "{{ $seoCanonical }}",
            "name": {!! json_encode($seoTitle, JSON_UNESCAPED_UNICODE) !!},
            "description": {!! json_encode($seoDescription, JSON_UNESCAPED_UNICODE) !!},
            "isPartOf": { "@@id": "{{ $seoSiteUrl }}/#website" },
            "about": { "@@id": "{{ $seoSiteUrl }}/#organization" },
            "inLanguage": "tr-TR"
        },
        {
            "@@type": "Service",
            "name": "Simit makinesi işletmede deneme",
            "serviceType": "Yerinde ürün denemesi",
            "provider": { "@@id": "{{ $seoSiteUrl }}/#organization" },
            "areaServed": "TR",
            "description": {!! json_encode($seoDescription, JSON_UNESCAPED_UNICODE) !!},
            "url": "{{ $seoCanonical }}"
        }
    ]
}
</script>
@endpush
