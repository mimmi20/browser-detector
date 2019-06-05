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

final class EngineFactoryTest extends TestCase
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
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

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, [], 'this is a test');

        static::assertInstanceOf(EngineInterface::class, $result);
        static::assertNull($result->getName());
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
    public function testFromArrayWithVersionString(): void
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
        $v        = '11.2.1';
        $version2 = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::exactly(2))
            ->method('set')
            ->withConsecutive(['0'], [$v])
            ->willReturnOnConsecutiveCalls($version1, $version2);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        static::assertInstanceOf(EngineInterface::class, $result);
        static::assertNull($result->getName());
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
    public function testFromArrayWithInvalidVersion(): void
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
        $v              = [];
        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::once())
            ->method('set')
            ->with('0')
            ->willReturn($version1);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        static::assertInstanceOf(EngineInterface::class, $result);
        static::assertNull($result->getName());
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
    public function testFromArrayWithFixedVersionObject(): void
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

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        static::assertInstanceOf(EngineInterface::class, $result);
        static::assertNull($result->getName());
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
    public function testFromArrayWithVersionDetectionClass(): void
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

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        static::assertInstanceOf(EngineInterface::class, $result);
        static::assertNull($result->getName());
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
    public function testFromArrayWithFixedVersionObjectAndNoSearch(): void
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

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], 'this is a test');

        static::assertInstanceOf(EngineInterface::class, $result);
        static::assertNull($result->getName());
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
    public function testFromArrayWithFixedVersionObjectAndSearch(): void
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

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['version' => $v], $useragent);

        static::assertInstanceOf(EngineInterface::class, $result);
        static::assertNull($result->getName());
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
            ->expects(static::once())
            ->method('set')
            ->with('0')
            ->willReturn($version);

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Version\VersionFactoryInterface $versionFactory */
        $object = new EngineFactory($companyLoader, $versionFactory);

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
        $result = $object->fromArray($logger, ['manufacturer' => $companyName], $useragent);

        static::assertInstanceOf(EngineInterface::class, $result);
        static::assertNull($result->getName());
        static::assertInstanceOf(VersionInterface::class, $result->getVersion());
        static::assertSame($version, $result->getVersion());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        //static::assertEquals($company, $result->getManufacturer());
    }
}
