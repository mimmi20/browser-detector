<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\AndroidOs;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

use function assert;

final class AndroidOsTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
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

        assert($logger instanceof LoggerInterface);
        $object = new AndroidOs($logger, new VersionBuilder($logger));

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string|null>>
     *
     * @throws void
     */
    public static function providerVersion(): array
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
            [
                'Mozilla/5.0 (Linux; Android 9; Redmi 8 Build/PKQ1.190319.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/115.0.5790.166 Mobile Safari/537.36 Instagram 296.0.0.35.109 Android (28/9; 320dpi; 720x1369; Xiaomi; Redmi 8; olive; qcom; de_DE; 505599009)',
                '9.0.0',
            ],
            [
                'Instagram 5.0.2 Android (15/4.0.4; 240dpi; 480x800; AIRIS; TM450; AIRIS_TM450; qcom; es_ES)',
                '4.0.4',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 30)',
                '11.0.0',
            ],
            [
                'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24#2.0#TCL/TCL-AP-MS68-S1/22/tclwebkit1.0.2/1920*1080(512512136,null;210494962,c756f2d1114b47c79c86725a20185784)',
                '5.1.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 34)',
                '14.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 33)',
                '13.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 32)',
                '12.1.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 31)',
                '12.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 29)',
                '10.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 28)',
                '9.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 27)',
                '8.1.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 26)',
                '8.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 25)',
                '7.1.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 24)',
                '7.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 23)',
                '6.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 22)',
                '5.1.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 21)',
                '5.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 20)',
                '4.4.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 19)',
                '4.4.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 18)',
                '4.3.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 17)',
                '4.2.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 16)',
                '4.2.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 15)',
                '4.0.3',
            ],
            [
                'Appcelerator Titanium/3.1.2 (HTC One X; Android API Level: 17; de-DE;)',
                '4.2.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 35)',
                '15.0.0',
            ],
            [
                'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 4)',
                '0.0.0',
            ],
        ];
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Dalvik/1.4.0 (Linux; U; Android 2.3.6; GT-I9100G Build/GINGERBREAD)';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, AndroidOs::SEARCHES)
            ->willThrowException($exception);
        $versionBuilder
            ->expects(self::never())
            ->method('set');

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFailSecond(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; 4.4.4; Nexus 7 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.107 Safari/537.36 Obigo/W20A.42';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('4.4.4')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFailThird(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; U; de-de; GT-I9100 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Safari/533.1';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('2.3.0')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFailForth(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; U; Android Eclair; md-us Build/pandigitalopc1/sourceidDL00000009) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('2.1.0')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFailFifth(): void
    {
        $useragent = 'Instagram 5.0.2 Android (15/4.0.4; 240dpi; 480x800; AIRIS; TM450; AIRIS_TM450; qcom; es_ES)';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('4.0.4')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFailSixth(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; Milestone Build/SHOLS_U2_02.36.0) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('2.1.1')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFailSeventh(): void
    {
        $useragent = 'Mozilla/5.0 (Android M; Mobile; rv:41.0) Gecko/41.0 Firefox/41.0';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('6.0')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFail8(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; Android 9; Redmi 8 Build/PKQ1.190319.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/115.0.5790.166 Mobile Safari/537.36 Instagram 296.0.0.35.109 Android (28/9; 320dpi; 720x1369; Xiaomi; Redmi 8; olive; qcom; de_DE; 505599009)';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('9')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFail9(): void
    {
        $useragent = 'ddg_android/5.92.1 (com.duckduckgo.mobile.android; Android API 30)';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('11')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws UnexpectedValueException */
    public function testDetectVersionFail10(): void
    {
        $useragent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24#2.0#TCL/TCL-AP-MS68-S1/22/tclwebkit1.0.2/1920*1080(512512136,null;210494962,c756f2d1114b47c79c86725a20185784)';
        $exception = new NotNumericException('set failed');
        $logger    = $this->createMock(LoggerInterface::class);
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

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('5.1')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new AndroidOs($logger, $versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
