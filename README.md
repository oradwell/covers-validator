ockcyp/covers-validator
=======================

[![Build Status](https://travis-ci.org/oradwell/covers-validator.svg?branch=master)](https://travis-ci.org/oradwell/covers-validator)
[![Coverage Status](https://coveralls.io/repos/github/oradwell/covers-validator/badge.svg?branch=master)](https://coveralls.io/github/oradwell/covers-validator?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/oradwell/covers-validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/oradwell/covers-validator/?branch=master)
[![License](https://poser.pugx.org/ockcyp/covers-validator/license)](https://packagist.org/packages/ockcyp/covers-validator)

PHPUnit @covers tags validator

[PHPUnit](https://github.com/sebastianbergmann/phpunit) fails to generate coverage report
when tests have invalid [@covers](https://phpunit.de/manual/6.0/en/appendixes.annotations.html#appendixes.annotations.covers)
tags.

This tool allows you to determine the tests that have invalid @covers tags
without you needing to run the coverage.

Usually coverage reports are run less often than the tests as it takes
a long time to run. This tool validates your @covers tags
quicker than you run your tests.

**Also see:** [dunkelfrosch/phpcoverfish](https://github.com/dunkelfrosch/phpcoverfish)

Why?
----

```
Trying to @cover or @use not existing class or interface "NonExistentClass".
Trying to @cover or @use not existing method "ExistingClass::nonExistantMethod".
```

See: [phpunit/issues/1758](https://github.com/sebastianbergmann/phpunit/issues/1758)<br />
Also see: [phpunit/issues/1791](https://github.com/sebastianbergmann/phpunit/issues/1791)

Installation
------------

```
composer require --dev ockcyp/covers-validator
```

### PHPUnit versions

Latest version of covers-validator only supports PHP 7.x and PHPUnit 6.x. Please use version 0.5 for older PHP and PHPUnit versions.

| PHPUnit version | Covers-validator version |
| --------------- | ------------------------ |
| < 6.0           | 0.5                      |
| >= 6.0          | 0.6                      |

Install using the following for version 0.5:

```
composer require --dev ockcyp/covers-validator "^0.5.0"
```

Usage
-----

```
vendor/bin/covers-validator
```

Give optional `-c` argument to load a particular PHPUnit configuration file:

```
vendor/bin/covers-validator -c tests/Fixtures/configuration.xml
```

Override `bootstrap` specified in PHPUnit configuration:

```
vendor/bin/covers-validator --bootstrap tests/bootstrap.php
```

Disable output by providing `-q` argument

```
vendor/bin/covers-validator -q
```

Adjust the verbosity:

| Verbosity | Shows                               |
| --------- | ----------------------------------- |
| -v        | Valid tests                         |
| -vv       | Loaded configuration file           |
| -vvv      | Test name before validation is done |

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

**Tip:** Command gives exit code 1 when any of the covers tags are invalid.
Use this to fail your builds.

Tests
-----

To run the tests, execute:

```
vendor/bin/phpunit
```
