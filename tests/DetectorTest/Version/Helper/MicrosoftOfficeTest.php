<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version\Helper;

use BrowserDetector\Version\Helper\MicrosoftOffice;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class MicrosoftOfficeTest extends TestCase
{
    private MicrosoftOffice $object;

    protected function setUp(): void
    {
        $this->object = new MicrosoftOffice();
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @dataProvider providerVersion
     */
    public function testMapOfficeVersion(string $version, string $expectedVersion): void
    {
        self::assertSame($expectedVersion, $this->object->mapOfficeVersion($version));
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function providerVersion(): array
    {
        return [
            ['2007', '2007'],
            ['2010', '2010'],
            ['2013', '2013'],
            ['2016', '2016'],
            ['16', '2016'],
            ['15', '2013'],
            ['14', '2010'],
            ['12', '2007'],
            ['x', '0'],
        ];
    }
}
