# Laravel sanctum authentication with refresh token

## Install
```composer
composer require larahook/sanctum-refresh-token
```
Add Trait in `User` model class.
```php
use Larahook\SanctumRefreshToken\Trait\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
}
```


Add `SanctumRefreshTokenServiceProvider` in `config/app.php`
```php
'providers' => ServiceProvider::defaultProviders()->merge([
        //...
        EventServiceProvider::class,
        RouteServiceProvider::class,
        SanctumRefreshTokenServiceProvider::class,
    ])->toArray(),
```


## Config
You can also publish the config file to change implementations
```composer
php artisan vendor:publish --provider="Larahook\SanctumRefreshToken\SanctumRefreshTokenServiceProvider" --tag=config
```
## Migration
Install migrations
```composer
 php artisan vendor:publish --provider="Larahook\SanctumRefreshToken\SanctumRefreshTokenServiceProvider" --tag=migrations
 php artisan migrate 
```

## Usage

```php
public function createTokens(User $user, string $deviceName, ?\DateTimeInterface $expiresAt = null): array
{    
    # Create tokens
    $accessToken = $user->createAuthToken($deviceName, $expiresAt);
    $refreshToken = $user->createRefreshToken($deviceName, $expiresAt);

    # Get ID
    $accessTokenId = $accessToken->accessToken->getAttribute('id'),
    $refreshTokenId = $refreshToken->accessToken->getAttribute('id')

    # Save refresh_id for access token
    PersonalAccessToken::whereId($accessTokenId)->update(['refresh_id' => $refreshTokenId]);

    # Send response with access_token and refresh_token
    return [
        'access_token' => $accessToken->plainTextToken,
        'access_token_expiration' => $accessToken->accessToken->expires_at ?? null,
        'refresh_token' => $refreshToken->plainTextToken,
        'refresh_token_expiration' => $refreshToken->accessToken->expires_at ?? null,
    ];
}
```
