<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        $this->activeLinks();
    }

    public function  activeLinks() {
        View::composer('layouts.app', function($view) {
            $view->with('homeLink', request()->is('/') ? 'menu-link__active' : '');
            $view->with('docsLink', (request()->is('docs') or request()->is('docs/*')) ? 'menu-link__active' : '');
            $view->with('themesLink', (request()->is('themes') or request()->is('themes/*'))  ? 'menu-link__active' : '');
            $view->with('selectedThemesLink', (request()->is('selected-themes') or request()->is('selected-themes/*')) ? 'menu-link__active' : '');
            $view->with('studentLink', (request()->is('student') or request()->is('student/*'))  ? 'menu-link__active' : '');
        });
        View::composer('app.student', function($view) {
            $view->with('homeLink', request()->is('/') ? 'menu-link__active' : '');
            $view->with('docsLink', (request()->is('docs') or request()->is('docs/*')) ? 'menu-link__active' : '');
            $view->with('themesLink', (request()->is('themes') or request()->is('themes/*'))  ? 'menu-link__active' : '');
            $view->with('selectedThemesLink', (request()->is('selected-themes') or request()->is('selected-themes/*')) ? 'menu-link__active' : '');
            $view->with('studentLink', (request()->is('student') or request()->is('student/*'))  ? 'menu-link__active' : '');
        });
    }
}
