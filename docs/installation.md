---
title: Installation
weight: 2
---

## Composer

You can install the package via composer:

```bash
composer require lara-zeus/wind
```

## publish
for your convenient, we create a one command to publish them all:

```bash
php artisan wind:publish
```

you can pass `--force` option to force publishing all the files, helps if you're updating the package

## Migrations
to just publish the migrations files

```bash
php artisan vendor:publish --tag=zeus-wind-migrations
```

## Seeder and Factories

optionally, if you want to seed the database, publish the seeder and factories with:

```bash
php artisan vendor:publish --tag=zeus-wind-seeder
php artisan vendor:publish --tag=zeus-wind-factories
```

## Assets

to publish the assets files for the frontend:

```bash
php artisan vendor:publish --tag=zeus-assets
```

## Run Migration

finally, run the migration:

```bash
php artisan migrate
```
