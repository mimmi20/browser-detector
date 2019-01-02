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
use BrowserDetector\Loader\PlatformLoaderFactory;
use BrowserDetector\Loader\PlatformLoaderInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;

class PlatformLoaderFactoryTest extends TestCase
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

        $iterator = $this->createMock(\Iterator::class);
        $finder   = $this->getMockBuilder(Finder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $finder
            ->expects(self::once())
            ->method('getIterator')
            ->willReturn($iterator);
        $finder
            ->expects(self::once())
            ->method('files');
        $finder
            ->expects(self::once())
            ->method('name')
            ->with('*.json');
        $finder
            ->expects(self::once())
            ->method('ignoreDotFiles')
            ->with(true);
        $finder
            ->expects(self::once())
            ->method('ignoreVCS')
            ->with(true);
        $finder
            ->expects(self::once())
            ->method('ignoreUnreadableDirs');
        $finder
            ->expects(self::once())
            ->method('in')
            ->with('/home/developer/projects/BrowserDetector/src/Loader/../../data/platforms');

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \Symfony\Component\Finder\Finder $finder */
        $factory = new PlatformLoaderFactory($logger, $jsonParser, $companyLoader, $finder);
        $object  = $factory();

        self::assertInstanceOf(PlatformLoaderInterface::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(PlatformLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
