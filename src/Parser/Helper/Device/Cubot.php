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
final class Cubot implements DeviceInterface
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
            'gt20' => 'cubot=cubot gt20',
            'cubot king kong' => 'cubot=cubot king kong',
            'cubot kingkong 9', 'kingkong 9' => 'cubot=cubot kingkong 9',
            'kingkong 7' => 'cubot=cubot kingkong 7',
            'cubot dinosaur' => 'cubot=cubot dinosaur',
            'king_kong_3' => 'cubot=cubot kingkong 3',
            'max 2' => 'cubot=cubot max 2',
            'cubot_manito' => 'cubot=cubot manito',
            'cubot_x18_plus' => 'cubot=cubot x18 plus',
            'note 20 pro' => 'cubot=cubot note 20 pro',
            'x70' => 'cubot=cubot x70',
            'cubot_nova' => 'cubot=cubot nova',
            'x20 pro' => 'cubot=cubot x20 pro',
            'note 7' => 'cubot=cubot note 7',
            'kingkong_mini' => 'cubot=cubot kingkong mini',
            'kingkong_mini2', 'kingkong mini2' => 'cubot=cubot kingkong mini2',
            'cubot max' => 'cubot=cubot max',
            'max 3' => 'cubot=cubot max 3',
            'r19' => 'cubot=cubot r19',
            'note 9' => 'cubot=cubot note 9',
            'x19' => 'cubot=cubot x19',
            'x19 s' => 'cubot=cubot x19 s',
            'cubot_note_s' => 'cubot=cubot note s',
            'cubot_p9' => 'cubot=cubot p9',
            'cubot_power' => 'cubot=cubot power',
            'cubot_p7' => 'cubot=cubot p7',
            'cubot_p20' => 'cubot=cubot p20',
            'cubot_j3' => 'cubot=cubot j3',
            'note 20' => 'cubot=cubot note 20',
            'note 50' => 'cubot=cubot note 50',
            'max 5', 'cubot max 5' => 'cubot=cubot max 5',
            'note 30' => 'cubot=cubot note 30',
            'pocket 3' => 'cubot=cubot pocket 3',
            'tab kingkong' => 'cubot=cubot tab king kong',
            'p80' => 'cubot=cubot p80',
            'kingkong 8' => 'cubot=cubot kingkong 8',
            'kingkong x pro' => 'cubot=cubot kingkong x pro',
            'kingkong x' => 'cubot=cubot kingkong x',
            'kingkong_es' => 'cubot=cubot kingkong es',
            'meet', 'cubot hafury meet' => 'cubot=cubot hafury meet',
            'kingkong_ax' => 'cubot=cubot kingkong ax',
            'note 23' => 'cubot=cubot note 23',
            'note 24' => 'cubot=cubot note 24',
            'x30p' => 'cubot=cubot x30p',
            'cubot hafury v1' => 'cubot=cubot hafury v1',
            'cubot j9' => 'cubot=cubot j9',
            'kingkong power 3' => 'cubot=cubot kingkong power 3',
            'kingkong ace 3' => 'cubot=cubot kingkong ace 3',
            'kingkong power' => 'cubot=cubot kingkong power',
            'note 21' => 'cubot=cubot note 21',
            'note 40' => 'cubot=cubot note 40',
            'kingkong mini 3' => 'cubot=cubot kingkong mini 3',
            'kingkong star' => 'cubot=cubot kingkong star',
            'kingkong star 2' => 'cubot=cubot kingkong star 2',
            'hafury umax' => 'cubot=cubot hafury umax',
            'hafury mix' => 'cubot=cubot hafury mix',
            'cubot cheetah 2' => 'cubot=cubot cheetah 2',
            'p60' => 'cubot=cubot p60',
            'kingkong power 5' => 'cubot=cubot kingkong power 5',
            'tab kingkong 2' => 'cubot=cubot tab king kong 2',
            'kingkong 11' => 'cubot=cubot kingkong 11',
            'kingkong es 3' => 'cubot=cubot king kong es 3',
            'kingkong mini 4' => 'cubot=cubot kingkong mini 4',
            'tab kingkong s' => 'cubot=cubot tab king kong s',
            'tab kingkong mini' => 'cubot=cubot tab king kong mini',
            // other
            default => null,
        };
    }
}
