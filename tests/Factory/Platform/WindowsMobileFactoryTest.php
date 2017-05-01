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

use BrowserDetector\Factory\Platform\WindowsMobileFactory;
use BrowserDetector\Loader\PlatformLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class WindowsMobileFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Platform\WindowsMobileFactory
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
        $this->object = new WindowsMobileFactory($loader);
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
        $s = new Stringy($agent);

        /** @var \UaResult\Os\OsInterface $result */
        $result = $this->object->detect($agent, $s);

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
                'this is a fake ua to trigger the fallback',
                'Windows Mobile OS',
                '0.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 7.11) Sprint:MotoQ9c',
                'Windows CE',
                '0.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/4.0 (compatible; Windows Mobile; WCE; Opera Mobi/WMD-50433; U; de) Presto/2.4.13 Version/10.00',
                'Windows CE',
                '0.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Windows Phone OS',
                '8.1.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.2; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 928) like Gecko',
                'Windows Phone OS',
                '8.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 920; Vodafone ES) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Windows Phone OS',
                '8.1.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 650) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Windows Phone OS',
                '10.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Xbox; Xbox One) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Windows Phone OS',
                '10.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 650) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Windows Phone OS',
                '10.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'ZDM/4.0; Windows Mobile 8.1',
                'Windows Phone OS',
                '8.1.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'UCWEB/2.0 (Windows; U; wds 7.10; en-US; SAMSUNG; GT-I8350) U2/1.0.0 UCBrowser/3.2.0.340 U2/1.0.0 Mobile',
                'Windows Phone OS',
                '7.10.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0; ARM; Touch; WPDesktop)',
                'Windows Phone OS',
                '8.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0; ARM; Lumia 650) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586',
                'Windows Phone OS',
                '10.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; HTC_HD2_T8585; Windows Phone 6.5)',
                'Windows Mobile OS',
                '6.5.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; XBLWP7; ZuneWP7)',
                'Windows Phone OS',
                '7.5.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 928) like Gecko',
                'Windows Phone OS',
                '8.1.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.4; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 928) like Gecko',
                'Windows Phone OS',
                '0.0.0',
                'Microsoft Corporation',
                32,
            ],
        ];
    }
}
