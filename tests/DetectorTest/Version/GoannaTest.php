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

use BrowserDetector\Version\Goanna;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class GoannaTest extends TestCase
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
        $object = new Goanna($logger, new VersionFactory());

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
                'Mozilla/5.0 (Windows NT 6.1; rv:52.9) Gecko/20100101 Goanna/3.3 Firefox/52.9 PaleMoon/27.5.0',
                '3.3.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:2.0) Gecko/20100101 Goanna/20151214 PaleMoon/26.0.0b4',
                '2.0.0',
            ],
            [
                'Mozilla/5.0 (X11; Linux x86_64; rv:3.0) Goanna/20170207 PaleMoon/27.1.0',
                '3.0.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                '1.0.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:26.0.0b2) Goanna/20150828 Gecko/20100101 AppleWebKit/601.1.37 (KHTML, like Gecko) Version/9.0 Safari/601.1.37 PaleMoon/26.0.0b2',
                '1.0.0',
            ],
        ];
    }

    /**
     * @return void
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:52.9) Gecko/20100101 Goanna/3.3 Firefox/52.9 PaleMoon/27.5.0';
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
            ->with('3.3')
            ->willThrowException($exception);

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        $object = new Goanna($logger, $versionFactory);

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
        $useragent = 'Mozilla/5.0 (X11; Linux x86_64; rv:3.0) Goanna/20170207 PaleMoon/27.1.0';
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
            ->with('3.0')
            ->willThrowException($exception);

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        $object = new Goanna($logger, $versionFactory);

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
        $useragent = 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:26.0.0b2) Goanna/20150828 Gecko/20100101 AppleWebKit/601.1.37 (KHTML, like Gecko) Version/9.0 Safari/601.1.37 PaleMoon/26.0.0b2';
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
            ->with('1.0')
            ->willThrowException($exception);

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        $object = new Goanna($logger, $versionFactory);

        $detectedVersion = $object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertInstanceOf(NullVersion::class, $detectedVersion);
        static::assertNull($detectedVersion->getVersion());
    }
}
