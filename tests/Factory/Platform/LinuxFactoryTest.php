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
namespace BrowserDetectorTest\Factory\Platform;

use BrowserDetector\Factory\Platform\LinuxFactory;
use BrowserDetector\Loader\PlatformLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class LinuxFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Platform\LinuxFactory
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $loader       = new PlatformLoader($cache);
        $this->object = new LinuxFactory($cache, $loader);
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $platform
     * @param string $version
     * @param string $manufacturer
     * @param int    $bits
     */
    public function testDetect($agent, $platform, $version, $manufacturer, $bits)
    {
        /** @var \UaResult\Os\OsInterface $result */
        $result = $this->object->detect($agent);

        self::assertInstanceOf('\UaResult\Os\OsInterface', $result);
        self::assertSame(
            $platform,
            $result->getName(),
            'Expected platform name to be "' . $platform . '" (was "' . $result->getName() . '")'
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

        self::assertSame(
            $bits,
            $result->getBits(),
            'Expected bits count to be "' . $bits . '" (was "' . $result->getBits() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'Mozilla/5.0 AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1 Installatron (Mimicking WebKit)',
                'Linux',
                '0.0.0',
                'Linux Foundation',
                32,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; rv:1.9a3pre) Gecko/20070330',
                'Linux',
                '0.0.0',
                'Linux Foundation',
                32,
            ],
            [
                'Opera/9.80 (X11; Linux i686; Edition Linux Mint) Presto/2.12.388 Version/12.16',
                'Linux Mint',
                '0.0.0',
                null,
                32,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; pl-PL; rv:1.9.2a1pre) Gecko/20090330 Kubuntu/8.10 (intrepid) Minefield/3.2a1pre',
                'Kubuntu',
                '8.10.0',
                'Canonical Foundation',
                32,
            ],
            [
                'curl/7.15.5 (x86_64-redhat-linux-gnu) libcurl/7.15.5 OpenSSL/0.9.8b zlib/1.2.3 libidn/0.6.5',
                'Redhat Linux',
                '0.0.0',
                'Red Hat Inc',
                64,
            ],
            [
                'OMozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.9) Gecko/20100827 Red Hat/3.6.9-2.el6 Firefox/3.6.9',
                'Redhat Linux',
                '0.0.0',
                'Red Hat Inc',
                32,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.8.0.5) Gecko/20060805 CentOS/1.0.3-0.el4.1.centos4 SeaMonkey/1.0.3',
                'Cent OS Linux',
                '0.0.0',
                null,
                32,
            ],
            [
                'Mozilla/5.0 (X11; CrOS x86_64 14.4.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2558.0 Safari/537.36',
                'ChromeOS',
                '0.0.0',
                'Google Inc',
                64,
            ],
            [
                'Mozilla/5.0 (X11; Jolicloud Linux i686) AppleWebKit/537.6 (KHTML, like Gecko) Joli OS/1.2 Chromium/23.0.1240.0 Chrome/23.0.1240.0 Safari/537.6',
                'Joli OS',
                '1.2.0',
                null,
                32,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.0.7) Gecko/2009031120 Mandriva/1.9.0.7-0.1mdv2009.0 (2009.0) Firefox/3.0.7',
                'Mandriva Linux',
                '0.0.0',
                'Mandriva',
                64,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.0.14) Gecko/2009090900 SUSE/3.0.14-0.1 Firefox/3.0.14',
                'Suse Linux',
                '0.0.0',
                'Suse',
                32,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; en; rv:1.9) Gecko/20080528 (Gentoo) Epiphany/2.22 Firefox/3.0',
                'Gentoo Linux',
                '0.0.0',
                'Gentoo Foundation Inc',
                32,
            ],
            [
                'Mozilla/5.0 (X11; Linux i686) AppleWebKit/534.30 (KHTML, like Gecko) Slackware/Chrome/12.0.742.100 Safari/534.30',
                'Slackware Linux',
                '0.0.0',
                'Slackware Linux Inc',
                32,
            ],
            [
                'Mozilla/5.0 (Linux; U; Linux Ventana; de-de; Transformer TF101G Build/HTJ85B) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/8.0 Safari/534.13',
                'Ventana Linux',
                '0.0.0',
                'Ventana',
                32,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.1.1) Gecko/20090725 Moblin/3.5.1-2.5.14.moblin2 Shiretoko/3.5.1',
                'Moblin',
                '0.0.0',
                null,
                32,
            ],
            [
                'Lynx/2.8.5rel.1 libwww-FM/2.15FC SSL-MM/1.4.1c OpenSSL/0.9.7e-dev',
                'Linux',
                '0.0.0',
                'Linux Foundation',
                32,
            ],
            [
                'amarok/2.8.0 (Phonon/4.8.0; Phonon-VLC/0.8.0) LibVLC/2.2.1',
                'Linux',
                '0.0.0',
                'Linux Foundation',
                32,
            ],
            [
                'UCS (ESX) - 4.0-3 errata302 - 28d414cc-2dac-4c0e-a34a-734020b8af66 - 00000000-0000-0000-0000-000000000000 -',
                'Linux',
                '0.0.0',
                'Linux Foundation',
                32,
            ],
            [
                'TinyBrowser/2.0 (TinyBrowser Comment; rv:1.9.1a2pre) Gecko/20201231',
                'Linux',
                '0.0.0',
                'Linux Foundation',
                32,
            ],
            [
                'Mozilla/5.0 (X11; Fedora; Linux armv7l; rv:38.0) Gecko/20100101 Firefox/38.0',
                'Fedora Linux',
                '0.0.0',
                'Red Hat Inc',
                32,
            ],
            [
                'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.34 (KHTML, like Gecko) profiler Safari/534.34',
                'Linux',
                '0.0.0',
                'Linux Foundation',
                64,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.1.1) Gecko/20090725 Moblin/3.5.1-2.5.14.moblin2 Shiretoko/3.5.1',
                'Moblin',
                '0.0.0',
                null,
                32,
            ],
            [
                'Mozilla/5.0 (X11; Ubuntu; Linux armv7l; rv:17.0) Gecko/20100101 Firefox/17.0',
                'Ubuntu',
                '0.0.0',
                'Canonical Foundation',
                32,
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1b4pre) Gecko/20090311 Ubuntu/9.04 (jaunty) Shiretoko/3.1b4pre',
                'Ubuntu',
                '9.04.0',
                'Canonical Foundation',
                32,
            ],
        ];
    }
}
