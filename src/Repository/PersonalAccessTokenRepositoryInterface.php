<?php

namespace Larahook\SanctumRefreshToken\Repository;

use App\Models\User;
use Larahook\SanctumRefreshToken\Model\PersonalAccessToken;

interface PersonalAccessTokenRepositoryInterface
{
    public function saveTokenPair(int $accessTokenId, int|string $refreshTokenId): bool;

    public function getCurrentAccessToken(User $user): PersonalAccessToken;

    public function removeTokenById(User $user, int|string $id): bool;

    public function removeTokenByRefreshId(User $user, int|string $refreshId): bool;
}