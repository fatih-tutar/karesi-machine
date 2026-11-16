<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\ReferenceVideoService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(ReferenceVideoService $referenceVideos): View
    {
        $seoFaqs = [
            [
                'question' => 'Simit makinesi fiyatları ne kadar?',
                'answer' => 'Karesi Makine simit bağlama makinesi liste fiyatı 230.000 TL\'dir. Kapasite, gram aralığı ve kurulum detaylarına göre fiyat değişebilir; güncel teklif ve taksit seçenekleri için telefon veya WhatsApp üzerinden iletişime geçebilirsiniz.',
            ],
            [
                'question' => 'Otomatik simit makinası saatlik kaç adet üretir?',
                'answer' => 'Karesi Makine otomatik simit yapma makinası saatlik 3600 adete kadar simit üretim kapasitesi sunar. 25–150 gr aralığında siparişe özel ayar yapılabilir.',
            ],
            [
                'question' => 'Simit bağlama makinesi nedir?',
                'answer' => 'Simit bağlama makinesi, hamur fitilini otomatik olarak simit formuna getiren endüstriyel ekipmandır. Karesi Makine simit makineleri bu aşamada yüksek tempo ve tekrarlanabilir kalite sağlar.',
            ],
            [
                'question' => 'Sahibinden veya ikinci el simit makinası yerine neden sıfır makine?',
                'answer' => 'Sahibinden ikinci el simit makinası arayan işletmeler için sıfır makinede garanti, yedek parça desteği ve işletmenizde deneme imkânı sunuyoruz. Böylece üretim hattınıza uygunluğu satın almadan önce birlikte test edebilirsiniz.',
            ],
            [
                'question' => 'Simit fitil makinesi ile bağlama makinesi arasındaki fark nedir?',
                'answer' => 'Simit fitil makinesi hamur şeridini hazırlar; simit bağlama makinesi ise bu fitili simit formuna getirir. Karesi Makine olarak simit üretiminde otomatik bağlama aşamasına odaklanıyoruz.',
            ],
            [
                'question' => 'Simit yapma makinası işletmemde denenebilir mi?',
                'answer' => 'Evet. Simit yapma makinasını kendi hamurunuz ve üretim hattınızda test etmeniz için işletmenizde deneme imkânı sunuyoruz. Tarih planlaması için iletişime geçmeniz yeterli.',
            ],
        ];

        // Short promo videos for social media (separate from the main slider).
        $promoShorts = [
            ['id' => 'i9PLMLubxsQ', 'label' => 'Hatay Simit Makinesi'],
            ['id' => 'XHJkKeMrxAM', 'label' => 'Gölcük Pişi Makinesi'],
            ['id' => 'QjArjJeqMuk', 'label' => 'Edirne Simit Makinası'],
            ['id' => 'Pgs8HjbeRPo', 'label' => 'Üsküdar Simit Makinesi'],
            ['id' => 'LrcmMnsaYsA', 'label' => 'Antalya Simit Makinası'],
            ['id' => 'mno2wtIEp_I', 'label' => 'Simit Bağlama Makineleri'],
            ['id' => '0r7bZNQOLf4', 'label' => 'Simit Bağlama Makinaları'],
            ['id' => 'ZlS5KSIf35k', 'label' => 'Sıcak Pekmez Simit Makinası'],
        ];

        $promoVideos = [];
        foreach ($promoShorts as $short) {
            $id = trim((string) ($short['id'] ?? ''));
            if ($id === '') {
                continue;
            }
            $format = strtolower(trim((string) ($short['format'] ?? '')));
            if (! in_array($format, ['vertical', 'horizontal'], true)) {
                $format = 'vertical';
            }
            $promoVideos[] = [
                'id' => $id,
                'label' => trim((string) ($short['label'] ?? 'Tanitim Videosu')),
                'format' => $format,
            ];
        }

        $videos = $referenceVideos->all();

        // Opening video: prefer the 3rd one so desktop side cards are filled.
        $defaultId = '';
        if ($videos !== []) {
            $defaultId = (string) $videos[count($videos) >= 3 ? 2 : 0]['id'];
        }

        $faqSchema = array_map(static fn (array $faq): array => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ], $seoFaqs);

        $siteUrl = config('seo.site_url');

        return view('public.pages.home', [
            'seoTitle' => 'Simit Makinesi Fiyatları | Otomatik Simit Bağlama Makinası — Karesi Makine',
            'seoDescription' => 'Simit makinesi ve otomatik simit yapma makinası üreticisi. Simit bağlama makineleri, simit makinası fiyatları ve işletmenizde deneme imkânı. Karesi Makine — İstanbul.',
            'seoOgTitle' => 'Simit Makinesi & Otomatik Simit Yapma Makinası | Karesi Makine',
            'seoKeywords' => 'simit makinesi, simit makinası, simit makinesi fiyatları, simit makinası fiyatları, otomatik simit makinesi, simit yapma makinası, simit makineleri, simit bağlama makinası',
            'seoCanonical' => $siteUrl.'/',
            'seoOgImage' => $siteUrl.'/img/makina-1100.png',
            'seoSiteUrl' => $siteUrl,
            'seoProductPrice' => 230000,
            'seoFaqs' => $seoFaqs,
            'faqSchema' => $faqSchema,
            'heroPreload' => asset('img/makina-720.png'),
            'heroPreloadDesktop' => asset('img/makina-1100.png'),
            'navActive' => 'home',
            'idx2Videos' => $videos,
            'idx2DefaultId' => $defaultId,
            'idx2PromoVideos' => $promoVideos,
        ]);
    }
}
