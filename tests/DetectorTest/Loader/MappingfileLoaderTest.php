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

namespace Loader;

use BrowserDetector\Loader\MappingfileLoader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(className: MappingfileLoader::class)]
final class MappingfileLoaderTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetItemWithoutInit(): void
    {
        $mappingfileLoader = new MappingfileLoader();

        $result = $mappingfileLoader->getItem('test');

        self::assertNull($result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws RuntimeException
     */
    public function testGetItemWithInit(): void
    {
        $expected = 'fantech=fantech m200h';

        $mappingfileLoader = new MappingfileLoader();
        $mappingfileLoader->init();

        $result = $mappingfileLoader->getItem('m200h');

        self::assertSame($expected, $result);
    }
}
