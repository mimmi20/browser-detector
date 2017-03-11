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

use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Version\VersionFactory;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\Log\NullLogger;
use UaResult\Browser\Browser;
use UaResult\Company\Company;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class BrowserFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\BrowserFactory
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $loader       = new BrowserLoader($cache);
        $this->object = new BrowserFactory($cache, $loader);
    }

    public function testToarray()
    {
        $logger = new NullLogger();

        $name         = 'TestBrowser';
        $manufacturer = new Company('Unknown', null);
        $version      = (new VersionFactory())->set('0.0.2-beta');

        $original = new Browser($name, $manufacturer, $version);

        $array  = $original->toArray();
        $object = $this->object->fromArray($logger, $array);

        self::assertSame($name, $object->getName());
        self::assertEquals($manufacturer, $object->getManufacturer());
        self::assertEquals($version, $object->getVersion());
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string $userAgent
     * @param string $browser
     * @param string $version
     * @param string $manufacturer
     */
    public function testDetect($userAgent, $browser, $version, $manufacturer)
    {
        $normalizer = (new NormalizerFactory())->build();

        $normalizedUa = $normalizer->normalize($userAgent);

        /** @var \UaResult\Browser\BrowserInterface $result */
        list($result) = $this->object->detect($normalizedUa);

        self::assertInstanceOf('\UaResult\Browser\BrowserInterface', $result);
        self::assertSame(
            $browser,
            $result->getName(),
            'Expected browser name to be "' . $browser . '" (was "' . $result->getName() . '")'
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
                'Mozilla/5.0 (iPad; CPU OS 8_1_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B440 Safari/600.1.4',
                'Safari',
                '8.0.0',
                'Apple Inc',
                null,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C; .NET4.0E)',
                'Internet Explorer',
                '8.0.0',
                'Microsoft Corporation',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.3; de-de; GT-I9300 Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Android Webkit',
                '4.0.0',
                'Google Inc',
                null,
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko)',
                'Apple Mail',
                '0.0.0',
                'Apple Inc',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko',
                'Internet Explorer',
                '11.0.0',
                'Microsoft Corporation',
                null,
            ],
            [
                'Mozilla/5.0 (BB10; Touch) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.2.2.1609 Mobile Safari/537.35+',
                'BlackBerry',
                '10.2.2.1609',
                'Research In Motion Limited',
                null,
            ],
            [
                'Mozilla/5.0 (Nintendo 3DS; U; ; de) Version/1.7567.EU',
                'NetFront NX',
                '0.0.0',
                'Access',
                null,
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'IEMobile',
                '11.0.0',
                'Microsoft Corporation',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0',
                'Edge',
                '12.0.0',
                'Microsoft Corporation',
                null,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; ru) Opera 8.01',
                'Opera',
                '8.01.0',
                'Opera Software ASA',
                null,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; PPC Mac OS X 10.6.8; Tasman 1.0)',
                'Internet Explorer',
                '6.0.0',
                'Microsoft Corporation',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:26.0.0b2) Goanna/20150828 Gecko/20100101 AppleWebKit/601.1.37 (KHTML, like Gecko) Version/9.0 Safari/601.1.37 PaleMoon/26.0.0b2',
                'PaleMoon',
                '26.0.0-beta+2',
                'Moonchild Productions',
                null,
            ],
            [
                'NokiaN90-1/3.0545.5.1 Series60/2.8 Profile/MIDP-2.0 Configuration/CLDC-1.1 (en-US; rv:9.3.3) Clecko/20141026 Classilla/CFM',
                'Classilla',
                '0.0.0',
                null,
                null,
            ],
            [
                'UCWEB/2.0(Linux; U; Opera Mini/7.1.32052/30.3697; en-us; GT-S5670 Build/GINGERBREAD) U2/1.0.0 UCBrowser/9.4.1.362 Mobile',
                'UC Browser',
                '9.4.1.362',
                'UCWeb Inc.',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; pt-BR; H5000 Build/IMM76D) AppleWebKit/534.31 (KHTML, like Gecko) UCBrowser/9.3.0.321 U3/0.8.0 Mobile Safari/534.31',
                'UC Browser',
                '9.3.0.321',
                'UCWeb Inc.',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; ru-; TAB917QC-8GB Build/KVT49L) AppleWebKit/534.24 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.24 T5/2.0 bdbrowser_i18n/4.6.0.7',
                'Baidu Browser',
                '4.6.0.7',
                'Baidu',
                null,
            ],
            [
                'Mozilla/5.0 (compatible; Konqueror/3.5; Linux) KHTML/3.5.8 (like Gecko) (Debian)',
                'Konqueror',
                '3.5.0',
                'KDE e.V.',
                null,
            ],
            [
                'Mozilla/5.0 (compatible; Konqueror/2.2.2; Linux 2.4.14-xfs; X11; i686)',
                'Konqueror',
                '2.2.2',
                'KDE e.V.',
                null,
            ],
            [
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.8.0.11) Firefox/1.5.0.11;',
                'Firefox',
                '1.5.0.11',
                'Mozilla Foundation',
                null,
            ],
            [
                'Mozilla/6.0 (Windows NT 6.2; WOW64; rv:16.0.1) Gecko/20121011 Firefox/16.0.1',
                'Firefox',
                '16.0.1',
                'Mozilla Foundation',
                null,
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.1033 Mobile Safari/534.11+',
                'BlackBerry',
                '7.1.0.1033',
                'Research In Motion Limited',
                null,
            ],
            [
                'BlackBerry9000/5.0.0.1079 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/114',
                'BlackBerry',
                '5.0.0.1079',
                'Research In Motion Limited',
                null,
            ],
            [
                'LG-GD350/V100 Obigo/WAP2.0 Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'Teleca-Obigo',
                '0.0.0',
                'Obigo',
                null,
            ],
            [
                'Mozilla/5.0 (compatible; archive-de.com/1.1; +http://archive-de.com/bot)',
                'archive-de.com bot',
                '1.1.0',
                null,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 6.0; U7 Plus Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Mobile Safari/537.36',
                'Android WebView',
                '4.0.0',
                'Google Inc',
                null,
            ],
        ];
    }
}
