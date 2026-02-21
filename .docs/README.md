# Contributte Utils

## Content

There are many classes in this package. Almost all are extending from `nette/utils` and adding more functionality.

- [Setup](#setup)
- [DateTime & DateTimeFactory](#datetime--datetimefactory)
- [Fields](#fields)
- [FileSystem](#filesystem)
- [Strings](#strings)
- [Caster](#caster)
- [Emptiness](#emptiness)
- [Urls](#urls)
- [System](#system)
- [TextString](#textstring)
- [UserAgents](#useragents)
- [Uuid](#uuid)
- [Validators](#validators)
- [CSV](#csv)
- [Collections](#collections)
	- [LazyCollection](#lazycollection)
- [Values](#values)
	- [Email](#email)

## Setup

```bash
composer require contributte/utils
```

## `DateTime` && `DateTimeFactory`

This extension register simple `DateTime` provider -> `DateTimeFactory`.

```neon
extensions:
	datetime: Contributte\Utils\DI\DateTimeFactoryExtension
```

You can use the default or override it by our own implementation:

```neon
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

## `Caster`

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

## `Emptiness`

Helpers for strict empty checks:

- `Emptiness::empty($value)`
- `Emptiness::notEmpty($value)`

## `Urls`

Collection of extra functions:

- `Urls::hasFragment($url)`

## `System`

Helpers for runtime diagnostics:

- `System::memoryUsage()`
- `System::memoryPeakUsage()`
- `System::timer($name)`

## `TextString`

Value object implementing `Stringable` for explicit text wrapping.

## `UserAgents`

Utility for rotating and randomizing user agents:

- `UserAgents::get()`
- `UserAgents::random()`

## `Uuid`

UUID v4 generation and validation:

- `Uuid::v4()`
- `Uuid::validateV4($uuid)`

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

## Collections

### LazyCollection

Initializes data only when required.

```php
use Contributte\Utils\LazyCollection;

$items = LazyCollection::fromCallback(callback $datasource);

foreach($items as $item) { // Datasource callback is called on first access

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
