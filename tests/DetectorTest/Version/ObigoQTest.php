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
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\ObigoQ;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function assert;

#[CoversClass(ObigoQ::class)]
final class ObigoQTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws Exception
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
    {
        $object = new ObigoQ(new VersionBuilder());

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
                'ALCATEL_TRIBE_3075A/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 ObigoInternetBrowser/Q05A',
                '5.0.0',
            ],
            [
                'Huawei/1.0/0HuaweiG2800/WAP2.0/Obigo-Browser/Q03C MMS/Obigo-MMS/1.2',
                '3.0.0',
            ],
            [
                'HUAWEI-M636/001.00 WAP/OBIGO/Q05A',
                '5.0.0',
            ],
            [
                'LG-GT505/v10a Browser/Teleca-Q7.1 MMS/LG-MMS-V1.0/1.2 MediaPlayer/LGPlayer/1.0 Java/ASVM/1.1 Profile/MIDP-2.1 Configuration/CLDC-1.1',
                '7.1.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                null,
            ],
            [
                'NGM_Coffee/ObigoInternetBrowser/QO3C Profile/MIDP2.0 Configuration/CLDC-1.1',
                '3.0.0',
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
        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('5')
            ->willThrowException($exception);

        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new ObigoQ($versionBuilder);

        $detectedVersion = $object->detectVersion(
            'ALCATEL_TRIBE_3075A/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 ObigoInternetBrowser/Q05A',
        );

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
        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('7.1')
            ->willThrowException($exception);

        assert($versionBuilder instanceof VersionFactoryInterface);
        $object = new ObigoQ($versionBuilder);

        $detectedVersion = $object->detectVersion(
            'LG-GT505/v10a Browser/Teleca-Q7.1 MMS/LG-MMS-V1.0/1.2 MediaPlayer/LGPlayer/1.0 Java/ASVM/1.1 Profile/MIDP-2.1 Configuration/CLDC-1.1',
        );

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
