![](https://heatbadger.now.sh/github/readme/contributte/utils/)

<p align=center>
  <a href="https://github.com/contributte/utils/actions"><img src="https://badgen.net/github/checks/contributte/utils/master?cache=300"></a>
  <a href="https://codecov.io/gh/contributte/utils"><img src="https://badgen.net/codecov/c/github/contributte/utils?cache=300"></a>
  <a href="https://packagist.org/packages/contributte/utils"><img src="https://badgen.net/packagist/dm/contributte/utils"></a>
  <a href="https://packagist.org/packages/contributte/utils"><img src="https://badgen.net/packagist/v/contributte/utils"></a>
</p>
<p align=center>
  <a href="https://packagist.org/packages/contributte/utils"><img src="https://badgen.net/packagist/php/contributte/utils"></a>
  <a href="https://github.com/contributte/utils"><img src="https://badgen.net/github/license/contributte/utils"></a>
  <a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
  <a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
  <a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/sponsor/donations/F96854"></a>
</p>

<p align=center>
Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

There are many classes in this package. Almost all are extending from `nette/utils` and adding more functionality.

## Versions

| State  | Version | Branch   | Nette | PHP     |
|--------|---------|----------|-------|---------|
| dev    | `^0.8`  | `master` | 4.0+  | `>=8.2` |
| stable | `^0.6`  | `master` | 3.1+  | `>=8.1` |

## Installation

To install the latest version of `contributte/utils`, use [Composer](https://getcomposer.org).

```bash
composer require contributte/utils
```

## DateTime & DateTimeFactory

This extension registers a simple `DateTime` provider, `DateTimeFactory`.

```neon
extensions:
	datetime: Contributte\Utils\DI\DateTimeFactoryExtension
```

You can use the default service or override it with your own implementation:

```neon
services:
	datetime.factory: App\Model\MyDateTimeFactory
```

Useful methods added to `DateTime`:

- `DateTime::setCurrentTime()`
- `DateTime::setZeroTime()` and `DateTime::resetTime()`
- `DateTime::setMidnight()`
- `DateTime::setToday()`
- `DateTime::getFirstDayOfWeek()`
- `DateTime::getLastDayOfWeek()`
- `DateTime::getFirstDayOfMonth()`
- `DateTime::getLastDayOfMonth()`
- `DateTime::getFirstDayOfYear()`
- `DateTime::getLastDayOfYear()`

## Fields

Collection of functions for normalizing input:

- `Fields::inn($s)`
- `Fields::tin($s)`
- `Fields::zip($s)`
- `Fields::phone($s)`

## FileSystem

Collection of extra functions:

- `FileSystem::pathalize($path)`
- `FileSystem::extension($file)`
- `FileSystem::purge($dir)`

## Strings

Collection of extra functions:

- `Strings::replacePrefix($s, $search, $replacement = '')`
- `Strings::replaceSuffix($s, $search, $replacement = '')`
- `Strings::spaceless($s)`
- `Strings::doublespaceless($s)`
- `Strings::dashless($s)`
- `Strings::slashless($s)`

## Caster

Collection of casting helpers:

- `Caster::stringOrNull($value)`
- `Caster::ensureString($value)`
- `Caster::forceString($value)`
- `Caster::intOrNull($value)`
- `Caster::ensureInt($value)`
- `Caster::forceInt($value)`
- `Caster::floatOrNull($value)`
- `Caster::ensureFloat($value)`
- `Caster::forceFloat($value)`
- `Caster::boolOrNull($value)`
- `Caster::ensureBool($value)`
- `Caster::forceBool($value)`
- `Caster::ensureArray($value)`
- `Caster::forceArray($value)`

## Emptiness

Helpers for strict empty checks:

- `Emptiness::empty($value)`
- `Emptiness::notEmpty($value)`

## Urls

Collection of extra functions:

- `Urls::hasFragment($url)`

## System

Helpers for runtime diagnostics:

- `System::memoryUsage()`
- `System::memoryPeakUsage()`
- `System::timer($name)`

## TextString

Value object implementing `Stringable` for explicit text wrapping.

## UserAgents

Utility for rotating and randomizing user agents:

- `UserAgents::get()`
- `UserAgents::random()`

## Uuid

UUID v4 generation and validation:

- `Uuid::v4()`
- `Uuid::validateV4($uuid)`

## Validators

Collection of extra functions:

- `Validators::isIco($s)` - trader identification number (Czech only)
- `Validators::isRc($s)` - personal identification number (Czech and Slovak only)

## Http

Collection of extra functions:

- `Http::metadata($s)` - gets HTTP metadata from string, returns it as `[name => content]`

## CSV

`Csv` helps you transform a flat line into the described structure.

Consider this CSV file:

```csv
"Milan";"Sulc";"HK";"123456";"foo"
"John";"Doe";"Doens";"111111";"bar"
```

Set up the scheme according to the columns:

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

```php
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

## Collections

### LazyCollection

Initializes data only when required.

```php
use Contributte\Utils\LazyCollection;

$items = LazyCollection::fromCallback($datasource);

foreach ($items as $item) { // Datasource callback is called on first access
}
```

## Values

### Email

```php
use Contributte\Utils\Values\Email;

$email = new Email('foo@example.com'); // Validate email format
$value = $email->get(); // Get value
$equal = $email->equal(new Email('foo@example.com')); // Compare values of objects
```

## Development

See [how to contribute](https://contributte.org) to this package. This package is currently maintained by these authors.

<a href="https://github.com/f3l1x">
    <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

-----

Consider supporting the [contributte](https://contributte.org/partners) development team.
Thank you for using this package.
