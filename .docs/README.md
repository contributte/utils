# Utils

## Content

There are many classes in this package. Almost all are extending from `nette/utils` and adding more functionality.

- [DateTime & DateTimeFactory](#datetime--datetimefactory)
- [Fields](#fields)
- [FileSystem](#filesystem)
- [Strings](#strings)
- [Urls](#urls)
- [Validators](#validators)

## `DateTime` && `DateTimeFactory`

This extesions register simple `DateTime` provider -> `DateTimeFactory`. 

```yml
extensions:
    datetime: Contributte\Utils\DI\DateTimeFactoryExtension
```

You can use the default or override it by our own implementation:

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

## `Fields`

Collections of functions for normalizing input:

- `inn($s)`
- `tin($s)`
- `zip($s)`
- `phone($s)`

## `FileSystem`

Collection of extra functions: 

- `pathalize($path)`
- `extension($file)`
- `purge($dir)`


## `Strings`

Collection of extra functions: 

- `replacePrefix($s, $search, $replacement = '')`
- `replaceSuffix($s, $search, $replacement = '')`
- `spaceless($s)`
- `doublespaceless($s)`
- `dashless($s)`
- `slashless($s)`

## `Urls`

Collection of extra functions: 

- `hasFragment($url)`

## `Validators`

Collection of extra functions: 

- `isIco($s)` - trader identification number (Czech only)
- `isRc($s)`- personal identification number (Czech and Slovak only)
