@php
    $seoSiteUrl = 'https://www.karesimakine.com';
    $seoCanonical = $seoCanonical ?? rtrim($seoSiteUrl, '/') . '/';
    $seoTitle = $seoTitle ?? 'Simit Bağlama Makinesi | Karesi Makine';
    $seoDescription = $seoDescription ?? 'Simit bağlama makinesi — yüksek kapasite, işletmenizde deneme imkânı. Karesi Makine.';
    $seoOgImage = $seoOgImage ?? $seoSiteUrl . '/img/makina-1100.png';
    $seoOgTitle = $seoOgTitle ?? $seoTitle;
    $heroPreloadMobile = $heroPreload ?? asset('img/makina-720.jpg');
    $heroPreloadDesktop = $heroPreloadDesktop ?? asset('img/makina-1100.jpg');
    $criticalCssPath = resource_path('views/public/partials/critical-public.css');
    $layoutCssPath = public_path('css/idx2-layout.css');
@endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
@if (empty($skipHeroPreload))
    <link rel="preload" as="image" href="{{ $heroPreloadMobile }}" media="(max-width: 991.98px)" fetchpriority="high" type="image/png">
    <link rel="preload" as="image" href="{{ $heroPreloadDesktop }}" media="(min-width: 992px)" fetchpriority="high" type="image/png">
@endif
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="tr">
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
@if (! empty($seoKeywords))
    <meta name="keywords" content="{{ $seoKeywords }}">
@endif
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $seoCanonical }}">
    <meta name="theme-color" content="#eef3f9">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="tr_TR">
    <meta property="og:site_name" content="Karesi Makine">
    <meta property="og:title" content="{{ $seoOgTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoOgImage }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoOgTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoOgImage }}">

    <link rel="icon" type="image/png" href="{{ asset('img/mavilogo-3.png') }}">

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://img.youtube.com">

    <style>{!! is_readable($criticalCssPath) ? file_get_contents($criticalCssPath) : '' !!}{!! is_readable($layoutCssPath) ? file_get_contents($layoutCssPath) : '' !!}</style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style-public.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" crossorigin="anonymous" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css"></noscript>
