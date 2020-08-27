# 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/starter-kit.svg?style=flat-square)](https://packagist.org/packages/spatie/starter-kit)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/starter-kit/run-tests?label=tests)](https://github.com/spatie/starter-kit/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/starter-kit.svg?style=flat-square)](https://packagist.org/packages/spatie/starter-kit)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require xmen/starter-kit
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Xmen\StarterKit\StarterKitServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Xmen\StarterKit\StarterKitServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$starter-kit = new Xmen\StarterKit();
echo $starter-kit->echoPhrase('Hello, Xmen!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [xmen](https://github.com/xmen)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
