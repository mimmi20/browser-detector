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

namespace Data;

use BrowserDetector\Data\Company;
use BrowserDetector\Data\Engine;
use BrowserDetector\Version\GeckoFactory;
use BrowserDetector\Version\GoannaFactory;
use BrowserDetector\Version\TridentFactory;
use BrowserDetector\Version\VersionBuilderFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function sprintf;

#[CoversClass(Engine::class)]
final class EngineTest extends TestCase
{
    /**
     * tests the constructor and the getter
     *
     * @param array{factory: string|null, search: list<string>|null} $version
     *
     * @throws UnexpectedValueException
     * @throws ExpectationFailedException
     */
    #[DataProvider('provider')]
    public function testType(
        string $type,
        string | null $name,
        Company $manufacturer,
        array $version,
        string $key,
    ): void {
        $result = Engine::tryFrom($type);

        if ($result === null) {
            self::fail(sprintf('unknown engine %s', $type));
        }

        self::assertSame($name, $result->getName());
        self::assertSame($manufacturer, $result->getManufacturer());
        self::assertSame($version, $result->getVersion());
        self::assertSame($key, $result->getKey());

        if ($name !== null) {
            $result2 = Engine::fromName($name);

            self::assertSame($name, $result2->getName());
            self::assertSame($manufacturer, $result2->getManufacturer());
            self::assertSame($version, $result2->getVersion());
            self::assertSame($key, $result2->getKey());
        }

        $result4 = Engine::fromName($result->value);

        self::assertSame($name, $result4->getName());
        self::assertSame($manufacturer, $result4->getManufacturer());
        self::assertSame($version, $result4->getVersion());
        self::assertSame($key, $result4->getKey());

        $result5 = Engine::fromName($result->name);

        self::assertSame($name, $result5->getName());
        self::assertSame($manufacturer, $result5->getManufacturer());
        self::assertSame($version, $result5->getVersion());
        self::assertSame($key, $result5->getKey());
    }

    /**
     * @return array<int, array{type: string, name: string|null, manufacturer: Company, version: array{factory: string|null, search: list<string>|null}, key: string}>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function provider(): array
    {
        return [
            [
                'type' => 'unknown',
                'name' => null,
                'manufacturer' => Company::unknown,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'unknown',
            ],
            [
                'type' => 'black-berry',
                'name' => 'black-berry',
                'manufacturer' => Company::rim,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'blackberry',
            ],
            [
                'type' => 'Blink',
                'name' => 'Blink',
                'manufacturer' => Company::google,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Chrome', 'Cronet']],
                'key' => 'blink',
            ],
            [
                'type' => 'Clecko',
                'name' => 'Clecko',
                'manufacturer' => Company::unknown,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['rv:']],
                'key' => 'clecko',
            ],
            [
                'type' => 'Edge',
                'name' => 'Edge',
                'manufacturer' => Company::microsoft,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Edge']],
                'key' => 'edge',
            ],
            [
                'type' => 'Gecko',
                'name' => 'Gecko',
                'manufacturer' => Company::mozilla,
                'version' => ['factory' => GeckoFactory::class, 'search' => null],
                'key' => 'gecko',
            ],
            [
                'type' => 'WebKit',
                'name' => 'WebKit',
                'manufacturer' => Company::apple,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['AppleWebKit', 'WebKit', 'CFNetwork', 'Browser\\/AppleWebKit']],
                'key' => 'webkit',
            ],
            [
                'type' => 'Trident',
                'name' => 'Trident',
                'manufacturer' => Company::microsoft,
                'version' => ['factory' => TridentFactory::class, 'search' => null],
                'key' => 'trident',
            ],
            [
                'type' => 'KHTML',
                'name' => 'KHTML',
                'manufacturer' => Company::unknown,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['KHTML']],
                'key' => 'khtml',
            ],
            [
                'type' => 'NetFront',
                'name' => 'NetFront',
                'manufacturer' => Company::access,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'netfront',
            ],
            [
                'type' => 'Presto',
                'name' => 'Presto',
                'manufacturer' => Company::opera,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Presto']],
                'key' => 'presto',
            ],
            [
                'type' => 'Servo',
                'name' => 'Servo',
                'manufacturer' => Company::mozilla,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Servo']],
                'key' => 'servo',
            ],
            [
                'type' => 'T5',
                'name' => 'T5',
                'manufacturer' => Company::baidu,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['T5']],
                'key' => 't5',
            ],
            [
                'type' => 'T7',
                'name' => 'T7',
                'manufacturer' => Company::baidu,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['T7']],
                'key' => 't7',
            ],
            [
                'type' => 'Tasman',
                'name' => 'Tasman',
                'manufacturer' => Company::apple,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'tasman',
            ],
            [
                'type' => 'U2',
                'name' => 'U2',
                'manufacturer' => Company::ucweb,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['U2']],
                'key' => 'u2',
            ],
            [
                'type' => 'U3',
                'name' => 'U3',
                'manufacturer' => Company::ucweb,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['U3']],
                'key' => 'u3',
            ],
            [
                'type' => 'U4',
                'name' => 'U4',
                'manufacturer' => Company::ucweb,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['U4']],
                'key' => 'u4',
            ],
            [
                'type' => 'Elektra',
                'name' => 'Elektra',
                'manufacturer' => Company::unknown,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'elektra',
            ],
            [
                'type' => 'Goanna',
                'name' => 'Goanna',
                'manufacturer' => Company::moonchild,
                'version' => ['factory' => GoannaFactory::class, 'search' => null],
                'key' => 'goanna',
            ],
            [
                'type' => 'Teleca',
                'name' => 'Teleca',
                'manufacturer' => Company::obigo,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'teleca',
            ],
            [
                'type' => 'Treco',
                'name' => 'Treco',
                'manufacturer' => Company::arsslensoft,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['rv:']],
                'key' => 'treco',
            ],
            [
                'type' => 'Text',
                'name' => 'Text',
                'manufacturer' => Company::unknown,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'text',
            ],
            [
                'type' => 'iCab',
                'name' => 'iCab',
                'manufacturer' => Company::unknown,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['iCab']],
                'key' => 'icab',
            ],
            [
                'type' => 'ArkWeb',
                'name' => 'ArkWeb',
                'manufacturer' => Company::huawei,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['ArkWeb']],
                'key' => 'arkweb',
            ],
            [
                'type' => 'NetSurf',
                'name' => 'NetSurf',
                'manufacturer' => Company::unknown,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['NetSurf']],
                'key' => 'netsurf',
            ],
        ];
    }
}
