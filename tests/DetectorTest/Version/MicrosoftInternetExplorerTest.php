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

use BrowserDetector\Version\MicrosoftInternetExplorer;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\Trident;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionDetectorInterface;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class MicrosoftInternetExplorerTest extends TestCase
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
        $object = new MicrosoftInternetExplorer($logger, new VersionFactory(), new Trident($logger, new VersionFactory()));

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
     * @return void
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; SearchToolbar 1.2; GTB7.0)';
        $exception = new NotNumericException('set failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::exactly(6))
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
            ->expects(static::exactly(6))
            ->method('set')
            ->withConsecutive(['11.0'], ['11.0'], ['10.0'], ['9.0'], ['8.0'], ['8.0'])
            ->willThrowException($exception);

        $trident = $this->getMockBuilder(VersionDetectorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $trident
            ->expects(static::once())
            ->method('detectVersion')
            ->with($useragent)
            ->willReturn(new Version('8', '0'));

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        /** @var VersionDetectorInterface $trident */
        $object = new MicrosoftInternetExplorer($logger, $versionFactory, $trident);

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
        $useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Siemens A/S; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
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

        $trident = $this->getMockBuilder(VersionDetectorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $trident
            ->expects(static::once())
            ->method('detectVersion')
            ->with($useragent)
            ->willReturn(new NullVersion());

        /** @var LoggerInterface $logger */
        /** @var VersionFactoryInterface $versionFactory */
        /** @var VersionDetectorInterface $trident */
        $object = new MicrosoftInternetExplorer($logger, $versionFactory, $trident);

        $detectedVersion = $object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertInstanceOf(NullVersion::class, $detectedVersion);
        static::assertNull($detectedVersion->getVersion());
    }
}
