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

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\Data\Company as CompanyData;
use BrowserDetector\Loader\Data\DataInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionException;
use ReflectionProperty;
use RuntimeException;
use UaLoader\Exception\NotFoundException;
use UaResult\Company\Company;

#[CoversClass(className: CompanyLoader::class)]
#[CoversClass(className: CompanyData::class)]
final class CompanyLoaderTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function testLoadAvailable(): void
    {
        $companyKey  = 'dune-hd';
        $companyName = 'Dune HD';
        $brand       = 'Dune HD';

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

        $initData = new CompanyData(logger: $logger);

        $companyData = new Company(type: $companyKey, name: $companyName, brandname: $brand);

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, [$companyKey => $companyData]);

        $companyLoader = new CompanyLoader($initData);

        $result = $companyLoader->load($companyKey);

        $prop = new ReflectionProperty($initData, 'initialized');

        self::assertTrue($prop->getValue($initData));

        self::assertSame(
            $companyName,
            $result->getName(),
            'Expected CompanyData name to be "' . $companyName . '" (was "' . $result->getName() . '")',
        );
        self::assertSame(
            $brand,
            $result->getBrandname(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrandname() . '")',
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws RuntimeException
     */
    public function testLoadAvailable2(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 'A6 Corp';
        $brand       = 'A6 Corp';

        $company = new Company(type: $companyKey, name: $companyName, brandname: $brand);

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('init');
        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn($company);

        $companyLoader = new CompanyLoader($initData);

        $result = $companyLoader->load($companyKey);

        self::assertSame(
            $companyName,
            $result->getName(),
            'Expected Company name to be "' . $companyName . '" (was "' . $result->getName() . '")',
        );
        self::assertSame(
            $brand,
            $result->getBrandname(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrandname() . '")',
        );
    }
}
