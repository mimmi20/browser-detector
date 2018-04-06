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
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\VersionInterface;
use BrowserDetector\Version\WindowsPhoneOs;
use PHPUnit\Framework\TestCase;

class WindowsPhoneOsTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\WindowsPhoneOs
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new WindowsPhoneOs();
    }

    /**
     * @dataProvider providerVersion
     *
     * @param string $useragent
     * @param string $expectedVersion
     *
     * @return void
     */
    public function testTestdetectVersion(string $useragent, string $expectedVersion): void
    {
        $detectedVersion = $this->object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array[]
     */
    public function providerVersion()
    {
        return [
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; XBLWP7; ZuneWP7)',
                '7.5.0',
            ],
            [
                'UCWEB/2.0 (Windows; U; wds 8.10; en-IN; NOKIA; RM-914_im_india_269) U2/1.0.0 UCBrowser/4.1.0.504 U2/1.0.0 Mobile',
                '8.10.0',
            ],
            [
                'UCWEB/2.0 (Windows; U; wds 8.0; en-IN; NOKIA; RM-941_im_india_204) U2/1.0.0 UCBrowser/4.2.1.541 U2/1.0.0 Mobile',
                '8.0.0',
            ],
            [
                'UCWEB/2.0 (Windows; U; wds 7.10; en-US; NOKIA; Lumia 610) U2/1.0.0 UCBrowser/3.2.0.340 U2/1.0.0 Mobile',
                '7.10.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.2; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 630; Orange) like Gecko',
                '8.0.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 928) like Gecko',
                '8.1.0',
            ],
            [
                'Mozilla/5.0 (Windows NT; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 928) like Gecko',
                '0.0.0',
            ],
            [
                'Mozilla/5.0 (Windows Phone 8.1; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 520; Vodafone ES) like Gecko',
                '8.1.0',
            ],
            [
                'ZDM/4.0; Windows Mobile 8.1',
                '8.1.0',
            ],
        ];
    }
}
