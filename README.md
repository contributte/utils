# Contributte > Utils

:sparkles: Extra contribution to [`nette/utils`](https://github.com/nette/utils).

-----

[![Build Status](https://img.shields.io/travis/contributte/utils.svg?style=flat-square)](https://travis-ci.org/contributte/utils)
[![Code coverage](https://img.shields.io/coveralls/contributte/utils.svg?style=flat-square)](https://coveralls.io/r/contributte/utils)
[![Downloads this Month](https://img.shields.io/packagist/dm/contributte/utils.svg?style=flat-square)](https://packagist.org/packages/contributte/utils)
[![Downloads total](https://img.shields.io/packagist/dt/contributte/utils.svg?style=flat-square)](https://packagist.org/packages/contributte/utils)
[![Latest stable](https://img.shields.io/packagist/v/contributte/utils.svg?style=flat-square)](https://packagist.org/packages/contributte/utils)
[![Latest unstable](https://img.shields.io/packagist/vpre/contributte/utils.svg?style=flat-square)](https://packagist.org/packages/contributte/utils)
[![Licence](https://img.shields.io/packagist/l/contributte/utils.svg?style=flat-square)](https://packagist.org/packages/contributte/utils)
[![HHVM Status](https://img.shields.io/hhvm/contributte/utils.svg?style=flat-square)](http://hhvm.h4cc.de/package/contributte/utils)

## Discussion / Help

[![Join the chat](https://img.shields.io/gitter/room/contributte/contributte.svg?style=flat-square)](https://gitter.im/contributte/contributte?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Install

```
composer require contributte/utils
```

## Usage

There are many classes in this package. Almost all are extending from nette/utils and adding more functionality.

- `Contributte\Utils\DateTime`
- `Contributte\Utils\DateTimeFactory`
- `Contributte\Utils\Fields`
- `Contributte\Utils\FileSystem`
- `Contributte\Utils\Strings`
- `Contributte\Utils\Urls`
- `Contributte\Utils\Validators`

### `DateTime` && `DateTimeFactory`

This extesions register simple `DateTime` provider -> `DateTimeFactory`. 

```yml
extensions:
    datetime: Contributte\Utils\DI\DateTimeFactoryExtension
```

You can use default or override it by our own implementation:

```php
services:
    datetime.factory: App\Model\MyDateTimeFactory
```

Another useful methods added to `DateTime`:

- `setCurrentTime()`
- `setZeroTime() && resetTime()`
- `setMidnight()`
- `setToday()`
- `getFirstDayOfWeek()`
- `getLastDayOfWeek()`
- `getFirstDayOfMonth()`
- `getLastDayOfMonth()`
- `getFirstDayOfYear()`
- `getLastDayOfYear()`

### `Fields`

Collections of functions for normalizing input:

- `inn($s)`
- `tin($s)`
- `zip($s)`
- `phone($s)`

### `FileSystem`

Collection of extra functions: 

- `pathalize($path)`
- `extension($file)`
- `purge($dir)`


### `Strings`

Collection of extra functions: 

- `replacePrefix($s, $search, $replacement = '')`
- `replaceSuffix($s, $search, $replacement = '')`
- `spaceless($s)`
- `doublespaceless($s)`
- `dashless($s)`

### `Urls`

Collection of extra functions: 

- `hasFragment($url)`

### `Validators`

Collection of extra functions: 

- `isIco($s)`
- `isRc($s)`

---

Thank you for testing, reporting and contributing.
