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
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaBrowserType\TypeInterface;
use UaBrowserType\TypeLoaderInterface;
use UaBrowserType\Unknown;
use UaResult\Browser\Browser;
use UaResult\Company\CompanyInterface;

class BrowserFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testFromEmptyArray(): void
    {
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('Unknown')
            ->willReturn($company);

        $version = $this->getMockBuilder(VersionInterface::class)
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
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /* @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, [], 'this is a test');

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        // self::assertNull($result->getBits());
        self::assertSame(32, $result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertInstanceOf(Unknown::class, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithUnknownType(): void
    {
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('Unknown')
            ->willReturn($company);

        $version = $this->getMockBuilder(VersionInterface::class)
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

        $typeName  = 'unknown-type';
        $exception = new NotFoundException('loading failed');

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willThrowException($exception);

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /* @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['type' => $typeName], 'this is a test');

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        // self::assertNull($result->getBits());
        self::assertSame(32, $result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertInstanceOf(Unknown::class, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFoundType(): void
    {
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('Unknown')
            ->willReturn($company);

        $version = $this->getMockBuilder(VersionInterface::class)
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

        $typeName = 'unknown-type';
        $type     = $this->getMockBuilder(TypeInterface::class)
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /* @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['type' => $typeName], 'this is a test');

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        // self::assertNull($result->getBits());
        self::assertSame(32, $result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFoundTypeAndVersionString(): void
    {
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('Unknown')
            ->willReturn($company);

        $version1 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $v        = '11.2.1';
        $version2 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::exactly(2))
            ->method('set')
            ->withConsecutive(['0'], [$v])
            ->willReturnOnConsecutiveCalls($version1, $version2);

        $typeName = 'unknown-type';
        $type     = $this->getMockBuilder(TypeInterface::class)
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /* @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['type' => $typeName, 'version' => $v], 'this is a test');

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        // self::assertNull($result->getBits());
        self::assertSame(32, $result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFoundTypeAndInvalidVersion(): void
    {
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('Unknown')
            ->willReturn($company);

        $version1 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $v              = [];
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('0')
            ->willReturn($version1);

        $typeName = 'unknown-type';
        $type     = $this->getMockBuilder(TypeInterface::class)
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /* @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['type' => $typeName, 'version' => $v], 'this is a test');

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        // self::assertNull($result->getBits());
        self::assertSame(32, $result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version1, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObject(): void
    {
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('Unknown')
            ->willReturn($company);

        $version1 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $v2       = '11.2.1';
        $v        = new \stdClass();
        $v->value = $v2;
        $version2 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::exactly(2))
            ->method('set')
            ->withConsecutive(['0'], [$v2])
            ->willReturnOnConsecutiveCalls($version1, $version2);

        $typeName = 'unknown-type';
        $type     = $this->getMockBuilder(TypeInterface::class)
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /* @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['type' => $typeName, 'version' => $v], 'this is a test');

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        // self::assertNull($result->getBits());
        self::assertSame(32, $result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFoundTypeAndVersionDetectionClass(): void
    {
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('Unknown')
            ->willReturn($company);

        $version1 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $v        = new \stdClass();
        $v->class = '\BrowserDetector\Version\Test';
        $version2 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('0')
            ->willReturn($version1);

        $typeName = 'unknown-type';
        $type     = $this->getMockBuilder(TypeInterface::class)
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /* @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['type' => $typeName, 'version' => $v], 'this is a test');

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        // self::assertNull($result->getBits());
        self::assertSame(32, $result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertNotSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObjectAndNoSearch(): void
    {
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('Unknown')
            ->willReturn($company);

        $version1 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $v              = new \stdClass();
        $v->class       = 'VersionFactory';
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('0')
            ->willReturn($version1);

        $typeName = 'unknown-type';
        $type     = $this->getMockBuilder(TypeInterface::class)
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /* @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['type' => $typeName, 'version' => $v], 'this is a test');

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        // self::assertNull($result->getBits());
        self::assertSame(32, $result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version1, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObjectAndSearch(): void
    {
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('Unknown')
            ->willReturn($company);

        $version1 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $version2 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $useragent      = 'this is a test';
        $search         = ['abc'];
        $v              = new \stdClass();
        $v->class       = 'VersionFactory';
        $v->search      = $search;
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('0')
            ->willReturn($version1);
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, $search)
            ->willReturn($version2);

        $typeName = 'unknown-type';
        $type     = $this->getMockBuilder(TypeInterface::class)
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /* @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['type' => $typeName, 'version' => $v], $useragent);

        self::assertInstanceOf(Browser::class, $result);
        self::assertNull($result->getName());
        self::assertNull($result->getModus());
        // self::assertNull($result->getBits());
        self::assertSame(32, $result->getBits());
        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }
}
