<?php

namespace App\Providers;

use App\Services\TenantDatabaseService;
use HotwiredLaravel\TurboLaravel\Http\PendingTurboStreamResponse;
use HotwiredLaravel\TurboLaravel\Http\TurboResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('TenantDatabaseService', fn ($app) => new TenantDatabaseService);
    }

    public function boot(): void
    {
        DB::prohibitDestructiveCommands($this->app->isProduction());

        Model::unguard();

        Model::preventSilentlyDiscardingAttributes();

        Model::preventLazyLoading(! $this->app->isProduction());

        Model::preventAccessingMissingAttributes();

        if (! $this->app->isLocal() && ! $this->app->environment('testing')) {
            URL::forceScheme('https');
        }

        $this->loadViewsFrom(resource_path('turbo'), 'turbo');

        Blade::directive('tailwindcssVersion', function (): string {
            $path = public_path('dist/css/app.css');
            $version = is_file($path) ? filemtime($path) : null;

            return $version ? "?v={$version}" : '';
        });

        PendingTurboStreamResponse::macro('reload', fn () => TurboResponseFactory::makeStream('<turbo-stream action="refresh"></turbo-stream>')
        );
    }
}
