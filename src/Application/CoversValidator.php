<?php

namespace OckCyp\CoversValidator\Application;

use Composer\InstalledVersions;

$isSymfony6 = \version_compare(
    InstalledVersions::getVersion('symfony/console'),
    '6.0.0'
) >= 0;

\class_alias(
    $isSymfony6 ? CoversValidatorSymfony6::class : CoversValidatorSymfony5::class,
    'OckCyp\CoversValidator\Application\CoversValidator'
);
