<?php

namespace App\Providers;

use App\Models\AboutContent;
use App\Models\HomeContent;
use App\Models\MenuItem;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // The admin panel / file manager / Livewire requests don't render the public
        // layout, so skip all of its DB queries there to keep the panel fast.
        $request = request();
        if ($request && $request->is('admin', 'admin/*', 'livewire/*', 'filemanager/*')) {
            View::share('settings', []);
            View::share('about', null);
            View::share('home', null);
            View::share('menuHeader', collect());
            View::share('menuFooterCompany', collect());
            View::share('menuFooterQuick', collect());

            return;
        }

        // Make site settings available to every view as $settings.
        View::share('settings', $this->loadSettings());

        // Make the About-page content available to every view as $about.
        View::share('about', $this->loadAbout());

        // Make the editable home-section text available to every view as $home.
        View::share('home', $this->loadHome());

        // Make the editable menus available to every view.
        $menus = $this->loadMenus();
        View::share('menuHeader', $menus['header']);
        View::share('menuFooterCompany', $menus['footer_company']);
        View::share('menuFooterQuick', $menus['footer_quick']);
    }

    private function loadMenus(): array
    {
        $empty = ['header' => collect(), 'footer_company' => collect(), 'footer_quick' => collect()];

        try {
            if (Schema::hasTable('menu_items')) {
                return [
                    'header' => MenuItem::active()->whereNull('parent_id')->where('location', 'header')
                        ->with(['page', 'children.page'])->orderBy('sort')->get(),
                    'footer_company' => MenuItem::active()->where('location', 'footer_company')->with('page')->orderBy('sort')->get(),
                    'footer_quick' => MenuItem::active()->where('location', 'footer_quick')->with('page')->orderBy('sort')->get(),
                ];
            }
        } catch (\Throwable $e) {
            // DB not ready — fall through.
        }

        return $empty;
    }

    private function loadHome(): ?HomeContent
    {
        try {
            if (Schema::hasTable('home_contents')) {
                return HomeContent::singleton();
            }
        } catch (\Throwable $e) {
            // DB not ready — fall through.
        }

        return null;
    }

    private function loadAbout(): ?AboutContent
    {
        try {
            if (Schema::hasTable('about_contents')) {
                return AboutContent::singleton();
            }
        } catch (\Throwable $e) {
            // DB not ready — fall through.
        }

        return null;
    }

    private function loadSettings(): array
    {
        try {
            if (Schema::hasTable('site_settings')) {
                return SiteSetting::map();
            }
        } catch (\Throwable $e) {
            // DB not ready (e.g. during migrate / no connection) — fall through.
        }

        return [];
    }
}
