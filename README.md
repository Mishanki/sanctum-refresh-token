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

## Config
You can also publish the config file to change implementations
```composer
php artisan vendor:publish --provider="Larahook\SanctumRefreshToken\SanctumRefreshTokenServiceProvider" --tag=config
```