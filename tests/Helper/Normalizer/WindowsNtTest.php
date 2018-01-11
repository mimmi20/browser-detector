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

use BrowserDetector\Helper\Normalizer\WindowsNt;
use PHPUnit\Framework\TestCase;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class WindowsNtTest extends TestCase
{
    /**
     * @var \BrowserDetector\Helper\Normalizer\WindowsNt
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
        $this->normalizer = new WindowsNt();
    }

    /**
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     *
     * @return void
     */
    public function testShouldNormalizeTheWindowsNtToken(string $userAgent, string $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    /**
     * @return array[]
     */
    public function userAgentsDataProvider()
    {
        return [
            [
                'Mozilla/4.0 (compatible; Lotus-Notes/6.0; Windows-NT)',
                'Mozilla/4.0 (compatible; Lotus-Notes/6.0; Windows NT)',
            ],
            [
                'Mozilla',
                'Mozilla',
            ],
            [
                'Firefox',
                'Firefox',
            ],
        ];
    }
}
