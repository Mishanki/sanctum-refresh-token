<?php

namespace Larahook\SanctumRefreshToken\Repository;

use App\Models\User;
use Larahook\SanctumRefreshToken\Model\PersonalAccessToken;

interface PersonalAccessTokenRepositoryInterface
{
    public function saveTokenPair(int $accessTokenId, int $refreshTokenId): bool;

    public function getCurrentAccessToken(User $user): PersonalAccessToken;

    public function removeTokenById(User $user, int $id): bool;

    public function removeTokenByRefreshId(User $user, int $refreshId): bool;
}