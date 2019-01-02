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
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

class MicrosoftInternetExplorerTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\MicrosoftInternetExplorer
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new MicrosoftInternetExplorer();
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
    public function providerVersion(): array
    {
        return [
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
                '0.0.0',
            ],
        ];
    }
}
