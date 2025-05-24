<?php
use App\Filament\Pages\StoreFrontPage;
use App\Filament\Pages\CartPage;
use App\Filament\Pages\CheckoutPage;

return [


    'resources' => [
        // List only the resources you want
        \App\Filament\Resources\UserResource::class,
        \App\Filament\Resources\OrderResource::class,
        \App\Filament\Resources\ProductResource::class,
        \App\Filament\Resources\CategoryResource::class,
        // etc.
    ],

    'pages' => [
        // Core pages you keep:
        \Filament\Pages\Dashboard::class,
        \Jeffgreco13\FilamentBreezy\Pages\MyProfilePage::class,

        // Your new LangPage
        \App\Filament\Pages\LangPage::class,
    ],

    'widgets' => [
        // ...
    ]

    // ...
];
