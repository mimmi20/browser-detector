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
use BrowserDetector\Version\FirefoxOsFactory;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\TestFactory;
use BrowserDetector\Version\TestNotNumericFactory;
use BrowserDetector\Version\TestUnexpectedFactory;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderFactory;
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
use UaResult\Company\Company;
use UaResult\Os\Os;
use UnexpectedValueException;

#[CoversClass(PlatformLoader::class)]
final class PlatformLoaderTest extends TestCase
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

        $initData = new OsData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');
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

        $initData = new OsData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');
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

        $initData = new OsData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
            version: (object) ['class' => null],
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

        $result = $object->load('test-key', 'test-ua');

        $expected = new Os(
            name: null,
            marketingName: null,
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
    public function testInvokeVersionSet(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
            version: (object) ['class' => null, 'value' => '1.0'],
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

        $result = $object->load('test-key', 'test-ua');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: $company,
            version: (new VersionBuilder())->set('1.0.0'),
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
    public function testInvokeGenericVersionForMacos(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
        );

        $platformData = new DataOs(
            name: 'Mac OS X',
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['factory' => '\\' . VersionBuilderFactory::class, 'search' => ['test']],
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

        $result = $object->load('test-key', 'test/10.12');

        $expected = new Os(
            name: 'macOS',
            marketingName: 'macOS',
            manufacturer: $company,
            version: (new VersionBuilder())->set('10.12.0'),
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
    public function testInvokeGenericVersionForMacos2(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
        );

        $platformData = new DataOs(
            name: 'Mac OS X',
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['factory' => '\\' . VersionBuilderFactory::class, 'search' => ['test']],
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

        $result = $object->load('test-key', 'test/10.11');

        $expected = new Os(
            name: 'Mac OS X',
            marketingName: null,
            manufacturer: $company,
            version: (new VersionBuilder())->set('10.11.0'),
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
    public function testInvokeGenericVersionIos(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
        );

        $platformData = new DataOs(
            name: 'iOS',
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['factory' => '\\' . VersionBuilderFactory::class, 'search' => ['test']],
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

        $result = $object->load('test-key', 'test/3.0');

        $expected = new Os(
            name: 'iPhone OS',
            marketingName: 'iPhone OS',
            manufacturer: $company,
            version: (new VersionBuilder())->set('3.0.0'),
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

        $initData = new OsData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
    public function testInvokeNullVersion(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
    public function testInvokeStringVersion(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
    public function testInvokeStringVersionWithException(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
    public function testInvokeVersionObject(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
    public function testInvokeVersionObjectWithException(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
    public function testInvokeVersionObjectWithException2(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
    public function testInvokeVersionObjectWithException3(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
    public function testInvokeVersionObject2(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
            version: (object) ['factory' => '\\' . FirefoxOsFactory::class],
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

        $result = $object->load('test-key', 'test/12.0 rv:44.0');

        $expected = new Os(
            name: null,
            marketingName: null,
            manufacturer: $company,
            version: (new VersionBuilder())->set('2.5.0'),
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
    public function testInvokeVersionObject3(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
            version: (object) ['value' => 1],
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
            ->with('1')
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
    public function testInvokeVersionObject4(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
            version: (object) ['value' => 1.2],
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
                        1 => '1.2',
                        default => '1.2.0',
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
            ->with('1.2')
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
            version: (new VersionBuilder())->set('1.2.0'),
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
    public function testInvokeVersionObject5(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
            version: (object) ['value' => []],
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
    public function testInvokeVersionObject6(): void
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
            version: (object) ['value' => null],
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
    public function testInvokeVersionObject7(): void
    {
        $platformVersion = '1.2.3.4';

        $exception = new UnexpectedValueException();

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

        $platformData = new DataOs(
            name: null,
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['value' => $platformVersion],
        );

        $initData = new OsData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
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
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MICRO)
            ->willThrowException($exception);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/12.0');

        self::assertNull($result->getName());
        self::assertNull($result->getMarketingName());
        self::assertSame($company, $result->getManufacturer());
        self::assertSame($version, $result->getVersion());
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
    public function testInvokeVersionObject8(): void
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

        $platformData = new DataOs(
            name: null,
            marketingName: null,
            manufacturer: 'xyz',
            version: (object) ['factory' => VersionBuilderFactory::class, 'search' => 'abc'],
        );

        $initData = new OsData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
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

        self::assertNull($result->getName());
        self::assertNull($result->getMarketingName());
        self::assertSame($company, $result->getManufacturer());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
    }
}
