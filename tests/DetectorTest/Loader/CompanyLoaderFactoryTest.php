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

use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;

class CompanyLoaderFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::any())
            ->method('decode')
            ->willReturn([]);

        $iterator = $this->createMock(\Iterator::class);
        $finder   = $this->getMockBuilder(Finder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $finder
            ->expects(self::any())
            ->method('getIterator')
            ->willReturn($iterator);

        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \Symfony\Component\Finder\Finder $finder */
        $factory = new CompanyLoaderFactory($jsonParser, $finder);
        $object  = $factory();

        self::assertInstanceOf(CompanyLoaderInterface::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(CompanyLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
