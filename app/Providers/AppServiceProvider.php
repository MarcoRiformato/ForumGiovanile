<?php

namespace App\Providers;
use App\Models\Ad;
use App\Models\Media;
use Inertia\Inertia;
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
    public function boot()
    {
        Inertia::share([
            'ads' => function () {
                return Ad::with('media')->get()->map(function ($ad) {
                    return [
                        'id' => $ad->id,
                        'title' => $ad->title,
                        'priority' => $ad->priority,
                        'media' => $ad->media
                    ];
                });
            },
        ]);
    }
}
