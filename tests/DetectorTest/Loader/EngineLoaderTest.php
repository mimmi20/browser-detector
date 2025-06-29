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
use BrowserDetector\Loader\Data\Engine as EngineData;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\InitData\Engine as DataEngine;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\TestFactory;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderFactory;
use BrowserDetector\Version\VersionBuilderInterface;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;
use PHPUnit\Event\NoPreviousThrowableException;
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
use UaResult\Engine\Engine;
use UnexpectedValueException;

#[CoversClass(EngineLoader::class)]
final class EngineLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvokeNotInCache(): void
    {
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

        $initData = new EngineData(
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

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::never())
            ->method('set');
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new EngineLoader($logger, $initData, $companyLoader, $versionBuilder);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the engine with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key', 'test-ua');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvokeNullInCache(): void
    {
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

        $initData = new EngineData(
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

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::never())
            ->method('set');
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new EngineLoader($logger, $initData, $companyLoader, $versionBuilder);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the engine with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key', 'test-ua');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvokeNoVersion(): void
    {
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

        $initData = new EngineData(
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

        $engineData = new DataEngine(
            name: null,
            manufacturer: 'abc',
            version: (object) ['class' => null],
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $engineData]);

        $company = new Company(type: 'abc-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('abc')
            ->willReturn($company);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::never())
            ->method('set');
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new EngineLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test-ua');

        $expected = new Engine(
            name: null,
            manufacturer: $company,
            version: new NullVersion(),
        );

        self::assertSame($expected->toArray(), $result->toArray());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvokeGenericVersion(): void
    {
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

        $initData = new EngineData(
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

        $engineData = new DataEngine(
            name: null,
            manufacturer: 'abc',
            version: (object) ['factory' => '\\' . VersionBuilderFactory::class, 'search' => ['test']],
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $engineData]);

        $company = new Company(type: 'abc-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('abc')
            ->willReturn($company);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::never())
            ->method('set');
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new EngineLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test-ua');

        $expected = new Engine(
            name: null,
            manufacturer: $company,
            version: new NullVersion(),
        );

        self::assertSame($expected->toArray(), $result->toArray());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws NotNumericException
     * @throws ReflectionException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvokeVersion(): void
    {
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

        $initData = new EngineData(
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

        $engineData = new DataEngine(
            name: null,
            manufacturer: 'abc',
            version: (object) ['factory' => TestFactory::class],
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $engineData]);

        $company = new Company(type: 'abc-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('abc')
            ->willReturn($company);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::never())
            ->method('set');
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new EngineLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test-ua');

        $expected = new Engine(
            name: null,
            manufacturer: $company,
            version: (new VersionBuilder())->set('1.11.111.1111.11111'),
        );

        self::assertSame($expected->toArray(), $result->toArray());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws NotNumericException
     * @throws ReflectionException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvokeVersionWithException(): void
    {
        $exeption = new NotFoundException('test');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exeption, []);
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

        $initData = new EngineData(
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

        $engineData = new DataEngine(
            name: null,
            manufacturer: 'abc',
            version: (object) ['factory' => TestFactory::class],
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $engineData]);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('abc')
            ->willThrowException($exeption);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::never())
            ->method('set');
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new EngineLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test-ua');

        $expected = new Engine(
            name: null,
            manufacturer: new Company(type: 'unknown', name: null, brandname: null),
            version: (new VersionBuilder())->set('1.11.111.1111.11111'),
        );

        self::assertSame($expected->toArray(), $result->toArray());
    }
}
