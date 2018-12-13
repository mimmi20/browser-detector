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
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\SpecificLoaderFactoryInterface;
use BrowserDetector\Loader\SpecificLoaderInterface;
use BrowserDetector\Parser\PlatformParser;
use BrowserDetector\Loader\PlatformLoaderFactory;
use JsonClass\Json;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use UaResult\Os\OsInterface;

class PlatformParserTest extends TestCase
{
    /**
     * @var \BrowserDetector\Parser\PlatformParser
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $logger = $this->createMock(NullLogger::class);
        $jsonParser = $this->createMock(JsonInterface::class);

        /** @var NullLogger $logger */
        /** @var Json $jsonParser */
        $this->object = new PlatformParser($logger, $jsonParser);
    }

    /**
     * @dataProvider providerUseragents
     *
     * @param string      $useragent
     * @param string      $expectedMode
     * @param OsInterface $expectedResult
     *
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvoke(string $useragent, string $expectedMode, OsInterface $expectedResult): void
    {
        $mockLoader = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(SpecificLoaderFactoryInterface::class)
            ->disableOriginalConstructor()

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
    public function providerUseragents(): array
    {
        $os = $this->createMock(OsInterface::class);

        return [
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'windowsmobile',
                $os,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:26.0.0b2) Goanna/20150828 Gecko/20100101 AppleWebKit/601.1.37 (KHTML, like Gecko) Version/9.0 Safari/601.1.37 PaleMoon/26.0.0b2',
                'windows',
                $os,
            ],
            [
                'Mozilla/5.0 (Symbian/3; Series60/5.3 Nokia500/111.021.0028; Profile/MIDP-2.1 Configuration/CLDC-1.1 ) AppleWebKit/535.1 (KHTML, like Gecko) NokiaBrowser/8.3.1.4 Mobile Safari/535.1 3gpp-gba',
                'symbian',
                $os,
            ],
            [
                'WAP Browser-Karbonn K84/1.0.0',
                'java',
                $os,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.5.1.16-RT-20120531.214856; xx; K-Touch E619 Build/AliyunOs-2012) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.8.1.447 U3/0.8.0 Mobile Safari/533.1',
                'android',
                $os,
            ],
            [
                'Mozilla/5.0 (X11; U; AIX 000690FC4C00; en-US; rv:1.7.3) Gecko/20041022',
                'unix',
                $os,
            ],
            [
                'UCBrowserHD/2.4.0.367 CFNetwork/672.1.15 Darwin/14.0.0',
                'darwin',
                $os,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; de-de) AppleWebKit/531.2+ (KHTML, like Gecko) Version/5.0 Safari/531.2+ Debian/squeeze (2.30.6-1) Epiphany/2.30.6',
                'linux',
                $os,
            ],
            [
                'Mozilla/5.0 (Maemo; Linux; U; Jolla; Sailfish; Mobile; rv:26.0) Gecko/26.0 Firefox/26.0 SailfishBrowser/1.0 like Safari/538.1',
                'maemo',
                $os,
            ],
            [
                'Mozilla/5.0 (Mobile; rv:18.0) Gecko/18.0 Firefox/18.0',
                'firefoxos',
                $os,
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 8_1_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B440 Safari/600.1.4',
                'ios',
                $os,
            ],
            [
                'Nokia7230/5.0 (05.71) Profile/MIDP-2.1 Configuration/CLDC-1.1 Mozilla/5.0 AppleWebKit/420+ (KHTML, like Gecko) Safari/420+',
                'symbian',
                $os,
            ],
            [
                'Mozilla/5.0 (LG-C199 AppleWebkit/531 Browser/Phantom/V2.0 Widget/LGMW/3.0 MMS/LG-MMS-V1.0/1.2 Java/ASVM/1.1 Profile/MIDP-2.1 Configuration/CLDC-1.1)',
                'java',
                $os,
            ],
            [
                'QuickTime.7.6.6 (qtver=7.6.6;cpu=IA32;os=Mac 10.6.7).',
                'mac',
                $os,
            ],
            [
                'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.2.1.2141 Mobile Safari/537.35+',
                'rimos',
                $os,
            ],
            [
                'nokia6120c/UC Browser8.0.3.107/69/444 UNTRUSTED/1.0',
                'symbian',
                $os,
            ],
            [
                'this is a fake ua to trigger the fallback',
                'unknown',
                $os,
            ],
            [
                'Mozilla/5.0 CommonCrawler Node BCRJD3NIBD5D7FSESX5FYPD7DASPLXXTNN3HQFQEM6BOOIQPSUOW42ZHQM2YEA7.O.756TNQIGQC6WQCZW43CC253MBXM7UTLFE2BTSQBYM4OZA6UR.cdn0.common.crawl.zone',
                'unknown',
                $os,
            ],
            [
                'Mozilla/5.0 (compatible; Konqueror/4.1; DragonFly) KHTML/4.1.4 (like Gecko)',
                'bsd',
                $os,
            ],
            [
                'ELinks/0.10.4-7-debian (textmode; GNU/kFreeBSD 5.3-17 i686; 143x53-2)',
                'bsd',
                $os,
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; de-DE) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 TouchPad/1.0',
                'webos',
                $os,
            ],
            [
                'Mozilla/5.0 (Linux; webOS/2.2.4; U; de-DE) AppleWebKit/534.6 (KHTML, like Gecko) webOSBrowser/221.56 Safari/534.6 Pre/1.2',
                'webos',
                $os,
            ],
            [
                'Huawei/1.0/HUAWEI-G7300 Browser/Opera MMS/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; Nucleus; Opera Mobi/4000; U; it-IT) Presto/2.5.28 Version/10.10',
                'java',
                $os,
            ],
            [
                'JUC (Linux; U; 4.0.4; zh-cn; GT-I9100; 480*800) UCWEB7.9.0.94/139/444',
                'android',
                $os,
            ],
            [
                'JUC(Linux;U;Android4.2.2;Zh_cn;GT-I9060;480*800;)UCWEB7.8.0.95/139/355',
                'android',
                $os,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1.8) Gecko/20100215 Solaris/10.1 (GNU) Superswan/3.5.8 (Byte/me)',
                'solaris',
                $os,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows 95; PalmSource; Blazer 3.0) 16; 160x160',
                'palm',
                $os,
            ],
            [
                'Opera/9.80 (BREW; Opera Mini/5.0/27.2339; U; en) Presto/2.8.119 320X240 Samsung SCH-U750',
                'genericplatform',
                $os,
            ],
            [
                'SAMSUNG-GT-C3310/1.0 NetFront/4.2 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'java',
                $os,
            ],
        ];
    }
}
