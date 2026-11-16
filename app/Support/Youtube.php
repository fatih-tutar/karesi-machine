<?php

namespace App\Support;

class Youtube
{
    /**
     * Extract a YouTube video id from an embed / watch / youtu.be URL.
     */
    public static function extractId(?string $url): ?string
    {
        if (! is_string($url) || $url === '') {
            return null;
        }

        if (preg_match('~/embed/([a-zA-Z0-9_-]{6,})~', $url, $m)) {
            return $m[1];
        }

        if (preg_match('~[?&]v=([a-zA-Z0-9_-]{6,})~', $url, $m)) {
            return $m[1];
        }

        if (preg_match('~youtu\.be/([a-zA-Z0-9_-]{6,})~', $url, $m)) {
            return $m[1];
        }

        if (preg_match('~/shorts/([a-zA-Z0-9_-]{6,})~', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}
