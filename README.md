# covers-validator

[![CI](https://github.com/oradwell/covers-validator/actions/workflows/ci.yaml/badge.svg)](https://github.com/oradwell/covers-validator/actions/workflows/ci.yaml)
[![Coverage Status](https://coveralls.io/repos/github/oradwell/covers-validator/badge.svg?branch=master)](https://coveralls.io/github/oradwell/covers-validator?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/oradwell/covers-validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/oradwell/covers-validator/?branch=master)
[![License](https://poser.pugx.org/ockcyp/covers-validator/license)](https://packagist.org/packages/ockcyp/covers-validator)
[![Total Downloads](https://poser.pugx.org/ockcyp/covers-validator/downloads)](https://packagist.org/packages/ockcyp/covers-validator)

PHPUnit @covers tags validator

## Why?

[PHPUnit](https://github.com/sebastianbergmann/phpunit) fails to generate a coverage report
when tests have invalid [@covers](https://docs.phpunit.de/en/9.6/annotations.html#covers)
tags.

This tool allows you to determine the tests that have invalid @covers tags
without you needing to run the coverage.

Usually coverage reports are run less often than the tests
as they take a long time to run.
This tool validates your @covers tags quicker than you run your tests.

```
Trying to @cover or @use not existing class or interface "NonExistentClass".
Trying to @cover or @use not existing method "ExistingClass::nonExistantMethod".
```

See: [phpunit/issues/1758](https://github.com/sebastianbergmann/phpunit/issues/1758)<br />
Also see: [phpunit/issues/1791](https://github.com/sebastianbergmann/phpunit/issues/1791)

Abandoned alternative: [dunkelfrosch/phpcoverfish](https://github.com/dunkelfrosch/phpcoverfish)

## Getting Started

### Prerequisites

- PHP 7.1+
- PHPUnit 6.0+

### Installation

#### Composer

Recommended way of installing covers-validator is via [Composer](https://get.org/).

```bash
composer require --dev ockcyp/covers-validator
```

#### Phar

Download the `covers-validator.phar` asset
from the [latest release](https://github.com/oradwell/covers-validator/releases/latest)
or any other release from the [releases](https://github.com/oradwell/covers-validator/releases).

Then run using the following:
```bash
php covers-validator.phar
```

>[!NOTE]
>The usage documentation assumes you installed covers-validator using Composer,
>so please replace any reference to "vendor/bin/covers-validator"
>with "php covers-validator.phar".

>[!NOTE]
>Only releases since v0.3.0 can be used as a phar.

#### Older versions

Latest version of covers-validator supports PHP 7.1+ and PHPUnit 7+.
Please use version 0.5 for older PHP and PHPUnit versions.

| PHPUnit version | Covers-validator version |
| --------------- | ------------------------ |
| < 6.0           | 0.5.x                    |
| >= 6.0          | 1.x                      |

### Usage

Run the validator using the following:

```bash
vendor/bin/covers-validator
```

>[!TIP]
>The command returns exit code 1 when any of the covers tags are invalid.
>Use this to fail your builds.

#### Override configuration file

Give optional `-c` argument to load a particular PHPUnit configuration file:

```bash
vendor/bin/covers-validator -c tests/Fixtures/configuration.xml
```

#### Override PHPUnit bootstrap

Override the `bootstrap` value specified in PHPUnit configuration:

```bash
vendor/bin/covers-validator --bootstrap tests/bootstrap.php
```

#### Disable output

Disable output by providing the `-q` argument

```bash
vendor/bin/covers-validator -q
```

Adjust the verbosity:

| Verbosity   | Shows                               |
| ----------- | ----------------------------------- |
| `-v`        | Valid tests                         |
| `-vv`       | Loaded configuration file           |
| `-vvv`      | Test name before validation is done |

### Sample output

#### Normal verbosity

```
Invalid - OckCyp\CoversValidator\Tests\Fixtures\TwoTestCoveringNonExistentClassTest::testDummyTest

There were 1 test(s) with invalid @covers tags.
```

#### Maximum verbosity (debug)

```
Configuration file loaded: /home/omer/Projects/Personal/covers-validator/tests/Fixtures/configuration-all.xml

Validating OckCyp\CoversValidator\Tests\Fixtures\TwoTestCoveringExistingClassTest::testDummyTest...
Valid - OckCyp\CoversValidator\Tests\Fixtures\TwoTestCoveringExistingClassTest::testDummyTest
Validating OckCyp\CoversValidator\Tests\Fixtures\TwoTestCoveringNonExistentClassTest::testDummyTest...
Invalid - OckCyp\CoversValidator\Tests\Fixtures\TwoTestCoveringNonExistentClassTest::testDummyTest

There were 1 test(s) with invalid @covers tags.
```

## Tests

To run the tests, execute:

```bash
vendor/bin/phpunit
```

## Versioning

We use [Semantic Versioning](https://semver.org/) for versioning. For the versions available, see the [releases](https://github.com/oradwell/covers-validator/releases) or the [CHANGELOG.md](./CHANGELOG.md) file.

## Authors

- Oliver Radwell - [@oradwell](https://github.com/oradwell)

See also the list of [contributors](https://github.com/oradwell/covers-validator/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.txt](./LICENSE.txt) file for details.

## Acknowledgments

- [Sebastian Bergmann](https://github.com/sebastianbergmann) for creating the [PHPUnit](https://phpunit.de/) project
- The [contributors](https://github.com/oradwell/covers-validator/graphs/contributors)
