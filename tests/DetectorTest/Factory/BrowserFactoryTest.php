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
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\TestFactory;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
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
    private const V      = '11.2.1';
    private const V2     = '11.2.1';
    private const SEARCH = ['abc'];

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
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with(self::V)
            ->willReturn($version1);

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
            ['name' => null, 'manufacturer' => 'unknown', 'version' => self::V, 'type' => $typeName, 'bits' => null, 'modus' => null],
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
        $v              = new stdClass();
        $v->value       = self::V2;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with(self::V2)
            ->willReturn($version1);

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
        $v->factory     = '\BrowserDetector\Version\TestFactory';
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');

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
        $v              = new stdClass();
        $v->class       = 'VersionFactory';
        $v->search      = self::SEARCH;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, self::SEARCH)
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
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
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
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
    }
}
