# Laravel pagination with distinct on (field_a, field_b,...)

### Calc total rows (pgsql)

## Install
```composer
composer require larahook/distinct-on-pagination
```

## Usage

Add `DistinctOnPagination` trait in `SomeModel`
```php
use DistinctOnPagination;
```

Call your ORM model with `distinct(['field_a', 'field_b'])` with `paginate($perPage)`.
Pagination total must be calc without Exception
```sql
SomeModel::select(['*'])
    ->distinct(['field_a', 'field_b'])
    ->orderBy('field_a')
    ->orderBy('field_b')
    ->paginate($perPage)
```

## Config
You can also publish the config file to change implementations (concat delimiter)
```composer
php artisan vendor:publish --provider="Larahook\DistinctOnPagination\DistinctOnPaginationServiceProvider" --tag=config
```