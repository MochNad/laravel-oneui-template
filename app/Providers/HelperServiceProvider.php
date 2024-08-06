<?php

namespace App\Providers;

use BreadCrumbHelper;
use Illuminate\Support\ServiceProvider;
use MenuHelper;
use ModeHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach (glob(app_path('Helpers') . '/*.php') as $file) {
            require_once $file;
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->share('helpers', [
            'mode' => ModeHelper::getMode(),
            'menus' => [
                'dashboard' => MenuHelper::getMenu('dashboard'),
                'landing' => MenuHelper::getMenu('landing'),
            ],
            'breadcrumb' => BreadCrumbHelper::getBreadcrumb(),
        ]);
    }
}
