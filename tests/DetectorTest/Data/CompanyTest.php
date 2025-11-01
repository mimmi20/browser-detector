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

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
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
                'name' => 'Meta Platforms, Inc.',
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
            [
                'type' => 'WildRed',
                'name' => 'WildRed',
                'brandname' => 'WildRed',
                'key' => 'wildred',
            ],
            [
                'type' => 'Asano',
                'name' => 'Asano',
                'brandname' => 'Asano',
                'key' => 'asano',
            ],
            [
                'type' => 'Hi',
                'name' => 'Hi',
                'brandname' => 'Hi',
                'key' => 'hi',
            ],
            [
                'type' => 'Scoole',
                'name' => 'Scoole',
                'brandname' => 'Scoole',
                'key' => 'scoole',
            ],
            [
                'type' => 'Soundmax',
                'name' => 'Soundmax',
                'brandname' => 'Soundmax',
                'key' => 'soundmax',
            ],
            [
                'type' => 'TopDevice',
                'name' => 'TopDevice',
                'brandname' => 'TopDevice',
                'key' => 'top-device',
            ],
            [
                'type' => 'Bigben',
                'name' => 'Bigben Interactive',
                'brandname' => 'Bigben',
                'key' => 'bigben',
            ],
            [
                'type' => 'Krono',
                'name' => 'Krono',
                'brandname' => 'Krono',
                'key' => 'krono',
            ],
            [
                'type' => 'Calme',
                'name' => 'Calme',
                'brandname' => 'Calme',
                'key' => 'calme',
            ],
            [
                'type' => 'XB',
                'name' => 'XB',
                'brandname' => 'XB',
                'key' => 'xb',
            ],
            [
                'type' => 'Ziovo',
                'name' => 'Ziovo',
                'brandname' => 'Ziovo',
                'key' => 'ziovo',
            ],
            [
                'type' => 'iHunt',
                'name' => 'iHunt',
                'brandname' => 'iHunt',
                'key' => 'ihunt',
            ],
            [
                'type' => 'Emporia',
                'name' => 'Emporia Telecom GmbH & Co. KG',
                'brandname' => 'Emporia',
                'key' => 'emporia',
            ],
            [
                'type' => 'MicroEra',
                'name' => 'MicroEra',
                'brandname' => 'MicroEra',
                'key' => 'microera',
            ],
            [
                'type' => 'Zebra',
                'name' => 'Zebra Technologies Corp.',
                'brandname' => 'Zebra',
                'key' => 'zebra',
            ],
            [
                'type' => 'Sonim',
                'name' => 'Sonim',
                'brandname' => 'Sonim',
                'key' => 'sonim',
            ],
            [
                'type' => 'XSmart',
                'name' => 'XSmart',
                'brandname' => 'XSmart',
                'key' => 'x-smart',
            ],
            [
                'type' => 'Moondrop',
                'name' => 'Chengdu Shuiyueyu Technology Co., Ltd.',
                'brandname' => 'Moondrop',
                'key' => 'moondrop',
            ],
            [
                'type' => 'Maxwest',
                'name' => 'Maxwest',
                'brandname' => 'Maxwest',
                'key' => 'maxwest',
            ],
            [
                'type' => 'F+',
                'name' => 'F+',
                'brandname' => 'F+',
                'key' => 'f-plus',
            ],
            [
                'type' => 'Energizer',
                'name' => 'Energizer',
                'brandname' => 'Energizer',
                'key' => 'energizer',
            ],
            [
                'type' => 'AYYA',
                'name' => 'AYYA',
                'brandname' => 'AYYA',
                'key' => 'ayya',
            ],
            [
                'type' => 'XREAL',
                'name' => 'XREAL',
                'brandname' => 'XREAL',
                'key' => 'xreal',
            ],
            [
                'type' => 'Wainyok',
                'name' => 'Wainyok',
                'brandname' => 'Wainyok',
                'key' => 'wainyok',
            ],
            [
                'type' => 'Hot Pepper',
                'name' => 'Hot Pepper Mobile, Inc.',
                'brandname' => 'Hot Pepper',
                'key' => 'hot-pepper',
            ],
            [
                'type' => 'EagleSoar',
                'name' => 'EagleSoar',
                'brandname' => 'EagleSoar',
                'key' => 'eagle-soar',
            ],
            [
                'type' => 'Blow',
                'name' => 'Blow',
                'brandname' => 'Blow',
                'key' => 'blow',
            ],
            [
                'type' => 'Cepter',
                'name' => 'Cepter',
                'brandname' => 'Cepter',
                'key' => 'cepter',
            ],
            [
                'type' => 'Clovertek',
                'name' => 'Clovertek',
                'brandname' => 'Clovertek',
                'key' => 'clovertek',
            ],
            [
                'type' => 'Visual Land',
                'name' => 'Visual Land',
                'brandname' => 'Visual Land',
                'key' => 'visual-land',
            ],
            [
                'type' => 'Padpro',
                'name' => 'Padpro',
                'brandname' => 'Padpro',
                'key' => 'padpro',
            ],
            [
                'type' => 'Inoi',
                'name' => 'Inoi',
                'brandname' => 'Inoi',
                'key' => 'inoi',
            ],
            [
                'type' => 'Jumper',
                'name' => 'Jumper',
                'brandname' => 'Jumper',
                'key' => 'jumper',
            ],
            [
                'type' => 'Flycoay',
                'name' => 'Flycoay',
                'brandname' => 'Flycoay',
                'key' => 'flycoay',
            ],
            [
                'type' => 'MAGCH',
                'name' => 'MAGCH',
                'brandname' => 'MAGCH',
                'key' => 'magch',
            ],
            [
                'type' => 'Oangcc',
                'name' => 'Oangcc',
                'brandname' => 'Oangcc',
                'key' => 'oangcc',
            ],
            [
                'type' => 'AOCWEI',
                'name' => 'AOCWEI',
                'brandname' => 'AOCWEI',
                'key' => 'aocwei',
            ],
            [
                'type' => 'AAUW',
                'name' => 'AAUW',
                'brandname' => 'AAUW',
                'key' => 'aauw',
            ],
            [
                'type' => 'Vale',
                'name' => 'Vale',
                'brandname' => 'Vale',
                'key' => 'vale',
            ],
            [
                'type' => 'Relndoo',
                'name' => 'Relndoo',
                'brandname' => 'Relndoo',
                'key' => 'relndoo',
            ],
            [
                'type' => 'HeadWolf',
                'name' => 'HeadWolf',
                'brandname' => 'HeadWolf',
                'key' => 'head-wolf',
            ],
            [
                'type' => 'Hezire',
                'name' => 'Hezire',
                'brandname' => 'Hezire',
                'key' => 'hezire',
            ],
            [
                'type' => 'Weelikeit',
                'name' => 'Weelikeit',
                'brandname' => 'Weelikeit',
                'key' => 'weelikeit',
            ],
            [
                'type' => 'Meswao',
                'name' => 'Meswao',
                'brandname' => 'Meswao',
                'key' => 'meswao',
            ],
            [
                'type' => 'Colorroom',
                'name' => 'Colorroom',
                'brandname' => 'Colorroom',
                'key' => 'colorroom',
            ],
            [
                'type' => 'Erisson',
                'name' => 'Erisson',
                'brandname' => 'Erisson',
                'key' => 'erisson',
            ],
            [
                'type' => 'Vision',
                'name' => 'Vision Technology',
                'brandname' => 'Vision',
                'key' => 'vision-technology',
            ],
            [
                'type' => 'HONKUAHG',
                'name' => 'HONKUAHG',
                'brandname' => 'HONKUAHG',
                'key' => 'honkuahg',
            ],
            [
                'type' => 'Egotek',
                'name' => 'Egotek',
                'brandname' => 'Egotek',
                'key' => 'egotek',
            ],
            [
                'type' => 'ZZB',
                'name' => 'ZZB',
                'brandname' => 'ZZB',
                'key' => 'zzb',
            ],
            [
                'type' => 'NEWAL',
                'name' => 'NEWAL',
                'brandname' => 'NEWAL',
                'key' => 'newal',
            ],
            [
                'type' => 'Sber',
                'name' => 'Sber',
                'brandname' => 'Sber',
                'key' => 'sber',
            ],
            [
                'type' => 'Senna',
                'name' => 'Senna',
                'brandname' => 'Senna',
                'key' => 'senna',
            ],
            [
                'type' => 'TrecFone',
                'name' => 'TrecFone',
                'brandname' => 'TrecFone',
                'key' => 'trecfone',
            ],
            [
                'type' => 'The Browser Company',
                'name' => 'The Browser Company of New York',
                'brandname' => 'The Browser Company',
                'key' => 'the-browser-company',
            ],
            [
                'type' => 'Readdle',
                'name' => 'Readdle',
                'brandname' => 'Readdle',
                'key' => 'readdle',
            ],
            [
                'type' => 'eightloops',
                'name' => 'eightloops GmbH',
                'brandname' => 'eightloops',
                'key' => 'eightloops',
            ],
            [
                'type' => 'Listia',
                'name' => 'Listia Inc.',
                'brandname' => 'Listia',
                'key' => 'listia',
            ],
            [
                'type' => 'Ecosia',
                'name' => 'Ecosia GmbH',
                'brandname' => 'Ecosia',
                'key' => 'ecosia',
            ],
            [
                'type' => 'NHN',
                'name' => 'NHN Corporation',
                'brandname' => 'NHN',
                'key' => 'nhn-corporation',
            ],
            [
                'type' => 'Duck Duck Go',
                'name' => 'Duck Duck Go Inc.',
                'brandname' => 'Duck Duck Go',
                'key' => 'duck-duck-go',
            ],
            [
                'type' => 'Keeper Security',
                'name' => 'Keeper Security, Inc.',
                'brandname' => 'Keeper Security',
                'key' => 'keeper',
            ],
            [
                'type' => 'Lamantine Software',
                'name' => 'Lamantine Software',
                'brandname' => 'Lamantine Software',
                'key' => 'lamantine-software',
            ],
            [
                'type' => 'Opera',
                'name' => 'Opera Software ASA',
                'brandname' => 'Opera',
                'key' => 'opera',
            ],
            [
                'type' => 'Asus',
                'name' => 'ASUSTeK Computer Inc.',
                'brandname' => 'Asus',
                'key' => 'asus',
            ],
            [
                'type' => 'BBK',
                'name' => 'BBK Electronics Corp Ltd',
                'brandname' => 'BBK',
                'key' => 'bbk',
            ],
            [
                'type' => 'OPPO',
                'name' => 'OPPO Electronics Corp.',
                'brandname' => 'OPPO',
                'key' => 'oppo',
            ],
            [
                'type' => 'Realme',
                'name' => 'Realme',
                'brandname' => 'Realme',
                'key' => 'realme',
            ],
            [
                'type' => 'vivo',
                'name' => 'Vivo Electronics Corp.',
                'brandname' => 'vivo',
                'key' => 'vivo',
            ],
            [
                'type' => 'OnePlus',
                'name' => 'Shenzhen OnePlus Science & Technology Co., Ltd.',
                'brandname' => 'OnePlus',
                'key' => 'oneplus',
            ],
            [
                'type' => 'Huawei',
                'name' => 'Huawei',
                'brandname' => 'Huawei',
                'key' => 'huawei',
            ],
            [
                'type' => 'Xiaomi',
                'name' => 'Xiaomi Tech',
                'brandname' => 'Xiaomi',
                'key' => 'xiaomi',
            ],
            [
                'type' => 'Yandex',
                'name' => 'Yandex LLC',
                'brandname' => 'Yandex',
                'key' => 'yandex',
            ],
            [
                'type' => 'Yahoo',
                'name' => 'Yahoo! Inc.',
                'brandname' => 'Yahoo',
                'key' => 'yahoo',
            ],
            [
                'type' => 'WordPress',
                'name' => 'wordpress.org',
                'brandname' => 'WordPress',
                'key' => 'wordpress',
            ],
            [
                'type' => 'Zoom',
                'name' => 'Zoom Communications Inc.',
                'brandname' => 'Zoom',
                'key' => 'zoom',
            ],
            [
                'type' => 'QWANT',
                'name' => 'QWANT SAS',
                'brandname' => 'QWANT',
                'key' => 'qwant',
            ],
            [
                'type' => 'Qiuwoky',
                'name' => 'Qiuwoky',
                'brandname' => 'Qiuwoky',
                'key' => 'qiuwoky',
            ],
            [
                'type' => 'V7',
                'name' => 'V7 Devices',
                'brandname' => 'V7',
                'key' => 'v7',
            ],
            [
                'type' => 'ApoloSign',
                'name' => 'ApoloSign',
                'brandname' => 'ApoloSign',
                'key' => 'apolo-sign',
            ],
            [
                'type' => 'Multilaser',
                'name' => 'Multilaser',
                'brandname' => 'Multilaser',
                'key' => 'multilaser',
            ],
            [
                'type' => 'Premier',
                'name' => 'Premier',
                'brandname' => 'Premier',
                'key' => 'premier',
            ],
            [
                'type' => 'Volla',
                'name' => 'Volla Systeme GmbH',
                'brandname' => 'Volla',
                'key' => 'volla',
            ],
            [
                'type' => 'Nesons',
                'name' => 'Nesons',
                'brandname' => 'Nesons',
                'key' => 'nesons',
            ],
            [
                'type' => 'Openbox',
                'name' => 'Openbox',
                'brandname' => 'Openbox',
                'key' => 'openbox',
            ],
            [
                'type' => 'Mortal',
                'name' => 'Mortal',
                'brandname' => 'Mortal',
                'key' => 'mortal',
            ],
            [
                'type' => 'HOMII',
                'name' => 'HOMII',
                'brandname' => 'HOMII',
                'key' => 'homii',
            ],
            [
                'type' => 'Andersson',
                'name' => 'Andersson',
                'brandname' => 'Andersson',
                'key' => 'andersson',
            ],
            [
                'type' => 'Whoop',
                'name' => 'Whoop',
                'brandname' => 'Whoop',
                'key' => 'whoop',
            ],
            [
                'type' => 'Hanson',
                'name' => 'Hanson',
                'brandname' => 'Hanson',
                'key' => 'hanson',
            ],
            [
                'type' => 'Cloud Mobile',
                'name' => 'Cloud Mobile',
                'brandname' => 'Cloud Mobile',
                'key' => 'cloud-mobile',
            ],
            [
                'type' => 'iData',
                'name' => 'iData',
                'brandname' => 'iData',
                'key' => 'idata',
            ],
            [
                'type' => 'Anbernic',
                'name' => 'Anbernic',
                'brandname' => 'Anbernic',
                'key' => 'anbernic',
            ],
            [
                'type' => 'Fontel',
                'name' => 'Fontel',
                'brandname' => 'Fontel',
                'key' => 'fontel',
            ],
            [
                'type' => 'Consung',
                'name' => 'Consung',
                'brandname' => 'Consung',
                'key' => 'consung',
            ],
            [
                'type' => 'Novey',
                'name' => 'Novey',
                'brandname' => 'Novey',
                'key' => 'novey',
            ],
            [
                'type' => 'Iiyama',
                'name' => 'Iiyama',
                'brandname' => 'Iiyama',
                'key' => 'iiyama',
            ],
            [
                'type' => 'jasmine tea',
                'name' => 'jasmine tea',
                'brandname' => 'jasmine tea',
                'key' => 'jasmine-tea',
            ],
            [
                'type' => 'SOWLY',
                'name' => 'SOWLY',
                'brandname' => 'SOWLY',
                'key' => 'sowly',
            ],
            [
                'type' => 'Mione',
                'name' => 'Mione',
                'brandname' => 'Mione',
                'key' => 'mione',
            ],
            [
                'type' => 'Pagraer',
                'name' => 'Pagraer',
                'brandname' => 'Pagraer',
                'key' => 'pagraer',
            ],
            [
                'type' => 'UnoPhone',
                'name' => 'UnoPhone',
                'brandname' => 'UnoPhone',
                'key' => 'uno-phone',
            ],
            [
                'type' => 'Grünberg',
                'name' => 'Grünberg',
                'brandname' => 'Grünberg',
                'key' => 'gruenberg',
            ],
            [
                'type' => 'Akai',
                'name' => 'Akai',
                'brandname' => 'Akai',
                'key' => 'akai',
            ],
            [
                'type' => 'Saba',
                'name' => 'Saba',
                'brandname' => 'Saba',
                'key' => 'saba',
            ],
            [
                'type' => 'Onyx Boox',
                'name' => 'Onyx Boox',
                'brandname' => 'Onyx Boox',
                'key' => 'onyx-boox',
            ],
            [
                'type' => 'Ghia',
                'name' => 'Ghia',
                'brandname' => 'Ghia',
                'key' => 'ghia',
            ],
            [
                'type' => 'Eudora',
                'name' => 'Eudora',
                'brandname' => 'Eudora',
                'key' => 'eudora',
            ],
            [
                'type' => 'CUIUD',
                'name' => 'CUIUD',
                'brandname' => 'CUIUD',
                'key' => 'cuiud',
            ],
            [
                'type' => 'Biegedy',
                'name' => 'Biegedy',
                'brandname' => 'Biegedy',
                'key' => 'biegedy',
            ],
            [
                'type' => 'Grundig',
                'name' => 'Grundig',
                'brandname' => 'Grundig',
                'key' => 'grundig',
            ],
            [
                'type' => 'DUDU AUTO',
                'name' => 'DUDU AUTO',
                'brandname' => 'DUDU AUTO',
                'key' => 'dudu-auto',
            ],
            [
                'type' => 'Vorcom',
                'name' => 'Vorcom',
                'brandname' => 'Vorcom',
                'key' => 'vorcom',
            ],
            [
                'type' => 'Hemilton',
                'name' => 'Hemilton',
                'brandname' => 'Hemilton',
                'key' => 'hemilton',
            ],
            [
                'type' => 'Saiet',
                'name' => 'Saiet',
                'brandname' => 'Saiet',
                'key' => 'saiet',
            ],
            [
                'type' => 'Syco',
                'name' => 'Syco',
                'brandname' => 'Syco',
                'key' => 'syco',
            ],
            [
                'type' => 'MobiWire',
                'name' => 'MobiWire',
                'brandname' => 'MobiWire',
                'key' => 'mobi-wire',
            ],
            [
                'type' => 'Hometech',
                'name' => 'Hometech',
                'brandname' => 'Hometech',
                'key' => 'hometech',
            ],
            [
                'type' => 'CMF',
                'name' => 'CMF',
                'brandname' => 'CMF',
                'key' => 'cmf',
            ],
            [
                'type' => 'Homatics',
                'name' => 'Homatics',
                'brandname' => 'Homatics',
                'key' => 'homatics',
            ],
            [
                'type' => 'KGTEL',
                'name' => 'KGTEL',
                'brandname' => 'KGTEL',
                'key' => 'kgtel',
            ],
            [
                'type' => 'Samsung',
                'name' => 'Samsung',
                'brandname' => 'Samsung',
                'key' => 'samsung',
            ],
            [
                'type' => 'Sony',
                'name' => 'Sony',
                'brandname' => 'Sony',
                'key' => 'sony',
            ],
            [
                'type' => 'Motorola',
                'name' => 'Motorola',
                'brandname' => 'Motorola',
                'key' => 'motorola',
            ],
            [
                'type' => 'Oukitel',
                'name' => 'Shenzhen Yunji Intelligent Technology Co,.Ltd.',
                'brandname' => 'Oukitel',
                'key' => 'oukitel',
            ],
            [
                'type' => 'Blackview',
                'name' => 'Blackview International Group',
                'brandname' => 'Blackview',
                'key' => 'blackview',
            ],
            [
                'type' => 'ZTE',
                'name' => 'ZTE',
                'brandname' => 'ZTE',
                'key' => 'zte',
            ],
            [
                'type' => 'Tecno',
                'name' => 'Tecno Mobile',
                'brandname' => 'Tecno',
                'key' => 'tecno',
            ],
            [
                'type' => 'Poco',
                'name' => 'Poco',
                'brandname' => 'Poco',
                'key' => 'poco',
            ],
            [
                'type' => 'Infinix',
                'name' => 'Infinix Inc.',
                'brandname' => 'Infinix',
                'key' => 'infinix',
            ],
            [
                'type' => 'Nothing',
                'name' => 'Nothing Technology Ltd',
                'brandname' => 'Nothing',
                'key' => 'nothing-phone',
            ],
            [
                'type' => 'T-Mobile',
                'name' => 'T-Mobile',
                'brandname' => 'T-Mobile',
                'key' => 't-mobile',
            ],
            [
                'type' => 'Doogee',
                'name' => 'Doogee',
                'brandname' => 'Doogee',
                'key' => 'doogee',
            ],
            [
                'type' => 'Vortex',
                'name' => 'Vortex',
                'brandname' => 'Vortex',
                'key' => 'vortex',
            ],
            [
                'type' => 'Lenovo',
                'name' => 'Lenovo',
                'brandname' => 'Lenovo',
                'key' => 'lenovo',
            ],
            [
                'type' => 'iTel',
                'name' => 'iTel Mobile',
                'brandname' => 'iTel',
                'key' => 'itel',
            ],
            [
                'type' => 'UMIDIGI',
                'name' => 'UMIDIGI',
                'brandname' => 'UMIDIGI',
                'key' => 'umi',
            ],
            [
                'type' => 'Cubot',
                'name' => 'Cubot',
                'brandname' => 'Cubot',
                'key' => 'cubot',
            ],
            [
                'type' => 'Unihertz',
                'name' => 'Unihertz',
                'brandname' => 'Unihertz',
                'key' => 'unihertz',
            ],
            [
                'type' => 'AllWinner',
                'name' => 'AllWinner',
                'brandname' => 'AllWinner',
                'key' => 'allwinner',
            ],
            [
                'type' => 'DEXP',
                'name' => 'DEXP',
                'brandname' => 'DEXP',
                'key' => 'dexp',
            ],
            [
                'type' => 'Onvo',
                'name' => 'Onvo',
                'brandname' => 'Onvo',
                'key' => 'onvo',
            ],
            [
                'type' => 'AGM',
                'name' => 'AGM',
                'brandname' => 'AGM',
                'key' => 'agm',
            ],
            [
                'type' => 'Digma',
                'name' => 'Digma',
                'brandname' => 'Digma',
                'key' => 'digma',
            ],
            [
                'type' => 'Teclast',
                'name' => 'Teclast',
                'brandname' => 'Teclast',
                'key' => 'teclast',
            ],
            [
                'type' => 'Onn',
                'name' => 'Onn',
                'brandname' => 'Onn',
                'key' => 'onn',
            ],
            [
                'type' => 'Zuum',
                'name' => 'Zuum',
                'brandname' => 'Zuum',
                'key' => 'zuum',
            ],
            [
                'type' => 'Amazon',
                'name' => 'Amazon.com, Inc.',
                'brandname' => 'Amazon',
                'key' => 'amazon',
            ],
            [
                'type' => 'Alldocube',
                'name' => 'Alldocube',
                'brandname' => 'Alldocube',
                'key' => 'alldocube',
            ],
            [
                'type' => 'Hotwav',
                'name' => 'Hotwav',
                'brandname' => 'Hotwav',
                'key' => 'hotwav',
            ],
            [
                'type' => 'Fujitsu',
                'name' => 'Fujitsu',
                'brandname' => 'Fujitsu',
                'key' => 'fujitsu',
            ],
            [
                'type' => 'Meizu',
                'name' => 'Meizu Technology Co., Ltd.',
                'brandname' => 'Meizu',
                'key' => 'meizu',
            ],
            [
                'type' => 'Casper',
                'name' => 'Casper',
                'brandname' => 'Casper',
                'key' => 'casper',
            ],
            [
                'type' => 'Ulefone',
                'name' => 'Ulefone Technology Co., Ltd.',
                'brandname' => 'Ulefone',
                'key' => 'ulefone',
            ],
            [
                'type' => 'HMD Global',
                'name' => 'HMD Global Oy',
                'brandname' => 'HMD Global',
                'key' => 'hmd-global',
            ],
            [
                'type' => 'LT Mobile',
                'name' => 'LT Mobile',
                'brandname' => 'LT Mobile',
                'key' => 'lt-mobile',
            ],
            [
                'type' => 'AT&T',
                'name' => 'AT&T',
                'brandname' => 'AT&T',
                'key' => 'at-t',
            ],
            [
                'type' => 'Nokia',
                'name' => 'Nokia',
                'brandname' => 'Nokia',
                'key' => 'nokia',
            ],
            [
                'type' => 'Reeder',
                'name' => 'Reeder',
                'brandname' => 'Reeder',
                'key' => 'reeder',
            ],
            [
                'type' => 'FOSSiBOT',
                'name' => 'FOSSiBOT',
                'brandname' => 'FOSSiBOT',
                'key' => 'fossi-bot',
            ],
            [
                'type' => 'Sharp',
                'name' => 'Sharp Corporation',
                'brandname' => 'Sharp',
                'key' => 'sharp',
            ],
            [
                'type' => 'Cricket',
                'name' => 'Cricket',
                'brandname' => 'Cricket',
                'key' => 'cricket',
            ],
            [
                'type' => 'BLU',
                'name' => 'BLU',
                'brandname' => 'BLU',
                'key' => 'blu',
            ],
            [
                'type' => 'GlobalSec',
                'name' => 'GlobalSec',
                'brandname' => 'GlobalSec',
                'key' => 'global-sec',
            ],
            [
                'type' => 'Krüger&Matz',
                'name' => 'Krüger&Matz',
                'brandname' => 'Krüger&Matz',
                'key' => 'kruger-matz',
            ],
            [
                'type' => 'Kyocera',
                'name' => 'Kyocera',
                'brandname' => 'Kyocera',
                'key' => 'kyocera',
            ],
            [
                'type' => 'Acer',
                'name' => 'Acer',
                'brandname' => 'Acer',
                'key' => 'acer',
            ],
            [
                'type' => 'Gigaset',
                'name' => 'Gigaset Communications GmbH',
                'brandname' => 'Gigaset',
                'key' => 'gigaset',
            ],
            [
                'type' => 'TCL',
                'name' => 'TCL Communication Ltd.',
                'brandname' => 'TCL',
                'key' => 'tcl',
            ],
            [
                'type' => 'N-One',
                'name' => 'N-One',
                'brandname' => 'N-One',
                'key' => 'n-one',
            ],
            [
                'type' => 'BQ',
                'name' => 'BQ',
                'brandname' => 'BQ',
                'key' => 'bq',
            ],
            [
                'type' => 'Logicom',
                'name' => 'Logicom',
                'brandname' => 'Logicom',
                'key' => 'logicom',
            ],
            [
                'type' => 'Walton',
                'name' => 'Walton Hi-Tech Industries Ltd.',
                'brandname' => 'Walton',
                'key' => 'walton',
            ],
            [
                'type' => 'HTC',
                'name' => 'HTC',
                'brandname' => 'HTC',
                'key' => 'htc',
            ],
            [
                'type' => 'M-HORSE',
                'name' => 'M-HORSE',
                'brandname' => 'M-HORSE',
                'key' => 'm-horse',
            ],
            [
                'type' => 'General Mobile',
                'name' => 'General Mobile',
                'brandname' => 'General Mobile',
                'key' => 'general-mobile',
            ],
            [
                'type' => 'Condor',
                'name' => 'Condor',
                'brandname' => 'Condor',
                'key' => 'condor',
            ],
            [
                'type' => 'Fairphone',
                'name' => 'Fairphone',
                'brandname' => 'Fairphone',
                'key' => 'fairphone',
            ],
            [
                'type' => 'Mobvoi',
                'name' => 'Mobvoi',
                'brandname' => 'Mobvoi',
                'key' => 'mobvoi',
            ],
            [
                'type' => 'iGET',
                'name' => 'iGET',
                'brandname' => 'iGET',
                'key' => 'iget',
            ],
            [
                'type' => 'Xgody',
                'name' => 'Xgody',
                'brandname' => 'Xgody',
                'key' => 'xgody',
            ],
            [
                'type' => 'AllCall',
                'name' => 'AllCall',
                'brandname' => 'AllCall',
                'key' => 'allcall',
            ],
            [
                'type' => 'VGO Tel',
                'name' => 'VGO Tel',
                'brandname' => 'VGO Tel',
                'key' => 'vgo-tel',
            ],
            [
                'type' => 'LG',
                'name' => 'LG',
                'brandname' => 'LG',
                'key' => 'lg',
            ],
            [
                'type' => 'Aligator',
                'name' => 'Aligator',
                'brandname' => 'Aligator',
                'key' => 'aligator',
            ],
            [
                'type' => 'Retroid Pocket',
                'name' => 'Retroid Pocket',
                'brandname' => 'Retroid Pocket',
                'key' => 'retroid-pocket',
            ],
            [
                'type' => 'X-View',
                'name' => 'X-View',
                'brandname' => 'X-View',
                'key' => 'x-view',
            ],
            [
                'type' => 'PEAQ',
                'name' => 'PEAQ',
                'brandname' => 'PEAQ',
                'key' => 'peaq',
            ],
            [
                'type' => 'Lava',
                'name' => 'Lava',
                'brandname' => 'Lava',
                'key' => 'lava',
            ],
            [
                'type' => 'Hafury',
                'name' => 'Hafury',
                'brandname' => 'Hafury',
                'key' => 'hafury',
            ],
            [
                'type' => 'Coolpad',
                'name' => 'Coolpad',
                'brandname' => 'Coolpad',
                'key' => 'coolpad',
            ],
            [
                'type' => 'Uhans',
                'name' => 'Uhans',
                'brandname' => 'Uhans',
                'key' => 'uhans',
            ],
            [
                'type' => 'TOSCiDO',
                'name' => 'TOSCiDO',
                'brandname' => 'TOSCiDO',
                'key' => 'toscido',
            ],
            [
                'type' => 'Sky',
                'name' => 'Sky',
                'brandname' => 'Sky',
                'key' => 'sky',
            ],
            [
                'type' => 'Wileyfox',
                'name' => 'Wileyfox',
                'brandname' => 'Wileyfox',
                'key' => 'wileyfox',
            ],
            [
                'type' => 'Oysters',
                'name' => 'Oysters',
                'brandname' => 'Oysters',
                'key' => 'oysters',
            ],
            [
                'type' => 'BlackBerry',
                'name' => 'BlackBerry Limited',
                'brandname' => 'BlackBerry',
                'key' => 'black-berry',
            ],
            [
                'type' => 'Vertu',
                'name' => 'Vertu',
                'brandname' => 'Vertu',
                'key' => 'vertu',
            ],
            [
                'type' => 'Ugoos',
                'name' => 'Ugoos',
                'brandname' => 'Ugoos',
                'key' => 'ugoos',
            ],
            [
                'type' => 'Chuwi',
                'name' => 'CHUWI Inc',
                'brandname' => 'Chuwi',
                'key' => 'chuwi',
            ],
            [
                'type' => 'Boost Mobile',
                'name' => 'Boost Mobile',
                'brandname' => 'Boost Mobile',
                'key' => 'boost-mobile',
            ],
            [
                'type' => 'Ace',
                'name' => 'Ace',
                'brandname' => 'Ace',
                'key' => 'ace',
            ],
            [
                'type' => 'GFive',
                'name' => 'GFive',
                'brandname' => 'GFive',
                'key' => 'gfive',
            ],
            [
                'type' => 'Mediacom',
                'name' => 'Mediacom',
                'brandname' => 'Mediacom',
                'key' => 'mediacom',
            ],
            [
                'type' => 'Cat',
                'name' => 'S4 Handelsgruppe GmbH',
                'brandname' => 'Cat',
                'key' => 'catsound',
            ],
            [
                'type' => 'Micromax',
                'name' => 'Micromax Informatics Ltd.',
                'brandname' => 'Micromax',
                'key' => 'micromax',
            ],
            [
                'type' => 'Symphony',
                'name' => 'Symphony',
                'brandname' => 'Symphony',
                'key' => 'symphony',
            ],
            [
                'type' => 'Archos',
                'name' => 'Archos S.A.',
                'brandname' => 'Archos',
                'key' => 'archos',
            ],
            [
                'type' => 'Haier',
                'name' => 'Haier',
                'brandname' => 'Haier',
                'key' => 'haier',
            ],
            [
                'type' => 'NEC',
                'name' => 'NEC',
                'brandname' => 'NEC',
                'key' => 'nec',
            ],
            [
                'type' => 'Green Lion',
                'name' => 'Green Lion',
                'brandname' => 'Green Lion',
                'key' => 'green-lion',
            ],
            [
                'type' => 'Feonal',
                'name' => 'Feonal',
                'brandname' => 'Feonal',
                'key' => 'feonal',
            ],
            [
                'type' => 'Thomson',
                'name' => 'Thomson',
                'brandname' => 'Thomson',
                'key' => 'thomson',
            ],
            [
                'type' => 'Majestic',
                'name' => 'Majestic',
                'brandname' => 'Majestic',
                'key' => 'majestic',
            ],
            [
                'type' => 'Honor',
                'name' => 'Honor',
                'brandname' => 'Honor',
                'key' => 'honor',
            ],
            [
                'type' => 'Facetel',
                'name' => 'Facetel',
                'brandname' => 'Facetel',
                'key' => 'facetel',
            ],
            [
                'type' => 'Hoozo',
                'name' => 'Hoozo',
                'brandname' => 'Hoozo',
                'key' => 'hoozo',
            ],
            [
                'type' => 'NUU',
                'name' => 'NUU Mobile',
                'brandname' => 'NUU',
                'key' => 'nuu-mobile',
            ],
            [
                'type' => 'Maxcom',
                'name' => 'Maxcom',
                'brandname' => 'Maxcom',
                'key' => 'maxcom',
            ],
            [
                'type' => 'Mobicel',
                'name' => 'Mobicel',
                'brandname' => 'Mobicel',
                'key' => 'mobicel',
            ],
            [
                'type' => 'Droid Player',
                'name' => 'Droid Player',
                'brandname' => 'Droid Player',
                'key' => 'droid-player',
            ],
            [
                'type' => 'HiSense',
                'name' => 'HiSense Company Ltd.',
                'brandname' => 'HiSense',
                'key' => 'hisense',
            ],
            [
                'type' => 'Allview',
                'name' => 'Allview Electronics SP. Z O.O.',
                'brandname' => 'Allview',
                'key' => 'allview',
            ],
            [
                'type' => 'Rhino',
                'name' => 'Rhino',
                'brandname' => 'Rhino',
                'key' => 'rhino',
            ],
            [
                'type' => 'FreeYond',
                'name' => 'FreeYond',
                'brandname' => 'FreeYond',
                'key' => 'free-yond',
            ],
            [
                'type' => 'MeMobile',
                'name' => 'MeMobile',
                'brandname' => 'MeMobile',
                'key' => 'me-mobile',
            ],
            [
                'type' => 'X-Mobile',
                'name' => 'X-Mobile',
                'brandname' => 'X-Mobile',
                'key' => 'x-mobile',
            ],
            [
                'type' => 'Bmobile',
                'name' => 'Bmobile',
                'brandname' => 'Bmobile',
                'key' => 'bmobile',
            ],
            [
                'type' => 'Soho Style',
                'name' => 'Soho Style',
                'brandname' => 'Soho Style',
                'key' => 'soho-style',
            ],
            [
                'type' => 'Veidoo',
                'name' => 'Veidoo',
                'brandname' => 'Veidoo',
                'key' => 'veidoo',
            ],
            [
                'type' => 'CROSSCALL',
                'name' => 'CROSSCALL SAS',
                'brandname' => 'CROSSCALL',
                'key' => 'crosscall',
            ],
            [
                'type' => 'Maze Speed',
                'name' => 'Maze Speed',
                'brandname' => 'Maze Speed',
                'key' => 'maze-speed',
            ],
            [
                'type' => 'M-KOPA',
                'name' => 'M-KOPA',
                'brandname' => 'M-KOPA',
                'key' => 'm-kopa',
            ],
            [
                'type' => 'S-Color',
                'name' => 'S-Color',
                'brandname' => 'S-Color',
                'key' => 's-color',
            ],
            [
                'type' => 'HiGrace',
                'name' => 'HiGrace',
                'brandname' => 'HiGrace',
                'key' => 'hi-grace',
            ],
            [
                'type' => 'MyPhone',
                'name' => 'MyPhone',
                'brandname' => 'MyPhone',
                'key' => 'myphone',
            ],
            [
                'type' => 'Sigma Mobile',
                'name' => 'Sigma Mobile',
                'brandname' => 'Sigma Mobile',
                'key' => 'sigma-mobile',
            ],
            [
                'type' => 'GOODTEL',
                'name' => 'GOODTEL',
                'brandname' => 'GOODTEL',
                'key' => 'goodtel',
            ],
            [
                'type' => 'Vontar',
                'name' => 'Vontar',
                'brandname' => 'Vontar',
                'key' => 'vontar',
            ],
            [
                'type' => 'PULID',
                'name' => 'PULID',
                'brandname' => 'PULID',
                'key' => 'pulid',
            ],
            [
                'type' => 'Readboy',
                'name' => 'Readboy',
                'brandname' => 'Readboy',
                'key' => 'readboy',
            ],
            [
                'type' => 'TechPad',
                'name' => 'TechPad',
                'brandname' => 'TechPad',
                'key' => 'techpad',
            ],
            [
                'type' => 'Blaupunkt',
                'name' => 'Blaupunkt',
                'brandname' => 'Blaupunkt',
                'key' => 'blaupunkt',
            ],
            [
                'type' => 'Land Rover',
                'name' => 'Land Rover',
                'brandname' => 'Land Rover',
                'key' => 'land-rover',
            ],
            [
                'type' => 'Doro',
                'name' => 'Doro AB',
                'brandname' => 'Doro',
                'key' => 'doro',
            ],
            [
                'type' => 'iconBIT',
                'name' => 'iconBIT',
                'brandname' => 'iconBIT',
                'key' => 'iconbit',
            ],
            [
                'type' => 'Eplutus',
                'name' => 'Richmond International (Hong Kong) Electronic Technology Development Co.,Ltd',
                'brandname' => 'Eplutus',
                'key' => 'eplutus',
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
                'fallback' => 'Meta Platforms, Inc.',
                'name' => 'Meta Platforms, Inc.',
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
            [
                'fallback' => 'top-device',
                'name' => 'TopDevice',
                'brandname' => 'TopDevice',
                'key' => 'top-device',
            ],
            [
                'fallback' => 'Bigben Interactive',
                'name' => 'Bigben Interactive',
                'brandname' => 'Bigben',
                'key' => 'bigben',
            ],
            [
                'fallback' => 'Emporia Telecom GmbH & Co. KG',
                'name' => 'Emporia Telecom GmbH & Co. KG',
                'brandname' => 'Emporia',
                'key' => 'emporia',
            ],
            [
                'fallback' => 'Zebra Technologies Corp.',
                'name' => 'Zebra Technologies Corp.',
                'brandname' => 'Zebra',
                'key' => 'zebra',
            ],
            [
                'fallback' => 'x-smart',
                'name' => 'XSmart',
                'brandname' => 'XSmart',
                'key' => 'x-smart',
            ],
            [
                'fallback' => 'Chengdu Shuiyueyu Technology Co., Ltd.',
                'name' => 'Chengdu Shuiyueyu Technology Co., Ltd.',
                'brandname' => 'Moondrop',
                'key' => 'moondrop',
            ],
            [
                'fallback' => 'f-plus',
                'name' => 'F+',
                'brandname' => 'F+',
                'key' => 'f-plus',
            ],
            [
                'fallback' => 'fplus',
                'name' => 'F+',
                'brandname' => 'F+',
                'key' => 'f-plus',
            ],
            [
                'fallback' => 'Hot Pepper Mobile, Inc.',
                'name' => 'Hot Pepper Mobile, Inc.',
                'brandname' => 'Hot Pepper',
                'key' => 'hot-pepper',
            ],
            [
                'fallback' => 'hot-pepper',
                'name' => 'Hot Pepper Mobile, Inc.',
                'brandname' => 'Hot Pepper',
                'key' => 'hot-pepper',
            ],
            [
                'fallback' => 'hotPepper',
                'name' => 'Hot Pepper Mobile, Inc.',
                'brandname' => 'Hot Pepper',
                'key' => 'hot-pepper',
            ],
            [
                'fallback' => 'eagle-soar',
                'name' => 'EagleSoar',
                'brandname' => 'EagleSoar',
                'key' => 'eagle-soar',
            ],
            [
                'fallback' => 'visual-land',
                'name' => 'Visual Land',
                'brandname' => 'Visual Land',
                'key' => 'visual-land',
            ],
            [
                'fallback' => 'visualland',
                'name' => 'Visual Land',
                'brandname' => 'Visual Land',
                'key' => 'visual-land',
            ],
            [
                'fallback' => 'Vision Technology',
                'name' => 'Vision Technology',
                'brandname' => 'Vision',
                'key' => 'vision-technology',
            ],
            [
                'fallback' => 'vision-technology',
                'name' => 'Vision Technology',
                'brandname' => 'Vision',
                'key' => 'vision-technology',
            ],
            [
                'fallback' => 'the-browser-company',
                'name' => 'The Browser Company of New York',
                'brandname' => 'The Browser Company',
                'key' => 'the-browser-company',
            ],
            [
                'fallback' => 'The Browser Company of New York',
                'name' => 'The Browser Company of New York',
                'brandname' => 'The Browser Company',
                'key' => 'the-browser-company',
            ],
            [
                'fallback' => 'eightloops GmbH',
                'name' => 'eightloops GmbH',
                'brandname' => 'eightloops',
                'key' => 'eightloops',
            ],
            [
                'fallback' => 'Listia Inc.',
                'name' => 'Listia Inc.',
                'brandname' => 'Listia',
                'key' => 'listia',
            ],
            [
                'fallback' => 'Ecosia GmbH',
                'name' => 'Ecosia GmbH',
                'brandname' => 'Ecosia',
                'key' => 'ecosia',
            ],
            [
                'fallback' => 'NHN Corporation',
                'name' => 'NHN Corporation',
                'brandname' => 'NHN',
                'key' => 'nhn-corporation',
            ],
            [
                'fallback' => 'nhn-corporation',
                'name' => 'NHN Corporation',
                'brandname' => 'NHN',
                'key' => 'nhn-corporation',
            ],
            [
                'fallback' => 'Duck Duck Go Inc.',
                'name' => 'Duck Duck Go Inc.',
                'brandname' => 'Duck Duck Go',
                'key' => 'duck-duck-go',
            ],
            [
                'fallback' => 'duck-duck-go',
                'name' => 'Duck Duck Go Inc.',
                'brandname' => 'Duck Duck Go',
                'key' => 'duck-duck-go',
            ],
            [
                'fallback' => 'duckDuckGo',
                'name' => 'Duck Duck Go Inc.',
                'brandname' => 'Duck Duck Go',
                'key' => 'duck-duck-go',
            ],
            [
                'fallback' => 'Keeper Security, Inc.',
                'name' => 'Keeper Security, Inc.',
                'brandname' => 'Keeper Security',
                'key' => 'keeper',
            ],
            [
                'fallback' => 'keeper',
                'name' => 'Keeper Security, Inc.',
                'brandname' => 'Keeper Security',
                'key' => 'keeper',
            ],
            [
                'fallback' => 'lamantine-software',
                'name' => 'Lamantine Software',
                'brandname' => 'Lamantine Software',
                'key' => 'lamantine-software',
            ],
            [
                'fallback' => 'lamantineSoftware',
                'name' => 'Lamantine Software',
                'brandname' => 'Lamantine Software',
                'key' => 'lamantine-software',
            ],
            [
                'fallback' => 'Opera Software ASA',
                'name' => 'Opera Software ASA',
                'brandname' => 'Opera',
                'key' => 'opera',
            ],
            [
                'fallback' => 'ASUSTeK Computer Inc.',
                'name' => 'ASUSTeK Computer Inc.',
                'brandname' => 'Asus',
                'key' => 'asus',
            ],
            [
                'fallback' => 'BBK Electronics Corp Ltd',
                'name' => 'BBK Electronics Corp Ltd',
                'brandname' => 'BBK',
                'key' => 'bbk',
            ],
            [
                'fallback' => 'OPPO Electronics Corp.',
                'name' => 'OPPO Electronics Corp.',
                'brandname' => 'OPPO',
                'key' => 'oppo',
            ],
            [
                'fallback' => 'Vivo Electronics Corp.',
                'name' => 'Vivo Electronics Corp.',
                'brandname' => 'vivo',
                'key' => 'vivo',
            ],
            [
                'fallback' => 'Shenzhen OnePlus Science & Technology Co., Ltd.',
                'name' => 'Shenzhen OnePlus Science & Technology Co., Ltd.',
                'brandname' => 'OnePlus',
                'key' => 'oneplus',
            ],
            [
                'fallback' => 'Xiaomi Tech',
                'name' => 'Xiaomi Tech',
                'brandname' => 'Xiaomi',
                'key' => 'xiaomi',
            ],
            [
                'fallback' => 'Yandex LLC',
                'name' => 'Yandex LLC',
                'brandname' => 'Yandex',
                'key' => 'yandex',
            ],
            [
                'fallback' => 'Yahoo! Inc.',
                'name' => 'Yahoo! Inc.',
                'brandname' => 'Yahoo',
                'key' => 'yahoo',
            ],
            [
                'fallback' => 'wordpress.org',
                'name' => 'wordpress.org',
                'brandname' => 'WordPress',
                'key' => 'wordpress',
            ],
            [
                'fallback' => 'Zoom Communications Inc.',
                'name' => 'Zoom Communications Inc.',
                'brandname' => 'Zoom',
                'key' => 'zoom',
            ],
            [
                'fallback' => 'QWANT SAS',
                'name' => 'QWANT SAS',
                'brandname' => 'QWANT',
                'key' => 'qwant',
            ],
            [
                'fallback' => 'V7 Devices',
                'name' => 'V7 Devices',
                'brandname' => 'V7',
                'key' => 'v7',
            ],
            [
                'fallback' => 'apolo-sign',
                'name' => 'ApoloSign',
                'brandname' => 'ApoloSign',
                'key' => 'apolo-sign',
            ],
            [
                'fallback' => 'Volla Systeme GmbH',
                'name' => 'Volla Systeme GmbH',
                'brandname' => 'Volla',
                'key' => 'volla',
            ],
            [
                'fallback' => 'cloudmobile',
                'name' => 'Cloud Mobile',
                'brandname' => 'Cloud Mobile',
                'key' => 'cloud-mobile',
            ],
            [
                'fallback' => 'cloud-mobile',
                'name' => 'Cloud Mobile',
                'brandname' => 'Cloud Mobile',
                'key' => 'cloud-mobile',
            ],
            [
                'fallback' => 'jasminetea',
                'name' => 'jasmine tea',
                'brandname' => 'jasmine tea',
                'key' => 'jasmine-tea',
            ],
            [
                'fallback' => 'jasmine-tea',
                'name' => 'jasmine tea',
                'brandname' => 'jasmine tea',
                'key' => 'jasmine-tea',
            ],
            [
                'fallback' => 'uno-phone',
                'name' => 'UnoPhone',
                'brandname' => 'UnoPhone',
                'key' => 'uno-phone',
            ],
            [
                'fallback' => 'gruenberg',
                'name' => 'Grünberg',
                'brandname' => 'Grünberg',
                'key' => 'gruenberg',
            ],
            [
                'fallback' => 'onyxboox',
                'name' => 'Onyx Boox',
                'brandname' => 'Onyx Boox',
                'key' => 'onyx-boox',
            ],
            [
                'fallback' => 'onyx-boox',
                'name' => 'Onyx Boox',
                'brandname' => 'Onyx Boox',
                'key' => 'onyx-boox',
            ],
            [
                'fallback' => 'dudu-auto',
                'name' => 'DUDU AUTO',
                'brandname' => 'DUDU AUTO',
                'key' => 'dudu-auto',
            ],
            [
                'fallback' => 'duduauto',
                'name' => 'DUDU AUTO',
                'brandname' => 'DUDU AUTO',
                'key' => 'dudu-auto',
            ],
            [
                'fallback' => 'mobi-wire',
                'name' => 'MobiWire',
                'brandname' => 'MobiWire',
                'key' => 'mobi-wire',
            ],
            [
                'fallback' => 'Shenzhen Yunji Intelligent Technology Co,.Ltd.',
                'name' => 'Shenzhen Yunji Intelligent Technology Co,.Ltd.',
                'brandname' => 'Oukitel',
                'key' => 'oukitel',
            ],
            [
                'fallback' => 'Blackview International Group',
                'name' => 'Blackview International Group',
                'brandname' => 'Blackview',
                'key' => 'blackview',
            ],
            [
                'fallback' => 'Tecno Mobile',
                'name' => 'Tecno Mobile',
                'brandname' => 'Tecno',
                'key' => 'tecno',
            ],
            [
                'fallback' => 'Infinix Inc.',
                'name' => 'Infinix Inc.',
                'brandname' => 'Infinix',
                'key' => 'infinix',
            ],
            [
                'fallback' => 'nothing-phone',
                'name' => 'Nothing Technology Ltd',
                'brandname' => 'Nothing',
                'key' => 'nothing-phone',
            ],
            [
                'fallback' => 'Nothing Technology Ltd',
                'name' => 'Nothing Technology Ltd',
                'brandname' => 'Nothing',
                'key' => 'nothing-phone',
            ],
            [
                'fallback' => 'iTel Mobile',
                'name' => 'iTel Mobile',
                'brandname' => 'iTel',
                'key' => 'itel',
            ],
            [
                'fallback' => 'umi',
                'name' => 'UMIDIGI',
                'brandname' => 'UMIDIGI',
                'key' => 'umi',
            ],
            [
                'fallback' => 'Amazon.com, Inc.',
                'name' => 'Amazon.com, Inc.',
                'brandname' => 'Amazon',
                'key' => 'amazon',
            ],
            [
                'fallback' => 'Meizu Technology Co., Ltd.',
                'name' => 'Meizu Technology Co., Ltd.',
                'brandname' => 'Meizu',
                'key' => 'meizu',
            ],
            [
                'fallback' => 'Ulefone Technology Co., Ltd.',
                'name' => 'Ulefone Technology Co., Ltd.',
                'brandname' => 'Ulefone',
                'key' => 'ulefone',
            ],
            [
                'fallback' => 'HMD Global Oy',
                'name' => 'HMD Global Oy',
                'brandname' => 'HMD Global',
                'key' => 'hmd-global',
            ],
            [
                'fallback' => 'hmd-global',
                'name' => 'HMD Global Oy',
                'brandname' => 'HMD Global',
                'key' => 'hmd-global',
            ],
            [
                'fallback' => 'lt-mobile',
                'name' => 'LT Mobile',
                'brandname' => 'LT Mobile',
                'key' => 'lt-mobile',
            ],
            [
                'fallback' => 'at-t',
                'name' => 'AT&T',
                'brandname' => 'AT&T',
                'key' => 'at-t',
            ],
            [
                'fallback' => 'fossi-bot',
                'name' => 'FOSSiBOT',
                'brandname' => 'FOSSiBOT',
                'key' => 'fossi-bot',
            ],
            [
                'fallback' => 'Sharp Corporation',
                'name' => 'Sharp Corporation',
                'brandname' => 'Sharp',
                'key' => 'sharp',
            ],
            [
                'fallback' => 'global-sec',
                'name' => 'GlobalSec',
                'brandname' => 'GlobalSec',
                'key' => 'global-sec',
            ],
            [
                'fallback' => 'kruger-matz',
                'name' => 'Krüger&Matz',
                'brandname' => 'Krüger&Matz',
                'key' => 'kruger-matz',
            ],
            [
                'fallback' => 'Gigaset Communications GmbH',
                'name' => 'Gigaset Communications GmbH',
                'brandname' => 'Gigaset',
                'key' => 'gigaset',
            ],
            [
                'fallback' => 'TCL Communication Ltd.',
                'name' => 'TCL Communication Ltd.',
                'brandname' => 'TCL',
                'key' => 'tcl',
            ],
            [
                'fallback' => 'Walton Hi-Tech Industries Ltd.',
                'name' => 'Walton Hi-Tech Industries Ltd.',
                'brandname' => 'Walton',
                'key' => 'walton',
            ],
            [
                'fallback' => 'general-mobile',
                'name' => 'General Mobile',
                'brandname' => 'General Mobile',
                'key' => 'general-mobile',
            ],
            [
                'fallback' => 'vgo-tel',
                'name' => 'VGO Tel',
                'brandname' => 'VGO Tel',
                'key' => 'vgo-tel',
            ],
            [
                'fallback' => 'retroid-pocket',
                'name' => 'Retroid Pocket',
                'brandname' => 'Retroid Pocket',
                'key' => 'retroid-pocket',
            ],
            [
                'fallback' => 'BlackBerry Limited',
                'name' => 'BlackBerry Limited',
                'brandname' => 'BlackBerry',
                'key' => 'black-berry',
            ],
            [
                'fallback' => 'black-berry',
                'name' => 'BlackBerry Limited',
                'brandname' => 'BlackBerry',
                'key' => 'black-berry',
            ],
            [
                'fallback' => 'CHUWI Inc',
                'name' => 'CHUWI Inc',
                'brandname' => 'Chuwi',
                'key' => 'chuwi',
            ],
            [
                'fallback' => 'boost-mobile',
                'name' => 'Boost Mobile',
                'brandname' => 'Boost Mobile',
                'key' => 'boost-mobile',
            ],
            [
                'fallback' => 'catsound',
                'name' => 'S4 Handelsgruppe GmbH',
                'brandname' => 'Cat',
                'key' => 'catsound',
            ],
            [
                'fallback' => 'S4 Handelsgruppe GmbH',
                'name' => 'S4 Handelsgruppe GmbH',
                'brandname' => 'Cat',
                'key' => 'catsound',
            ],
            [
                'fallback' => 'Micromax Informatics Ltd.',
                'name' => 'Micromax Informatics Ltd.',
                'brandname' => 'Micromax',
                'key' => 'micromax',
            ],
            [
                'fallback' => 'Archos S.A.',
                'name' => 'Archos S.A.',
                'brandname' => 'Archos',
                'key' => 'archos',
            ],
            [
                'fallback' => 'green-lion',
                'name' => 'Green Lion',
                'brandname' => 'Green Lion',
                'key' => 'green-lion',
            ],
            [
                'fallback' => 'NUU Mobile',
                'name' => 'NUU Mobile',
                'brandname' => 'NUU',
                'key' => 'nuu-mobile',
            ],
            [
                'fallback' => 'nuu-mobile',
                'name' => 'NUU Mobile',
                'brandname' => 'NUU',
                'key' => 'nuu-mobile',
            ],
            [
                'fallback' => 'droid-player',
                'name' => 'Droid Player',
                'brandname' => 'Droid Player',
                'key' => 'droid-player',
            ],
            [
                'fallback' => 'HiSense Company Ltd.',
                'name' => 'HiSense Company Ltd.',
                'brandname' => 'HiSense',
                'key' => 'hisense',
            ],
            [
                'fallback' => 'Allview Electronics SP. Z O.O.',
                'name' => 'Allview Electronics SP. Z O.O.',
                'brandname' => 'Allview',
                'key' => 'allview',
            ],
            [
                'fallback' => 'free-yond',
                'name' => 'FreeYond',
                'brandname' => 'FreeYond',
                'key' => 'free-yond',
            ],
            [
                'fallback' => 'me-mobile',
                'name' => 'MeMobile',
                'brandname' => 'MeMobile',
                'key' => 'me-mobile',
            ],
            [
                'fallback' => 'soho-style',
                'name' => 'Soho Style',
                'brandname' => 'Soho Style',
                'key' => 'soho-style',
            ],
            [
                'fallback' => 'CROSSCALL SAS',
                'name' => 'CROSSCALL SAS',
                'brandname' => 'CROSSCALL',
                'key' => 'crosscall',
            ],
            [
                'fallback' => 'maze-speed',
                'name' => 'Maze Speed',
                'brandname' => 'Maze Speed',
                'key' => 'maze-speed',
            ],
            [
                'fallback' => 'hi-grace',
                'name' => 'HiGrace',
                'brandname' => 'HiGrace',
                'key' => 'hi-grace',
            ],
            [
                'fallback' => 'sigma-mobile',
                'name' => 'Sigma Mobile',
                'brandname' => 'Sigma Mobile',
                'key' => 'sigma-mobile',
            ],
            [
                'fallback' => 'land-rover',
                'name' => 'Land Rover',
                'brandname' => 'Land Rover',
                'key' => 'land-rover',
            ],
            [
                'fallback' => 'Doro AB',
                'name' => 'Doro AB',
                'brandname' => 'Doro',
                'key' => 'doro',
            ],
            [
                'fallback' => 'Richmond International (Hong Kong) Electronic Technology Development Co.,Ltd',
                'name' => 'Richmond International (Hong Kong) Electronic Technology Development Co.,Ltd',
                'brandname' => 'Eplutus',
                'key' => 'eplutus',
            ],
        ];
    }
}
