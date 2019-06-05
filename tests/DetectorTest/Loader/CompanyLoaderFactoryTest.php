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

final class CompanyLoaderFactoryTest extends TestCase
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
        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(static::any())
            ->method('decode')
            ->willReturn([]);

        $iterator = $this->createMock(\Iterator::class);
        $filter   = $this->getMockBuilder(FilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filter
            ->expects(static::any())
            ->method('__invoke')
            ->with(CompanyLoaderFactory::DATA_PATH, 'json')
            ->willReturn($iterator);

        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \BrowserDetector\Loader\Helper\FilterInterface $filter */
        $factory = new CompanyLoaderFactory($jsonParser, $filter);
        $object  = $factory();

        static::assertInstanceOf(CompanyLoaderInterface::class, $object);

        $objectTwo = $factory();

        static::assertInstanceOf(CompanyLoaderInterface::class, $objectTwo);
        static::assertSame($objectTwo, $object);
    }
}
