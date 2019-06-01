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

use BrowserDetector\Version\Puffin;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

final class PuffinTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\Puffin
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new Puffin();
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

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array[]
     */
    public function providerVersion(): array
    {
        return [
            [
                'Mozilla/5.0 (X11; U; Linux i686; de-DE) AppleWebKit/534.35 (KHTML, like Gecko)  Chrome/11.0.696.65 Safari/534.35 Puffin/2.0.6440M',
                '2.0.6440',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 3.2.1; en-us) AppleWebKit/534.35 (KHTML, like Gecko) Chrome/11.0.696.65 Safari/534.35 Puffin/2.10990AT Mobile',
                '2.10990.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                '0.0.0',
            ],
        ];
    }
}
