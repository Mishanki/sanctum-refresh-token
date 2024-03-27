<?php

namespace Larahook\SanctumRefreshToken\Trait;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Larahook\SanctumRefreshToken\Repository\PersonalAccessTokenRepositoryInterface;
use Laravel\Sanctum\NewAccessToken;

trait AuthTokens
{
    /* @var $personalAccessTokenRepository PersonalAccessTokenRepositoryInterface */
    private PersonalAccessTokenRepositoryInterface $personalAccessTokenRepository;

    /**
     * @param User $user
     * @param string $deviceName
     * @param null|Carbon $accessTokenExpiresAt
     * @param null|Carbon $refreshTokenExpiresAt
     *
     * @return array
     */
    public function createTokens(
        User $user,
        string $deviceName,
        ?Carbon $accessTokenExpiresAt = null,
        ?Carbon $refreshTokenExpiresAt = null,
    ): array {
        $this->init();

        $accessToken = $user->createAuthToken($deviceName, $accessTokenExpiresAt);
        $refreshToken = $user->createRefreshToken($deviceName, $refreshTokenExpiresAt);

        $this->personalAccessTokenRepository->saveTokenPair(
            $accessToken->accessToken->getAttribute('id'),
            $refreshToken->accessToken->getAttribute('id'),
        );

        return [
            'access_token' => $accessToken->plainTextToken,
            'access_token_expiration' => $accessToken->accessToken->expires_at ?? null,
            'refresh_token' => $refreshToken->plainTextToken,
            'refresh_token_expiration' => $refreshToken->accessToken->expires_at ?? null,
        ];
    }

    private function init()
    {
        /* @var $personalAccessTokenRepository PersonalAccessTokenRepositoryInterface */
        $this->personalAccessTokenRepository = app()->make(PersonalAccessTokenRepositoryInterface::class);
    }
}
