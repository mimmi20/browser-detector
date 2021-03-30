<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Helper\FilterInterface;
use BrowserDetector\Loader\PlatformLoaderFactory;
use BrowserDetector\Loader\PlatformLoaderInterface;
use Iterator;
use JsonClass\JsonInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

use function assert;

final class PlatformLoaderFactoryTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     */
    public function testInvoke(): void
    {
        $logger     = $this->createMock(LoggerInterface::class);
        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::any())
            ->method('decode')
            ->willReturn([]);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $iterator = $this->createMock(Iterator::class);
        $filter   = $this->getMockBuilder(FilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filter
            ->expects(self::once())
            ->method('__invoke')
            ->with(PlatformLoaderFactory::DATA_PATH, 'json')
            ->willReturn($iterator);

        assert($logger instanceof LoggerInterface);
        assert($jsonParser instanceof JsonInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($filter instanceof FilterInterface);
        $factory = new PlatformLoaderFactory($logger, $jsonParser, $companyLoader, $filter);
        $object  = $factory();

        self::assertInstanceOf(PlatformLoaderInterface::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(PlatformLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
