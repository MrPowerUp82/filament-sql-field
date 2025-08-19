<?php

namespace MrPowerUp\FilamentSqlField;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSqlFieldServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-sql-field';

    public static string $viewNamespace = 'filament-sql-field';

    // public function boot()
    // {
    //     $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-sql-field');
    // }
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Css::make("codemirror5-css-cdn", __DIR__ . '/../resources/css/codemirror.css')->loadedOnRequest(),
            Js::make("codemirror5-js-cdn", __DIR__ . '/../resources/js/codemirror.js')->loadedOnRequest(),
            Css::make("showhint-css-cdn", __DIR__ . '/../resources/css/show-hint.css')->loadedOnRequest(),
            Css::make("dracula-theme", __DIR__ . '/../resources/css/dracula.min.css')->loadedOnRequest(),
            Css::make("fullscreen-css-mode", __DIR__ . '/../resources/css/fullscreen.min.css')->loadedOnRequest(),
            Js::make("showhint-js-cdn", __DIR__ . '/../resources/js/show-hint.js')->loadedOnRequest(),
            JS::make("fullscreen-js-mode", __DIR__ . '/../resources/js/fullscreen.min.js')->loadedOnRequest(),
            Js::make("matchbrackets-js-cdn", __DIR__ . '/../resources/js/matchbrackets.js')->loadedOnRequest(),
            Js::make("sql-js-cdn", __DIR__ . '/../resources/js/sql.js')->loadedOnRequest(),
            Js::make("sqlhint-js-cdn", __DIR__ . '/../resources/js/sql-hint.js')->loadedOnRequest(),
            Js::make("sql-formatter-js-cdn", __DIR__ . '/../resources/js/sql-formatter.min.js')->loadedOnRequest(),
            Js::make("sql-parser-js-cdn", __DIR__ . '/../resources/js/sqlParser.min.js')->loadedOnRequest(),
            Js::make("searchcursor-js-cdn", __DIR__ . '/../resources/js/searchcursor.js')->loadedOnRequest(),
            Js::make("mark-selection-js-cdn", __DIR__ . '/../resources/js/mark-selection.js')->loadedOnRequest(),
        ], 'mrpowerup/filament-sql-field');
    }

    // public function register()
    // {
    //     // Register any package services.
    // }
}
