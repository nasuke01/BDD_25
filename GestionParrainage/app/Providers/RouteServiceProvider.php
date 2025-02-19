<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Namespace par défaut pour les contrôleurs.
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Limite de requêtes API par minute
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // Chargement des routes API
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)  // ✅ Ajout du namespace
                ->group(base_path('routes/api.php'));

            // Chargement des routes Web
            Route::middleware('web')
                ->namespace($this->namespace)  // ✅ Ajout du namespace
                ->group(base_path('routes/web.php'));
        });
    }
}
