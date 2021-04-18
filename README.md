# This is my package Jumia

[![Latest Version on Packagist](https://img.shields.io/packagist/v/combindma/jumia.svg?style=flat-square)](https://packagist.org/packages/combindma/jumia)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/combindma/jumia/run-tests?label=tests)](https://github.com/combindma/jumia/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/combindma/jumia/Check%20&%20fix%20styling?label=code%20style)](https://github.com/combindma/jumia/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/combindma/jumia.svg?style=flat-square)](https://packagist.org/packages/combindma/jumia)

## Installation

You can install the package via composer:

```bash
composer require combindma/jumia
```

You can publish the config file with:
```bash
php artisan vendor:publish  --tag="jumia-config"
```

This is the contents of the published config file:

```php
return [

    /*
     * The user id, should be an email used in seller center.
     */
    'user_id' => env('JUMIA_USER_ID', ''),

    /*
     * The api url under which data will be sent.
     */
    'api_url' => env('JUMIA_API_URL', 'https://sellercenter-api.jumia.ma'),

    /*
     * The api key used for authentication.
     */
    'api_key' => env('JUMIA_API_KEY', null),

    /*
     * Enable or disable sync with the seller center. Useful for local development.
     */
    'enabled' => env('JUMIA_SYNC_ENABLED', false),

    /*
     * These brands will be deleted from title and description
     */
    'blackList' => [
        'daniel wellington',
        'tissot',
        'guess',
        'swatch',
        'hugo boss',
        'boss',
        'balmain',
        'longines',
        'emporio armani',
        'armani'
    ],

    /*
     * This will be added to xml feed
     */
    'default_weight' => '0.5kg',

    /*
     * This will be added to xml feed
     */
    'default_warranty_duration' => 24,

    /*
     * This will be added to the price of product
     */
    'price_commission' => 15,
];
```

## Usage

You should create JumiaHelper to generate name, description and price.

You should also create JumiaProductAttributes trait and add it to Product Model.

Attach to Product Category these variables: meta[jumia_id_category], meta[jumia_string_category], meta[jumia_seo_category]

Add HasJumiaFeed trait to ProductController.

Add 3 methods in ProductController: addProductToJumia, syncProductWithJumia, syncProductImageWithJumia and add their routes

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Combind](https://github.com/combindma)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
