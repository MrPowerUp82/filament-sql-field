<?php

namespace MrPowerUp\FilamentSqlField;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Support\ServiceProvider;

class FilamentSqlFieldServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-sql-field';

    public static string $viewNamespace = 'filament-sql-field';

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-sql-field');
    }
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Css::make("codemirror5-css-cdn", __DIR__ . '/../resources/css/codemirror.css'),
            Css::make("showhint-css-cdn", __DIR__ . '/../resources/css/show-hint.css'),
            Css::make("dracula-theme", __DIR__ . '/../resources/css/dracula.min.css'),
            Js::make("codemirror5-js-cdn", __DIR__ . '/../resources/js/codemirror.js'),
            Js::make("matchbrackets-js-cdn", __DIR__ . '/../resources/js/matchbrackets.js'),
            Js::make("sql-js-cdn", __DIR__ . '/../resources/js/sql.js'),
            Js::make("showhint-js-cdn", __DIR__ . '/../resources/js/show-hint.js'),
            Js::make("sqlhint-js-cdn", __DIR__ . '/../resources/js/sql-hint.js'),
        ]);
    }

     public function register()
    {
        // Register any package services.
    }
}
