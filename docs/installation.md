---
title: Installation
weight: 2
---

## Installation

You can install the package via composer:

```bash
composer require lara-zeus/wind
```

for your convenient, we create a one command to publish them all:

```bash
php artisan wind:publish
```

you can pass `--force` option to force publishing all the files, helps if you're updating the package

to just publish the migrations files

```bash
php artisan vendor:publish --tag=zeus-wind-migrations
```

optionally, if you want to seed the database, publish the seeder and factories with:

```bash
php artisan vendor:publish --tag=zeus-wind-seeder
php artisan vendor:publish --tag=zeus-wind-factories
```

to publish the assets files for the frontend:

```bash
php artisan vendor:publish --tag=zeus-zeus-assets
```

finally, run the migration:

```bash
php artisan migrate
```
