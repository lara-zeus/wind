# Changelog

All notable changes to `wind` will be documented in this file

## 2.4.1 - 2023-04-27

### What's Changed

- Bump guzzlehttp/psr7 from 2.4.4 to 2.5.0 by @dependabot in https://github.com/lara-zeus/wind/pull/32
- Bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/lara-zeus/wind/pull/33
- Fix boot by @atmonshi in https://github.com/lara-zeus/wind/pull/34

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.4.0...2.4.1

## 2.4.0 - 2023-04-10

### What's Changed

- Bump dependabot/fetch-metadata from 1.3.5 to 1.3.6 by @dependabot in https://github.com/lara-zeus/wind/pull/29
- Bump aglipanci/laravel-pint-action from 1.0.0 to 2.2.0 by @dependabot in https://github.com/lara-zeus/wind/pull/30
- Bump ramsey/composer-install from 1 to 2 by @dependabot in https://github.com/lara-zeus/wind/pull/27
- support laravel 10 by @atmonshi in https://github.com/lara-zeus/wind/pull/31

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.3.2...2.4.0

## 2.3.2 - 2022-11-07

### What's Changed

- Bump dependabot/fetch-metadata from 1.3.3 to 1.3.4 by @dependabot in https://github.com/lara-zeus/wind/pull/24
- Bump dependabot/fetch-metadata from 1.3.4 to 1.3.5 by @dependabot in https://github.com/lara-zeus/wind/pull/26
- Fixed "Undefined property: Closure::$name" error by @leekaimun in https://github.com/lara-zeus/wind/pull/25

### New Contributors

- @dependabot made their first contribution in https://github.com/lara-zeus/wind/pull/24
- @leekaimun made their first contribution in https://github.com/lara-zeus/wind/pull/25

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.3.1...2.3.2

## 2.3.1 - 2022-09-18

### What's Changed

- improve responsive layout by @atmonshi in https://github.com/lara-zeus/wind/pull/23

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.3.0...2.3.1

## 2.3.0 - 2022-09-17

### What's Changed

improve skeleton and add tests and dark mode
separate the CSS for frontend and filament
update .github workflows

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.2.5...2.3.0

## 2.2.5 - 2022-09-14

### What's Changed

- Apply fixes from StyleCI by @atmonshi in https://github.com/lara-zeus/wind/pull/21
- Fix new status by @atmonshi in https://github.com/lara-zeus/wind/pull/20

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.2.4...2.2.5

## 2.2.4 - 2022-09-06

### What's Changed

- update core by @atmonshi in https://github.com/lara-zeus/wind/pull/19

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.2.3...2.2.4

## 2.2.3 - 2022-09-05

### What's Changed

- Update core by @atmonshi in https://github.com/lara-zeus/wind/pull/17
- update UI by @atmonshi in https://github.com/lara-zeus/wind/pull/18

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.2.1...2.2.3

## 2.2.1 - 2022-08-24

### What's Changed

- update composer and assets by @atmonshi in https://github.com/lara-zeus/wind/pull/16

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.2.0...2.2.1

## 2.1.1 - 2022-06-21

### What's Changed

- update core version by @atmonshi in https://github.com/lara-zeus/wind/pull/14

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.1.0...2.1.1

## 2.1.0 - 2022-06-21

### What's Changed

- allow embedding the contact form in any blade template by @atmonshi in https://github.com/lara-zeus/wind/pull/12

**Full Changelog**: https://github.com/lara-zeus/wind/compare/2.0.1...2.1.0

## 2.0.0 - 2022-04-19

- remove title slot and use laravel-seo
- fix validations on all resources
- clean up some blade files
- allow configuring the default status for new messages
- hide the Departments from the admin panel when it's disabled in the config
- update the config file
- add translations

## 1.0.4 - 2022-04-10

- fix missing `departments` from Contacts Component
- add validation for ordering in `DepartmentResource`

## 1.0.3 - 2022-03-29

- add support for laravel 9
- use filament forms as the frontend
- Improve the admin and the forms

## 1.0.2 - 2022-02-10

- update assets from zeus-core

## 1.0.1 - 2022-02-10

- fix DepartmentFactory

## 1.0.0 - 2022-02-10

- refactor Categories to Departments
- change the command 'install' to 'publish'
- update readme
- update the docs

## 0.1.3 - 2022-01-19

- fix sorting in Category and Letter Resources

## 0.1.2 - 2022-01-10

- added the package `doctrine/dbal` for modifying the database

### fixes:

- set a default value if the categories are disabled
- disable category_id validation if categories are disabled

### improvements:

#### `LetterResource`:

- disable adding new Letter
- set default replay message

## 0.1.1 - 2022-01-07

small fixes and update zeus-core package.

## 0.1.0 - 2022-01-07

using [filament](https://filamentadmin.com/) as an admin panel, which give us:

- lightweight package
- fully extendable admin panel ([docs](https://filamentadmin.com/docs/2.x/admin/installation))

## 0.0.1 - 2021-12-15

- initial release
