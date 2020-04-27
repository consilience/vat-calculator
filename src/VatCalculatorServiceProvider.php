<?php

namespace Sprocketbox\VatCalculator;

/*
 * This file is part of Teamwork
 *
 * @license MIT
 * @package Teamwork
 */

use Illuminate\Config\Repository;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class VatCalculatorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
        $this->registerValidatorExtension();
        $this->registerRoutes();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();
        $this->registerVatCalculator();
        $this->registerFacade();
    }

    /**
     * Register the vault facade without the user having to add it to the app.php file.
     *
     * @return void
     */
    public function registerFacade()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('VatCalculator', 'Sprocketbox\VatCalculator\Facades\VatCalculator');
        });
    }

    /**
     * Publish Teamwork configuration.
     */
    protected function publishConfig()
    {
        // Publish config files
        $this->publishes([
            __DIR__ . '/../config/config.php'              => config_path('vat_calculator.php'),
            __DIR__ . '/../resources/js/vat_calculator.js' => public_path('js/vat_calculator.js'),
        ]);

        $this->publishes([
            __DIR__ . '/../resources/js/vat_calculator.js' => base_path('resources/assets/js/vat_calculator.js'),
        ], 'vatcalculator-spark');
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    protected function registerVatCalculator()
    {
        $this->app->bind('vatcalculator', VatCalculator::class);
        $this->app->alias('vatcalculator', VatCalculator::class);

        $this->app->bind(VatCalculator::class, static function ($app) {
            $config = $app->make(Repository::class);

            return new VatCalculator($config);
        });
    }

    /**
     * Merges user's and teamwork's configs.
     *
     * @return void
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'vat_calculator'
        );
    }

    protected function registerValidatorExtension()
    {
        $this->loadTranslationsFrom(
            __DIR__ . '/../lang',
            'vatnumber-validator'
        );

        $this->app['validator']->extend('vat_number',
            'Sprocketbox\VatCalculator\Validators\VatCalculatorValidatorExtension@validateVatNumber');
    }

    /**
     * Register predefined routes, used for the
     * handy javascript toolkit.
     */
    protected function registerRoutes()
    {
        $config = $this->app->make('Illuminate\Contracts\Config\Repository');
        if ($config->get('vat_calculator.use_routes', true)) {
            include __DIR__ . '/routes.php';
        }
    }
}
