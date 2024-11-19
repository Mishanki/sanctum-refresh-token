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
 * @property string $tokenable_id
 * @property string $name
 * @property string $token
 * @property null|array $abilities
 * @property null|Carbon $last_used_at
 * @property null|Carbon $expires_at
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 * @property null|int $refresh_id
 * @property null|string $created_ip
 * @property null|string $updated_ip
 * @property \Eloquent|Model $tokenable
 *
 * @method static Builder<static>|\App\Models\Token\PersonalAccessToken newModelQuery()
 * @method static Builder<static>|PersonalAccessToken newQuery()
 * @method static Builder<static>|PersonalAccessToken query()
 * @method static Builder<static>|PersonalAccessToken whereAbilities($value)
 * @method static Builder<static>|PersonalAccessToken whereCreatedAt($value)
 * @method static Builder<static>|PersonalAccessToken whereCreatedIp($value)
 * @method static Builder<static>|PersonalAccessToken whereExpiresAt($value)
 * @method static Builder<static>|PersonalAccessToken whereId($value)
 * @method static Builder<static>|PersonalAccessToken whereLastUsedAt($value)
 * @method static Builder<static>|PersonalAccessToken whereName($value)
 * @method static Builder<static>|PersonalAccessToken whereRefreshId($value)
 * @method static Builder<static>|PersonalAccessToken whereToken($value)
 * @method static Builder<static>|PersonalAccessToken whereTokenableId($value)
 * @method static Builder<static>|PersonalAccessToken whereTokenableType($value)
 * @method static Builder<static>|PersonalAccessToken whereUpdatedAt($value)
 * @method static Builder<static>|PersonalAccessToken whereUpdatedIp($value)
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
        'created_ip',
        'updated_ip',
    ];

    /* @var $casts array */
    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
}
