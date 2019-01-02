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

use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaResult\Company\CompanyInterface;
use UaResult\Engine\EngineInterface;

class EngineFactoryTest extends TestCase
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithVersionString(): void
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithInvalidVersion(): void
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version1, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFixedVersionObject(): void
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithVersionDetectionClass(): void
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertNotSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFixedVersionObjectAndNoSearch(): void
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version1, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromArrayWithFixedVersionObjectAndSearch(): void
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

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], $useragent);

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version2, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }

    /**
     * @return void
     */
    public function testFromEmptyArrayWithCompanyError(): void
    {
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
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->withConsecutive(['Unknown', $useragent], [$companyName, $useragent])
            ->willReturnCallback(static function (string $key, string $useragent = '') use ($company, $exception) {
                if ('Unknown' === $key) {
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
            ->expects(self::once())
            ->method('set')
            ->with('0')
            ->willReturn($version);

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['manufacturer' => $companyName], $useragent);

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertNull($result->getName());
        self::assertInstanceOf(VersionInterface::class, $result->getVersion());
        self::assertSame($version, $result->getVersion());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
    }
}
