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

use BrowserDetector\Version\Debian;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

class DebianTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\Debian
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        self::markTestIncomplete();
        $this->object = new Debian();
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
                'Mozilla/5.0 (X11; U; Linux i686; de-de@euro) AppleWebKit/531.2+ (KHTML, like Gecko) Version/5.0 Safari/531.2+ Debian/squeeze (2.30.6-1) Epiphany/2.30.6',
                '6.0.0',
            ],
            [
                'ELinks/0.10.4-7-debian (textmode; GNU/kFreeBSD 5.3-17 i686; 143x53-2)',
                '5.3.17',
            ],
            [
                'Mozilla/5.0 (Macintosh; ARM Mac OS X) AppleWebKit/538.15 (KHTML, like Gecko) Safari/538.15 Version/6.0 Debian/8.0 (1:3.8.2.0-0) Epiphany/3.8.2',
                '8.0.0',
            ],
        ];
    }
}
