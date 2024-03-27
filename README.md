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
Add trait `AuthTokens` and call method `createTokens`
```php
use Larahook\SanctumRefreshToken\Trait\AuthTokens;

class SomeClass
{
    use AuthTokens;

    public function login(string $email, string $password, string $deviceName): array
    {
        $user = User::whereEmail($email)->first();
        if (!$user || !$this->isValidPassword($password, $user->getPassword())) {
            throw new UnauthorizedException('The provided credentials are incorrect.', Errors::AUTHORIZATION_ERROR->value);
        }

        return $this->createTokens($user, $deviceName);
    }
}
```
