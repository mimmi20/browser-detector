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

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\PlatformLoaderFactory;
use BrowserDetector\Loader\PlatformLoaderInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class PlatformLoaderFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $logger = $this->createMock(LoggerInterface::class);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory = new PlatformLoaderFactory($logger, $companyLoader);
        $object  = $factory();

        self::assertInstanceOf(PlatformLoaderInterface::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(PlatformLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
