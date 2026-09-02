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

namespace BrowserDetector\Parser\Helper\Device;

use BrowserDetector\Parser\Helper\DeviceInterface;
use Override;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
final class Ulefone implements DeviceInterface
{
    /**
     * @return non-empty-string|null
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[Override]
    public function getDeviceCode(string $code): string | null
    {
        return match ($code) {
            'note 6p' => 'ulefone=ulefone note 6p',
            'armor 11t 5g' => 'ulefone=ulefone armor 11t 5g',
            'armor x5' => 'ulefone=ulefone armor x5',
            'armor_6e' => 'ulefone=ulefone armor 6e',
            'note 16 pro', 'ulefone note 16 pro' => 'ulefone=ulefone note 16 pro',
            'note 9p', 'ulefone note 9p' => 'ulefone=ulefone note 9p',
            'armor 8' => 'ulefone=ulefone armor 8',
            'armor 8 pro' => 'ulefone=ulefone armor 8 pro',
            'armor_x2' => 'ulefone=ulefone armor x2',
            'armor_x6' => 'ulefone=ulefone armor x6',
            'armor x7 pro' => 'ulefone=ulefone armor x7 pro',
            'be touch 3' => 'ulefone=ulefone be touch 3',
            'note 11p' => 'ulefone=ulefone note 11p',
            'armor 11 5g' => 'ulefone=ulefone armor 11 5g',
            'armor x9 pro' => 'ulefone=ulefone armor x9 pro',
            'armor 17 pro' => 'ulefone=ulefone armor 17 pro',
            'armor x8' => 'ulefone=ulefone armor x8',
            'power armor 18t' => 'ulefone=ulefone power armor 18t',
            'armor 7', 'armor_7' => 'ulefone=ulefone armor 7',
            'armor 9' => 'ulefone=ulefone armor 9',
            'armor x10 pro' => 'ulefone=ulefone armor x10 pro',
            'power armor x11 pro' => 'ulefone=ulefone power armor x11 pro',
            'power_5' => 'ulefone=ulefone power 5',
            'power armor 16 pro' => 'ulefone=ulefone power armor 16 pro',
            'power armor14 pro' => 'ulefone=ulefone power armor 14 pro',
            'armor_6s' => 'ulefone=ulefone armor 6s',
            'power' => 'ulefone=ulefone power',
            'note_7p' => 'ulefone=ulefone note 7p',
            's10_pro' => 'ulefone=ulefone s10 pro',
            'power_3' => 'ulefone=ulefone power 3',
            'note 14' => 'ulefone=ulefone note 14',
            'note 8p' => 'ulefone=ulefone note 8p',
            'note 13p' => 'ulefone=ulefone note 13p',
            'note 10p' => 'ulefone=ulefone note 10p',
            'armor pad lite' => 'ulefone=ulefone armor pad lite',
            'armor pad 4 ultra' => 'ulefone=ulefone armor pad 4 ultra',
            'armor mini 20 pro' => 'ulefone=ulefone armor mini 20 pro',
            'armor mini 20' => 'ulefone=ulefone armor mini 20',
            'armor mini 20t pro' => 'ulefone=ulefone armor mini 20t pro',
            'armor pad pro' => 'ulefone=ulefone armor pad pro',
            'tab a11 pro' => 'ulefone=ulefone tab a11 pro',
            'armor pad 2' => 'ulefone=ulefone armor pad 2',
            'armor pad 3 pro' => 'ulefone=ulefone armor pad 3 pro',
            'armor 34 pro' => 'ulefone=ulefone armor 34 pro',
            'armor x16' => 'ulefone=ulefone armor x16',
            'armor x32' => 'ulefone=ulefone armor x32',
            'armor 21' => 'ulefone=ulefone armor 21',
            'armor 23 ultra' => 'ulefone=ulefone armor 23 ultra',
            'armor 27' => 'ulefone=ulefone armor 27',
            'armor x12' => 'ulefone=ulefone armor x12',
            'power armor x11' => 'ulefone=ulefone power armor x11',
            'armor pad' => 'ulefone=ulefone armor pad',
            'gq3060tf3' => 'ulefone=ulefone gq3060tf3',
            'power armor 13' => 'ulefone=ulefone power armor 13',
            'gemini pro' => 'ulefone=ulefone gemini pro',
            'power_6' => 'ulefone=ulefone power 6',
            'power 3s' => 'ulefone=ulefone power 3s',
            'power armor 18' => 'ulefone=ulefone power armor 18',
            'power armor 16s' => 'ulefone=ulefone power armor 16s',
            'rugking' => 'ulefone=ulefone rugking',
            'armor 24' => 'ulefone=ulefone armor 24',
            'armor 5s' => 'ulefone=ulefone armor 5s',
            'power armor 19t' => 'ulefone=ulefone power armor 19t',
            'armor x32 pro' => 'ulefone=ulefone armor x32 pro',
            'rugking 4 pro' => 'ulefone=ulefone rugking 4 pro',
            'armor_6' => 'ulefone=ulefone armor 6',
            'note 6' => 'ulefone=ulefone note 6',
            'note 18 ultra' => 'ulefone=ulefone note 18 ultra',
            'armor_3w' => 'ulefone=ulefone armor 3w',
            'armor x16 pro' => 'ulefone=ulefone armor x16 pro',
            'armor x6 pro' => 'ulefone=ulefone armor x6 pro',
            'armor x' => 'ulefone=ulefone armor x',
            'ulefone_note 7' => 'ulefone=ulefone note 7',
            'armor pad 5 pro' => 'ulefone=ulefone armor pad 5 pro',
            'armor 34' => 'ulefone=ulefone armor 34',
            'armor 29 ultra' => 'ulefone=ulefone armor 29 ultra',
            'rugking pad pro' => 'ulefone=ulefone rugking pad pro',
            'rugking pad 2 pro' => 'ulefone=ulefone rugking pad 2 pro',
            'rugking 3 pro' => 'ulefone=ulefone rugking 3 pro',
            'rugking 2 pro' => 'ulefone=ulefone rugking 2 pro',
            'armor x31' => 'ulefone=ulefone armor x31',
            'armor 33 pro' => 'ulefone=ulefone armor 33 pro',
            'armor 29 pro' => 'ulefone=ulefone armor 29 pro',
            'armor 2' => 'ulefone=ulefone armor 2',
            'armor 5' => 'ulefone=ulefone armor 5',
            'armor' => 'ulefone=ulefone armor',
            'power 2' => 'ulefone=ulefone power 2',
            'armor 28 pro' => 'ulefone=ulefone armor 28 pro',
            'armor 30' => 'ulefone=ulefone armor 30',
            'armor 33' => 'ulefone=ulefone armor 33',
            'armor x10' => 'ulefone=ulefone armor x10',
            'armor 7e' => 'ulefone=ulefone armor 7e',
            'armor 9e' => 'ulefone=ulefone armor 9e',
            'armor x7' => 'ulefone=ulefone armor x7',
            'armor_x3' => 'ulefone=ulefone armor x3',
            'armor_3wt' => 'ulefone=ulefone armor 3wt',
            'armor x5 pro' => 'ulefone=ulefone armor x5 pro',
            'armor 10 5g' => 'ulefone=ulefone armor 10 5g',
            'armor x9' => 'ulefone=ulefone armor x9',
            'ulefone tab a7' => 'ulefone=ulefone tab a7',
            'armor x12 pro' => 'ulefone=ulefone armor x12 pro',
            'armor 12s' => 'ulefone=ulefone armor 12s',
            'armor 12 5g' => 'ulefone=ulefone armor 12 5g',
            'armor 15' => 'ulefone=ulefone armor 15',
            'armor x13' => 'ulefone=ulefone armor x13',
            'armor 20wt' => 'ulefone=ulefone armor 20wt',
            // other
            default => null,
        };
    }
}
