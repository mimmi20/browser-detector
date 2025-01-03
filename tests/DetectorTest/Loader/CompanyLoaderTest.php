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

use AssertionError;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use stdClass;

use function assert;

/**
 * Test class for \BrowserDetector\Loader\CompanyLoader
 */
final class CompanyLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws RuntimeException
     */
    public function testLoadFailHasNot(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 'A6 Corp';
        $brand       = 'A6 Corp';

        $result            = new stdClass();
        $result->name      = $companyName;
        $result->brandname = $brand;

        $data = $this->createMock(DataInterface::class);
        $data->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $data->expects(self::never())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn($result);
        $data->expects(self::once())
            ->method('__invoke');

        assert($data instanceof DataInterface);
        $object = new CompanyLoader($data);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the company with key "A6Corp" was not found');

        $object->load($companyKey);
    }

    /**
     * @throws NotFoundException
     * @throws RuntimeException
     */
    public function testLoadFailNullReturned(): void
    {
        $companyKey = 'A6Corp';

        $data = $this->createMock(DataInterface::class);
        $data->expects(self::once())
            ->method('hasItem')
            ->willReturn(true);
        $data->expects(self::once())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn(null);
        $data->expects(self::once())
            ->method('__invoke');

        assert($data instanceof DataInterface);
        $object = new CompanyLoader($data);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the company with key "A6Corp" was not found');

        $object->load($companyKey);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws RuntimeException
     */
    public function testLoadAvailable(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 'A6 Corp';
        $brand       = 'A6 Corp';

        $result            = new stdClass();
        $result->name      = $companyName;
        $result->brandname = $brand;

        $data = $this->createMock(DataInterface::class);
        $data->expects(self::once())
            ->method('hasItem')
            ->willReturn(true);
        $data->expects(self::once())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn($result);
        $data->expects(self::once())
            ->method('__invoke');

        assert($data instanceof DataInterface);
        $object = new CompanyLoader($data);

        $result = $object->load($companyKey);
        self::assertIsArray($result);

        self::assertSame(
            $companyName,
            $result['name'],
            'Expected Company name to be "' . $companyName . '" (was "' . $result['name'] . '")',
        );
        self::assertSame(
            $brand,
            $result['brandname'],
            'Expected brand name to be "' . $brand . '" (was "' . $result['brandname'] . '")',
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws RuntimeException
     */
    public function testAssertLoad(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 12;
        $brand       = 'A6 Corp';

        $result            = new stdClass();
        $result->name      = $companyName;
        $result->brandname = $brand;

        $data = $this->createMock(DataInterface::class);
        $data->expects(self::once())
            ->method('hasItem')
            ->willReturn(true);
        $data->expects(self::once())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn($result);
        $data->expects(self::once())
            ->method('__invoke');

        assert($data instanceof DataInterface);
        $object = new CompanyLoader($data);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"name" property is required');
        $this->expectExceptionCode(1);

        $object->load($companyKey);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws RuntimeException
     */
    public function testAssertLoad2(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 'A6 Corp';
        $brand       = 12;

        $result            = new stdClass();
        $result->name      = $companyName;
        $result->brandname = $brand;

        $data = $this->createMock(DataInterface::class);
        $data->expects(self::once())
            ->method('hasItem')
            ->willReturn(true);
        $data->expects(self::once())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn($result);
        $data->expects(self::once())
            ->method('__invoke');

        assert($data instanceof DataInterface);
        $object = new CompanyLoader($data);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"brandname" property is required');
        $this->expectExceptionCode(1);

        $object->load($companyKey);
    }
}
