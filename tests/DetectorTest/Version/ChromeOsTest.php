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

use BrowserDetector\Version\ChromeOs;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

class ChromeOsTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\ChromeOs
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new ChromeOs();
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
                'Mozilla/5.0 (X11; CrOS armv7l 6812.75.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.87 Safari/537.36',
                '42.0.2311.87',
            ],
            [
                'Mozilla/5.0 (X11; CrOS x86_64 14.4.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2550.0 Safari/537.36',
                '14.4.0',
            ],
            [
                'Mozilla/5.0 (X11; CrOS 14.4.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2550.0 Safari/537.36',
                '0.0.0',
            ],
        ];
    }
}
