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

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\LineageOs;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

#[CoversClass(LineageOs::class)]
final class LineageOsTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws Exception
     * @throws NotNumericException
     */
    #[DataProvider('providerVersion')]
    public function testGetVersion(string $androidVersion, string | null $expectedVersion): void
    {
        $object = new LineageOs(new VersionBuilder());

        $detectedVersion = $object->getVersion($androidVersion);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
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
            [
                '16',
                '23.0.0',
            ],
            [
                '15',
                '22.0.0',
            ],
            [
                '14',
                '21.0.0',
            ],
            [
                '13',
                '20.0.0',
            ],
            [
                '12.1',
                '19.1.0',
            ],
            [
                '12',
                '19.0.0',
            ],
            [
                '11',
                '18.0.0',
            ],
            [
                '10',
                '17.0.0',
            ],
            [
                '9',
                '16.0.0',
            ],
            [
                '8.1',
                '15.1.0',
            ],
            [
                '8',
                '15.0.0',
            ],
            [
                '7.1.2',
                '14.1.0',
            ],
            [
                '7.1.1',
                '14.1.0',
            ],
            [
                '7',
                '14.0.0',
            ],
            [
                '6.0.1',
                '13.0.0',
            ],
            [
                '6',
                '13.0.0',
            ],
            [
                '5.1.1',
                '12.1.0',
            ],
            [
                '5.0.2',
                '12.0.0',
            ],
            [
                '5',
                '12.0.0',
            ],
            [
                '4.4.4',
                '11.0.0',
            ],
            [
                '4.3',
                '10.2.0',
            ],
            [
                '4.2.2',
                '10.1.0',
            ],
            [
                '4.0.4',
                '9.1.0',
            ],
            [
                'x',
                null,
            ],
            [
                '8.2',
                '15.1.0',
            ],
        ];
    }
}
