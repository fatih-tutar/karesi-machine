@extends('public.layouts.public', ['bodyClass' => 'index2 idx2-subpage'])

@section('content')
<section class="idx2-page-hero">
    <div class="idx2-hero-bg" aria-hidden="true">
        <div class="idx2-hero-bg-blob-tr"></div>
        <div class="idx2-hero-bg-blob-bl"></div>
        <div class="idx2-hero-bg-dots"></div>
        <div class="idx2-hero-bg-line"></div>
    </div>
    <div class="container py-4 py-lg-5">
        <nav class="idx2-breadcrumb mb-3" aria-label="Sayfa konumu">
            <a href="{{ url('/') }}">Ana sayfa</a>
            <span aria-hidden="true">/</span>
            <span>İletişim</span>
        </nav>
        <h1 class="idx2-page-title mb-3">İletişim</h1>
        <p class="idx2-page-lead col-lg-8 px-0 mb-0">
            Simit bağlama makinesi için kapasite, fiyat, yerleşim ve deneme takvimini birlikte netleştirelim.
            Hızlı yanıt için telefon veya WhatsApp üzerinden yazabilirsiniz.
        </p>
    </div>
</section>

<section class="idx2-section">
    <div class="container">
        <div class="row g-3 g-lg-4">
            <div class="col-md-6 col-xl-3">
                <a class="idx2-contact-tile" href="tel:+905315426368">
                    <span class="idx2-contact-icon" aria-hidden="true"><i class="bi bi-telephone"></i></span>
                    <span class="idx2-contact-label">Telefon</span>
                    <span class="idx2-contact-val">(+90) 531 542 63 68</span>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="idx2-contact-tile" href="https://wa.me/905315426368" target="_blank" rel="noopener">
                    <span class="idx2-contact-icon" aria-hidden="true"><i class="bi bi-whatsapp"></i></span>
                    <span class="idx2-contact-label">WhatsApp</span>
                    <span class="idx2-contact-val">Hızlı mesaj gönderin</span>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="idx2-contact-tile" href="mailto:bilgi@karesimakine.com">
                    <span class="idx2-contact-icon" aria-hidden="true"><i class="bi bi-envelope"></i></span>
                    <span class="idx2-contact-label">E-posta</span>
                    <span class="idx2-contact-val">bilgi@karesimakine.com</span>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="idx2-contact-tile" href="https://maps.app.goo.gl/PCabcCgTYx7YZbFv5" target="_blank" rel="noopener">
                    <span class="idx2-contact-icon" aria-hidden="true"><i class="bi bi-geo-alt"></i></span>
                    <span class="idx2-contact-label">Adres</span>
                    <span class="idx2-contact-val">Astro Rezidans A Blok No:2/32</span>
                    <span class="idx2-contact-sub">Beylikdüzü / İstanbul</span>
                </a>
            </div>
        </div>

        <div class="row g-4 g-lg-5 mt-1 mt-lg-2 align-items-stretch">
            <div class="col-lg-5">
                <div class="idx2-contact-panel h-100">
                    <h2 class="idx2-contact-panel-title">Nasıl yardımcı oluruz?</h2>
                    <ul class="idx2-contact-list mb-4">
                        <li>Simit makinesi fiyatları ve taksit seçenekleri</li>
                        <li>İşletmenizde deneme planlaması</li>
                        <li>Kurulum, yerleşim ve kapasite danışmanlığı</li>
                        <li>Yedek parça ve teknik destek</li>
                    </ul>
                    <p class="idx2-contact-note mb-4">
                        Detaylı bilgi için bizi hemen arayabilirsiniz; talebinizi birlikte netleştiririz.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn idx2-hero-primary px-4" href="tel:+905315426368"><i class="bi bi-telephone me-2" aria-hidden="true"></i>Hemen ara</a>
                        <a class="btn idx2-cta-wa px-4" href="https://wa.me/905315426368" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-2" aria-hidden="true"></i>WhatsApp</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="idx2-contact-map-wrap">
                    <iframe
                        class="idx2-contact-map"
                        title="Karesi Makine konum haritası — Beylikdüzü İstanbul"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                        src="https://www.google.com/maps?q=Marmara+mah.+9.+sk.+Astro+Rezidans+Beylikd%C3%BCz%C3%BC+%C4%B0stanbul&output=embed">
                    </iframe>
                </div>
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
                    "name": "İletişim",
                    "item": "{{ $seoCanonical }}"
                }
            ]
        },
        {
            "@@type": "ContactPage",
            "@@id": "{{ $seoCanonical }}#contactpage",
            "url": "{{ $seoCanonical }}",
            "name": {!! json_encode($seoTitle, JSON_UNESCAPED_UNICODE) !!},
            "description": {!! json_encode($seoDescription, JSON_UNESCAPED_UNICODE) !!},
            "isPartOf": { "@@id": "{{ $seoSiteUrl }}/#website" },
            "about": { "@@id": "{{ $seoSiteUrl }}/#organization" },
            "inLanguage": "tr-TR"
        },
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
            "contactPoint": {
                "@@type": "ContactPoint",
                "telephone": "+90-531-542-63-68",
                "contactType": "sales",
                "areaServed": "TR",
                "availableLanguage": ["tr"]
            }
        }
    ]
}
</script>
@endpush
