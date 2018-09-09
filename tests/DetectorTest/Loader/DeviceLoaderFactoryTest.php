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

use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Loader\GenericLoader;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class DeviceLoaderFactoryTest extends TestCase
{
    /**
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return void
     */
    public function testInvoke(): void
    {
        /** @var NullLogger $logger */
        $logger = $this->createMock(NullLogger::class);

        $factory = new DeviceLoaderFactory($logger);
        $object  = $factory('unknown', 'default');

        self::assertInstanceOf(GenericLoader::class, $object);

        $objectTwo = $factory('unknown', 'default');

        self::assertInstanceOf(GenericLoader::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
