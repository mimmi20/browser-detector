<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\ErrorVersionCreatorFactory;
use BrowserDetector\Version\TestFactory;
use BrowserDetector\Version\VersionBuilderFactory;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Stringable;
use UaBrowserType\TypeLoaderInterface;
use UaBrowserType\Unknown;
use UnexpectedValueException;

use function assert;

final class BrowserLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(false);
        $initData
            ->expects(self::never())
            ->method('getItem');

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
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

        $object = new BrowserLoader($logger, $initData, $companyLoader, $typeLoader, $versionBuilder);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the browser with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key', 'test-ua');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);
        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
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

        $object = new BrowserLoader($logger, $initData, $companyLoader, $typeLoader, $versionBuilder);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the browser with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key', 'test-ua');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $browserData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => null,
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(['type' => 'unknown']);

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

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

        $object = new BrowserLoader($logger, $initData, $companyLoader, $typeLoader, $versionBuilder);

        $result = $object->load('test-key', 'test-ua');

        $expected = [
            [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeGenericVersionAndEngineException(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::never())
            ->method('debug');
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $browserData = (object) [
            'version' => (object) ['factory' => '\\' . VersionBuilderFactory::class, 'search' => ['test']],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(['type' => 'unknown']);

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

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

        $object = new BrowserLoader($logger, $initData, $companyLoader, $typeLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/1.0');

        $expected = [
            [
                'name' => null,
                'version' => '1.0.0',
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'unknown',
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeGenericVersionAndEngineInvalidException(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::never())
            ->method('debug');
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $useragent   = 'test/1.0';
        $engineKey   = 'unknown';
        $browserData = (object) [
            'version' => (object) ['factory' => '\\' . VersionBuilderFactory::class, 'search' => ['test']],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => $engineKey,
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(['type' => 'unknown']);

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

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

        $object = new BrowserLoader($logger, $initData, $companyLoader, $typeLoader, $versionBuilder);

        $result = $object->load('test-key', $useragent);

        $expected = [
            [
                'name' => null,
                'version' => '1.0.0',
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'unknown',
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeVersionAndEngine(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $browserData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => 'test-browser',
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(['type' => 'unknown']);

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

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

        $object = new BrowserLoader($logger, $initData, $companyLoader, $typeLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/1.0');

        $expected = [
            [
                'name' => 'test-browser',
                'version' => '1.11.111.1111.11111',
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'unknown',
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeVersionAndEngineWithException(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $browserData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => 'test-browser',
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willThrowException($exception);

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

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

        $object = new BrowserLoader($logger, $initData, $companyLoader, $typeLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/1.0');

        $expected = [
            [
                'name' => 'test-browser',
                'version' => '1.11.111.1111.11111',
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'unknown',
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeVersionAndEngineWithException2(): void
    {
        $exception = new \UaBrowserType\NotFoundException('test');

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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $browserData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => 'test-browser',
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(['type' => 'unknown']);

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
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

        $object = new BrowserLoader($logger, $initData, $companyLoader, $typeLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/1.0');

        $expected = [
            [
                'name' => 'test-browser',
                'version' => '1.11.111.1111.11111',
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'unknown',
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeGenericVersion2(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::once())
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []): void {
                    self::assertInstanceOf(UnexpectedValueException::class, $message);
                    self::assertSame([], $context);

                    assert($message instanceof UnexpectedValueException);

                    self::assertSame(VersionInterface::COMPLETE . '::[]', $message->getMessage());
                    self::assertSame(0, $message->getCode());
                    self::assertNull($message->getPrevious());
                },
            );
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $engineKey   = 'unknown';
        $browserData = (object) [
            'version' => (object) ['factory' => '\\' . ErrorVersionCreatorFactory::class, 'search' => 'test'],
            'manufacturer' => 'xyz',
            'type' => 'unknown',
            'engine' => $engineKey,
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

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

        $object = new BrowserLoader($logger, $initData, $companyLoader, $typeLoader, $versionBuilder);

        $result = $object->load('test-key', 'test/3.0');

        $expected = [
            [
                'name' => null,
                'version' => null,
                'manufacturer' => 'xyz-type',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'unknown',
        ];

        self::assertSame($expected, $result);
    }
}
