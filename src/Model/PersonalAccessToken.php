<?php

namespace Larahook\SanctumRefreshToken\Model;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * App\Models\Token\PersonalAccessToken.
 *
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property null|array $abilities
 * @property null|Carbon $last_used_at
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 * @property null|string $updated_ip
 * @property null|Carbon $expires_at
 * @property null|int $refresh_id
 * @property \Eloquent|Model $tenable
 *
 * @method static Builder|PersonalAccessToken newModelQuery()
 * @method static Builder|PersonalAccessToken newQuery()
 * @method static Builder|PersonalAccessToken query()
 * @method static Builder|PersonalAccessToken whereAbilities($value)
 * @method static Builder|PersonalAccessToken whereCreatedAt($value)
 * @method static Builder|PersonalAccessToken whereCreatedIp($value)
 * @method static Builder|PersonalAccessToken whereExpiresAt($value)
 * @method static Builder|PersonalAccessToken whereId($value)
 * @method static Builder|PersonalAccessToken whereLastUsedAt($value)
 * @method static Builder|PersonalAccessToken whereName($value)
 * @method static Builder|PersonalAccessToken whereRefreshId($value)
 * @method static Builder|PersonalAccessToken whereToken($value)
 * @method static Builder|PersonalAccessToken whereTokenableId($value)
 * @method static Builder|PersonalAccessToken whereTokenableType($value)
 * @method static Builder|PersonalAccessToken whereUpdatedAt($value)
 * @method static Builder|PersonalAccessToken whereUpdatedIp($value)
 *
 * @mixin Eloquent
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /* @var $fillable array */
    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expires_at',
        'refresh_id',
    ];

    /* @var $casts array */
    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
}
