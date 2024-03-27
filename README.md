# Laravel sanctum authentication with refresh token

## Install
```composer
composer require larahook/sanctum-refresh-token
```
- Add Trait in `User` model class.
```php
use Larahook\SanctumRefreshToken\Trait\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
}
```


- Add `SanctumRefreshTokenServiceProvider` in `config/app.php`
```php
'providers' => ServiceProvider::defaultProviders()->merge([
        //...
        EventServiceProvider::class,
        RouteServiceProvider::class,
        SanctumRefreshTokenServiceProvider::class,
    ])->toArray(),
```


## Config
- You can also publish the config file to change implementations
```composer
php artisan vendor:publish --provider="Larahook\SanctumRefreshToken\SanctumRefreshTokenServiceProvider" --tag=config
```
## Migration
- Install migrations
```composer
 php artisan vendor:publish --provider="Larahook\SanctumRefreshToken\SanctumRefreshTokenServiceProvider" --tag=migrations
 php artisan migrate 
```

## Usage
### Add trait `AuthTokens`
- `createTokenPair` - create `access_token` and `refresh_token`
- `refreshTokenPair` - unlink current token pair and create new `access_token` and `refresh_token`
- `logoutTokenPair` - unlink current token pair
```php
use Larahook\SanctumRefreshToken\Trait\AuthTokens;

class SomeClass
{
    use AuthTokens;

    public function login(string $email, string $password, string $deviceName): array
    {
        $user = User::whereEmail($email)->first();
        // ...some login pass validation

        return $this->createTokenPair($user, $deviceName);
    }
    
    /**
     * @param User $user
     *
     * @return array
     */
    public function refresh(User $user): array
    {
        return $this->refreshTokenPair($user);
    }
    
    /**
     * @param User $user
     *
     * @return bool
     */
    public function logout(User $user): bool
    {
        return $this->logoutTokenPair($user);
    }
}
```
