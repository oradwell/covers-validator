<?php

namespace OckCyp\CoversValidator\Application;

use Composer\InstalledVersions;

$consoleVersion = InstalledVersions::getVersion('symfony/console');

$chosenClass = CoversValidatorSymfony5::class;
if (\version_compare($consoleVersion, '6.0.0') >= 0) {
    $chosenClass = CoversValidatorSymfony6::class;
}

\class_alias($chosenClass, CoversValidator::class);
