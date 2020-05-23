<?php
/**
 * This file is part of the mimmi20/template package.
 *
 * Copyright (c) 2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

$header = <<<'EOF'
This file is part of the mimmi20/template package.

Copyright (c) 2020, Thomas Mueller <mimmi20@live.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->name('*.php')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->append([__FILE__]);

$rules = require 'vendor/mimmi20/coding-standard/src/phpcs.config.php';

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(
        array_merge(
            $rules,
            [
                'header_comment' => [
                    'header' => $header,
                    'comment_type' => 'PHPDoc',
                    'location' => 'after_open',
                    'separate' => 'bottom',
                ],
            ]
        )
    )
    ->setUsingCache(true)
    ->setFinder($finder);
