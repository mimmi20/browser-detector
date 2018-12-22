<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Loader\DeviceLoaderInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class DeviceLoaderFactoryTest extends TestCase
{
    /**
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
        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Parser\PlatformParserInterface $platformParser */
        $factory = new DeviceLoaderFactory($logger, $jsonParser, $companyLoader, $platformParser);
        $object  = $factory();

        self::assertInstanceOf(DeviceLoaderInterface::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(DeviceLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
