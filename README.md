ockcyp/covers-validator
=======================

[![Build Status](https://travis-ci.org/ockcyp/covers-validator.svg?branch=master)](https://travis-ci.org/ockcyp/covers-validator)
[![Coverage Status](https://coveralls.io/repos/ockcyp/covers-validator/badge.svg?branch=master&service=github)](https://coveralls.io/github/ockcyp/covers-validator?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ockcyp/covers-validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ockcyp/covers-validator/?branch=master)
[![License](https://poser.pugx.org/ockcyp/covers-validator/license)](https://packagist.org/packages/ockcyp/covers-validator)

PHPUnit @covers tags validator

[PHPUnit](https://github.com/sebastianbergmann/phpunit) fails to generate coverage report
when tests have invalid [@covers](https://phpunit.de/manual/3.7/en/appendixes.annotations.html#appendixes.annotations.covers)
tags.

This tool allows you to determine the tests that have invalid @covers tags
without you needing to run the coverage.

Usually coverage reports are run less often than the tests as it takes
a long time to run. This tool validates your @covers tags
quicker than you run your tests.

Why?
----

```
Trying to @cover or @use not existing class or interface "NonExistentClass".
Trying to @cover or @use not existing method "ExistingClass::nonExistantMethod".
```

See: [phpunit/issues/1758](https://github.com/sebastianbergmann/phpunit/issues/1758)
Also see: [phpunit/issues/1791](https://github.com/sebastianbergmann/phpunit/issues/1791)

Installation
------------

```
composer require --dev ockcyp/covers-validator dev-master
```

Usage
-----

```
vendor/bin/covers-validator
```

You can give optional `-c` argument to load a particular PHPUnit configuration file:

```
vendor/bin/covers-validator -c tests/Fixtures/configuration.xml
```

### Sample output

```
Valid - OckCyp\CoversValidator\Tests\Fixtures\TestCoveringExistingClassTest::testDummyTest
Invalid - OckCyp\CoversValidator\Tests\Fixtures\TestCoveringNonExistentClassTest::testDummyTest
```

*Tip:* Command gives exit code 1 when any of the covers tags are invalid.
Use this to fail your builds.

Tests
-----

To run the tests, execute:

```
vendor/bin/phpunit
```
