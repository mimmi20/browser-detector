<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use BrowserDetector\Version\WindowsMobileOs;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function assert;

#[CoversClass(WindowsMobileOs::class)]
final class WindowsMobileOsTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws Exception
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
    {
        $object = new WindowsMobileOs(new VersionBuilder());

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerVersion(): array
    {
        return [
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 8.12; MSIEMobile 6.0) 320x240; VZW; UTStar-XV6175.1; Windows Mobile 6.5 Standard;',
                '6.5.0',
            ],
            [
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100222 Firefox/3.6 Kylo/0.6.1.70394',
                '6.0.0',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; HTC_HD2_T8585; Windows Phone 6.5)',
                '6.5.0',
            ],
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100222 Firefox/3.6 Kylo/0.6.1.70394';
        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('6.0')
            ->willThrowException($exception);

        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new WindowsMobileOs($versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFailSecond(): void
    {
        $useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; HTC_HD2_T8585; Windows Phone 6.5)';
        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, WindowsMobileOs::SEARCHES)
            ->willThrowException($exception);
        $versionBuilder
            ->expects(self::never())
            ->method('set');

        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new WindowsMobileOs($versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
