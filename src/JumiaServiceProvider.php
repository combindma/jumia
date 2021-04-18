<?php

namespace Combindma\Jumia;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class JumiaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('jumia')
            ->hasConfigFile()
            ->hasViews();
    }

    public function registeringPackage()
    {
        $this->app->singleton('jumia', function () {
            return new Jumia();
        });
    }
}
