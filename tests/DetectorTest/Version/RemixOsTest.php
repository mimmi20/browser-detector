<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Version;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\RemixOs;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

#[CoversClass(RemixOs::class)]
final class RemixOsTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws Exception
     * @throws NotNumericException
     */
    #[DataProvider('providerVersion')]
    public function testGetVersion(string $useragent, string | null $expectedVersion): void
    {
        $object = new RemixOs(new VersionBuilder());

        $detectedVersion = $object->detectVersion($useragent);

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
                'Browse/0.6.mini (Linux 3.4.0+; RemixOS 6.0; Motorola Moto G 2014; en_us) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.119 Desktop',
                '2.0.0',
            ],
            [
                'Browse/0.6.mini (Linux 3.4.0+; RemixOS 5.0; Motorola Moto G 2014; en_us) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.119 Desktop',
                '1.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 6.0.1; Remix Pro Build/MMB29M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 YaBrowser/17.1.0.412.01 Safari/537.36',
                '3.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1; Remix Mini) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.105 Safari/537.36',
                '2.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1; Remix) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.105 Safari/537.36',
                '0.0.0',
            ],
        ];
    }
}
