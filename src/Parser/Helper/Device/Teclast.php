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
final class Teclast implements DeviceInterface
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
            'p30s_eea' => 'teclast=teclast p30s_eea',
            'p25t_eea', 'p25_t_eea' => 'teclast=teclast p25t_eea',
            't40 pro_eea' => 'teclast=teclast t40 pro_eea',
            'p10_hd_eea' => 'teclast=teclast p10hd_eea',
            'm40pro_eea' => 'teclast=teclast m40pro_eea',
            'p20s_row' => 'teclast=teclast p20s_row',
            'p20hd_eea' => 'teclast=teclast p20hd_eea',
            'm40(n9h3)' => 'teclast=teclast n9h3',
            't50pro_w_row' => 'teclast=teclast t50 pro',
            'p40hd_t_eea' => 'teclast=teclast p40hd_t_eea',
            'p40hd_t_row' => 'teclast=teclast p40hd_t_row',
            't60ai_row' => 'teclast=teclast t60ai_row',
            'p50ai_row' => 'teclast=teclast p50ai_row',
            'p50_b' => 'teclast=teclast p50_b',
            'p50_t_eea' => 'teclast=teclast p50_t_eea',
            'p50_t_row' => 'teclast=teclast p50_t_row',
            'm40_eea' => 'teclast=teclast m40_eea',
            't40 air' => 'teclast=teclast t40 air',
            'p50case' => 'teclast=teclast p50 case',
            'm40 pro_row' => 'teclast=teclast m40 pro_row',
            'tlg01_eea' => 'teclast=teclast tlg01_eea',
            'p26t_eea' => 'teclast=teclast p26t_eea',
            't50hd_row' => 'teclast=teclast t50hd_row',
            't50hd_eea' => 'teclast=teclast t50hd_eea',
            'p40s_row' => 'teclast=teclast p40s_row',
            'p40s_eea' => 'teclast=teclast p40s_eea',
            'p50_eea' => 'teclast=teclast p50_eea',
            'p50_row' => 'teclast=teclast p50_row',
            't50max_eea' => 'teclast=teclast t50max_eea',
            't50max_row' => 'teclast=teclast t50max_row',
            't70_row' => 'teclast=teclast t70_row',
            'p20_eea' => 'teclast=teclast p20_eea',
            'm50mini' => 'teclast=teclast m50mini',
            'm50_row', 'm50-row' => 'teclast=teclast m50_row',
            'm50s' => 'teclast=teclast m50s',
            't40hd' => 'teclast=teclast t40hd',
            't45hd' => 'teclast=teclast t45hd',
            't40hd_eea' => 'teclast=teclast t40hd_eea',
            't45hd_eea' => 'teclast=teclast t45hd_eea',
            'p85t_row' => 'teclast=teclast p85t_row',
            'p30t' => 'teclast=teclast p30t',
            'm50hd' => 'teclast=teclast m50hd',
            'm50hd_eea' => 'teclast=teclast m50hd_eea',
            'm50hd_row' => 'teclast=teclast m50hd_row',
            'm50 pro' => 'teclast=teclast m50 pro',
            'p40hd_row' => 'teclast=teclast p40hd_row',
            'p40hd_eea' => 'teclast=teclast p40hd_eea',
            'p30s_row' => 'teclast=teclast p30s_row',
            'm40s_row' => 'teclast=teclast m40s_row',
            't40s_eea' => 'teclast=teclast t40s_eea',
            't50mini_row' => 'teclast=teclast t50mini_row',
            't65max_eea' => 'teclast=teclast t65max_eea',
            't65max_row' => 'teclast=teclast t65max_row',
            'p85t_eea' => 'teclast=teclast p85t_eea',
            'p26t_row' => 'teclast=teclast p26t_row',
            't50hd' => 'teclast=teclast t50hd',
            't60' => 'teclast=teclast t60',
            't50pro_w_eea' => 'teclast=teclast t50pro_w_eea',
            't50' => 'teclast=teclast t50',
            'p25t_row', 'p25_t_row' => 'teclast=teclast p25t_row',
            'p30s_w_eea' => 'teclast=teclast p30s_w_eea',
            'p80t_row' => 'teclast=teclast p80t_row',
            'p80t_eea' => 'teclast=teclast p80t_eea',
            'm40_plus_eea' => 'teclast=teclast m40_plus_eea',
            'm40_plus_row' => 'teclast=teclast m40_plus_row',
            'p30air_eea' => 'teclast=teclast p30air_eea',
            't50_row' => 'teclast=teclast t50_row',
            't50_eea' => 'teclast=teclast t50_eea',
            'p30air_row' => 'teclast=teclast p30air_row',
            'artpadpro_row' => 'teclast=teclast artpadpro_row',
            'm50-eea', 'm50_eea' => 'teclast=teclast m50_eea',
            'p30t_row' => 'teclast=teclast p30t_row',
            't50mini_a_row' => 'teclast=teclast t50mini_a_row',
            'artpad pro' => 'teclast=teclast artpad pro',
            // other
            default => null,
        };
    }
}
