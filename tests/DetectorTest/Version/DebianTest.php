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

use BrowserDetector\Version\Debian;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class DebianTest extends TestCase
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
        $object = new Debian($logger, new VersionFactory());

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
                'Mozilla/5.0 (X11; U; Linux i686; de-de@euro) AppleWebKit/531.2+ (KHTML, like Gecko) Version/5.0 Safari/531.2+ Debian/squeeze (2.30.6-1) Epiphany/2.30.6',
                '6.0.0',
            ],
            [
                'ELinks/0.10.4-7-debian (textmode; GNU/kFreeBSD 5.3-17 i686; 143x53-2)',
                '5.3.17',
            ],
            [
                'Mozilla/5.0 (Macintosh; ARM Mac OS X) AppleWebKit/538.15 (KHTML, like Gecko) Safari/538.15 Version/6.0 Debian/8.0 (1:3.8.2.0-0) Epiphany/3.8.2',
                '8.0.0',
            ],
        ];
    }

    /**
     * @return void
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Mozilla/5.0 (X11; U; Linux i686; de-de@euro) AppleWebKit/531.2+ (KHTML, like Gecko) Version/5.0 Safari/531.2+ Debian/squeeze (2.30.6-1) Epiphany/2.30.6';
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
            ->with('6.0')
            ->willThrowException($exception);

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        $object = new Debian($logger, $versionFactory);

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
        $useragent = 'Mozilla/5.0 (Macintosh; ARM Mac OS X) AppleWebKit/538.15 (KHTML, like Gecko) Safari/538.15 Version/6.0 Debian/8.0 (1:3.8.2.0-0) Epiphany/3.8.2';
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
            ->with($useragent, Debian::SEARCHES)
            ->willThrowException($exception);
        $versionFactory
            ->expects(static::never())
            ->method('set');

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        $object = new Debian($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertInstanceOf(NullVersion::class, $detectedVersion);
        static::assertNull($detectedVersion->getVersion());
    }
}
