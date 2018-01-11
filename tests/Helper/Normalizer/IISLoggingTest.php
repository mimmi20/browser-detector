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
use PHPUnit\Framework\TestCase;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class IISLoggingTest extends TestCase
{
    /**
     * @var \BrowserDetector\Helper\Normalizer\IISLogging
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
        $this->normalizer = new IISLogging();
    }

    /**
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     *
     * @return void
     */
    public function testNormalize(string $userAgent, string $expected): void
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
