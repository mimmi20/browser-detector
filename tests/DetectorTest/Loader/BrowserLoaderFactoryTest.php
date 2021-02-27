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

use BrowserDetector\Loader\BrowserLoaderFactory;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Helper\FilterInterface;
use BrowserDetector\Parser\EngineParserInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class BrowserLoaderFactoryTest extends TestCase
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     *
     * @return void
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

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $iterator = $this->createMock(\Iterator::class);
        $filter   = $this->getMockBuilder(FilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filter
            ->expects(self::once())
            ->method('__invoke')
            ->with(BrowserLoaderFactory::DATA_PATH, 'json')
            ->willReturn($iterator);

        \assert($logger instanceof LoggerInterface);
        \assert($jsonParser instanceof JsonInterface);
        \assert($companyLoader instanceof CompanyLoaderInterface);
        \assert($engineParser instanceof EngineParserInterface);
        \assert($filter instanceof FilterInterface);
        $factory = new BrowserLoaderFactory($logger, $jsonParser, $companyLoader, $engineParser, $filter);
        $object  = $factory();

        self::assertInstanceOf(BrowserLoaderInterface::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(BrowserLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
