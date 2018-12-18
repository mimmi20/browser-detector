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

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \BrowserDetector\Loader\CompanyLoader
 */
class CompanyLoaderTest extends TestCase
{
    /**
     * @return void
     */
    public function testLoadFailHasNot(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 'A6 Corp';
        $brand       = 'A6 Corp';

        $result            = new \stdClass();
        $result->name      = $companyName;
        $result->brandname = $brand;

        $data = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $data->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $data->expects(self::never())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn($result);
        $data->expects(self::once())
            ->method('__invoke');

        /* @var Data $data */
        $object = new CompanyLoader($data);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the company with key "A6Corp" was not found');

        $object($companyKey);
    }

    /**
     * @return void
     */
    public function testLoadFailNullReturned(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 'A6 Corp';
        $brand       = 'A6 Corp';

        $result            = new \stdClass();
        $result->name      = $companyName;
        $result->brandname = $brand;

        $data = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $data->expects(self::once())
            ->method('hasItem')
            ->willReturn(true);
        $data->expects(self::once())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn(null);
        $data->expects(self::once())
            ->method('__invoke');

        /* @var Data $data */
        $object = new CompanyLoader($data);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the company with key "A6Corp" was not found');

        $object($companyKey);
    }

    /**
     * @return void
     */
    public function testLoadAvailable(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 'A6 Corp';
        $brand       = 'A6 Corp';

        $result            = new \stdClass();
        $result->name      = $companyName;
        $result->brandname = $brand;

        $data = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $data->expects(self::once())
            ->method('hasItem')
            ->willReturn(true);
        $data->expects(self::once())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn($result);
        $data->expects(self::once())
            ->method('__invoke');

        /* @var Data $data */
        $object = new CompanyLoader($data);

        /** @var \UaResult\Company\CompanyInterface $result */
        $result = $object($companyKey);

        self::assertInstanceOf(\UaResult\Company\CompanyInterface::class, $result);

        self::assertSame(
            $companyName,
            $result->getName(),
            'Expected Company name to be "' . $companyName . '" (was "' . $result->getName() . '")'
        );
        self::assertSame(
            $brand,
            $result->getBrandName(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrandName() . '")'
        );
    }
}
