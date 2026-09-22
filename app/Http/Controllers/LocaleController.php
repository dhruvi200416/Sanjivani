<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['en', 'gu'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }
        return back();
    }
}