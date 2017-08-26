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

use BrowserDetector\Helper\Normalizer\IISLogging;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class IISLoggingTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Helper\Normalizer\IISLogging
     */
    private $normalizer = null;

    protected function setUp()
    {
        $this->normalizer = new IISLogging();
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function testNormalize($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    public function userAgentsDataProvider()
    {
        return [
            [
                'Mozilla/4.0+(compatible;+MSIE+7.0;+Windows+NT+5.1)',
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ],
            [
                'Mozilla/5.0 (compatible;WI Job Roboter Spider Version 3;+http://www.webintegration.at)',
                'Mozilla/5.0 (compatible;WI Job Roboter Spider Version 3;+http://www.webintegration.at)',
            ],
            [
                'Firefox',
                'Firefox',
            ],
        ];
    }
}
