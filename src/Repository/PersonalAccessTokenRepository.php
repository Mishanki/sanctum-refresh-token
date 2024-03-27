<?php

namespace Larahook\SanctumRefreshToken\Repository;

use App\Models\User;
use Larahook\SanctumRefreshToken\Model\PersonalAccessToken;

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

    /**
     * @param User $user
     *
     * @return PersonalAccessToken
     */
    public function getCurrentAccessToken(User $user): PersonalAccessToken
    {
        /* @var PersonalAccessToken */
        return $user->currentAccessToken();
    }

    /**
     * @param User $user
     * @param int $id
     *
     * @return bool
     */
    public function removeTokenById(User $user, int $id): bool
    {
        return (bool) config('sanctum-refresh-token.personal_access_token_model')::whereId($id)
            ->whereTokenableType($user::class)
            ->whereTokenableId($user->id)
            ->delete()
            ;
    }

    /**
     * @param User $user
     * @param int $refreshId
     *
     * @return bool
     */
    public function removeTokenByRefreshId(User $user, int $refreshId): bool
    {
        return (bool) config('sanctum-refresh-token.personal_access_token_model')::whereRefreshId($refreshId)
            ->whereTokenableType($user::class)
            ->whereTokenableId($user->id)
            ->delete()
            ;
    }
}