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
use BrowserDetector\Version\WindowsMobileOs;
use PHPUnit\Framework\TestCase;

class WindowsMobileOsTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\WindowsMobileOs
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new WindowsMobileOs();
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
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 8.12; MSIEMobile 6.0) 320x240; VZW; UTStar-XV6175.1; Windows Mobile 6.5 Standard;',
                '6.5.0',
            ],
            [
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100222 Firefox/3.6 Kylo/0.6.1.70394',
                '6.0.0',
            ],
        ];
    }
}
