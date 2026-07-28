<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

$config
    // Adjusting scanned paths
    ->addPathToScan(__DIR__ . '/src', isDev: false)
    ->addPathToScan(__DIR__ . '/tests', isDev: true)
    // applies only to directory scanning, not directly listed files
    ->setFileExtensions(['php'])

    // do not complain about some modules
    ->ignoreErrorsOnPackage('mimmi20/coding-standard', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('phpstan/extension-installer', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('phpstan/phpstan-deprecation-rules', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('ergebnis/composer-normalize', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('infection/infection', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('phpstan/phpstan', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('rector/rector', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('rector/type-perfect', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('shipmonk/composer-dependency-analyser', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('symplify/phpstan-rules', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('tomasvotruba/cognitive-complexity', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('tomasvotruba/type-coverage', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('tomasvotruba/unused-public', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage(
        'jbelien/phpstan-sarif-formatter',
        [ErrorType::UNUSED_DEPENDENCY],
    )

    // Adjust analysis
    // dev packages are often used only in CI, so this is not enabled by default
    ->enableAnalysisOfUnusedDevDependencies();

return $config;
