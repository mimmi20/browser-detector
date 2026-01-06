<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\DeviceLoaderFactory;
use Laminas\Hydrator\Exception\InvalidArgumentException;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaLoader\DeviceLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaResult\Company\Company;

#[CoversClass(DeviceLoaderFactory::class)]
final class DeviceLoaderFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvoke(): void
    {
        $company = 'apple';

        $comp = new Company($company, 'Apple', 'Apple');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::atLeastOnce())
            ->method('load')
            ->with('Apple')
            ->willReturn($comp);

        $factory = new DeviceLoaderFactory($logger, $companyLoader);
        $object  = $factory($company);

        self::assertInstanceOf(DeviceLoaderInterface::class, $object);

        $device = $object->load('apple iphone');

        self::assertSame('iPhone', $device->getDevice()->getDeviceName());
    }
}
