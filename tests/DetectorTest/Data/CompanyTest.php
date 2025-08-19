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

namespace Data;

use BrowserDetector\Data\Company;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function sprintf;

#[CoversClass(Company::class)]
final class CompanyTest extends TestCase
{
    /**
     * tests the constructor and the getter
     *
     * @throws UnexpectedValueException
     * @throws ExpectationFailedException
     */
    #[DataProvider('provider')]
    public function testType(string $type, string | null $name, string | null $brandname, string $key): void
    {
        $result = Company::tryFrom($type);

        if ($result === null) {
            self::fail(sprintf('unknown company %s', $type));
        }

        self::assertSame($name, $result->getName());
        self::assertSame($brandname, $result->getBrandname());
        self::assertSame($key, $result->getKey());

        $result3 = Company::fromName($type);

        self::assertSame($name, $result3->getName());
        self::assertSame($brandname, $result3->getBrandname());
        self::assertSame($key, $result3->getKey());

        if ($name !== null) {
            $result2 = Company::fromName($name);

            self::assertSame($name, $result2->getName());
            self::assertSame($brandname, $result2->getBrandname());
            self::assertSame($key, $result2->getKey());
        }

        $result4 = Company::fromName($result->value);

        self::assertSame($name, $result4->getName());
        self::assertSame($brandname, $result4->getBrandname());
        self::assertSame($key, $result4->getKey());

        $result5 = Company::fromName($result->name);

        self::assertSame($name, $result5->getName());
        self::assertSame($brandname, $result5->getBrandname());
        self::assertSame($key, $result5->getKey());
    }

    /**
     * @return array<int, array{type: string, name: string|null, brandname: string|null, key: string}>
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
                'brandname' => null,
                'key' => 'unknown',
            ],
            [
                'type' => 'hoco',
                'name' => 'hoco',
                'brandname' => 'hoco',
                'key' => 'hoco',
            ],
            [
                'type' => 'GTX',
                'name' => 'GTX',
                'brandname' => 'GTX',
                'key' => 'gtx',
            ],
            [
                'type' => 'Vasoun',
                'name' => 'Vasoun',
                'brandname' => 'Vasoun',
                'key' => 'vasoun',
            ],
            [
                'type' => 'Kenshi',
                'name' => 'Kenshi',
                'brandname' => 'Kenshi',
                'key' => 'kenshi',
            ],
            [
                'type' => 'Wishtel',
                'name' => 'Wishtel Private Limited',
                'brandname' => 'Wishtel',
                'key' => 'wish-tel',
            ],
            [
                'type' => 'LUNNEN',
                'name' => 'LUNNEN',
                'brandname' => 'LUNNEN',
                'key' => 'lunnen',
            ],
            [
                'type' => 'mipo',
                'name' => 'mipo',
                'brandname' => 'mipo',
                'key' => 'mipo',
            ],
            [
                'type' => 'ACD',
                'name' => 'ACD',
                'brandname' => 'ACD',
                'key' => 'acd',
            ],
            [
                'type' => 'Meta',
                'name' => 'Meta Inc',
                'brandname' => 'Meta',
                'key' => 'meta',
            ],
            [
                'type' => 'Atozee',
                'name' => 'Atozee',
                'brandname' => 'Atozee',
                'key' => 'atozee',
            ],
            [
                'type' => 'Everis',
                'name' => 'Everis',
                'brandname' => 'Everis',
                'key' => 'everis',
            ],
            [
                'type' => 'Unitech',
                'name' => 'Unitech',
                'brandname' => 'Unitech',
                'key' => 'unitech',
            ],
            [
                'type' => 'Stylo',
                'name' => 'Stylo',
                'brandname' => 'Stylo',
                'key' => 'stylo',
            ],
            [
                'type' => 'Realix',
                'name' => 'Realix',
                'brandname' => 'Realix',
                'key' => 'realix',
            ],
            [
                'type' => 'Opel Mobile',
                'name' => 'Opel Mobile',
                'brandname' => 'Opel Mobile',
                'key' => 'opel-mobile',
            ],
            [
                'type' => 'Okapi Mobile',
                'name' => 'Okapi Mobile',
                'brandname' => 'Okapi Mobile',
                'key' => 'okapi-mobile',
            ],
            [
                'type' => 'Olax',
                'name' => 'Olax',
                'brandname' => 'Olax',
                'key' => 'olax',
            ],
            [
                'type' => 'Lville',
                'name' => 'Lville',
                'brandname' => 'Lville',
                'key' => 'lville',
            ],
            [
                'type' => 'Trimble',
                'name' => 'Trimble',
                'brandname' => 'Trimble',
                'key' => 'trimble',
            ],
            [
                'type' => 'Google',
                'name' => 'Google Inc.',
                'brandname' => 'Google',
                'key' => 'google',
            ],
            [
                'type' => 'Apple',
                'name' => 'Apple Inc',
                'brandname' => 'Apple',
                'key' => 'apple',
            ],
            [
                'type' => 'Microsoft',
                'name' => 'Microsoft Corporation',
                'brandname' => 'Microsoft',
                'key' => 'microsoft',
            ],
            [
                'type' => 'Ajib',
                'name' => 'Ajib',
                'brandname' => 'Ajib',
                'key' => 'ajib',
            ],
            [
                'type' => 'Mintt',
                'name' => 'Mintt',
                'brandname' => 'Mintt',
                'key' => 'mintt',
            ],
            [
                'type' => 'IOTWE',
                'name' => 'IOTWE',
                'brandname' => 'IOTWE',
                'key' => 'iotwe',
            ],
            [
                'type' => 'Fenoti',
                'name' => 'Fenoti',
                'brandname' => 'Fenoti',
                'key' => 'fenoti',
            ],
            [
                'type' => 'Sparx',
                'name' => 'Sparx',
                'brandname' => 'Sparx',
                'key' => 'sparx',
            ],
            [
                'type' => 'Dcode',
                'name' => 'Dcode',
                'brandname' => 'Dcode',
                'key' => 'dcode',
            ],
            [
                'type' => 'iBrit',
                'name' => 'iBrit',
                'brandname' => 'iBrit',
                'key' => 'ibrit',
            ],
            [
                'type' => 'Nordmende',
                'name' => 'Talisman Brands, Inc. d/b/a Established',
                'brandname' => 'Nordmende',
                'key' => 'nordmende',
            ],
            [
                'type' => 'Vios',
                'name' => 'Vios',
                'brandname' => 'Vios',
                'key' => 'vios',
            ],
            [
                'type' => 'ATMPC',
                'name' => 'ATMPC',
                'brandname' => 'ATMPC',
                'key' => 'atmpc',
            ],
            [
                'type' => 'Benco',
                'name' => 'Benco',
                'brandname' => 'Benco',
                'key' => 'benco',
            ],
            [
                'type' => 'Safaricom',
                'name' => 'Safaricom',
                'brandname' => 'Safaricom',
                'key' => 'safaricom',
            ],
            [
                'type' => 'Yumkem',
                'name' => 'Yumkem',
                'brandname' => 'Yumkem',
                'key' => 'yumkem',
            ],
            [
                'type' => 'Bookry',
                'name' => 'Bookry Ltd.',
                'brandname' => 'Bookry',
                'key' => 'bookry',
            ],
            [
                'type' => 'tbucci',
                'name' => 'tbucci',
                'brandname' => 'tbucci',
                'key' => 'tbucci',
            ],
            [
                'type' => 'Gener8',
                'name' => 'Gener8',
                'brandname' => 'Gener8',
                'key' => 'gener8',
            ],
            [
                'type' => 'OMIX',
                'name' => 'OMIX',
                'brandname' => 'OMIX',
                'key' => 'omix',
            ],
            [
                'type' => 'Yestel',
                'name' => 'Yestel',
                'brandname' => 'Yestel',
                'key' => 'yestel',
            ],
            [
                'type' => 'Duoqin',
                'name' => 'Duoqin',
                'brandname' => 'Duoqin',
                'key' => 'duoqin',
            ],
            [
                'type' => 'Vocal',
                'name' => 'Vocal',
                'brandname' => 'Vocal',
                'key' => 'vocal',
            ],
            [
                'type' => 'Oscal',
                'name' => 'Oscal',
                'brandname' => 'Oscal',
                'key' => 'oscal',
            ],
            [
                'type' => 'Vitumi',
                'name' => 'Vitumi',
                'brandname' => 'Vitumi',
                'key' => 'vitumi',
            ],
            [
                'type' => 'iiiF150',
                'name' => 'SHENZHEN OXO Technology Co., Ltd.',
                'brandname' => 'iiiF150',
                'key' => 'iiif150',
            ],
            [
                'type' => 'Searchcraft',
                'name' => 'Searchcraft Inc.',
                'brandname' => 'Searchcraft',
                'key' => 'searchcraft',
            ],
            [
                'type' => 'DxDcS',
                'name' => 'DxDcS',
                'brandname' => 'DxDcS',
                'key' => 'dxdcs',
            ],
            [
                'type' => 'Databite',
                'name' => 'Databite',
                'brandname' => 'Databite',
                'key' => 'databite',
            ],
            [
                'type' => 'Senuto',
                'name' => 'Senuto Sp. z o.o.',
                'brandname' => 'Senuto',
                'key' => 'senuto',
            ],
            [
                'type' => 'Acquia',
                'name' => 'Acquia, Inc.',
                'brandname' => 'Acquia',
                'key' => 'acquia',
            ],
            [
                'type' => 'Criteo',
                'name' => 'Criteo',
                'brandname' => 'Criteo',
                'key' => 'criteo',
            ],
            [
                'type' => 'Nubia',
                'name' => 'Nubia',
                'brandname' => 'Nubia',
                'key' => 'nubia',
            ],
            [
                'type' => 'Bigme',
                'name' => 'Bigme',
                'brandname' => 'Bigme',
                'key' => 'bigme',
            ],
            [
                'type' => 'Netflix',
                'name' => 'Netflix, Inc.',
                'brandname' => 'Netflix',
                'key' => 'netflix',
            ],
            [
                'type' => 'Waze',
                'name' => 'Waze',
                'brandname' => 'Waze',
                'key' => 'waze',
            ],
            [
                'type' => 'QJY',
                'name' => 'QJY',
                'brandname' => 'QJY',
                'key' => 'qjy',
            ],
            [
                'type' => 'MeanIT',
                'name' => 'MeanIT',
                'brandname' => 'MeanIT',
                'key' => 'meanit',
            ],
            [
                'type' => 'Yezz',
                'name' => 'Yezz',
                'brandname' => 'Yezz',
                'key' => 'yezz',
            ],
            [
                'type' => 'BYJUS',
                'name' => 'BYJUS',
                'brandname' => 'BYJUS',
                'key' => 'byjus',
            ],
            [
                'type' => 'Joyar',
                'name' => 'Joyar',
                'brandname' => 'Joyar',
                'key' => 'joyar',
            ],
            [
                'type' => 'Kalley',
                'name' => 'Kalley',
                'brandname' => 'Kalley',
                'key' => 'kalley',
            ],
            [
                'type' => 'Ceibal',
                'name' => 'Ceibal',
                'brandname' => 'Ceibal',
                'key' => 'ceibal',
            ],
            [
                'type' => 'Foxxd',
                'name' => 'Foxxd',
                'brandname' => 'Foxxd',
                'key' => 'foxxd',
            ],
            [
                'type' => 'Vankyo',
                'name' => 'Vankyo',
                'brandname' => 'Vankyo',
                'key' => 'vankyo',
            ],
            [
                'type' => 'AEEZO',
                'name' => 'AEEZO',
                'brandname' => 'AEEZO',
                'key' => 'aeezo',
            ],
            [
                'type' => 'DNA',
                'name' => 'DNA Oyj',
                'brandname' => 'DNA',
                'key' => 'dna',
            ],
            [
                'type' => 'ITECH',
                'name' => 'ITECH SLU',
                'brandname' => 'ITECH',
                'key' => 'itech',
            ],
            [
                'type' => 'Nexech',
                'name' => 'Nexech',
                'brandname' => 'Nexech',
                'key' => 'nexech',
            ],
            [
                'type' => '1 & 1',
                'name' => '1 & 1',
                'brandname' => '1 & 1',
                'key' => 'einsundeins',
            ],
            [
                'type' => 'Corn',
                'name' => 'Corn',
                'brandname' => 'Corn',
                'key' => 'corn',
            ],
            [
                'type' => 'Logic',
                'name' => 'Logic',
                'brandname' => 'Logic',
                'key' => 'logic',
            ],
            [
                'type' => 'Hammer',
                'name' => 'Hammer',
                'brandname' => 'Hammer',
                'key' => 'hammer',
            ],
            [
                'type' => 'RunGee',
                'name' => 'RunGee',
                'brandname' => 'RunGee',
                'key' => 'rungee',
            ],
            [
                'type' => 'BMAX',
                'name' => 'BMAX',
                'brandname' => 'BMAX',
                'key' => 'bmax',
            ],
            [
                'type' => 'Jambo',
                'name' => 'JamboTechnology Hakuna Matata Chill Limited',
                'brandname' => 'Jambo',
                'key' => 'jambo',
            ],
            [
                'type' => 'Fanvace',
                'name' => 'Fanvace',
                'brandname' => 'Fanvace',
                'key' => 'fanvace',
            ],
            [
                'type' => 'Rombica',
                'name' => 'Rombica',
                'brandname' => 'Rombica',
                'key' => 'rombica',
            ],
            [
                'type' => 'Novis',
                'name' => 'Novis',
                'brandname' => 'Novis',
                'key' => 'novis',
            ],
            [
                'type' => 'Pritom',
                'name' => 'Pritom',
                'brandname' => 'Pritom',
                'key' => 'pritom',
            ],
            [
                'type' => 'Pixus',
                'name' => 'Pixus',
                'brandname' => 'Pixus',
                'key' => 'pixus',
            ],
            [
                'type' => 'Tibuta',
                'name' => 'Tibuta',
                'brandname' => 'Tibuta',
                'key' => 'tibuta',
            ],
            [
                'type' => 'Daria',
                'name' => 'Daria',
                'brandname' => 'Daria',
                'key' => 'daria',
            ],
            [
                'type' => 'Dijitsu',
                'name' => 'Dijitsu',
                'brandname' => 'Dijitsu',
                'key' => 'dijitsu',
            ],
        ];
    }

    /**
     * tests the constructor and the getter
     *
     * @throws UnexpectedValueException
     * @throws ExpectationFailedException
     */
    #[DataProvider('providerFallback')]
    public function testFallbackType(
        string $fallback,
        string | null $name,
        string | null $brandname,
        string $key,
    ): void {
        $result = Company::fromName($fallback);

        self::assertSame($name, $result->getName());
        self::assertSame($brandname, $result->getBrandname());
        self::assertSame($key, $result->getKey());
    }

    /**
     * @return array<int, array{fallback: string, name: string|null, brandname: string|null, key: string}>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerFallback(): array
    {
        return [
            [
                'fallback' => 'wish-tel',
                'name' => 'Wishtel Private Limited',
                'brandname' => 'Wishtel',
                'key' => 'wish-tel',
            ],
            [
                'fallback' => 'Wishtel Private Limited',
                'name' => 'Wishtel Private Limited',
                'brandname' => 'Wishtel',
                'key' => 'wish-tel',
            ],
            [
                'fallback' => 'Meta Inc',
                'name' => 'Meta Inc',
                'brandname' => 'Meta',
                'key' => 'meta',
            ],
            [
                'fallback' => 'opelmobile',
                'name' => 'Opel Mobile',
                'brandname' => 'Opel Mobile',
                'key' => 'opel-mobile',
            ],
            [
                'fallback' => 'opel-mobile',
                'name' => 'Opel Mobile',
                'brandname' => 'Opel Mobile',
                'key' => 'opel-mobile',
            ],
            [
                'fallback' => 'okapimobile',
                'name' => 'Okapi Mobile',
                'brandname' => 'Okapi Mobile',
                'key' => 'okapi-mobile',
            ],
            [
                'fallback' => 'okapi-mobile',
                'name' => 'Okapi Mobile',
                'brandname' => 'Okapi Mobile',
                'key' => 'okapi-mobile',
            ],
            [
                'fallback' => 'Google Inc.',
                'name' => 'Google Inc.',
                'brandname' => 'Google',
                'key' => 'google',
            ],
            [
                'fallback' => 'Apple Inc',
                'name' => 'Apple Inc',
                'brandname' => 'Apple',
                'key' => 'apple',
            ],
            [
                'fallback' => 'Microsoft Corporation',
                'name' => 'Microsoft Corporation',
                'brandname' => 'Microsoft',
                'key' => 'microsoft',
            ],
            [
                'fallback' => 'Talisman Brands, Inc. d/b/a Established',
                'name' => 'Talisman Brands, Inc. d/b/a Established',
                'brandname' => 'Nordmende',
                'key' => 'nordmende',
            ],
            [
                'fallback' => 'Bookry Ltd.',
                'name' => 'Bookry Ltd.',
                'brandname' => 'Bookry',
                'key' => 'bookry',
            ],
            [
                'fallback' => 'SHENZHEN OXO Technology Co., Ltd.',
                'name' => 'SHENZHEN OXO Technology Co., Ltd.',
                'brandname' => 'iiiF150',
                'key' => 'iiif150',
            ],
            [
                'fallback' => 'Searchcraft Inc.',
                'name' => 'Searchcraft Inc.',
                'brandname' => 'Searchcraft',
                'key' => 'searchcraft',
            ],
            [
                'fallback' => 'Senuto Sp. z o.o.',
                'name' => 'Senuto Sp. z o.o.',
                'brandname' => 'Senuto',
                'key' => 'senuto',
            ],
            [
                'fallback' => 'Acquia, Inc.',
                'name' => 'Acquia, Inc.',
                'brandname' => 'Acquia',
                'key' => 'acquia',
            ],
            [
                'fallback' => 'Netflix, Inc.',
                'name' => 'Netflix, Inc.',
                'brandname' => 'Netflix',
                'key' => 'netflix',
            ],
            [
                'fallback' => 'DNA Oyj',
                'name' => 'DNA Oyj',
                'brandname' => 'DNA',
                'key' => 'dna',
            ],
            [
                'fallback' => 'ITECH SLU',
                'name' => 'ITECH SLU',
                'brandname' => 'ITECH',
                'key' => 'itech',
            ],
            [
                'fallback' => 'einsundeins',
                'name' => '1 & 1',
                'brandname' => '1 & 1',
                'key' => 'einsundeins',
            ],
            [
                'fallback' => 'JamboTechnology Hakuna Matata Chill Limited',
                'name' => 'JamboTechnology Hakuna Matata Chill Limited',
                'brandname' => 'Jambo',
                'key' => 'jambo',
            ],
        ];
    }
}
