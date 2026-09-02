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
final class Asus implements DeviceInterface
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
            'p024' => 'asus=asus p024',
            'asus_x00dd' => 'asus=asus x00dd',
            'asus_i005da' => 'asus=asus i005da',
            'asus_i003d' => 'asus=asus i003d',
            'asus_i003dd' => 'asus=asus i003dd',
            'asus_i006d' => 'asus=asus i006d',
            'zc554kl' => 'asus=asus zc554kl',
            'asus_x00id' => 'asus=asus x00id',
            'asus_z008d' => 'asus=asus z008d',
            'asus_ai2302', 'asus asus_ai2302' => 'asus=asus ai2302',
            'asus_ai2202' => 'asus=asus ai2202',
            'asus_x008d' => 'asus=asus x008d',
            'p01t_1' => 'asus=asus p01t_1',
            'p027' => 'asus=asus p027',
            'asus_i001dc' => 'asus=asus i001dc',
            'asus_i001de' => 'asus=asus i001de',
            'asus_x01ad' => 'asus=asus x01ad',
            'asus_ai2203_c' => 'asus=asus ai2203 c',
            'asus_ai2203_d' => 'asus=asus ai2203 d',
            'asus_ai2203_a' => 'asus=asus ai2203 a',
            'asus_ai2203_b' => 'asus=asus ai2203 b',
            'asus_ai2203' => 'asus=asus ai2203',
            'asus_ai2201_c' => 'asus=asus ai2201 c',
            'p00c' => 'asus=asus p00c',
            'asus_x018d' => 'asus=asus x018d',
            'asus_ai2205_c' => 'asus=asus ai2205 c',
            'asus_z01kd' => 'asus=asus z01kd',
            'asus_i002d' => 'asus=asus i002d',
            'asus_z01rd' => 'asus=asus z01rd',
            'zs620kl' => 'asus=asus zs620kl',
            'zenfone 5z' => 'asus=asus zenfone 5z',
            'asusai2501c' => 'asus=asus ai2501 c',
            'zenfone 5' => 'asus=asus zenfone 5',
            'asus_x00qd' => 'asus=asus x00qd',
            'ze620kl' => 'asus=asus ze620kl',
            'zf620kl' => 'asus=asus zf620kl',
            'asus_x00qda' => 'asus=asus x00qda',
            'asus chromebook flip c100pa' => 'asus=asus chromebook flip c100pa',
            'memo pad fhd 10 lte', 'aosp on duma' => 'asus=asus memo pad fhd 10 lte',
            'asus_ai2401_h' => 'asus=asus ai2401 h',
            'asus_ai2401_a' => 'asus=asus ai2401 a',
            'asus_ai2401_d' => 'asus=asus ai2401 d',
            'asus_ai2401_c' => 'asus=asus ai2401 c',
            'asus_ai2401_e' => 'asus=asus ai2401 e',
            'asus_ai2401_n' => 'asus=asus ai2401 n',
            'p023' => 'asus=asus p023',
            'asus_x01bda' => 'asus=asus x01bda',
            'zb631kl' => 'asus=asus zb631kl',
            'zb602kl' => 'asus=asus zb602kl',
            'asus chromebook flip c101pa' => 'asus=asus chromebook flip c101pa',
            'zb500kl', 'asus zenfone go zb500kl' => 'asus=asus zb500kl',
            'asus_zenpad_12p' => 'asus=asus zenpad 12p',
            'asus zenfone max pro m2' => 'asus=asus zenfone max pro m2',
            'zb630kl' => 'asus=asus zb630kl',
            'asus rog phone 8' => 'asus=asus rog phone 8',
            'asus rog phone 5' => 'asus=asus rog phone 5',
            'zs673ks' => 'asus=asus zs673ks',
            'zb601kl' => 'asus=asus zb601kl',
            'asus_x00t' => 'asus=asus x00t',
            'zs660kl' => 'asus=asus zs660kl',
            'asus zb633kl' => 'asus=asus zb633kl',
            'zd551kl' => 'asus=asus zd551kl',
            'zb570tl' => 'asus=asus zb570tl',
            'za550kl' => 'asus=asus za550kl',
            'zc451tg' => 'asus=asus zc451tg',
            'zb552kl' => 'asus=asus zb552kl',
            'zs630kl' => 'asus=asus zs630kl',
            'ze554kl' => 'asus=asus ze554kl',
            'ze553kl' => 'asus=asus ze553kl',
            'zc553kl' => 'asus=asus zc553kl',
            'za520kl' => 'asus=asus za520kl',
            'ze520kl' => 'asus=asus ze520kl',
            'zs600kl' => 'asus=asus zs600kl',
            'zs551kl' => 'asus=asus zs551kl',
            'asus_z01gd' => 'asus=asus z01gd',
            'asus_z01gs' => 'asus=asus z01gs',
            // other
            default => null,
        };
    }
}
