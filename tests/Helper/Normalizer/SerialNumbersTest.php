<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Helper\Normalizer;

use BrowserDetector\Helper\Normalizer\SerialNumbers;
use PHPUnit\Framework\TestCase;

/**
 * Class SerialNumbersTest
 *
 * @group Handlers
 */
class SerialNumbersTest extends TestCase
{
    /**
     * @var \BrowserDetector\Helper\Normalizer\SerialNumbers
     */
    private $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->normalizer = new SerialNumbers();
    }

    /**
     * @dataProvider serialNumbersDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     *
     * @return void
     */
    public function testRemoveSerialNumber(string $userAgent, string $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    /**
     * @return array[]
     */
    public function serialNumbersDataProvider()
    {
        return [
            [
                'r451[TFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX] UP.Browser/6.2.3.8 (GUI) MMP/2.0',
                'r451 UP.Browser/6.2.3.8 (GUI) MMP/2.0',
            ],
            [
                'LG-LG1500[TF011231004305163000940013045946416] UP.Browser/6.2.3 (GUI) MMP/1.0 UP.Link/6.3.0.0.0',
                'LG-LG1500 UP.Browser/6.2.3 (GUI) MMP/1.0 UP.Link/6.3.0.0.0',
            ],
            [
                'MOT-V176/6.6.61[ST010913001046723002023302085980278] UP.Browser/6.2.3.9.c.9 (GUI) MMP/2.0 UP.Link/6.3.0.0.0',
                'MOT-V176/6.6.61 UP.Browser/6.2.3.9.c.9 (GUI) MMP/2.0 UP.Link/6.3.0.0.0',
            ],
            ['Mozilla', 'Mozilla'],
            [
                'Vodafone/1.0/V702NK/NKJ001/IMEI/SN354350000005026 Series60/2.6 Nokia6630/2.40.235 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'Vodafone/1.0/V702NK/NKJ001/IMEI Series60/2.6 Nokia6630/2.40.235 Profile/MIDP-2.0 Configuration/CLDC-1.1',
            ],
        ];
    }
}
