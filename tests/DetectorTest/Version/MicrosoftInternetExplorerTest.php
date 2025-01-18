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
use BrowserDetector\Version\MicrosoftInternetExplorer;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\Trident;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

#[CoversClass(MicrosoftInternetExplorer::class)]
final class MicrosoftInternetExplorerTest extends TestCase
{
    /**
     * @throws UnexpectedValueException
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
    {
        $object = new MicrosoftInternetExplorer(
            new VersionBuilder(),
            new Trident(new VersionBuilder()),
        );

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
                'Mozilla/5.0 (compatible;FW 2.0. 6868.p;FW 2.0. 7049.p; Windows NT 6.1; WOW64; Trident/8.0; rv:11.0) like Gecko',
                '11.0.0',
            ],
            [
                'Mozilla/5.0 (compatible;FW 2.0. 6868.p;FW 2.0. 7049.p; Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko',
                '11.0.0',
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; ARM; Trident/6.0; Touch; ARMBJS)',
                '10.0.0',
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0; tb-webde/2.6.7)',
                '9.0.0',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; SearchToolbar 1.2; GTB7.0)',
                '8.0.0',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows Phone OS 7.0; Trident/3.1; IEMobile/7.0; DELL; Venue Pro)',
                '7.0.0',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE x.0; Windows Phone OS 7.0; Trident/3.1; IEMobile/7.0; DELL; Venue Pro)',
                null,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Siemens A/S; .NET CLR 1.0.3705; .NET CLR 1.1.4322)',
                '6.0.0',
            ],
        ];
    }

    /**
     * @throws NotNumericException
     * @throws Exception
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; SearchToolbar 1.2; GTB7.0)';

        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $matcher        = self::exactly(6);
        $versionBuilder
            ->expects($matcher)
            ->method('set')
            ->willReturnCallback(static function (string $version) use ($matcher, $exception): void {
                $invocation = $matcher->numberOfInvocations();

                match ($invocation) {
                    1, 2 => self::assertSame('11.0', $version, (string) $invocation),
                    3 => self::assertSame('10.0', $version, (string) $invocation),
                    4 => self::assertSame('9.0', $version, (string) $invocation),
                    default => self::assertSame('8.0', $version, (string) $invocation),
                };

                throw $exception;
            });

        $trident = $this->createMock(VersionBuilderInterface::class);
        $trident
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent)
            ->willReturn(new Version('8', '0'));

        $object = new MicrosoftInternetExplorer($versionBuilder, $trident);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws Exception */
    public function testDetectVersionFail2(): void
    {
        $useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Siemens A/S; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('6.0')
            ->willThrowException($exception);

        $trident = $this->createMock(VersionBuilderInterface::class);
        $trident
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent)
            ->willReturn(new NullVersion());

        $object = new MicrosoftInternetExplorer($versionBuilder, $trident);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws Exception */
    public function testDetectVersionFail3(): void
    {
        $useragent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; SearchToolbar 1.2; GTB7.0)';

        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('8.0')
            ->willReturn(new NullVersion());

        $trident = $this->createMock(VersionBuilderInterface::class);
        $trident
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent)
            ->willThrowException($exception);

        $object = new MicrosoftInternetExplorer($versionBuilder, $trident);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /** @throws Exception */
    public function testDetectVersionFail4(): void
    {
        $useragent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; SearchToolbar 1.2; GTB7.0)';

        $exception = new UnexpectedValueException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('8.0')
            ->willReturn(new NullVersion());

        $trident = $this->createMock(VersionBuilderInterface::class);
        $trident
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent)
            ->willThrowException($exception);

        $object = new MicrosoftInternetExplorer($versionBuilder, $trident);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
