# Laravel Starter Kit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/xmen/starter-kit.svg?style=flat-square)](https://packagist.org/packages/spatie/starter-kit)
[![Total Downloads](https://img.shields.io/packagist/dt/xmen/starter-kit.svg?style=flat-square)](https://packagist.org/packages/spatie/starter-kit)


An Starter Kit For Laravel Projects.

## Installation

1-Install the package via composer:

```bash
composer require xmen/starter-kit
```

2-Publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Xmen\StarterKit\StarterKitServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
php artisan migrate
```

3-Publish the assets with:

```bash
php artisan vendor:publish --provider="Xmen\StarterKit\StarterKitServiceProvider" --tag="assets"
```

4-Publish the language file with:

```bash
php artisan vendor:publish --provider="Xmen\StarterKit\StarterKitServiceProvider" --tag="lang"
```

5-Add `StarterKit` trait to `User` model:
```php
use Xmen\StarterKit\Models\StarterKit;

class User extends Authenticatable {
    use StarterKit;
...
}
```

6-Change the home path to dashboard in `RouteServiceProvider`:
```php
//app/Providers/RouteServiceProvider.php

public const HOME = '/dashboard/news/index';
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Xmen\StarterKit\StarterKitServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    //The dashboard uri
    'uri'=>'dashboard'
];
```

## Usage

Create admin user by running `install` command and then login to dashboard:
```bash
php artisan starter-kit:install
```

Also install `laravel/ui` if you need login/registration.

## Testing

``` bash
composer test
```

## Security

If you discover any security related issues, please email sadeghpm@gmail.com instead of using the issue tracker.

## Credits

- [4xmen](https://github.com/4xmen)
- [SadeghPM](https://github.com/sadeghpm)
- [A1Gard](https://github.com/A1Gard)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
