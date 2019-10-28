# Contributte Utils

Extra contribution to [`nette/utils`](https://github.com/nette/utils).

## Content

There are many classes in this package. Almost all are extending from `nette/utils` and adding more functionality.

- [Setup](#setup)
- [DateTime & DateTimeFactory](#datetime--datetimefactory)
- [Fields](#fields)
- [FileSystem](#filesystem)
- [Strings](#strings)
- [Urls](#urls)
- [Validators](#validators)
- [CSV](#csv)

## Setup

```bash
composer require contributte/utils
```

## `DateTime` && `DateTimeFactory`

This extension register simple `DateTime` provider -> `DateTimeFactory`. 

```yml
extensions:
    datetime: Contributte\Utils\DI\DateTimeFactoryExtension
```

You can use the default or override it by our own implementation:

```yaml
services:
    datetime.factory: App\Model\MyDateTimeFactory
```

Another useful methods added to `DateTime`:

- `DateTime::setCurrentTime()`
- `DateTime::setZeroTime() && resetTime()`
- `DateTime::setMidnight()`
- `DateTime::setToday()`
- `DateTime::getFirstDayOfWeek()`
- `DateTime::getLastDayOfWeek()`
- `DateTime::getFirstDayOfMonth()`
- `DateTime::getLastDayOfMonth()`
- `DateTime::getFirstDayOfYear()`
- `DateTime::getLastDayOfYear()`

## `Fields`

Collections of functions for normalizing input:

- `Fields::inn($s)`
- `Fields::tin($s)`
- `Fields::zip($s)`
- `Fields::phone($s)`

## `FileSystem`

Collection of extra functions: 

- `FileSystem::pathalize($path)`
- `FileSystem::extension($file)`
- `FileSystem::purge($dir)`


## `Strings`

Collection of extra functions: 

- `Strings::replacePrefix($s, $search, $replacement = '')`
- `Strings::replaceSuffix($s, $search, $replacement = '')`
- `Strings::spaceless($s)`
- `Strings::doublespaceless($s)`
- `Strings::dashless($s)`
- `Strings::slashless($s)`

## `Urls`

Collection of extra functions: 

- `Urls::hasFragment($url)`

## `Validators`

Collection of extra functions: 

- `Validators::isIco($s)` - trader identification number (Czech only)
- `Validators::isRc($s)`- personal identification number (Czech and Slovak only)

## `Http`

Collection of extra functions: 

- `Http::metadata($s)` - gets http metadata from string, returns as `[name => content]`

## `CSV`

Csv class helps you transform flat line into the described structure.

Consider this CSV files:

```
"Milan";"Sulc";"HK";"123456";"foo"
"John";"Doe";"Doens";"111111";"bar"
```

Setup scheme according to the columns:

```php
$scheme = [
    0 => 'user.name',
    1 => 'user.surname',
    2 => 'city',
    3 => 'extra.id',
    4 => 'extra.x',
];

$result = Csv::structural($scheme, __DIR__ . '/some.csv');

```

Result will be like this:

```
0 => [
    'user' => [
        'name' => 'Milan',
        'surname' => 'Sulc',
    ],
    'city' => 'HK',
    'extra' => [
        'id' => '123456',
        'x' => 'foo',
    ],
],
1 => [
    'user' => [
        'name' => 'John',
        'surname' => 'Doe',
    ],
    'city' => 'Doens',
    'extra' => [
        'id' => '111111',
        'x' => 'bar',
    ],
],
```
