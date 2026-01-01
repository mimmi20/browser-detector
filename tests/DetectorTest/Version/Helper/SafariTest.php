<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version\Helper;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\Helper\Safari;
use BrowserDetector\Version\VersionBuilder;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

#[CoversClass(Safari::class)]
final class SafariTest extends TestCase
{
    private Safari $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new Safari();
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     * @throws Exception
     */
    #[DataProvider('providerVersion')]
    public function testMapSafariVersion(string $version, string | null $expectedVersion): void
    {
        $versionObj = (new VersionBuilder())->set($version);
        self::assertSame($expectedVersion, $this->object->mapSafariVersion($versionObj));
    }

    /**
     * @return array<int, array<int, string|null>>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerVersion(): array
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
            ['399', null],
            ['x', null],
            ['20623.2', '26.3'],
            ['20623.1', '26.2'],
            ['20622.2', '26.1'],
            ['20622.1', '26.0'],
            ['20621.3', '18.6'],
            ['20621.2', '18.5'],
            ['20621.1', '18.4'],
            ['20620.2', '18.3'],
            ['20620.1', '18.2'],
            ['20619.2', '18.1'],
            ['20619.1', '18.0'],
            ['19618.3', '17.6'],
            ['19618.2', '17.5'],
            ['19618.1', '17.4'],
            ['19617.2', '17.3'],
            ['19617.1', '17.2'],
            ['19616.2', '17.1'],
            ['19616.1', '17.0'],
            ['18615.3', '16.6'],
            ['18615.2', '16.5'],
            ['18615.1', '16.4'],
            ['18614.4', '16.3'],
            ['18614.3', '16.2'],
            ['18614.2', '16.1'],
            ['18614.1', '16.0'],
            ['17613.3', '15.6'],
            ['17613.2', '15.5'],
            ['17613.1', '15.4'],
            ['17612.3', '15.2'],
            ['17612.1', '15.0'],
            ['16611', '14.1'],
            ['16610', '14.0'],
            ['15609', '13.1'],
            ['15608', '13.0'],
            ['15600', '13.0'],
            ['15599', '12.1'],
            ['14606', '12.0'],
            ['11.1', '11.1.0'],
            ['11.2', '11.2.0'],
            ['11.3', '11.3.0'],
            ['11.4', '11.4.0'],
            ['12.0', '12.0.0'],
            ['12.1', '12.1.0'],
            ['12.2', '12.2.0'],
            ['12.3', '12.3.0'],
            ['12.4', '12.4.0'],
            ['13.0', '13.0.0'],
            ['13.1', '13.1.0'],
            ['13.2', '13.2.0'],
            ['13.3', '13.3.0'],
            ['13.4', '13.4.0'],
            ['13.5', '13.5.0'],
            ['13.6', '13.6.0'],
            ['13.7', '13.7.0'],
            ['14.0', '14.0.0'],
            ['14.1', '14.1.0'],
            ['14.2', '14.2.0'],
            ['14.3', '14.3.0'],
            ['14.4', '14.4.0'],
            ['14.5', '14.5.0'],
            ['14.6', '14.6.0'],
            ['14.7', '14.7.0'],
            ['14.8', '14.8.0'],
            ['15.0', '15.0.0'],
            ['15.1', '15.1.0'],
            ['15.2', '15.2.0'],
            ['15.3', '15.3.0'],
            ['15.4', '15.4.0'],
            ['15.5', '15.5.0'],
            ['15.6', '15.6.0'],
            ['15.7', '15.7.0'],
            ['16.0', '16.0.0'],
            ['16.1', '16.1.0'],
            ['16.2', '16.2.0'],
            ['16.3', '16.3.0'],
            ['16.4', '16.4.0'],
            ['16.5', '16.5.0'],
            ['16.6', '16.6.0'],
            ['17.0', '17.0.0'],
            ['17.1', '17.1.0'],
            ['17.2', '17.2.0'],
            ['18.0', '18.0.0'],
            ['18.1', '18.1.0'],
            ['18.2', '18.2.0'],
            ['18.3', '18.3.0'],
            ['18.4', '18.4.0'],
            ['18.5', '18.5.0'],
            ['18.6', '18.6.0'],
            ['18.7', '18.7.0'],
            ['26.0', '26.0.0'],
            ['26.1', '26.1.0'],
            ['26.2', '26.2.0'],
        ];
    }
}
