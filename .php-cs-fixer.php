<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PHP71Migration' => true,
        '@Symfony' => true,
        'phpdoc_summary' => false,
        'phpdoc_align' => false,
    ])
    ->setFinder($finder)
;

return $config;
