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

Contributte Utils is a set of small helpers for Nette Framework, built on top of `nette/utils`. It adds string,
array, date and file helpers, casting and validation functions and value objects such as `Email`, so you don't
write them again in every project.

## Usage

To install the latest version of `contributte/utils`, use [Composer](https://getcomposer.org):

```bash
composer require contributte/utils
```

Requires PHP 8.2 or later and `nette/utils` 4.0 or later.

Call the helpers statically, or wrap a value in a value object:

```php
use Contributte\Utils\Strings;
use Contributte\Utils\Values\Email;

Strings::spaceless(' CZ 11 22 33 44'); // 'CZ11223344'

$email = new Email('foo@example.com'); // throws InvalidEmailAddressException for an invalid address
$email->getDomainPart(); // 'example.com'
```

The [documentation](.docs) lists every helper, collection and value object.

## Versions

| State       | Version | Branch   | Nette | PHP     |
|-------------|---------|----------|-------|---------|
| dev         | `^0.7`  | `master` | 4.0+  | `>=8.1` |
| stable      | `^0.6`  | `master` | 3.1+  | `>=8.1` |

## Development

Install the dependencies and run the checks:

```bash
make install   # install dependencies
make qa        # check code style and run static analysis
make tests     # run tests
```

Run `make` to list every target.

See [how to contribute](https://contributte.org/contributing.html) to this package.

This package is maintained by these authors.

<a href="https://github.com/f3l1x">
  <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

-----

Consider [supporting](https://contributte.org/partners.html) the **contributte** development team.
Thank you for using this package.
