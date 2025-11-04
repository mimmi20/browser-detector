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

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\Data\Company as CompanyData;
use BrowserDetector\Loader\Data\DataInterface;
use BrowserDetector\Loader\InitData\Company as DataCompany;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionProperty;
use RuntimeException;
use UaLoader\Exception\NotFoundException;

#[CoversClass(CompanyLoader::class)]
#[CoversClass(CompanyData::class)]
final class CompanyLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws RuntimeException
     */
    public function testLoadFailHasNot(): void
    {
        $companyKey = 'A6Corp';

        $initData = new CompanyData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function extract(mixed $value, object | null $object = null): null
                {
                    return null;
                }

                /**
                 * @param array<mixed>|null $data
                 *
                 * @return array<string, mixed>
                 *
                 * @throws void
                 *
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
        );

        $object = new CompanyLoader($initData);

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

        $initData = new CompanyData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function extract(mixed $value, object | null $object = null): null
                {
                    return null;
                }

                /**
                 * @param array<mixed>|null $data
                 *
                 * @return array<string, mixed>
                 *
                 * @throws void
                 *
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
        );

        $object = new CompanyLoader($initData);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the company with key "A6Corp" was not found');

        $object->load($companyKey);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function testLoadAvailable(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 'A6 Corp';
        $brand       = 'A6 Corp';

        $initData = new CompanyData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function extract(mixed $value, object | null $object = null): null
                {
                    return null;
                }

                /**
                 * @param array<mixed>|null $data
                 *
                 * @return array<string, mixed>
                 *
                 * @throws void
                 *
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
        );

        $companyData = new DataCompany(name: $companyName, brandname: $brand);

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, [$companyKey => $companyData]);

        $object = new CompanyLoader($initData);

        $result = $object->load($companyKey);

        $prop = new ReflectionProperty($initData, 'initialized');

        self::assertTrue($prop->getValue($initData));

        self::assertSame(
            $companyName,
            $result->getName(),
            'Expected CompanyData name to be "' . $companyName . '" (was "' . $result->getName() . '")',
        );
        self::assertSame(
            $brand,
            $result->getBrandName(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrandName() . '")',
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testLoadAvailable2(): void
    {
        $companyKey  = 'A6Corp';
        $companyName = 'A6 Corp';
        $brand       = 'A6 Corp';

        $companyData = new DataCompany(name: $companyName, brandname: $brand);

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('init');
        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with($companyKey)
            ->willReturn($companyData);

        $object = new CompanyLoader($initData);

        $result = $object->load($companyKey);

        self::assertSame(
            $companyName,
            $result->getName(),
            'Expected Company name to be "' . $companyName . '" (was "' . $result->getName() . '")',
        );
        self::assertSame(
            $brand,
            $result->getBrandName(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrandName() . '")',
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testLoadWithInitException(): void
    {
        $companyKey = 'A6Corp';

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('init')
            ->willThrowException(new RuntimeException('error'));
        $initData
            ->expects(self::never())
            ->method('getItem');

        $object = new CompanyLoader($initData);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('the company with key "' . $companyKey . '" was not found');

        $object->load($companyKey);
    }
}
