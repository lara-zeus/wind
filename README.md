# Lara Zeus Wind

<p style="color: red; text-align: center">🔺 ========== Still Under Development ========== 🔺</p>

Wind is another package from Lara-Zeus, it's simply provide you with a contact form, with simple dashboard to read and replay to any messages you receive from your website.
>small tasks can be time-consuming, let us build these for you,

## features:
- 🔥 built with [TALL stack](https://tallstack.dev/)
- 🔥 using [filament](https://filamentadmin.com) as an admin panel
- 🔥 optionally you can add categories to the contact form like 'sales','dev','report bug' etc.
- 🔥 you can add logos for all categories.
- 🔥 direct URL to contact on specific category.

## Installation

You can install the package via composer:

```bash
composer require lara-zeus/wind
```

run the command:

```bash
php artisan wind:install
```

which will run the following commands:

```bash
php artisan vendor:publish --tag=zeus-wind-config
php artisan vendor:publish --tag=zeus-wind-migrations
php artisan vendor:publish --tag=zeus-wind-views
php artisan vendor:publish --tag=zeus-wind-seeder
php artisan vendor:publish --tag=zeus-wind-factories
php artisan vendor:publish --tag=zeus-zeus-config
php artisan vendor:publish --tag=zeus-zeus-views
php artisan vendor:publish --tag=zeus-zeus-assets
php artisan migrate
```

you can pass `--force` option to force publishing all files

```bash
php artisan wind:install --force
```

## Usage

visit the url `/admin` to manage the Letters, and `/contact-us` to access the contact form.
> you can configure the URL from the config file

if you dont have a user, or it's a fresh instalation of laravel, you can use the command to create a new user
```bash
php artisan make:filament-user
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email wh7r.com@gmail.com instead of using the issue tracker.

## Credits

-   [Ashraf Monshi](https://github.com/atmonshi)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.