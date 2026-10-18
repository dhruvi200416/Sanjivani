<?php

use App\Services\GoogleTranslator;

if (!function_exists('gtrans')) {
    /**
     * Auto-translate any text to the current locale.
     * Falls back to the original if anything fails.
     */
    function gtrans(?string $text): ?string
    {
        return GoogleTranslator::translate($text);
    }
}

if (!function_exists('dbtrans')) {
    /**
     * Translate a DB field with locale-aware column support.
     *
     * Priority:
     *  1. Localized column (e.g. story_heading_gu) if it exists and has a value
     *  2. Auto-translate the base column value
     *  3. Fallback value
     */
    function dbtrans($model, string $field, $fallback = null)
    {
        $locale = app()->getLocale();
        $localizedField = $field . '_' . $locale;

        // 1. Localized column takes priority (manual override)
        if (isset($model->$localizedField) && !empty($model->$localizedField)) {
            return $model->$localizedField;
        }

        // 2. Auto-translate base column
        $value = $model->$field ?? null;
        if (!empty($value)) {
            return GoogleTranslator::translate($value);
        }

        // 3. Fallback
        return $fallback;
    }
}
