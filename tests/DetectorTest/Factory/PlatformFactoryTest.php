<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\Loader;
use BrowserDetector\Loader\PlatformLoaderFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

class PlatformFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Factory\PlatformFactory
     */
    private $object;

    /**
     * @throws \ReflectionException
     *
     * @return void
     */
    protected function setUp(): void
    {
        /** @var NullLogger $logger */
        $logger = $this->createMock(NullLogger::class);

        /** @var Cache $cache */
        $cache = $this->createMock(Cache::class);

        $this->object = new PlatformFactory($cache, $logger);
    }

    /**
     * @dataProvider providerUseragents
     *
     * @param string      $useragent
     * @param string      $expectedMode
     * @param OsInterface $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvoke(string $useragent, string $expectedMode, OsInterface $expectedResult): void
    {
        $mockLoader = $this->getMockBuilder(Loader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(PlatformLoaderFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $mockLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($expectedMode)
            ->willReturn($mockLoader);

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mockLoaderFactory);

        $object = $this->object;

        self::assertSame($expectedResult, $object($useragent));
    }

    /**
     * @return array[]
     */
    public function providerUseragents()
    {
        return [
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'windowsmobile',
                new Os(),
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:26.0.0b2) Goanna/20150828 Gecko/20100101 AppleWebKit/601.1.37 (KHTML, like Gecko) Version/9.0 Safari/601.1.37 PaleMoon/26.0.0b2',
                'windows',
                new Os(),
            ],
            [
                'Mozilla/5.0 (Symbian/3; Series60/5.3 Nokia500/111.021.0028; Profile/MIDP-2.1 Configuration/CLDC-1.1 ) AppleWebKit/535.1 (KHTML, like Gecko) NokiaBrowser/8.3.1.4 Mobile Safari/535.1 3gpp-gba',
                'symbian',
                new Os(),
            ],
            [
                'WAP Browser-Karbonn K84/1.0.0',
                'java',
                new Os(),
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.5.1.16-RT-20120531.214856; xx; K-Touch E619 Build/AliyunOs-2012) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.8.1.447 U3/0.8.0 Mobile Safari/533.1',
                'android',
                new Os(),
            ],
            [
                'Mozilla/5.0 (X11; U; AIX 000690FC4C00; en-US; rv:1.7.3) Gecko/20041022',
                'genericplatform',
                new Os(),
            ],
            [
                'UCBrowserHD/2.4.0.367 CFNetwork/672.1.15 Darwin/14.0.0',
                'darwin',
                new Os(),
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; de-de) AppleWebKit/531.2+ (KHTML, like Gecko) Version/5.0 Safari/531.2+ Debian/squeeze (2.30.6-1) Epiphany/2.30.6',
                'linux',
                new Os(),
            ],
            [
                'Mozilla/5.0 (Maemo; Linux; U; Jolla; Sailfish; Mobile; rv:26.0) Gecko/26.0 Firefox/26.0 SailfishBrowser/1.0 like Safari/538.1',
                'genericplatform',
                new Os(),
            ],
            [
                'Mozilla/5.0 (Mobile; rv:18.0) Gecko/18.0 Firefox/18.0',
                'firefoxos',
                new Os(),
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 8_1_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B440 Safari/600.1.4',
                'ios',
                new Os(),
            ],
            [
                'Nokia7230/5.0 (05.71) Profile/MIDP-2.1 Configuration/CLDC-1.1 Mozilla/5.0 AppleWebKit/420+ (KHTML, like Gecko) Safari/420+',
                'symbian',
                new Os(),
            ],
            [
                'Mozilla/5.0 (LG-C199 AppleWebkit/531 Browser/Phantom/V2.0 Widget/LGMW/3.0 MMS/LG-MMS-V1.0/1.2 Java/ASVM/1.1 Profile/MIDP-2.1 Configuration/CLDC-1.1)',
                'java',
                new Os(),
            ],
            [
                'QuickTime.7.6.6 (qtver=7.6.6;cpu=IA32;os=Mac 10.6.7).',
                'genericplatform',
                new Os(),
            ],
            [
                'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.2.1.2141 Mobile Safari/537.35+',
                'genericplatform',
                new Os(),
            ],
            [
                'nokia6120c/UC Browser8.0.3.107/69/444 UNTRUSTED/1.0',
                'symbian',
                new Os(),
            ],
            [
                'this is a fake ua to trigger the fallback',
                'unknown',
                new Os(),
            ],
        ];
    }
}
