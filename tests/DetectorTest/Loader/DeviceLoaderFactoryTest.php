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

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;
use UaLoader\DeviceLoaderInterface;

final class DeviceLoaderFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws RuntimeException
     */
    public function testInvoke(): void
    {
        $company = 'test-company';

        $logger        = $this->createMock(LoggerInterface::class);
        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        $factory = new DeviceLoaderFactory($logger, $companyLoader);
        $object  = $factory($company);

        self::assertInstanceOf(DeviceLoaderInterface::class, $object);

        $objectTwo = $factory($company);

        self::assertInstanceOf(DeviceLoaderInterface::class, $objectTwo);
        self::assertSame($objectTwo, $object);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "apple iphone" was not found');
        $this->expectExceptionCode(0);

        $object->load('apple iphone');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws RuntimeException
     */
    public function testInvoke2(): void
    {
        $company = 'apple';

        $logger        = $this->createMock(LoggerInterface::class);
        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        $factory = new DeviceLoaderFactory($logger, $companyLoader);
        $object  = $factory($company);

        self::assertInstanceOf(DeviceLoaderInterface::class, $object);

        $device = $object->load('apple iphone');

        self::assertSame('iPhone', $device[0]['deviceName']);
    }
}
