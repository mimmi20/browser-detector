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
namespace BrowserDetectorTest\Version\Helper;

use BrowserDetector\Version\Helper\Safari;
use PHPUnit\Framework\TestCase;

class SafariTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\Helper\Safari
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new Safari();
    }

    /**
     * @dataProvider providerVersion
     *
     * @param string $version
     * @param string $expectedVersion
     *
     * @return void
     */
    public function testMapSafariVersion(string $version, string $expectedVersion): void
    {
        self::assertSame($expectedVersion, $this->object->mapSafariVersion($version));
    }

    /**
     * @return array[]
     */
    public function providerVersion()
    {
        return [
            ['3.0', '3.0'],
            ['3.1', '3.1'],
            ['3.2', '3.2'],
            ['4.0', '4.0'],
            ['4.1', '4.1'],
            ['4.2', '4.2'],
            ['4.3', '4.3'],
            ['4.4', '4.4'],
            ['5.0', '5.0'],
            ['5.1', '5.1'],
            ['5.2', '5.2'],
            ['6.0', '6.0'],
            ['6.1', '6.1'],
            ['6.2', '6.2'],
            ['7.0', '7.0'],
            ['7.1', '7.1'],
            ['8.0', '8.0'],
            ['8.1', '8.1'],
            ['9.0', '9.0'],
            ['9.1', '9.1'],
            ['10.0', '10.0'],
            ['10.1', '10.1'],
            ['11.0', '11.0'],
            ['13600', '11.0'],
            ['12600', '10.0'],
            ['11600', '9.1'],
            ['10500', '8.0'],
            ['9500', '7.0'],
            ['8500', '6.0'],
            ['7500', '5.1'],
            ['6500', '5.0'],
            ['4500', '4.0'],
            ['600', '5.0'],
            ['500', '4.0'],
            ['400', '3.0'],
            ['x', '0'],
        ];
    }
}
