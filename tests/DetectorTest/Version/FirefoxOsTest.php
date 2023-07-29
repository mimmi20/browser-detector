<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\FirefoxOs;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

final class FirefoxOsTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
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

        $object = new FirefoxOs($logger, new VersionFactory());

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
                'Mozilla/5.0 (Mobile; OPENC; rv:40.0) Gecko/40.0 Firefox/40.0',
                '2.2.0',
            ],
            [
                'Mozilla/5.0 (Mobile; OPENC; rv:40.0) Gecko/40.0 Firefox/37.0',
                '2.2.0',
            ],
            [
                'Mozilla/5.0 (Mobile; OPENC; rv:44.0) Gecko/44.0 Firefox/44.0',
                '2.5.0',
            ],
            [
                'Mozilla/5.0 (Mobile; rv:18.0) Gecko/18.0 Firefox/18.0',
                '1.0.0',
            ],
            [
                'Mozilla/5.0 (Mobile; Orange KLIF; rv:32.0) Gecko/32.0 Firefox/32.0',
                '2.0.0',
            ],
            [
                'Mozilla/5.0 (Mobile; ALCATELOneTouch4012A; rv:18.1) Gecko/18.1 Firefox/18.1',
                '1.1.0',
            ],
            [
                'Mozilla/5.0 (Mobile; ALCATELOneTouch6015X SVN:01004P MMS:1.1; rv:28.0) Gecko/28.0 Firefox/28.0',
                '1.3.0',
            ],
            [
                'Mozilla/5.0 (Mobile; ALCATELOneTouch6015X SVN:01004P MMS:1.1; rv:30.0) Gecko/30.0 Firefox/30.0',
                '1.4.0',
            ],
            [
                'Mozilla/5.0 (Mobile; ALCATELOneTouch6015X SVN:01004P MMS:1.1; rv:34.0) Gecko/34.0 Firefox/34.0',
                '2.1.0',
            ],
            [
                'Mozilla/5.0 (Mobile; ALCATELOneTouch6015X SVN:01004P MMS:1.1; rv:26.0) Gecko/26.0 Firefox/26.0',
                '1.2.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                null,
            ],
            [
                'warmup',
                null,
            ],
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Mozilla/5.0 (Mobile; ALCATELOneTouch6015X SVN:01004P MMS:1.1; rv:34.0) Gecko/34.0 Firefox/34.0';
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
            ->expects(self::never())
            ->method('detectVersion');
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('2.1')
            ->willThrowException($exception);

        $object = new FirefoxOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
