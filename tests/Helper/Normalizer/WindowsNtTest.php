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

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class WindowsNtTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Helper\Normalizer\WindowsNt
     */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new WindowsNt();
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function shouldNormalizeTheWindowsNtToken($userAgent, $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

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
