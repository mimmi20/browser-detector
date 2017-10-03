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

use BrowserDetector\Helper\Normalizer\Mozilla;
use BrowserDetector\Helper\Normalizer\UserAgentNormalizer;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class UserAgentNormalizerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     *
     * @return void
     */
    public function testNormalizeConstruct(string $userAgent, string $expected): void
    {
        $normalizer = new UserAgentNormalizer([new Mozilla()]);

        self::assertSame(1, $normalizer->count());

        self::assertSame($expected, $normalizer->normalize($userAgent));
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     *
     * @return void
     */
    public function testNormalizeAdd(string $userAgent, string $expected): void
    {
        $normalizer = new UserAgentNormalizer();
        $normalizer->add(new Mozilla());

        self::assertSame(1, $normalizer->count());

        self::assertSame($expected, $normalizer->normalize($userAgent));
    }

    /**
     * @return array[]
     */
    public function userAgentsDataProvider()
    {
        return [
            [
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
            ],
            [
                'Android (Linux;  U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux;  U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
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
