<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class EngineFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\EngineFactory
     */
    private $object = null;

    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../cache/');
        $this->cache  = new FilesystemCachePool(new Filesystem($adapter));
        $loader       = new EngineLoader($this->cache);
        $this->object = new EngineFactory($loader);
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string $userAgent
     * @param string $engine
     * @param string $version
     * @param string $manufacturer
     */
    public function testDetect($userAgent, $engine, $version, $manufacturer)
    {
        $normalizer      = (new NormalizerFactory())->build();
        $normalizedUa    = $normalizer->normalize($userAgent);
        $browserLoader   = new BrowserLoader($this->cache);
        $platformFactory = new PlatformFactory(new PlatformLoader($this->cache));

        try {
            $platform = $platformFactory->detect($normalizedUa);
        } catch (NotFoundException $e) {
            $platform = null;
        }

        /** @var \UaResult\Engine\EngineInterface $result */
        $result = $this->object->detect($normalizedUa, $browserLoader, $platform);

        self::assertInstanceOf('\UaResult\Engine\EngineInterface', $result);
        self::assertSame(
            $engine,
            $result->getName(),
            'Expected engine name to be "' . $engine . '" (was "' . $result->getName() . '")'
        );

        self::assertInstanceOf('\BrowserDetector\Version\Version', $result->getVersion());
        self::assertSame(
            $version,
            $result->getVersion()->getVersion(),
            'Expected version to be "' . $version . '" (was "' . $result->getVersion()->getVersion() . '")'
        );

        self::assertSame(
            $manufacturer,
            $result->getManufacturer()->getName(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer()->getName() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'this is a fake ua to trigger the fallback',
                null,
                '0.0.0',
                null,
                null,
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 8_1_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B440 Safari/600.1.4',
                'WebKit',
                '600.1.4',
                'Apple Inc',
                'Apple',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C; .NET4.0E)',
                'Trident',
                '4.0.0',
                'Microsoft Corporation',
                'Microsoft',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.3; de-de; GT-I9300 Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'WebKit',
                '534.30.0',
                'Apple Inc',
                'Apple',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko)',
                'WebKit',
                '600.1.25',
                'Apple Inc',
                'Apple',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko',
                'Trident',
                '7.0.0',
                'Microsoft Corporation',
                'Microsoft',
            ],
            [
                'Mozilla/5.0 (BB10; Touch) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.2.2.1609 Mobile Safari/537.35+',
                'WebKit',
                '537.35.0',
                'Apple Inc',
                'Apple',
            ],
            [
                'Mozilla/5.0 (Nintendo 3DS; U; ; de) Version/1.7567.EU',
                'NetFront',
                '0.0.0',
                'Access',
                'Access',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Trident',
                '7.0.0',
                'Microsoft Corporation',
                'Microsoft',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0',
                'Edge',
                '12.0.0',
                'Microsoft Corporation',
                'Microsoft',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; ru) Opera 8.01',
                'Presto',
                '0.0.0',
                'Opera Software ASA',
                'Opera',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; PPC Mac OS X 10.6.8; Tasman 1.0)',
                'Tasman',
                '0.0.0',
                'Apple Inc',
                'Apple',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:26.0.0b2) Goanna/20150828 Gecko/20100101 AppleWebKit/601.1.37 (KHTML, like Gecko) Version/9.0 Safari/601.1.37 PaleMoon/26.0.0b2',
                'Goanna',
                '1.0.0',
                'Moonchild Productions',
                'Moonchild',
            ],
            [
                'NokiaN90-1/3.0545.5.1 Series60/2.8 Profile/MIDP-2.0 Configuration/CLDC-1.1 (en-US; rv:9.3.3) Clecko/20141026 Classilla/CFM',
                'Clecko',
                '9.3.3',
                null,
                null,
            ],
            [
                'UCWEB/2.0(Linux; U; Opera Mini/7.1.32052/30.3697; en-us; GT-S5670 Build/GINGERBREAD) U2/1.0.0 UCBrowser/9.4.1.362 Mobile',
                'U2',
                '1.0.0',
                'UCWeb Inc.',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; pt-BR; H5000 Build/IMM76D) AppleWebKit/534.31 (KHTML, like Gecko) UCBrowser/9.3.0.321 U3/0.8.0 Mobile Safari/534.31',
                'U3',
                '0.8.0',
                'UCWeb Inc.',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; ru-; TAB917QC-8GB Build/KVT49L) AppleWebKit/534.24 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.24 T5/2.0 bdbrowser_i18n/4.6.0.7',
                'T5',
                '2.0.0',
                'Baidu',
                null,
            ],
            [
                'Mozilla/5.0 (compatible; Konqueror/3.5; Linux) KHTML/3.5.8 (like Gecko) (Debian)',
                'KHTML',
                '3.5.8',
                null,
                null,
            ],
            [
                'Mozilla/5.0 (compatible; Konqueror/2.2.2; Linux 2.4.14-xfs; X11; i686)',
                'KHTML',
                '0.0.0',
                null,
                null,
            ],
            [
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.8.0.11) Firefox/1.5.0.11;',
                'Gecko',
                '1.8.0.11',
                'Mozilla Foundation',
                null,
            ],
            [
                'Mozilla/6.0 (Windows NT 6.2; WOW64; rv:16.0.1) Gecko/20121011 Firefox/16.0.1',
                'Gecko',
                '16.0.1',
                'Mozilla Foundation',
                null,
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.1033 Mobile Safari/534.11+',
                'WebKit',
                '534.11.0',
                'Apple Inc',
                null,
            ],
            [
                'BlackBerry9000/5.0.0.1079 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/114',
                'BlackBerry',
                '0.0.0',
                'Research In Motion Limited',
                null,
            ],
            [
                'LG-GD350/V100 Obigo/WAP2.0 Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'Teleca',
                '0.0.0',
                'Obigo',
                null,
            ],
            [
                'Mozilla/5.0 (compatible; archive-de.com/1.1; +http://archive-de.com/bot)',
                null,
                '0.0.0',
                null,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 6.0; U7 Plus Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Mobile Safari/537.36',
                'Blink',
                '537.36.0',
                'Google Inc',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; HUAWEI MT7-CL00 Build/HuaweiMT7-CL00) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/35.0.1916.138 Mobile Safari/537.36 T7/6.4',
                'T7',
                '6.4.0',
                'Baidu',
                null,
            ],
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0_2 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/30.0.1599.16 Mobile/11A501 Safari/8536.25',
                'WebKit',
                '537.51.1',
                'Apple Inc',
                'Apple',
            ],
        ];
    }
}
