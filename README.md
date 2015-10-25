ockcyp/covers-validator
=======================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ockcyp/covers-validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ockcyp/covers-validator/?branch=master)

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

Until I put it on packagist you will need to clone the repository
and run `composer install`.

```
git clone https://github.com/ockcyp/covers-validator.git
cd covers-validator
composer install
```

Tests
-----

To run the tests, execute:

```
vendor/bin/phpunit
```

Usage
-----

```
./covers-validator
```
