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

use BrowserDetector\Version\Ios;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

class IosTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\Ios
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new Ios();
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
                'Mozilla/5.0 (iPod; U; CPU like Mac OS X; de-de) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3',
                '1.0.0',
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 8_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) CriOS/42.0.2311.47 Mobile/12B401 Safari/600.1.4',
                '8.1.0-beta+1',
            ],
            [
                'TestApp/1.0 CFNetwork/808.2.16 Darwin/16.3.0',
                '10.2.0',
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) CriOS/42.0.2311.47 Mobile/11D167 Safari/9537.53',
                '7.1.0',
            ],
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 10_10 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile Safari/600.1.4',
                '8.0.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                '0.0.0',
            ],
            [
                'AppleCoreMedia/1.0.0.12D5480a (iPad; U; CPU OS 8_2 like Mac OS X; sv_se)',
                '8.2.0-beta+5',
            ],
            [
                'Apple-iPhone3C1/902.206',
                '5.1.1',
            ],
            [
                'Apple-iPhone9C4/1602.92',
                '12.1.0',
            ],
        ];
    }
}
