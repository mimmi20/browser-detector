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
use BrowserDetector\Loader\EngineLoaderFactory;
use BrowserDetector\Loader\EngineLoaderInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class EngineLoaderFactoryTest extends TestCase
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

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        $factory = new EngineLoaderFactory($logger, $jsonParser, $companyLoader);
        $object  = $factory();

        self::assertInstanceOf(EngineLoaderInterface::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(EngineLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
