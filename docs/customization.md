---
title: Customization
weight: 6
---

to customize the layout, you can change the default layout in the `zeus.php` config file

```php
'layout' => 'components.app',
```

## Publishing the default layout

or if you don't have a layout yet, you can publish the default one:

```bash
php artisan vendor:publish --tag=zeus-views
```

## Publishing the default views

to customize the default views for wind:

```bash
php artisan vendor:publish --tag=zeus-wind-views
```

## Publishing Translations

to customize the translations:

```bash
php artisan vendor:publish --tag=zeus-wind-translations
```

## themes
soon
