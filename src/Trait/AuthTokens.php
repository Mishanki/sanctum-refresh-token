<?php

namespace Larahook\SanctumRefreshToken\Trait;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

trait AuthTokens
{
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
        $accessToken = $user->createAuthToken($deviceName, $accessTokenExpiresAt);
        $refreshToken = $user->createRefreshToken($deviceName, $refreshTokenExpiresAt);

        $accessTokenId = $accessToken->accessToken->getAttribute('id');
        $refreshTokenId = $refreshToken->accessToken->getAttribute('id');

        config('sanctum-refresh-token.personal_access_token_model')::whereId($accessTokenId)
            ->update(['refresh_id' => $refreshTokenId,]);

        return [
            'access_token' => $accessToken->plainTextToken,
            'access_token_expiration' => $accessToken->accessToken->expires_at ?? null,
            'refresh_token' => $refreshToken->plainTextToken,
            'refresh_token_expiration' => $refreshToken->accessToken->expires_at ?? null,
        ];
    }
}
