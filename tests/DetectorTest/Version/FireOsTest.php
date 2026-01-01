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
use BrowserDetector\Version\FireOs;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

#[CoversClass(FireOs::class)]
final class FireOsTest extends TestCase
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
        $object = new FireOs(new VersionBuilder());

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
                '11',
                '8.0.0',
            ],
            [
                '10',
                '8.0.0',
            ],
            [
                '9',
                '7.0.0',
            ],
            [
                '7',
                '6.0.0',
            ],
            [
                '5',
                '5.0.0',
            ],
            [
                '4.4.3',
                '4.5.1',
            ],
            [
                '4.4.2',
                '4.0.0',
            ],
            [
                '4.2.2',
                '3.0.0',
            ],
            [
                '4.0.3',
                '3.0.0',
            ],
            [
                '4.0.2',
                '3.0.0',
            ],
            [
                '4',
                '2.0.0',
            ],
            [
                '2',
                '1.0.0',
            ],
            [
                'x',
                null,
            ],
            [
                '8.2',
                '6.0.0',
            ],
        ];
    }
}
