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

use BrowserDetector\Helper\Normalizer\TransferEncoding;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class TransferEncodingTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Helper\Normalizer\TransferEncoding
     */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new TransferEncoding();
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function testNormalize($userAgent, $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    public function userAgentsDataProvider()
    {
        return [
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0,gzip(gfe)',
                'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0',
            ],
            [
                'Firefox',
                'Firefox',
            ],
        ];
    }
}
