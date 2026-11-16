<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public marketing site URL (canonical host)
    |--------------------------------------------------------------------------
    |
    | Preferred host for canonicals, Open Graph, JSON-LD, sitemap, and robots.
    | Must match the hostname that actually serves the site (no redirect loop).
    | Railway custom domain is apex → use https://karesimakine.com and 301
    | www → apex in Cloudflare.
    |
    */

    'site_url' => rtrim((string) env('SEO_SITE_URL', 'https://karesimakine.com'), '/'),

];
