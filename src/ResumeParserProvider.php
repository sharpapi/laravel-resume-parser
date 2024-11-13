<?php

declare(strict_types=1);

namespace SharpAPI\ResumeParser;

use Illuminate\Support\ServiceProvider;

/**
 * @api
 */
class ResumeParserProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/sharpapi-resume-parser.php' => config_path('sharpapi-resume-parser.php'),
            ], 'sharpapi-resume-parser');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Merge the package configuration with the app configuration.
        $this->mergeConfigFrom(
            __DIR__.'/../config/sharpapi-resume-parser.php', 'sharpapi-resume-parser'
        );
    }
}
