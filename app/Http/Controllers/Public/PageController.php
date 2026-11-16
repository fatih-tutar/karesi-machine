<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\ReferenceVideoService;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function trial(): View
    {
        $siteUrl = config('seo.site_url');

        return view('public.pages.deneme', [
            'seoTitle' => 'İşletmede Deneme | Simit Makinesi Yerinde Test — Karesi Makine',
            'seoDescription' => 'Simit makinesini satın almadan önce kendi hamurunuzda ve üretim hattınızda deneyin. Karesi Makine işletmede deneme imkânı sunar; tarih için hemen arayın.',
            'seoOgTitle' => 'İşletmede Deneme | Karesi Makine',
            'seoKeywords' => 'simit makinesi deneme, işletmede deneme, simit makinası test, yerinde deneme, karesi makine deneme',
            'seoCanonical' => $siteUrl.'/deneme',
            'seoOgImage' => $siteUrl.'/img/deneme-hero.jpg',
            'seoSiteUrl' => $siteUrl,
            'skipHeroPreload' => true,
            'navActive' => 'deneme',
            'heroBg' => asset('img/deneme-hero.jpg'),
            'heroBgMobile' => asset('img/deneme-hero-mobile.jpg'),
            'doughImg' => asset('img/deneme-dough.jpg'),
            'machineImg' => asset('img/deneme-machine.jpg'),
            'denemeUrl' => url('/deneme'),
            'iletisimUrl' => url('/iletisim'),
        ]);
    }

    public function references(ReferenceVideoService $referenceVideos): View
    {
        $siteUrl = config('seo.site_url');
        $refVideos = $referenceVideos->all();

        return view('public.pages.referanslar', [
            'seoTitle' => 'Referanslar | Simit Makinesi Videoları — Karesi Makine',
            'seoDescription' => 'Karesi Makine referans videoları: işletmelerde çalışan simit makinesi ve simit makinası uygulamalarını izleyin. Yerinde kurulum ve üretim görüntüleri.',
            'seoOgTitle' => 'Referanslar | Karesi Makine',
            'seoKeywords' => 'simit makinesi referans, simit makinası video, karesi makine referanslar, simit bağlama makinesi video',
            'seoCanonical' => $siteUrl.'/referanslar',
            'seoOgImage' => $siteUrl.'/img/makina-1100.png',
            'seoSiteUrl' => $siteUrl,
            'skipHeroPreload' => true,
            'navActive' => 'referanslar',
            'refVideos' => $refVideos,
            'refActiveId' => $refVideos[0]['id'] ?? '',
            'refActiveLabel' => $refVideos[0]['label'] ?? 'Referans videosu',
            'refCount' => count($refVideos),
        ]);
    }

    public function contact(): View
    {
        $siteUrl = config('seo.site_url');

        return view('public.pages.iletisim', [
            'seoTitle' => 'İletişim | Karesi Makine — Simit Makinesi Teklif ve Destek',
            'seoDescription' => 'Karesi Makine iletişim: telefon, WhatsApp, e-posta ve Beylikdüzü / İstanbul adresi. Simit makinesi fiyatları, deneme ve kurulum için bize ulaşın.',
            'seoOgTitle' => 'İletişim | Karesi Makine',
            'seoKeywords' => 'karesi makine iletişim, simit makinesi iletişim, simit makinası teklif, beylikdüzü simit makinesi',
            'seoCanonical' => $siteUrl.'/iletisim',
            'seoOgImage' => $siteUrl.'/img/makina-1100.png',
            'seoSiteUrl' => $siteUrl,
            'skipHeroPreload' => true,
            'navActive' => 'iletisim',
        ]);
    }
}
