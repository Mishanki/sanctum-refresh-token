<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PersonalAccessToken model
    |--------------------------------------------------------------------------
    |
    | This model with refresh_id column
    |
    */
    'personal_access_token_model' => \Larahook\SanctumRefreshToken\Model\PersonalAccessToken::class,

    /*
    |--------------------------------------------------------------------------
    | Refresh Route Name
    |--------------------------------------------------------------------------
    |
    | This value controls the used refresh route name
    |
    */
    'refresh_route_names' => 'token.refresh',

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | This value controls the number of minutes until an issued tokens will be
    | considered expired.
    |
    */
    'auth_token_expiration' => 60 * 24 * 30,
    'refresh_token_expiration' => 60 * 24 * 60,
];
