<?php

namespace Larahook\SanctumRefreshToken;

use Larahook\SanctumRefreshToken\Model\PersonalAccessToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class SanctumRefreshTokenServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sanctum-refresh-token.php', 'sanctum-refresh-token');
    }
    
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Sanctum::authenticateAccessTokensUsing(function ($token, $isValid): bool {
            return $isValid && $this->isTokenAbilityValid($token);
        });

        if ($this->app->runningInConsole()) {
            $this->registerMigrations();
            $this->publishes([
                __DIR__.'/../Migration' => database_path('migrations'),
            ], 'sanctum-migrations');
            $this->publishes([
                __DIR__ . '/../config/sanctum-refresh-token.php' => config_path('sanctum-refresh-token.php'),
            ], 'config');
        }
    }

    /**
     * @return void
     */
    protected function registerMigrations(): void
    {
        if (Sanctum::shouldRunMigrations()) {
            return $this->loadMigrationsFrom(__DIR__.'/../Migration');
        }
    }

    /**
     * @param PersonalAccessToken $token
     *
     * @return bool
     */
    private function isTokenAbilityValid(PersonalAccessToken $token): bool
    {
        $routeNames = config('sanctum-refresh-token.refresh_route_names');
        if (\is_string($routeNames)) {
            $routeNames = [$routeNames];
        }

        return collect($routeNames)->contains(Route::currentRouteName()) ?
           $this->isRefreshTokenValid($token) :
           $this->isAuthTokenValid($token);
    }

    /**
     * @param PersonalAccessToken $token
     *
     * @return bool
     */
    private function isAuthTokenValid(PersonalAccessToken $token): bool
    {
        return $token->can('auth') && $token->cant('refresh');
    }

    /**
     * @param PersonalAccessToken $token
     *
     * @return bool
     */
    private function isRefreshTokenValid(PersonalAccessToken $token): bool
    {
        return $token->can('refresh') && $token->cant('auth');
    }
}
