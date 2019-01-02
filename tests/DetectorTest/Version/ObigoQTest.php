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

use BrowserDetector\Version\ObigoQ;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

class ObigoQTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\ObigoQ
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new ObigoQ();
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
                'ALCATEL_TRIBE_3075A/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 ObigoInternetBrowser/Q05A',
                '05.0.0',
            ],
            [
                'Huawei/1.0/0HuaweiG2800/WAP2.0/Obigo-Browser/Q03C MMS/Obigo-MMS/1.2',
                '03.0.0',
            ],
            [
                'HUAWEI-M636/001.00 WAP/OBIGO/Q05A',
                '05.0.0',
            ],
            [
                'LG-GT505/v10a Browser/Teleca-Q7.1 MMS/LG-MMS-V1.0/1.2 MediaPlayer/LGPlayer/1.0 Java/ASVM/1.1 Profile/MIDP-2.1 Configuration/CLDC-1.1',
                '7.1.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                '0.0.0',
            ],
            [
                'NGM_Coffee/ObigoInternetBrowser/QO3C Profile/MIDP2.0 Configuration/CLDC-1.1',
                '3.0.0',
            ],
        ];
    }
}
