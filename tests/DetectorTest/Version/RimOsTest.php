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

use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\RimOs;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

use function assert;

final class RimOsTest extends TestCase
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

        assert($logger instanceof LoggerInterface);
        $object = new RimOs($logger, new VersionFactory());

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
                'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Mobile Safari/537.35+',
                '10.0.0',
            ],
            [
                'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.3.3.3057 Mobile Safari/537.35+',
                '10.3.3.3057',
            ],
            [
                'FlyCast/1.34 (BlackBerry; 8330/4.5.0.131 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/-1)',
                '4.5.0.131',
            ],
            [
                'BlackBerry8530/5.0.0.973 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/105',
                '5.0.0.973',
            ],
            [
                'Opera/9.80 (BlackBerry; Opera Mini/8.0.35667/35.7561; U; en) Presto/2.8.119 Version/11.10',
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
        $useragent = 'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Mobile Safari/537.35+';
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
            ->with('10.0.0')
            ->willThrowException($exception);

        assert($logger instanceof LoggerInterface);
        assert($versionFactory instanceof VersionFactoryInterface);
        $object = new RimOs($logger, $versionFactory);

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
        $useragent = 'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.3.3.3057 Mobile Safari/537.35+';
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
            ->with(
                $useragent,
                ['Version', 'BlackBerry[0-9a-z]+', 'BlackBerry; [0-9a-z]+\/', 'BlackBerrySimulator'],
            )
            ->willThrowException($exception);
        $versionFactory
            ->expects(self::never())
            ->method('set');

        assert($logger instanceof LoggerInterface);
        assert($versionFactory instanceof VersionFactoryInterface);
        $object = new RimOs($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
