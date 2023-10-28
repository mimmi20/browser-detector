<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class CompanyLoaderFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws RuntimeException
     */
    public function testInvoke(): void
    {
        $factory = new CompanyLoaderFactory();
        $object  = $factory();

        self::assertInstanceOf(CompanyLoaderInterface::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(CompanyLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
