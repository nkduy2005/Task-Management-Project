<?php

namespace App\Providers;

use App\Models\User;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\Facades\Gate;
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
        Gate::define("task", function (User $user, $id) {
            return $user->id == $id;
        });
        Scramble::afterOpenApiGenerated(function (OpenApi $open) {
            $open->secure(
                SecurityScheme::http("bearer", "BearerAuth")
            );
        });
    }
}
