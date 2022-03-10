<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
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
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UnexpectedValueException;

use function assert;

final class AndroidOsTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     *
     * @dataProvider providerVersion
     */
    public function testTestdetectVersion(string $useragent, ?string $expectedVersion): void
    {
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

        assert($logger instanceof LoggerInterface);
        $object = new AndroidOs($logger, new VersionFactory());

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string|null>>
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
            [
                'Mozilla/5.0 (Android M; Mobile; rv:41.0) Gecko/41.0 Firefox/41.0',
                '6.0.0',
            ],
            [
                '{version:6.1937.3-arm64-v8a,platform:server_android,osversion:8.0.0}',
                '8.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; SM-G850F Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Mobile Safari/537.36 Instagram 19.1.0.31.91 Android (19/4.4.4; 320dpi; 720x1280; samsung; SM-G850F; slte; universal5430; ar_AE)',
                '4.4.4',
            ],
        ];
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Dalvik/1.4.0 (Linux; U; Android 2.3.6; GT-I9100G Build/GINGERBREAD)';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, AndroidOs::SEARCHES)
            ->willThrowException($exception);
        $versionFactory
            ->expects(self::never())
            ->method('set');

        assert($logger instanceof LoggerInterface);
        assert($versionFactory instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFailSecond(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; 4.4.4; Nexus 7 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.107 Safari/537.36 Obigo/W20A.42';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('4.4.4')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionFactory instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFailThird(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; U; de-de; GT-I9100 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Safari/533.1';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('2.3.0')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionFactory instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFailForth(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; U; Android Eclair; md-us Build/pandigitalopc1/sourceidDL00000009) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('2.1.0')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionFactory instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFailFifth(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; Android 4.4.4; SM-G850F Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Mobile Safari/537.36 Instagram 19.1.0.31.91 Android (19/4.4.4; 320dpi; 720x1280; samsung; SM-G850F; slte; universal5430; ar_AE)';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('4.4.4')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionFactory instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFailSixth(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; Milestone Build/SHOLS_U2_02.36.0) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('2.1.1')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionFactory instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFailSeventh(): void
    {
        $useragent = 'Mozilla/5.0 (Android M; Mobile; rv:41.0) Gecko/41.0 Firefox/41.0';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('6.0')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionFactory instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
