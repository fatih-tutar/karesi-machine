<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $siteUrl = config('seo.site_url');

        $body = <<<TXT
User-agent: *
Allow: /

Sitemap: {$siteUrl}/sitemap.xml

TXT;

        return response($body, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    public function sitemap(): Response
    {
        $siteUrl = config('seo.site_url');

        $urls = [
            ['loc' => $siteUrl.'/', 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => $siteUrl.'/iletisim', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $siteUrl.'/deneme', 'changefreq' => 'monthly', 'priority' => '0.85'],
            ['loc' => $siteUrl.'/referanslar', 'changefreq' => 'weekly', 'priority' => '0.85'],
        ];

        $entries = '';
        foreach ($urls as $url) {
            $entries .= <<<XML
    <url>
        <loc>{$url['loc']}</loc>
        <changefreq>{$url['changefreq']}</changefreq>
        <priority>{$url['priority']}</priority>
    </url>

XML;
        }

        $body = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{$entries}</urlset>

XML;

        return response($body, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
