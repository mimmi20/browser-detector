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

use BrowserDetector\Version\Macosx;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

class MacosxTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\Macosx
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new Macosx();
    }

    /**
     * @dataProvider providerVersion
     *
     * @param string $useragent
     * @param string $expectedVersion
     *
     * @throws \Exception
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
                'Downcast/2.9.11 (Mac OS X Version 10.11.3 (Build 15D13b))',
                '10.11.3-beta+2',
            ],
            [
                'Mail/3445.1.3 CFNetwork/887 Darwin/17.0.0 (x86_64)',
                '10.13.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 107) AppleWebKit/534.48.3 (KHTML like Gecko) Version/5.1 Safari/534.48.3',
                '10.7.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 1084) AppleWebKit/536.29.13 (KHTML like Gecko) Version/6.0.4 Safari/536.29.13',
                '10.8.4',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.5.17 (KHTML, like Gecko) Version/8.0.5 Safari/600.5.17',
                '10.10.4',
            ],
            [
                'Apple Mac OS X v10.6.8 CoreMedia v1.0.0.10K540',
                '10.6.8',
            ],
        ];
    }
}
