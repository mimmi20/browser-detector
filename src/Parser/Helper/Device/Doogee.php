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
final class Doogee implements DeviceInterface
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
            'n40pro', 'doogee n40 pro' => 'doogee=doogee n40 pro',
            's88pro' => 'doogee=doogee s88 pro',
            's59pro' => 'doogee=doogee s59 pro',
            's97pro' => 'doogee=doogee s97 pro',
            'x30' => 'doogee=doogee x30',
            's96pro' => 'doogee=doogee s96 pro',
            's95pro' => 'doogee=doogee s95 pro',
            'x93' => 'doogee=doogee x93',
            't10plus' => 'doogee=doogee t10plus',
            's86pro' => 'doogee=doogee s86 pro',
            's40pro' => 'doogee=doogee s40 pro',
            'x97pro' => 'doogee=doogee x97 pro',
            'n20pro' => 'doogee=doogee n20 pro',
            'x95' => 'doogee=doogee x95',
            'y8' => 'doogee=doogee y8',
            'x95pro' => 'doogee=doogee x95 pro',
            's61pro' => 'doogee=doogee s61 pro',
            's98pro' => 'doogee=doogee s98 pro',
            's58pro' => 'doogee=doogee s58 pro',
            'x96pro', 'doogee x96 pro' => 'doogee=doogee x96 pro',
            's118' => 'doogee=doogee s118',
            'note 58' => 'doogee=doogee note 58',
            'note 59' => 'doogee=doogee note 59',
            'x95i' => 'doogee=doogee x95i',
            'n30' => 'doogee=doogee n30',
            's35t' => 'doogee=doogee s35t',
            's60lite', 's60 lite' => 'doogee=doogee s60 lite',
            'n20' => 'doogee=doogee n20',
            // conflicts with Blackview BL5000
            // 'bl5000' => 'doogee=doogee bl5000',
            'bl7000' => 'doogee=doogee bl7000',
            'doogee s35' => 'doogee=doogee s35',
            's70' => 'doogee=doogee s70',
            'blade10 pro' => 'doogee=doogee blade 10 pro',
            'blade10 ultra' => 'doogee=doogee blade 10 ultra',
            'doogee n50' => 'doogee=doogee n50',
            'valencia2_y100pro' => 'doogee=doogee valencia 2 y100 pro',
            'bl12000 pro' => 'doogee=doogee bl12000 pro',
            'turbo_mini_f1' => 'doogee=doogee turbo mini f1',
            'mix lite' => 'doogee=doogee mix lite',
            'y100_plus' => 'doogee=doogee y100 plus',
            'v31gt' => 'doogee=doogee v31gt',
            't30pro' => 'doogee=doogee t30pro',
            't10s' => 'doogee=doogee t10s',
            't20mini' => 'doogee=doogee t20mini',
            'v40 pro' => 'doogee=doogee v40 pro',
            't20s' => 'doogee=doogee t20s',
            'smini' => 'doogee=doogee s mini',
            't10e' => 'doogee=doogee t10e',
            't30ultra' => 'doogee=doogee t30 ultra',
            't20ultra' => 'doogee=doogee t20 ultra',
            'v30pro', 'doogee v30 pro' => 'doogee=doogee v30 pro',
            'v20s' => 'doogee=doogee v20s',
            's118 pro' => 'doogee=doogee s118 pro',
            'u10 kid' => 'doogee=doogee u10 kid',
            't10pro' => 'doogee=doogee t10 pro',
            't30 max' => 'doogee=doogee t30 max',
            's119' => 'doogee=doogee s119',
            'v max s' => 'doogee=doogee v max s',
            's cyber pro' => 'doogee=doogee s cyber pro',
            's punk pro' => 'doogee=doogee s punk pro',
            's100', 'doogee s100' => 'doogee=doogee s100',
            'fire 6 max' => 'doogee=doogee fire 6 max',
            'n55 pro' => 'doogee=doogee n55 pro',
            'fire 6' => 'doogee=doogee fire 6',
            'note59 pro+' => 'doogee=doogee note 59 pro+',
            'note58 pro' => 'doogee=doogee note 58 pro',
            'n55' => 'doogee=doogee n55',
            't20mini pro' => 'doogee=doogee t20 mini pro',
            's41 max' => 'doogee=doogee s41 max',
            'n50s' => 'doogee=doogee n50s',
            'dk10' => 'doogee=doogee dk10',
            's punk' => 'doogee=doogee s punk',
            's41t' => 'doogee=doogee s41t',
            's cyber' => 'doogee=doogee s cyber',
            'r10' => 'doogee=doogee r10',
            'r20' => 'doogee=doogee r20',
            't20mini kid' => 'doogee=doogee t20 mini kid',
            'v max pro' => 'doogee=doogee v max pro',
            'blade gt' => 'doogee=doogee blade gt',
            'blade10 power' => 'doogee=doogee blade 10 power',
            's200 x' => 'doogee=doogee s200 x',
            's89pro' => 'doogee=doogee s89pro',
            'v20pro' => 'doogee=doogee v20pro',
            'blade20' => 'doogee=doogee blade20',
            'blade gt pro' => 'doogee=doogee blade gt pro',
            'blade20 ultra' => 'doogee=doogee blade20 ultra',
            'blade gt play' => 'doogee=doogee blade gt play',
            'fire 3' => 'doogee=doogee fire 3',
            'fire 3 ultra' => 'doogee=doogee fire 3 ultra',
            'fire 3 pro' => 'doogee=doogee fire 3 pro',
            's51' => 'doogee=doogee s51',
            's100pro' => 'doogee=doogee s100 pro',
            'v30', 'doogee v30' => 'doogee=doogee v30',
            'v30t' => 'doogee=doogee v30t',
            'v max' => 'doogee=doogee v max',
            's96gt' => 'doogee=doogee s96 gt',
            's89' => 'doogee=doogee s89',
            's41pro' => 'doogee=doogee s41 pro',
            's98' => 'doogee=doogee s98',
            // 's200' => 'doogee=doogee s200',
            'v max play' => 'doogee=doogee v max play',
            'fire 3 max' => 'doogee=doogee fire 3 max',
            'fire 5 pro' => 'doogee=doogee fire 5 pro',
            'fire 7' => 'doogee=doogee fire 7',
            'note56 plus' => 'doogee=doogee note 56 plus',
            'v max plus' => 'doogee=doogee v max plus',
            'tab a9+' => 'doogee=doogee tab a9+',
            'blade10 ultra energy' => 'doogee=doogee blade 10 ultra energy',
            'fire 7 ultra' => 'doogee=doogee fire 7 ultra',
            'fire 7 pro' => 'doogee=doogee fire 7 pro',
            'fire 5 ultra' => 'doogee=doogee fire 5 ultra',
            'blade10 pro energy' => 'doogee=doogee blade 10 pro energy',
            's200 ultra' => 'doogee=doogee s200 ultra',
            's200 max' => 'doogee=doogee s200 max',
            't40 pro' => 'doogee=doogee t40 pro',
            // other
            default => null,
        };
    }
}
