<?php

namespace Larahook\SanctumRefreshToken\Repository;

class PersonalAccessTokenRepository implements PersonalAccessTokenRepositoryInterface
{
    /**
     * @param int $accessTokenId
     * @param int $refreshTokenId
     *
     * @return bool
     */
    public function saveTokenPair(int $accessTokenId, int $refreshTokenId): bool
    {
        return (bool) config('sanctum-refresh-token.personal_access_token_model')::whereId($accessTokenId)->update([
            'refresh_id' => $refreshTokenId,
        ]);
    }
}