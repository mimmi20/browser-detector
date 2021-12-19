<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Factory;

use AssertionError;
use BrowserDetector\Factory\BrowserFactory;
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
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use stdClass;
use UaBrowserType\TypeInterface;
use UaBrowserType\TypeLoaderInterface;
use UaBrowserType\Unknown;
use UaResult\Browser\Browser;
use UaResult\Company\CompanyInterface;
use UnexpectedValueException;

final class BrowserFactoryTest extends TestCase
{
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

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"name" property is required');

        $object->fromArray([], 'this is a test');
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundType(): void
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $typeName   = '1';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => null, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testFromArrayWithFoundTypeAndVersionString(): void
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

        $version1       = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $v              = '11.2.1';
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with($v)
            ->willReturn($version1);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version1, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundTypeAndVersionString2(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObject(): void
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

        $version1       = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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
            ->willReturn($version1);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version1, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObject2(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testFromArrayWithFoundTypeAndVersionDetectionClass(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertNotSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundTypeAndVersionDetectionFactory(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(Version::class, $result->getVersion());
        self::assertSame('1.11.111.1111.11111', $result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundTypeAndVersionDetectionFactory2(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObjectAndNoSearch(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObjectAndNoSearch2(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(Version::class, $result->getVersion());
        self::assertSame('1.11.111.1111.11111', $result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObjectAndNoSearch3(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObjectAndSearch(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            [
                'name' => null,
                'manufacturer' => 'unknown',
                'version' => $v,
                'type' => $typeName,
                'bits' => null,
                'modus' => null,
            ],
            $useragent
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObjectAndSearch2(): void
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

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            [
                'name' => null,
                'manufacturer' => 'unknown',
                'version' => $v,
                'type' => $typeName,
                'bits' => null,
                'modus' => null,
            ],
            $useragent
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $typeName   = 'unknown-type';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => $companyName, 'version' => null, 'type' => $typeName, 'bits' => null, 'modus' => null],
            $useragent
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testFromEmptyArrayWithTypeError(): void
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $typeName     = 'unknown-type';
        $exceptionTwo = new \UaBrowserType\NotFoundException('type not found');
        $typeLoader   = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willThrowException($exceptionTwo);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::exactly(2))
            ->method('info')
            ->withConsecutive([$exceptionTwo], [$exception]);
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

        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader, $logger);

        $result = $object->fromArray(
            ['name' => null, 'manufacturer' => $companyName, 'version' => null, 'type' => $typeName, 'bits' => null, 'modus' => null],
            $useragent
        );

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        self::assertNull($result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertInstanceOf(Unknown::class, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertInstanceOf(NullVersion::class, $result->getVersion());
        self::assertNull($result->getVersion()->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
    }
}
