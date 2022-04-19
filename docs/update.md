---
title: Updating Wind
weight: 99
---

## Composer

to update the package first run:

```bash
composer update
```

## Publishing the files

then run the same command to publish any new files

```bash
php artisan wind:publish
```

> updating to wind V2 may introduce some braking changes if you already published the views and the configuration file.
we recommend running the `publish` command with the flag: `--force` and check your changes.

```bash
php artisan wind:publish --force
```
