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

use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Helper\FilterInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;

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
        $filter   = $this->getMockBuilder(FilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filter
            ->expects(self::any())
            ->method('__invoke')
            ->with(CompanyLoaderFactory::DATA_PATH, 'json')
            ->willReturn($iterator);

        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \BrowserDetector\Loader\Helper\FilterInterface $filter */
        $factory = new CompanyLoaderFactory($jsonParser, $filter);
        $object  = $factory();

        self::assertInstanceOf(CompanyLoaderInterface::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(CompanyLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
