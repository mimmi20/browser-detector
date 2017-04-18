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
        $loader       = new BrowserLoader($this->cache);
        $this->object = new BrowserFactory($loader);
    }

    public function testToarray()
    {
        $logger = new NullLogger();

        $name         = 'TestBrowser';
        $manufacturer = new Company('Unknown', null);
        $version      = (new VersionFactory())->set('0.0.2-beta');

        $original = new Browser($name, $manufacturer, $version);

        $array  = $original->toArray();
        $object = (new \UaResult\Browser\BrowserFactory())->fromArray($this->cache, $logger, $array);

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
            [
                'QuickTime\\\\xaa.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)',
                'Quicktime',
                '7.0.4',
                'Apple Inc',
                null,
            ],
            [
                'Zend\Http\Client',
                'Zend_Http_Client',
                '0.0.0',
                'Zend Technologies Ltd.',
                null,
            ],
            [
                'Mozilla/5.0+(compatible; RevIP.info site analyzer v4.00; http://poweredby.revip.info)',
                'Reverse IP Lookup',
                '4.00.0',
                'binarymonkey.com',
                null,
            ],
            [
                'Mozilla / reddit pic scraper v0.8 (bklug@tyx.net)',
                'reddit pic scraper',
                '0.8.0',
                'Reddit Inc.',
                null,
            ],
            [
                'Mozilla crawl/5.0 (compatible; fairshare.cc +http://fairshare.cc)',
                'Mozilla Crawler',
                '5.0.0',
                'fairshare.cc',
                null,
            ],
            [
                'UCBrowserHD/2.4.0.367 CFNetwork/672.1.15 Darwin/14.0.0',
                'UC Browser HD',
                '2.4.0.367',
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
                'SAMSUNG-GT-E3309T Opera/9.80 (J2ME/MIDP; Opera Mini/4.4.34189/34.1016; U; en) Presto/2.8.119 Version/11.10',
                'Opera Mini',
                '4.4.34189',
                'Opera Software ASA',
                null,
            ],
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) OPiOS/8.0.1.80062 Mobile/11D201 Safari/9537.53',
                'Opera Mini',
                '8.0.1.80062',
                'Opera Software ASA',
                null,
            ],
            [
                'Opera/9.80 (Android 4.0.4; Linux; Opera Mobi/ADR-1210091050) Presto/2.11.355 Version/12.10',
                'Opera Mobile',
                '12.10.0',
                'Opera Software ASA',
                null,
            ],
            [
                'IC OpenGraph Crawler 4.5 (proprietary)',
                'IBM Connections',
                '4.5.0',
                'IBM',
                null,
            ],
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Coast/3.0.0.74604 Mobile/11D201 Safari/7534.48.3',
                'Coast',
                '3.0.0.74604',
                'Opera Software ASA',
                null,
            ],
            [
                'Huawei/1.0/HUAWEI-G7300 Browser/Opera MMS/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; Nucleus; Opera Mobi/4000; U; it-IT) Presto/2.5.28 Version/10.10',
                'Opera Mobile',
                '10.10.0',
                'Opera Software ASA',
                null,
            ],
            [
                'MicromaxX650 ASTRO36_TD/v3 MAUI/10A1032MP_ASTRO_W1052 Release/31.12.2010 Browser/Opera Sync/SyncClient1.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; U; en-US) Presto/2.5.28 Version/10.10',
                'Opera Mobile',
                '10.10.0',
                'Opera Software ASA',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36 OPR/16.0.1196.62',
                'Opera',
                '16.0.1196.62',
                'Opera Software ASA',
                null,
            ],
            [
                'iCabMobile/1.0.6 CFNetwork/711.1.16 Darwin/14.0.0',
                'iCab Mobile',
                '1.0.6',
                'Alexander Clauss',
                null,
            ],
            [
                'iCab/5.5 (Macintosh; U; Intel Mac OS X)',
                'iCab',
                '5.5.0',
                'Alexander Clauss',
                null,
            ],
            [
                'Mozilla/5.0 (Macintosh; U; PPC Mac OS; en) iCab 3',
                'iCab',
                '3.0.0',
                'Alexander Clauss',
                null,
            ],
            [
                'HggH PhantomJS Screenshoter',
                'HggH Screenshot System with PhantomJS',
                '0.0.0',
                'Jonas Genannt (HggH)',
                null,
            ],
            [
                'Mozilla/5.0 (bl.uk_lddc_bot; Linux x86_64) PhantomJS/1.9.7 (+http://www.bl.uk/aboutus/legaldeposit/websites/websites/faqswebmaster/index.html)',
                'bl.uk_lddc_bot',
                '0.0.0',
                'The British Legal Deposit Libraries',
                null,
            ],
            [
                'phantomas/1.8.0 (PhantomJS/1.9.8; linux x64)',
                'phantomas',
                '1.8.0',
                'Maciej Brencz',
                null,
            ],
            [
                'Mozilla/5.0 (compatible; Seznam screenshot-generator 2.0; +http://fulltext.sblog.cz/screenshot/)',
                'Seznam Screenshot Generator',
                '2.0.0',
                'Seznam.cz, a.s.',
                null,
            ],
            [
                'Mozilla/5.0 (Unknown; Linux x86_64) AppleWebKit/534.34 (KHTML, like Gecko) CasperJS/1.1.0-beta3+PhantomJS/1.9.7 Safari/534.34',
                'PhantomJS',
                '1.9.7',
                'phantomjs.org',
                null,
            ],
            [
                'Mozilla/5.0 (Unknown; BSD Four) AppleWebKit/534.34 (KHTML, like Gecko) PhantomJS/1.9.2 Safari/534.34',
                'PhantomJS',
                '1.9.2',
                'phantomjs.org',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.102 YaBrowser/14.2.1700.12599 Safari/537.36',
                'Yandex Browser',
                '14.2.1700.12599',
                'Yandex LLC',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; SCL24 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Mobile Safari/537.36 Kamelio Android',
                'Kamelio App',
                '0.0.0',
                'Kamelio',
                null,
            ],
            [
                'Mozilla/5.0 (iPod touch; U; CPU iPhone OS 4_2_1 like Mac OS X; es_ES) AppleWebKit (KHTML, like Gecko) Mobile [FBAN/FBForIPhone;FBAV/4.1.1;FBBV/4110.0;FBDV/iPod2,1;FBMD/iPod touch;FBSN/iPhone OS;FBSV/4.2.1;FBSS/1; FBCR/;FBID/phone;FBLC/es_ES;FBSF/1.0]',
                'Facebook App',
                '4.1.1',
                'Facebook',
                null,
            ],
            [
                '[FBAN/FB4A;FBAV/10.0.0.28.27;FBBV/2802760;FBDM/{density=3.0,width=1080,height=1776};FBLC/fr_CA;FBCR/VIRGIN;FBPN/com.facebook.katana;FBDV/Nexus 5;FBSV/4.4.3;FBOP/1;FBCA/armeabi-v7a:armeabi;]',
                'Facebook App',
                '10.0.0.28.27',
                'Facebook',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; MTC SMART Run Build/ARK) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36 ACHEETAHI/2100501044',
                'CM Browser',
                '0.0.0',
                'Cheetah Mobile',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.4; en-us; GT-I9100G Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) FlyFlow/2.5 Version/4.0 Mobile Safari/533.1 baidubrowser/042_6.3.5.2_diordna_008_084/gnusmas_01_4.3.2_G0019I-TG/7400001l/AFCD145CE647EC590CFE42154CB19B89%7C274573340474753/1',
                'FlyFlow',
                '2.5.0',
                'Baidu',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; gxt_dongle_3188 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Safari/537.36 bdbrowserhd_i18n/1.8.0.1',
                'Baidu Browser HD',
                '1.8.0.1',
                'Baidu',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; ru-; s4502 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 bdbrowser_mini/1.0.0.0',
                'Baidu Browser Mini',
                '1.0.0.0',
                'Baidu',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 3.2.1; en-us) AppleWebKit/534.35 (KHTML, like Gecko) Chrome/11.0.696.65 Safari/534.35 Puffin/2.10990AT Mobile',
                'Puffin',
                '2.10990.0',
                'CloudMosa Inc.',
                null,
            ],
            [
                'stagefright/1.2 (Linux;Android 4.2.1)',
                'stagefright',
                '1.2.0',
                null,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0; SAMSUNG SM-G900F Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/2.1 Chrome/34.0.1847.76 Mobile Safari/537.36',
                'Samsung Browser',
                '2.1.0',
                'Samsung',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; en-us; KFTT Build/IML74K) AppleWebKit/535.19 (KHTML, like Gecko) Silk/3.11 Safari/535.19 Silk-Accelerated=true',
                'Silk',
                '3.11.0',
                'Amazon.com, Inc.',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/49.0 Chrome/43.0.2357.126_coc_coc Safari/537.36',
                'Coc Coc Browser',
                '49.0.0',
                'Coc Coc Company Limited',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.6; ja-jp; SC-02C Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 NaverMatome-Android/4.0.7',
                'Matome',
                '4.0.7',
                'NHN Corporation',
                null,
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:28.0) Gecko/20100101 Firefox/28.0 (FlipboardProxy/1.1; +http://flipboard.com/browserproxy)',
                'FlipboardProxy',
                '1.1.0',
                'Flipboard, Inc.',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; GT-I9300I Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Mobile Safari/537.36 Flipboard/3.1.5/2581,3.1.5.2581,2015-02-24 17:19, +0800, ru',
                'Flipboard App',
                '3.1.5',
                'Flipboard, Inc.',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36 Seznam.cz/1.2.1',
                'Seznam Browser',
                '1.2.1',
                'Seznam.cz, a.s.',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.36 (KHTML, like Gecko) WhiteHat Aviator/33.0.1750.117 Chrome/33.0.1750.117 Safari/537.36',
                'Aviator',
                '33.0.1750.117',
                'WhiteHat Security',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android; es_mx; WT19a Build/) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 NetFrontLifeBrowser/2.3 Mobile (Dragonfruit)',
                'NetFrontLifeBrowser',
                '2.3.0',
                'Access',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; rv:26.0) Gecko/20100101 Firefox/26.0 IceDragon/26.0.0.2',
                'IceDragon',
                '26.0.0.2',
                'Comodo Group Inc',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Dragon/43.3.3.185 Chrome/43.0.2357.81 Safari/537.36',
                'Dragon',
                '43.3.3.185',
                'Comodo Group Inc',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Beamrise/27.3.0.5964 Chrome/27.0.1453.116 Safari/537.36',
                'Beamrise',
                '27.3.0.5964',
                'Beamrise Team',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Diglo/28.0.1479.334 Chrome/28.0.1479.0 Safari/537.36',
                'Diglo',
                '28.0.1479.334',
                'Diglo Inc',
                null,
            ],
            [
                'Mozilla/5.0 (Windows; U; Windows NT 5.2; en) Chrome/37.0.2049.0 (KHTML, like Gecko) Version/4.0 APUSBrowser/1.1.315  Safari/',
                'APUSBrowser',
                '1.1.315',
                'APUS-Group',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chedot/43.0.2357.402 Safari/537.36',
                'Chedot',
                '43.0.2357.402',
                'Chedot.com',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Qword/35.0.1905.5 Safari/537.36',
                'Qword Browser',
                '35.0.1905.5',
                'Qword Corporation',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Iridium/44.0 Safari/537.36 Chrome/43.0.2357.132',
                'Iridium Browser',
                '44.0.0',
                'Iridium Browser Team',
                null,
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0; Avant Browser)',
                'Avant',
                '0.0.0',
                'Avant Force',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) MxNitro/1.0.1.3000 Chrome/35.0.1849.0 Safari/537.36',
                'Maxthon Nitro',
                '1.0.1.3000',
                'Maxthon International Limited',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.6; fa-fa; GT-S5830i Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 MxBrowser/4.3.0.2000',
                'Maxthon',
                '4.3.0.2000',
                'Maxthon International Limited',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.4; de-de; GT-I9100 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 Maxthon/4.0.3.3000',
                'Maxthon',
                '4.0.3.3000',
                'Maxthon International Limited',
                null,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) SuperBird/24.0',
                'SuperBird',
                '24.0.0',
                'superbird-browser.com',
                null,
            ],
            [
                'TinyBrowser/2.0 (TinyBrowser Comment; rv:1.9.1a2pre) Gecko/20201231',
                'TinyBrowser',
                '2.0.0',
                null,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; zh-cn; HM NOTE 1LTETD Build/KVT49L) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.4 TBS/025410 Mobile Safari/533.1 MicroMessenger/6.1.0.66_r1062275.542 NetType/cmnet',
                'WeChat App',
                '6.1.0.66',
                'Tencent Ltd.',
                null,
            ],
            [
                'MQQBrowser/Mini2.4 (SAMSUNG-GT-E2252)',
                'QQbrowser Mini',
                '2.4.0',
                'Tencent Ltd.',
                null,
            ],
            [
                'MQQBrowser/3.0/Mozilla/5.0 (Linux; U; Android 4.0.3; de-de; GT-I9100 Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'QQ Browser',
                '3.0.0',
                'Tencent Ltd.',
                null,
            ],
            [
                'Pinterest/0.1 +http://pinterest.com/',
                'Pinterest App',
                '0.1.0',
                'Ericsson Research',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0; SAMSUNG-SM-N900A Build/LRX21V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/42.0.2311.129 Mobile Safari/537.36 [Pinterest/Android]',
                'Pinterest App',
                '0.0.0',
                'Ericsson Research',
                null,
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12F69 [Pinterest/iOS]',
                'Pinterest App',
                '0.0.0',
                'Ericsson Research',
                null,
            ],
        ];
    }
}
