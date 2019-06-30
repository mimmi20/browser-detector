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
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\AndroidOs;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class AndroidOsTest extends TestCase
{
    /**
     * @dataProvider providerVersion
     *
     * @param string      $useragent
     * @param string|null $expectedVersion
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testTestdetectVersion(string $useragent, ?string $expectedVersion): void
    {
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

        /** @var LoggerInterface $logger */
        $object = new AndroidOs($logger, new VersionFactory());

        $detectedVersion = $object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array[]
     */
    public function providerVersion(): array
    {
        return [
            [
                'Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; Milestone Build/SHOLS_U2_02.36.0) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
                '2.1.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; de-de; GT-I9100 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Safari/533.1',
                '2.3.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android Eclair; md-us Build/pandigitalopc1/sourceidDL00000009) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
                '2.1.0',
            ],
            [
                'Dalvik/1.4.0 (Linux; U; Android 2.3.6; GT-I9100G Build/GINGERBREAD)',
                '2.3.6',
            ],
            [
                'Mozilla/5.0 (Linux; 4.4.4; Nexus 7 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.107 Safari/537.36 Obigo/W20A.42',
                '4.4.4',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                null,
            ],
            [
                'Booking.com Android App 16.0.0.5723278 (OS: 8.1.0; Type: tablet; AppStore: google; Brand: samsung; Model: SM-T590;)',
                '8.1.0',
            ],
        ];
    }

    /**
     * @return void
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Dalvik/1.4.0 (Linux; U; Android 2.3.6; GT-I9100G Build/GINGERBREAD)';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::once())
            ->method('detectVersion')
            ->with($useragent, AndroidOs::SEARCHES)
            ->willThrowException($exception);
        $versionFactory
            ->expects(static::never())
            ->method('set');

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertInstanceOf(NullVersion::class, $detectedVersion);
        static::assertNull($detectedVersion->getVersion());
    }

    /**
     * @return void
     */
    public function testDetectVersionFailSecond(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; 4.4.4; Nexus 7 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.107 Safari/537.36 Obigo/W20A.42';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::once())
            ->method('set')
            ->with('4.4.4')
            ->willThrowException($exception);

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertInstanceOf(NullVersion::class, $detectedVersion);
        static::assertNull($detectedVersion->getVersion());
    }

    /**
     * @return void
     */
    public function testDetectVersionFailThird(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; U; de-de; GT-I9100 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Safari/533.1';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::once())
            ->method('set')
            ->with('2.3.0')
            ->willThrowException($exception);

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertInstanceOf(NullVersion::class, $detectedVersion);
        static::assertNull($detectedVersion->getVersion());
    }

    /**
     * @return void
     */
    public function testDetectVersionFailForth(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; U; Android Eclair; md-us Build/pandigitalopc1/sourceidDL00000009) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(static::once())
            ->method('set')
            ->with('2.1.0')
            ->willThrowException($exception);

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertInstanceOf(NullVersion::class, $detectedVersion);
        static::assertNull($detectedVersion->getVersion());
    }
}
