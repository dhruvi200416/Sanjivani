<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoogleTranslator
{
    protected static function httpOptions(): array
    {
        return [
            'timeout'         => 15,
            'connect_timeout' => 5,
            'verify'          => false,
        ];
    }

    public static function translate(?string $text, ?string $targetLocale = null, string $sourceLocale = 'en'): ?string
    {
        if (empty($text)) {
            return $text;
        }

        $targetLocale = $targetLocale ?? app()->getLocale();

        if ($targetLocale === $sourceLocale) {
            return $text;
        }

        $cacheKey = 'gtranslate_' . md5($sourceLocale . '|' . $targetLocale . '|' . $text);

        return Cache::rememberForever($cacheKey, function () use ($text, $targetLocale, $sourceLocale) {
            try {
                $tr = new GoogleTranslate($targetLocale);
                $tr->setSource($sourceLocale);
                $tr->setOptions(self::httpOptions());

                if (preg_match('/<[^>]+>/', $text)) {
                    return $tr->translateMarkup($text);
                }

                return $tr->translate($text);
            } catch (\Throwable $e) {
                Log::warning('GoogleTranslate failed: ' . $e->getMessage());
                return $text;
            }
        });
    }

    /**
     * Translate an array of strings in bulk.
     * Combines multiple strings into a single API request to prevent timeouts.
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

        // 1. Check Cache
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

        // 2. Translate uncached strings in a SINGLE bulk request
        if (!empty($uncached)) {
            try {
                // Combine all strings with a unique separator
                $separator = ' ||| ';
                $combinedText = implode($separator, array_values($uncached));

                // Truncate if the combined string exceeds Google's character limit (approx 5000 chars)
                if (strlen($combinedText) > 4500) {
                    $combinedText = substr($combinedText, 0, 4500);
                }

                $tr = new GoogleTranslate($targetLocale);
                $tr->setSource($sourceLocale);
                $tr->setOptions(self::httpOptions());

                // Make 1 single API call
                $translatedCombined = $tr->translate($combinedText);

                // Split the result back into an array using the separator
                $translatedArray = explode($separator, $translatedCombined);

                // Map the translated strings back to the original keys
                $i = 0;
                foreach ($uncached as $key => $originalText) {
                    // If the array split successfully, use it, otherwise fallback to original
                    $translated = isset($translatedArray[$i]) ? trim($translatedArray[$i]) : $originalText;

                    $results[$key] = $translated;
                    Cache::forever($uncachedKeys[$key], $translated);
                    $i++;
                }
            } catch (\Throwable $e) {
                Log::warning('GoogleTranslate batch failed: ' . $e->getMessage());
                // Fallback to original text for everything that failed
                foreach ($uncached as $key => $text) {
                    $results[$key] = $text;
                }
            }
        }

        return $results;
    }
}
