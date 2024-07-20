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
            Css::make("codemirror5-css-cdn", "https://codemirror.net/5/lib/codemirror.css"),
            Css::make("showhint-css-cdn", "https://codemirror.net/5/addon/hint/show-hint.css"),
            Css::make("dracula-theme", "https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/dracula.min.css"),
            Js::make("codemirror5-js-cdn", "https://codemirror.net/5/lib/codemirror.js"),
            Js::make("matchbrackets-js-cdn", "https://codemirror.net/5/addon/edit/matchbrackets.js"),
            Js::make("sql-js-cdn", "https://codemirror.net/5/mode/sql/sql.js"),
            Js::make("showhint-js-cdn", "https://codemirror.net/5/addon/hint/show-hint.js"),
            Js::make("sqlhint-js-cdn", "https://codemirror.net/5/addon/hint/sql-hint.js"),
        ]);
    }

     public function register()
    {
        // Register any package services.
    }
}
