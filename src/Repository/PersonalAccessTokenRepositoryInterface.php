<?php

namespace Larahook\SanctumRefreshToken\Repository;

interface PersonalAccessTokenRepositoryInterface
{
    public function saveTokenPair(int $accessTokenId, int $refreshTokenId): bool;
}