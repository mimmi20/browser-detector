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

use BrowserDetector\Version\CoreMedia;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

class CoreMediaTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\CoreMedia
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new CoreMedia();
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
                'AppleCoreMedia/1.0.0.12D508 (iPad; U; CPU OS 8_2 like Mac OS X; sv_se)',
                '1.0.0',
            ],
            [
                'Apple Mac OS X v10.6.8 CoreMedia v1.0.0.10K540',
                '1.0.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                '0.0.0',
            ],
        ];
    }
}
