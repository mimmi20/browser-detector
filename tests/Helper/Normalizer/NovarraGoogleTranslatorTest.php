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

use BrowserDetector\Helper\Normalizer\NovarraGoogleTranslator;
use PHPUnit\Framework\TestCase;

/**
 * Class NovarraGoogleTranslatorTest
 *
 * @group Handlers
 */
class NovarraGoogleTranslatorTest extends TestCase
{
    /**
     * @var \BrowserDetector\Helper\Normalizer\NovarraGoogleTranslator
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
        $this->normalizer = new NovarraGoogleTranslator();
    }

    /**
     * @dataProvider novarraGoogleTranslatorDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     *
     * @return void
     */
    public function testNovarraAndGoogleTranslator(string $userAgent, string $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    /**
     * @return array[]
     */
    public function novarraGoogleTranslatorDataProvider()
    {
        return [
            [
                'BlackBerry8310/4.2.2 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/125 Novarra-Vision/7.3',
                'BlackBerry8310/4.2.2 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/125',
            ],
            [
                'Palm750/v0100 Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320),gzip(gfe) (via translate.google.com)',
                'Palm750/v0100 Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320)',
            ],
            [
                'Nokia3120classic/2.0 (10.00) Profile/MIDP-2.1 Configuration/CLDC-1.1,gzip(gfe) (via translate.google.com)',
                'Nokia3120classic/2.0 (10.00) Profile/MIDP-2.1 Configuration/CLDC-1.1',
            ],
        ];
    }
}
