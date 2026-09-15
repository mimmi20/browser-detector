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

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(className: CompanyLoaderFactory::class)]
final class CompanyLoaderFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws RuntimeException
     */
    public function testInvoke(): void
    {
        $companyLoaderFactory = new CompanyLoaderFactory();
        $companyLoader        = $companyLoaderFactory();

        self::assertInstanceOf(CompanyLoaderInterface::class, $companyLoader);

        $objectTwo = $companyLoaderFactory();

        self::assertInstanceOf(CompanyLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $companyLoader);
    }
}
