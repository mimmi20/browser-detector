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
use BrowserDetector\Loader\Data\Os as OsData;
use BrowserDetector\Loader\InitData\Os as DataOs;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\TestFactory;
use BrowserDetector\Version\TestNotNumericFactory;
use BrowserDetector\Version\TestUnexpectedFactory;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Constraint\IsInstanceOf;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionException;
use ReflectionProperty;
use RuntimeException;
use UaLoader\Exception\NotFoundException;
use UaResult\Bits\Bits;
use UaResult\Company\Company;
use UaResult\Os\Os;
use UnexpectedValueException;

#[CoversClass(PlatformLoader::class)]
#[CoversClass(OsData::class)]
final class PlatformLoader2Test extends TestCase
{
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
    public function testLoadVersionWithException(): void
    {
        $exception = new NotFoundException('test');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception, []);
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

        $initData = new OsData(
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

        $platformData = new DataOs(
            name: null,
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['factory' => TestFactory::class],
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willThrowException($exception);

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

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/12.0');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: new Company(type: 'unknown', name: null, brandname: null),
            version: (new VersionBuilder())->set('1.11.111.1111.11111'),
            bits: Bits::unknown,
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
    public function testLoadNullVersion(): void
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

        $initData = new OsData(
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

        $platformData = new DataOs(name: null, marketingName: null, manufacturer: 'xyz', version: null);

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'xyz-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
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

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/12.0');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: $company,
            version: new NullVersion(),
            bits: Bits::unknown,
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
    public function testLoadStringVersion(): void
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

        $initData = new OsData(
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

        $platformData = new DataOs(
            name: null,
            marketingName: null,
            manufacturer: 'xyz',
            version: '1.0',
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'xyz-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(2);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher): string {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame(
                            VersionInterface::IGNORE_MICRO,
                            $mode,
                            (string) $invocation,
                        ),
                        default => self::assertSame(
                            VersionInterface::COMPLETE,
                            $mode,
                            (string) $invocation,
                        ),
                    };

                    return match ($invocation) {
                        1 => '1.0',
                        default => '1.0.0',
                    };
                },
            );

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willReturn($version);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/12.0');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: $company,
            version: (new VersionBuilder())->set('1.0.0'),
            bits: Bits::unknown,
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
    public function testLoadStringVersionWithException(): void
    {
        $exception = new NotNumericException('test');

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
            ->expects(self::once())
            ->method('error')
            ->with($exception, []);
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $initData = new OsData(
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

        $platformData = new DataOs(
            name: null,
            marketingName: null,
            manufacturer: 'xyz',
            version: '1.0',
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'xyz-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willThrowException($exception);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/12.0');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: $company,
            version: new NullVersion(),
            bits: Bits::unknown,
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
    public function testLoadVersionObject(): void
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

        $initData = new OsData(
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

        $platformData = new DataOs(
            name: null,
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['value' => '1.0'],
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'xyz-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(2);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher): string {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame(
                            VersionInterface::IGNORE_MICRO,
                            $mode,
                            (string) $invocation,
                        ),
                        default => self::assertSame(
                            VersionInterface::COMPLETE,
                            $mode,
                            (string) $invocation,
                        ),
                    };

                    return match ($invocation) {
                        1 => '1.0',
                        default => '1.0.0',
                    };
                },
            );

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willReturn($version);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/12.0');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: $company,
            version: (new VersionBuilder())->set('1.0.0'),
            bits: Bits::unknown,
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
    public function testLoadVersionObjectWithException(): void
    {
        $exception = new NotNumericException('test');

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
            ->expects(self::once())
            ->method('error')
            ->with($exception, []);
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $initData = new OsData(
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

        $platformData = new DataOs(
            name: null,
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['value' => '1.0'],
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'xyz-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willThrowException($exception);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/12.0');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: $company,
            version: new NullVersion(),
            bits: Bits::unknown,
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
    public function testLoadVersionObjectWithException2(): void
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
            ->expects(self::once())
            ->method('error')
            ->with(new IsInstanceOf(UnexpectedValueException::class), []);
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $initData = new OsData(
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

        $platformData = new DataOs(
            name: null,
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['factory' => '\\' . TestUnexpectedFactory::class],
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'xyz-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
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

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/12.0');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: $company,
            version: new NullVersion(),
            bits: Bits::unknown,
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
    public function testLoadVersionObjectWithException3(): void
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
            ->expects(self::once())
            ->method('error')
            ->with(new IsInstanceOf(NotNumericException::class), []);
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $initData = new OsData(
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

        $platformData = new DataOs(
            name: null,
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['factory' => '\\' . TestNotNumericFactory::class],
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'xyz-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
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

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/12.0');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: $company,
            version: new NullVersion(),
            bits: Bits::unknown,
        );

        self::assertSame($expected->toArray(), $result->toArray());
    }
}
