<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Port of getUsdRate() from the legacy karesi helper/function.php.
 *
 * Looks up the TCMB (Central Bank of Turkey) USD/TRY forex selling rate for a date,
 * walking back over weekends/holidays (at most 10 days). Successful lookups are cached
 * (historical rates never change); if TCMB is unreachable the service stops trying for
 * the rest of the request so pages stay responsive.
 */
class TcmbExchangeRate
{
    /** @var array<string, float|false> */
    private array $memo = [];

    private bool $unreachable = false;

    /**
     * Rate for a date only if it is already cached (never hits the network).
     */
    public function getCachedUsdRate(string $date): ?float
    {
        try {
            $key = 'tcmb_usd_rate:'.Carbon::parse($date)->format('Y-m-d');
        } catch (Throwable) {
            return null;
        }

        $cached = Cache::get($key);

        return is_numeric($cached) && (float) $cached > 0 ? (float) $cached : null;
    }

    /**
     * @return float|false USD/TRY forex selling rate, or false when unavailable.
     */
    public function getUsdRate(string $date): float|false
    {
        if (array_key_exists($date, $this->memo)) {
            return $this->memo[$date];
        }

        try {
            $day = Carbon::parse($date)->startOfDay();
        } catch (Throwable) {
            return false;
        }

        $cacheKey = 'tcmb_usd_rate:'.$day->format('Y-m-d');
        $cached = Cache::get($cacheKey);

        if (is_numeric($cached) && (float) $cached > 0) {
            return $this->memo[$date] = (float) $cached;
        }

        // Recently failed lookups (no data / TCMB down) are not retried on every page load.
        $missKey = $cacheKey.':miss';

        if ($this->unreachable || Cache::has('tcmb_usd_unreachable') || Cache::has($missKey)) {
            return $this->memo[$date] = false;
        }

        // Look back at most 10 days.
        for ($i = 0; $i < 10; $i++) {
            if ($day->isSaturday()) {
                $day = $day->subDay();
            } elseif ($day->isSunday()) {
                $day = $day->subDays(2);
            }

            $url = sprintf(
                'https://www.tcmb.gov.tr/kurlar/%s/%s.xml',
                $day->format('Ym'),
                $day->format('dmY'),
            );

            try {
                $rate = $this->fetchUsd($url);
            } catch (ConnectionException) {
                $this->unreachable = true;
                Cache::put('tcmb_usd_unreachable', true, now()->addMinutes(5));

                return $this->memo[$date] = false;
            }

            if ($rate !== null) {
                Cache::forever($cacheKey, $rate);

                return $this->memo[$date] = $rate;
            }

            $day = $day->subDay();
        }

        Cache::put($missKey, true, now()->addMinutes(30));

        return $this->memo[$date] = false;
    }

    /**
     * @throws ConnectionException
     */
    private function fetchUsd(string $url): ?float
    {
        $response = Http::connectTimeout(8)->timeout(10)->get($url);

        if (! $response->successful() || $response->body() === '') {
            return null;
        }

        $xml = @simplexml_load_string($response->body());

        if (! $xml) {
            return null;
        }

        foreach ($xml->Currency as $currency) {
            if ((string) $currency['CurrencyCode'] === 'USD') {
                $value = (float) str_replace(',', '.', (string) $currency->ForexSelling);

                if ($value > 0) {
                    return $value;
                }
            }
        }

        return null;
    }
}
