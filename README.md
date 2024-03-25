# Laravel sanctum authentication with refresh token

## Install
```composer
composer require larahook/sanctum-refresh-token
```

## Config
You can also publish the config file to change implementations
```composer
php artisan vendor:publish --provider="Larahook\SanctumRefreshToken\SanctumRefreshTokenServiceProvider" --tag=config
```