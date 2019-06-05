<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
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
     * @throws \BrowserDetector\Loader\NotFoundException
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
            ->expects(static::any())
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
            ->expects(static::once())
            ->method('__invoke')
            ->with(BrowserLoaderFactory::DATA_PATH, 'json')
            ->willReturn($iterator);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Parser\EngineParserInterface $engineParser */
        /** @var \BrowserDetector\Loader\Helper\FilterInterface $filter */
        $factory = new BrowserLoaderFactory($logger, $jsonParser, $companyLoader, $engineParser, $filter);
        $object  = $factory();

        static::assertInstanceOf(BrowserLoaderInterface::class, $object);

        $objectTwo = $factory();

        static::assertInstanceOf(BrowserLoaderInterface::class, $objectTwo);
        static::assertSame($objectTwo, $object);
    }
}
