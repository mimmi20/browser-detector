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

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\Gecko;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function assert;

#[CoversClass(Gecko::class)]
final class GeckoTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
    {
        $object = new Gecko(new VersionBuilder());

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
                'Mozilla/5.0 (Windows NT 10.0; rv:69.0) Gecko/20100101 Firefox/69.0 anonymized by Abelssoft 1855802700 Herring/100.1.6180.81',
                '69.0.0',
            ],
            [
                'Mozilla/5.0 (Android 13; Mobile; rv:109.0) Gecko/115.0 Firefox/115.0',
                '115.0.0',
            ],
            [
                'Mozilla/5.0 (Android 13; Mobile; rv:0.0) Gecko/20100101.0 Firefox/115.0',
                '0.0.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0; RV:69.0) Gecko/20100101 Firefox/69.0 anonymized by Abelssoft 1855802700 Herring/100.1.6180.81',
                '69.0.0',
            ],
            [
                'Mozilla/5.0 (Android 13; Mobile; RV:109.0) Gecko/115.0 Firefox/115.0',
                '115.0.0',
            ],
            [
                'Mozilla/5.0 (Android 13; Mobile; RV:0.0) Gecko/20100101.0 Firefox/115.0',
                '0.0.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0; RV:69.0) Gecko/20100101 Firefox69.0 anonymized by Abelssoft 1855802700 Herring/100.1.6180.81',
                '69.0.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0; RV:69.0) Gecko20100101 Firefox/69.0 anonymized by Abelssoft 1855802700 Herring/100.1.6180.81',
                null,
            ],
            [
                'Mozilla/5.0 (Android 13; Mobile; RV:109.0) Gecko115.0 Firefox/115.0',
                null,
            ],
            [
                'Mozilla/5.0 (Android 13; Mobile; RV:109.0) Gecko/115.0 Firefox115.0',
                '109.0.0',
            ],
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Mozilla/5.0 (Windows NT 10.0; rv:69.0) Gecko/20100101 Firefox/69.0 anonymized by Abelssoft 1855802700 Herring/100.1.6180.81';
        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('69.0')
            ->willThrowException($exception);

        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new Gecko($versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testDetectVersionFailSecond(): void
    {
        $useragent = 'Mozilla/5.0 (Android 13; Mobile; rv:109.0) Gecko/115.0 Firefox/115.0';
        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('115.0')
            ->willThrowException($exception);

        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new Gecko($versionBuilder);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
