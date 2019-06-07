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
namespace BrowserDetectorTest\Version\Helper;

use BrowserDetector\Version\Helper\Safari;
use BrowserDetector\Version\VersionFactory;
use PHPUnit\Framework\TestCase;

final class SafariTest extends TestCase
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
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testMapSafariVersion(string $version, string $expectedVersion): void
    {
        $versionObj = (new VersionFactory())->set($version);
        static::assertSame($expectedVersion, $this->object->mapSafariVersion($versionObj));
    }

    /**
     * @return array[]
     */
    public function providerVersion(): array
    {
        return [
            ['3.0', '3.0.0'],
            ['3.1', '3.1.0'],
            ['3.2', '3.2.0'],
            ['4.0', '4.0.0'],
            ['4.1', '4.1.0'],
            ['4.2', '4.2.0'],
            ['4.3', '4.3.0'],
            ['4.4', '4.4.0'],
            ['5.0', '5.0.0'],
            ['5.1', '5.1.0'],
            ['5.2', '5.2.0'],
            ['6.0', '6.0.0'],
            ['6.1', '6.1.0'],
            ['6.2', '6.2.0'],
            ['7.0', '7.0.0'],
            ['7.1', '7.1.0'],
            ['8.0', '8.0.0'],
            ['8.1', '8.1.0'],
            ['9.0', '9.0.0'],
            ['9.1', '9.1.0'],
            ['10.0', '10.0.0'],
            ['10.1', '10.1.0'],
            ['11.0', '11.0.0'],
            ['14600', '12.0'],
            ['14599', '11.0'],
            ['13600', '11.0'],
            ['13599', '10.0'],
            ['12600', '10.0'],
            ['12599', '9.1'],
            ['11600', '9.1'],
            ['11599', '8.0'],
            ['10500', '8.0'],
            ['10499', '7.0'],
            ['9500', '7.0'],
            ['9499', '6.0'],
            ['8500', '6.0'],
            ['8499', '5.1'],
            ['7500', '5.1'],
            ['7499', '5.0'],
            ['6500', '5.0'],
            ['6499', '4.0'],
            ['4500', '4.0'],
            ['600', '5.0'],
            ['599', '4.0'],
            ['500', '4.0'],
            ['499', '3.0'],
            ['400', '3.0'],
            ['399', '0'],
            ['x', '0'],
        ];
    }
}
