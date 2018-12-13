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

use BrowserDetector\Loader\BrowserLoaderFactory;
use BrowserDetector\Loader\SpecificLoaderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class BrowserLoaderFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        self::markTestIncomplete();
        /** @var NullLogger $logger */
        $logger = $this->createMock(NullLogger::class);

        $factory = new BrowserLoaderFactory($logger);
        $object  = $factory('default');

        self::assertInstanceOf(SpecificLoaderInterface::class, $object);

        $objectTwo = $factory('default');

        self::assertInstanceOf(SpecificLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
