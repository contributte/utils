# Contributte Utils

Instructions for AI coding agents working in this repository.

## Overview

`contributte/utils` is a set of small static helpers and value objects on top of `nette/utils`: `Strings`, `Arrays`,
`Validators` and `DateTime` extend their Nette counterparts, the rest (`Caster`, `Csv`, `Deeper`, `FileSystem`,
`Uuid`, `LazyCollection`, `Values\Email`, ...) are new classes. It has one small DI extension and no configuration.
It is a library, not an application.

- **PHP**: 8.2 or later (`>=8.2` in `composer.json`); CI runs the tests on PHP 8.2 to 8.4
- **Package**: `contributte/utils`, namespace `Contributte\Utils\`
- **Extension**: `Contributte\Utils\DI\DateTimeFactoryExtension` (optional, needs `nette/di`)
- **Integrates**: `nette/utils` 4.x; `nette/di` 3.2 only in `require-dev` and `suggest`

## Documentation

- `.docs/README.md` is the user documentation and the page on contributte.org. It lists the public methods of each
  class; update it in the same pull request when a method is added, renamed or removed.
- Organization rules for code, tests and tooling are in
  [contributte/contributte specs](https://github.com/contributte/contributte/tree/master/specs).

## Commands

```bash
# Install dependencies
make install

# Run all checks (PHPStan level 9 + code style), does not run tests
make qa

# Fix code style
make csf

# Run all tests, or one file
make tests
vendor/bin/tester -s -p php --colors 1 -C tests/Cases/Strings.phpt

# Generate code coverage (coverage.html)
make coverage
```

CI runs the tests on PHP 8.2 to 8.4 and once on PHP 8.2 with `--prefer-lowest`.

## Conventions

- One test file per class in `tests/Cases`, mirroring `src/` (`Values/Email.phpt`, `Http/FileResponse.phpt`).
  Bigger topics split with a dot: `DateTime.phpt`, `DateTime.compare.phpt`.
- New tests are `.phpt` files with `Toolkit::test()`. `DeeperTest.php` and `Monad/OptionalTest.php` are older
  `TestCase` classes; they run because of the `Test.php` suffix.
- Test data lives in `tests/Fixtures` (`sample.csv`, annotated classes for `Annotations`).

## Traps

- **`Strings`, `Arrays`, `Validators` and `DateTime` extend `nette/utils` classes.** A new static method can clash
  with one that `nette/utils` adds later, and an override must keep the parent signature. Check the parent class
  in `vendor/nette/utils/src/Utils` before adding a method.
- **`FileSystem` does not extend Nette `FileSystem`, it delegates to it.** A new Nette method is not available
  here until a delegating method is written.
- **`FileSystem::purge()` deletes everything inside the directory and creates it when it is missing.** Tests must
  point it only at `Environment::getTestDir()`.
- **`DateTimeFactoryExtension` registers a generated factory for `IDateTimeFactory`.** Nette writes the
  implementation from the interface, so changing `create()` changes every user's container.
- **`nette/di` is not a runtime dependency.** Only `src/DI` may use it; the rest of `src/` must work with
  `nette/utils` alone.
- **`Values\Email` normalizes the domain with `idn_to_ascii()` only when `ext-intl` is loaded.** Results differ
  without the extension; don't make `intl` required.
- **`Annotations` detects docblock support from its own class docblock.** If `Annotations` has no docblock,
  `$useReflection` becomes `false` and every lookup returns `[]`. Results are cached per member for the whole
  process; `$autoRefresh` is not read anywhere.
- Usage and examples for users live in `.docs/README.md`, not here.
