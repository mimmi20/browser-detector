<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
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
use UaResult\Browser\Browser;
use UaResult\Company\CompanyInterface;

final class BrowserFactoryTest extends TestCase
{
    /**
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testFromEmptyArray(): void
    {
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::never())
            ->method('load');

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::never())
            ->method('set');
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $this->expectException(\AssertionError::class);
        $this->expectExceptionMessage('"name" property is required');

        /* @var \Psr\Log\LoggerInterface $logger */
        $object->fromArray($logger, [], 'this is a test');
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testFromArrayWithFoundType(): void
    {
        static::markTestSkipped('need to rewrite');
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $version = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::once())
            ->method('set')
            ->with('0')
            ->willReturn($version);

        $typeName = 1;
        $type     = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(static::once())
            ->method('load')
            ->with('1')
            ->willReturn($type);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['name' => null, 'manufacturer' => 'unknown', 'version' => '0', 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        static::assertInstanceOf(Browser::class, $result);
        static::assertNull($result->getName());
        static::assertNull($result->getModus());
        static::assertNull($result->getBits());
        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertSame($version, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
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
            ->expects(static::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $version1 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $v              = '11.2.1';
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::once())
            ->method('set')
            ->with($v)
            ->willReturn($version1);

        $typeName = 'unknown-type';
        $type     = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(static::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        static::assertInstanceOf(Browser::class, $result);
        static::assertNull($result->getName());
        static::assertNull($result->getModus());
        static::assertNull($result->getBits());
        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertSame($version1, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testFromArrayWithFoundTypeAndInvalidVersion(): void
    {
        static::markTestSkipped('need to rewrite');
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        $version1 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $v              = [];
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::once())
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
            ->expects(static::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        static::assertInstanceOf(Browser::class, $result);
        static::assertNull($result->getName());
        static::assertNull($result->getModus());
        static::assertNull($result->getBits());
        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertSame($version1, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObject(): void
    {
        static::markTestSkipped('need to rewrite');
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->with('unknown')
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
            ->expects(static::exactly(2))
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
            ->expects(static::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        static::assertInstanceOf(Browser::class, $result);
        static::assertNull($result->getName());
        static::assertNull($result->getModus());
        static::assertNull($result->getBits());
        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertSame($version2, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testFromArrayWithFoundTypeAndVersionDetectionClass(): void
    {
        static::markTestSkipped('need to rewrite');
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->with('unknown')
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
            ->expects(static::once())
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
            ->expects(static::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        static::assertInstanceOf(Browser::class, $result);
        static::assertNull($result->getName());
        static::assertNull($result->getModus());
        static::assertNull($result->getBits());
        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertNotSame($version2, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObjectAndNoSearch(): void
    {
        static::markTestSkipped('need to rewrite');
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->with('unknown')
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
            ->expects(static::once())
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
            ->expects(static::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            'this is a test'
        );

        static::assertInstanceOf(Browser::class, $result);
        static::assertNull($result->getName());
        static::assertNull($result->getModus());
        static::assertNull($result->getBits());
        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertSame($version1, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testFromArrayWithFoundTypeAndFixedVersionObjectAndSearch(): void
    {
        static::markTestSkipped('need to rewrite');
        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->with('unknown')
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
            ->expects(static::once())
            ->method('set')
            ->with('0')
            ->willReturn($version1);
        $versionFactory
            ->expects(static::once())
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
            ->expects(static::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['name' => null, 'manufacturer' => 'unknown', 'version' => $v, 'type' => $typeName, 'bits' => null, 'modus' => null],
            $useragent
        );

        static::assertInstanceOf(Browser::class, $result);
        static::assertNull($result->getName());
        static::assertNull($result->getModus());
        static::assertNull($result->getBits());
        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertSame($version2, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertSame($company, $result->getManufacturer());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testFromEmptyArrayWithCompanyError(): void
    {
        static::markTestSkipped('need to rewrite');
        $companyName = 'test-company';
        $useragent   = 'this is a test';
        $exception   = new NotFoundException('failed');
        $company     = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->withConsecutive(['unknown', $useragent], [$companyName, $useragent])
            ->willReturnCallback(static function (string $key, string $useragent = '') use ($company, $exception) {
                if ('unknown' === $key) {
                    return $company;
                }
                throw $exception;
            });

        $version = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::exactly(2))
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
            ->expects(static::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::once())
            ->method('info')
            ->with($exception);
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['name' => null, 'manufacturer' => $companyName, 'version' => '0', 'type' => $typeName, 'bits' => null, 'modus' => null],
            $useragent
        );

        static::assertInstanceOf(Browser::class, $result);
        static::assertNull($result->getName());
        static::assertNull($result->getModus());
        static::assertNull($result->getBits());
        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertSame($version, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testFromEmptyArrayWithTypeError(): void
    {
        static::markTestSkipped('need to rewrite');
        $companyName = 'test-company';
        $useragent   = 'this is a test';
        $exception   = new NotFoundException('failed');
        $company     = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->withConsecutive(['unknown', $useragent], [$companyName, $useragent])
            ->willReturnCallback(static function (string $key, string $useragent = '') use ($company, $exception) {
                if ('unknown' === $key) {
                    return $company;
                }
                throw $exception;
            });

        $version = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::exactly(2))
            ->method('set')
            ->with('0')
            ->willReturn($version);

        $typeName  = 'unknown-type';
        $exception = new NotFoundException('type not found');
        $type      = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(static::once())
            ->method('load')
            ->with($typeName)
            ->willThrowException($exception);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        /** @var \UaBrowserType\TypeLoaderInterface $typeLoader */
        $object = new BrowserFactory($companyLoader, $versionFactory, $typeLoader);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::once())
            ->method('info')
            ->with($exception);
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['name' => null, 'manufacturer' => $companyName, 'version' => '0', 'type' => $typeName, 'bits' => null, 'modus' => null],
            $useragent
        );

        static::assertInstanceOf(Browser::class, $result);
        static::assertNull($result->getName());
        static::assertNull($result->getModus());
        static::assertNull($result->getBits());
        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertSame($version, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
    }
}
