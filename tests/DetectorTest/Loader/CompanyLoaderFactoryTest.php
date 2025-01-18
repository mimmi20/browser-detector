<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use Laminas\Hydrator\Strategy\StrategyInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(CompanyLoaderFactory::class)]
final class CompanyLoaderFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws RuntimeException
     */
    public function testInvoke(): void
    {
        $strategy = $this->createMock(StrategyInterface::class);
        $strategy->expects(self::never())
            ->method('extract');
        $strategy->expects(self::never())
            ->method('hydrate');

        $factory = new CompanyLoaderFactory();
        $object  = $factory($strategy);

        self::assertInstanceOf(CompanyLoaderInterface::class, $object);

        $objectTwo = $factory($strategy);

        self::assertInstanceOf(CompanyLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
