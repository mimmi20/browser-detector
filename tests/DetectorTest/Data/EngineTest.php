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

namespace BrowserDetectorTest\Data;

use BrowserDetector\Data\Engine;
use BrowserDetector\Version\GeckoFactory;
use BrowserDetector\Version\GoannaFactory;
use BrowserDetector\Version\TridentFactory;
use BrowserDetector\Version\VersionBuilderFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(className: Engine::class)]
final class EngineTest extends TestCase
{
    /**
     * tests the constructor and the getter
     *
     * @param array{factory: string|null, search: list<string>|null} $version
     *
     * @throws ExpectationFailedException
     */
    #[DataProvider(methodName: 'provider')]
    public function testType(
        string $type,
        string | null $name,
        string | null $company,
        array $version,
        string $key,
    ): void {
        $result = Engine::tryFrom($type);

        if ($result === null) {
            self::fail(sprintf('unknown engine %s', $type));
        }

        self::assertSame($name, $result->getName());
        self::assertSame($company, $result->getManufacturer());
        self::assertSame($version, $result->getVersion());
        self::assertSame($key, $result->getKey());

        if ($name !== null) {
            $result2 = Engine::fromName($name);

            self::assertSame($name, $result2->getName());
            self::assertSame($company, $result2->getManufacturer());
            self::assertSame($version, $result2->getVersion());
            self::assertSame($key, $result2->getKey());
        }

        $engine = Engine::fromName($result->value);

        self::assertSame($name, $engine->getName());
        self::assertSame($company, $engine->getManufacturer());
        self::assertSame($version, $engine->getVersion());
        self::assertSame($key, $engine->getKey());

        $result5 = Engine::fromName($result->name);

        self::assertSame($name, $result5->getName());
        self::assertSame($company, $result5->getManufacturer());
        self::assertSame($version, $result5->getVersion());
        self::assertSame($key, $result5->getKey());
    }

    /**
     * @return array<int, array{type: string, name: string|null, company: string|null, version: array{factory: string|null, search: list<string>|null}, key: string}>
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
                'company' => null,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'unknown',
            ],
            [
                'type' => 'black-berry',
                'name' => 'black-berry',
                'company' => 'rim',
                'version' => ['factory' => null, 'search' => null],
                'key' => 'blackberry',
            ],
            [
                'type' => 'Blink',
                'name' => 'Blink',
                'company' => 'google',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Chrome', 'Chr0me', 'Cronet', 'Chromium_', 'Chromium']],
                'key' => 'blink',
            ],
            [
                'type' => 'Clecko',
                'name' => 'Clecko',
                'company' => null,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['rv:']],
                'key' => 'clecko',
            ],
            [
                'type' => 'Edge',
                'name' => 'Edge',
                'company' => 'microsoft',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Edge']],
                'key' => 'edge',
            ],
            [
                'type' => 'Gecko',
                'name' => 'Gecko',
                'company' => 'mozilla',
                'version' => ['factory' => GeckoFactory::class, 'search' => null],
                'key' => 'gecko',
            ],
            [
                'type' => 'WebKit',
                'name' => 'WebKit',
                'company' => 'apple',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['AppleWebKit \\/', 'AppleWebKit', 'WebKit', 'CFNetwork', 'Browser\\/AppleWebKit']],
                'key' => 'webkit',
            ],
            [
                'type' => 'Trident',
                'name' => 'Trident',
                'company' => 'microsoft',
                'version' => ['factory' => TridentFactory::class, 'search' => null],
                'key' => 'trident',
            ],
            [
                'type' => 'KHTML',
                'name' => 'KHTML',
                'company' => null,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['KHTML']],
                'key' => 'khtml',
            ],
            [
                'type' => 'NetFront',
                'name' => 'NetFront',
                'company' => 'access',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['NetFront']],
                'key' => 'netfront',
            ],
            [
                'type' => 'Presto',
                'name' => 'Presto',
                'company' => 'opera',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Presto']],
                'key' => 'presto',
            ],
            [
                'type' => 'Servo',
                'name' => 'Servo',
                'company' => 'mozilla',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Servo']],
                'key' => 'servo',
            ],
            [
                'type' => 'T5',
                'name' => 'T5',
                'company' => 'baidu',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['T5']],
                'key' => 't5',
            ],
            [
                'type' => 'T7',
                'name' => 'T7',
                'company' => 'baidu',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['T7']],
                'key' => 't7',
            ],
            [
                'type' => 'Tasman',
                'name' => 'Tasman',
                'company' => 'apple',
                'version' => ['factory' => null, 'search' => null],
                'key' => 'tasman',
            ],
            [
                'type' => 'U2',
                'name' => 'U2',
                'company' => 'ucweb',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['U2']],
                'key' => 'u2',
            ],
            [
                'type' => 'U3',
                'name' => 'U3',
                'company' => 'ucweb',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['U3']],
                'key' => 'u3',
            ],
            [
                'type' => 'U4',
                'name' => 'U4',
                'company' => 'ucweb',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['U4']],
                'key' => 'u4',
            ],
            [
                'type' => 'Elektra',
                'name' => 'Elektra',
                'company' => null,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'elektra',
            ],
            [
                'type' => 'Goanna',
                'name' => 'Goanna',
                'company' => 'moonchild',
                'version' => ['factory' => GoannaFactory::class, 'search' => null],
                'key' => 'goanna',
            ],
            [
                'type' => 'Teleca',
                'name' => 'Teleca',
                'company' => 'obigo',
                'version' => ['factory' => null, 'search' => null],
                'key' => 'teleca',
            ],
            [
                'type' => 'Treco',
                'name' => 'Treco',
                'company' => 'arsslensoft',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['rv:']],
                'key' => 'treco',
            ],
            [
                'type' => 'Text',
                'name' => 'Text',
                'company' => null,
                'version' => ['factory' => null, 'search' => null],
                'key' => 'text',
            ],
            [
                'type' => 'iCab',
                'name' => 'iCab',
                'company' => null,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['iCab']],
                'key' => 'icab',
            ],
            [
                'type' => 'ArkWeb',
                'name' => 'ArkWeb',
                'company' => 'huawei',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['ArkWeb']],
                'key' => 'arkweb',
            ],
            [
                'type' => 'NetSurf',
                'name' => 'NetSurf',
                'company' => null,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['NetSurf']],
                'key' => 'netsurf',
            ],
            [
                'type' => 'EkiohFlow',
                'name' => 'EkiohFlow',
                'company' => 'ekioh',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['EkiohFlow']],
                'key' => 'ekiohflow',
            ],
            [
                'type' => 'Maple',
                'name' => 'Maple',
                'company' => 'samsung',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Maple']],
                'key' => 'maple',
            ],
            [
                'type' => 'Dillo',
                'name' => 'Dillo',
                'company' => 'theDilloProject',
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Dillo']],
                'key' => 'dillo',
            ],
            [
                'type' => 'Arachne',
                'name' => 'Arachne',
                'company' => null,
                'version' => ['factory' => VersionBuilderFactory::class, 'search' => ['Arachne\\/5\\.']],
                'key' => 'arachne',
            ],
        ];
    }
}
