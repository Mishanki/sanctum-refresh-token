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

        # Repositories
        $this->app->bind(\Larahook\SanctumRefreshToken\Repository\PersonalAccessTokenRepositoryInterface::class, \Larahook\SanctumRefreshToken\Repository\PersonalAccessTokenRepository::class);
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
            $this->publishes([
                __DIR__.'/../src/Migration' => database_path('migrations'),
            ], 'migrations');
            $this->publishes([
                __DIR__ . '/../config/sanctum-refresh-token.php' => config_path('sanctum-refresh-token.php'),
            ], 'config');
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
