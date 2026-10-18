<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoogleTranslator
{
    /**
     * Shared options for the Guzzle HTTP client used by GoogleTranslate.
     * Prevents requests from hanging until PHP's max_execution_time kills them.
     */
    protected static function httpOptions(): array
    {
        return [
            'timeout'         => 10,   // 10 seconds max for the whole request
            'connect_timeout' => 5,    // 5 seconds to establish connection
            'verify'          => false, // skip SSL verification (helps on local dev / Windows)
        ];
    }

    /**
     * Translate text from English to the current locale.
     * Uses caching so repeated strings don't hit Google every time.
     */
    public static function translate(?string $text, ?string $targetLocale = null, string $sourceLocale = 'en'): ?string
    {
        if (empty($text)) {
            return $text;
        }

        $targetLocale = $targetLocale ?? app()->getLocale();

        // Don't translate if source == target (already in that language)
        if ($targetLocale === $sourceLocale) {
            return $text;
        }

        // Cache key: unique per text + locale combination
        $cacheKey = 'gtranslate_' . md5($sourceLocale . '|' . $targetLocale . '|' . $text);

        return Cache::rememberForever($cacheKey, function () use ($text, $targetLocale, $sourceLocale) {
            try {
                $tr = new GoogleTranslate($targetLocale);
                $tr->setSource($sourceLocale);
                $tr->setOptions(self::httpOptions());

                // If text contains HTML, translate the inner text only
                if (preg_match('/<[^>]+>/', $text)) {
                    return $tr->translateMarkup($text);
                }

                return $tr->translate($text);
            } catch (\Throwable $e) {
                // If translation fails, return original text
                Log::warning('GoogleTranslate failed: ' . $e->getMessage());
                return $text;
            }
        });
    }

    /**
     * Translate a whole array of strings in bulk (fewer API calls).
     */
    public static function translateBatch(array $texts, ?string $targetLocale = null, string $sourceLocale = 'en'): array
    {
        $targetLocale = $targetLocale ?? app()->getLocale();
        if ($targetLocale === $sourceLocale) {
            return $texts;
        }

        $results = [];
        $uncached = [];
        $uncachedKeys = [];

        // First pass: fetch cached values
        foreach ($texts as $key => $text) {
            if (empty($text)) {
                $results[$key] = $text;
                continue;
            }
            $cacheKey = 'gtranslate_' . md5($sourceLocale . '|' . $targetLocale . '|' . $text);
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                $results[$key] = $cached;
            } else {
                $uncached[$key] = $text;
                $uncachedKeys[$key] = $cacheKey;
            }
        }

        // Second pass: hit Google for uncached items
        if (!empty($uncached)) {
            try {
                $tr = new GoogleTranslate($targetLocale);
                $tr->setSource($sourceLocale);
                $tr->setOptions(self::httpOptions());

                foreach ($uncached as $key => $text) {
                    try {
                        $translated = $tr->translate($text);
                    } catch (\Throwable $innerEx) {
                        // If a single string fails, fall back to the original
                        Log::warning('GoogleTranslate per-item failed for key "' . $key . '": ' . $innerEx->getMessage());
                        $translated = $text;
                    }

                    $results[$key] = $translated;
                    Cache::forever($uncachedKeys[$key], $translated);
                }
            } catch (\Throwable $e) {
                Log::warning('GoogleTranslate batch failed: ' . $e->getMessage());
                foreach ($uncached as $key => $text) {
                    $results[$key] = $text;
                }
            }
        }

        return $results;
    }
}