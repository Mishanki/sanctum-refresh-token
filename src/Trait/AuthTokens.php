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
    public function createTokenPair(
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

    /**
     * @param User $user
     *
     * @return bool
     */
    public function logoutTokenPair(User $user): bool
    {
        $this->init();

        $refreshToken = $this->personalAccessTokenRepository->getCurrentAccessToken($user);
        $refreshId = $refreshToken->getAttribute('refresh_id');
        $isCurrentDeleted = $refreshToken->delete();
        $isRefreshDeleted = $this->personalAccessTokenRepository->removeTokenById($user, $refreshId);

        return $isCurrentDeleted && $isRefreshDeleted;
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function refreshTokenPair(User $user): array
    {
        $this->init();

        $personalAccessTokenModel = $this->personalAccessTokenRepository->getCurrentAccessToken($user);
        $deviceName = $personalAccessTokenModel->getAttribute('name');

        $this->logoutRefreshToken($user);

        return $this->createTokenPair($user, $deviceName);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    private function logoutRefreshToken(User $user): bool
    {
        $refreshToken = $this->personalAccessTokenRepository->getCurrentAccessToken($user);
        $refreshId = $refreshToken->getAttribute('id');

        $isCurrentDeleted = $this->personalAccessTokenRepository->removeTokenByRefreshId($user, $refreshId);
        $isRefreshDeleted = $refreshToken->delete();

        return $isCurrentDeleted && $isRefreshDeleted;
    }

    private function init()
    {
        /* @var $personalAccessTokenRepository PersonalAccessTokenRepositoryInterface */
        $this->personalAccessTokenRepository = app()->make(PersonalAccessTokenRepositoryInterface::class);
    }
}
