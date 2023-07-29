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

namespace BrowserDetectorTest\Factory;

use AssertionError;
use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\Test;
use BrowserDetector\Version\TestError;
use BrowserDetector\Version\TestErrorFactory;
use BrowserDetector\Version\TestFactory;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Constraint\IsInstanceOf;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use stdClass;
use UaResult\Company\CompanyInterface;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

final class EngineFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testFromEmptyArray(): void
    {
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"name" property is required');

        $object->fromArray([], 'this is a test');
    }

    /** @throws ExpectationFailedException */
    public function testFromArrayWithVersionString(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v              = '11.2.1';
        $version2       = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with($v)
            ->willReturn($version2);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithVersionString2(): void
    {
        $exception = new NotNumericException('not numeric');

        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v              = '11.2.1';
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with($v)
            ->willThrowException($exception);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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
            ->expects(self::once())
            ->method('error')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundTypeAndNullObjectVersion(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v              = new stdClass();
        $v->value       = null;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /** @throws ExpectationFailedException */
    public function testFromArrayWithFixedVersionObject(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v2             = '11.2.1';
        $v              = new stdClass();
        $v->value       = $v2;
        $version2       = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with($v2)
            ->willReturn($version2);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFixedVersionObject2(): void
    {
        $exception = new NotNumericException('not numeric');

        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v2             = '11.2.1';
        $v              = new stdClass();
        $v->value       = $v2;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with($v2)
            ->willThrowException($exception);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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
            ->expects(self::once())
            ->method('error')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /** @throws ExpectationFailedException */
    public function testFromArrayWithVersionDetectionClass(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v              = new stdClass();
        $v->factory     = TestFactory::class;
        $version2       = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertNotSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithVersionDetectionFactory(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v              = new stdClass();
        $v->factory     = TestFactory::class;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(Version::class, $result->getVersion());
        self::assertSame('1.11.111.1111.11111', $result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithVersionDetectionFactory2(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v              = new stdClass();
        $v->factory     = TestErrorFactory::class;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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
            ->expects(self::once())
            ->method('error')
            ->with(new IsInstanceOf(UnexpectedValueException::class));
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFixedVersionObjectAndNoSearch(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v              = new stdClass();
        $v->class       = 'VersionFactory';
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFixedVersionObjectAndNoSearch2(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v              = new stdClass();
        $v->class       = Test::class;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(Version::class, $result->getVersion());
        self::assertSame('1.11.111.1111.11111', $result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFixedVersionObjectAndNoSearch3(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $v              = new stdClass();
        $v->class       = TestError::class;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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
            ->expects(self::once())
            ->method('error')
            ->with(new IsInstanceOf(UnexpectedValueException::class));
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            'this is a test',
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /** @throws ExpectationFailedException */
    public function testFromArrayWithFixedVersionObjectAndSearch(): void
    {
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $version2 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $useragent      = 'this is a test';
        $search         = ['abc'];
        $v              = new stdClass();
        $v->class       = 'VersionFactory';
        $v->search      = $search;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, $search)
            ->willReturn($version2);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            $useragent,
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFixedVersionObjectAndSearch2(): void
    {
        $exception = new NotNumericException('not numeric');

        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $useragent      = 'this is a test';
        $search         = ['abc'];
        $v              = new stdClass();
        $v->class       = 'VersionFactory';
        $v->search      = $search;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, $search)
            ->willThrowException($exception);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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
            ->expects(self::once())
            ->method('error')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v],
            $useragent,
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /** @throws ExpectationFailedException */
    public function testFromEmptyArrayWithCompanyError(): void
    {
        $companyName   = 'test-company';
        $useragent     = 'this is a test';
        $exception     = new NotFoundException('failed');
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with($companyName, $useragent)
            ->willThrowException($exception);

        $version        = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('0')
            ->willReturn($version);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception);
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

        $object = new EngineFactory($companyLoader, $versionFactory, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => $companyName, 'version' => '0'],
            $useragent,
        );

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        // static::assertEquals($company, $result->getManufacturer());
    }
}
