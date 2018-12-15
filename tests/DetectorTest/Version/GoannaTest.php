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

use BrowserDetector\Version\Goanna;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

class GoannaTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\Goanna
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        self::markTestIncomplete();
        $this->object = new Goanna();
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
                'Mozilla/5.0 (Windows NT 6.1; rv:52.9) Gecko/20100101 Goanna/3.3 Firefox/52.9 PaleMoon/27.5.0',
                '3.3.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:2.0) Gecko/20100101 Goanna/20151214 PaleMoon/26.0.0b4',
                '2.0.0',
            ],
            [
                'Mozilla/5.0 (X11; Linux x86_64; rv:3.0) Goanna/20170207 PaleMoon/27.1.0',
                '3.0.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                '1.0.0',
            ],
        ];
    }
}
