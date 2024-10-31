<?php

namespace Larahook\SanctumRefreshToken\Trait;

use Larahook\SanctumRefreshToken\Model\PersonalAccessToken;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;
use Laravel\Sanctum\NewAccessToken;

trait HasApiTokens
{
    use SanctumHasApiTokens;

    /**
     * @param string $name
     * @param array $abilities
     * @param null|\DateTimeInterface $expiresAt
     *
     * @return NewAccessToken
     */
    public function createToken(string $name, array $abilities = ['*'], \DateTimeInterface $expiresAt = null): NewAccessToken
    {
        /** @var PersonalAccessToken $token */
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
        ]);

        return new NewAccessToken($token, $plainTextToken);
    }

    /**
     * @param string $name
     * @param null|\DateTimeInterface $expiresAt
     * @param array $abilities
     *
     * @return NewAccessToken
     */
    public function createAuthToken(string $name, \DateTimeInterface $expiresAt = null, array $abilities = []): NewAccessToken
    {
        return $this->createToken($name, array_merge($abilities, ['auth']), $expiresAt ?? now()->addMinutes(config('sanctum-refresh-token.auth_token_expiration')));
    }

    /**
     * @param string $name
     * @param null|\DateTimeInterface $expiresAt
     *
     * @return NewAccessToken
     */
    public function createRefreshToken(string $name, \DateTimeInterface $expiresAt = null)
    {
        return $this->createToken($name, ['refresh'], $expiresAt ?? now()->addMinutes(config('sanctum-refresh-token.refresh_token_expiration')));
    }
}
