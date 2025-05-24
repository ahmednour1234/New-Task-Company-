<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LangPage extends Page
{
    // URL: /admin/lang
    protected static ?string $slug = 'lang';

    // Blade view to render
    protected static string $view = 'filament.pages.lang-page';

    // Sidebar navigation
    protected static ?string $navigationIcon  = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'اللغات';
    protected static ?string $navigationGroup = 'الإعدادات';
    protected static ?int    $navigationSort  = 2;

    public static function canAccess(): bool
    {
        return true;
    }

    protected function getViewData(): array
    {
        return [
            // Adjust this to match your locales config
            'locales' => config('app.locales', ['en', 'ar']),
        ];
    }
}
