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
final class Alcatel implements DeviceInterface
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
            '5024d_eea' => 'alcatel=alcatel 5024d_eea',
            '6025d_eea' => 'alcatel=alcatel 6025d_eea',
            '9009f' => 'alcatel=alcatel 9009f',
            '4063t' => 'alcatel=alcatel 4063t',
            '5026d' => 'alcatel=alcatel 5026d',
            '5010d' => 'alcatel=alcatel 5010d',
            'telekom puls' => 'alcatel=alcatel telekom puls',
            '6056d' => 'alcatel=alcatel 6056d',
            '5053k_eea' => 'alcatel=alcatel 5053k_eea',
            '5029d_eea' => 'alcatel=alcatel 5029d_eea',
            '5061u_eea' => 'alcatel=alcatel 5061u_eea',
            '5099y' => 'alcatel=alcatel 5099y',
            '5006d' => 'alcatel=alcatel 5006d',
            '8094x_eea' => 'alcatel=alcatel 8094x_eea',
            '5099d' => 'alcatel=alcatel 5099d',
            '5003d_eea' => 'alcatel=alcatel 5003d_eea',
            '5033d_eea' => 'alcatel=alcatel 5033d_eea',
            '8088x_eea' => 'alcatel=alcatel 8088x_eea',
            '5028d_eea' => 'alcatel=alcatel 5028d_eea',
            '5039d_eea' => 'alcatel=alcatel 5039d_eea',
            '5039d' => 'alcatel=alcatel 5039d',
            '5039u' => 'alcatel=alcatel 5039u',
            '6065a' => 'alcatel=alcatel 6065a',
            '6027a' => 'alcatel=alcatel 6027a',
            '5059s' => 'alcatel=alcatel 5059s',
            'a466bg' => 'alcatel=alcatel a466bg',
            '8082' => 'alcatel=alcatel 8082',
            '5017b' => 'alcatel=alcatel 5017b',
            '5054n' => 'alcatel=alcatel 5054n',
            '5054w' => 'alcatel=alcatel 5054w',
            '5056n' => 'alcatel=alcatel 5056n',
            '6045o' => 'alcatel=alcatel 6045o',
            'a621bl' => 'alcatel=alcatel a621bl',
            'alcatel 7046t', '7046t' => 'alcatel=alcatel 7046t',
            'alcatel a845l', 'a845l' => 'alcatel=alcatel a845l',
            'alcatelonetouch4022d' => 'alcatel=alcatel 4022d',
            '5004c' => 'alcatel=alcatel 5004c',
            '5030i' => 'alcatel=alcatel 5030i',
            '8091' => 'alcatel=alcatel 8091',
            'alcatel_5002c' => 'alcatel=alcatel 5002c',
            '5002e' => 'alcatel=alcatel 5002e',
            't452b' => 'alcatel=alcatel t452b',
            't452a' => 'alcatel=alcatel t452a',
            't452m' => 'alcatel=alcatel t452m',
            // other
            default => null,
        };
    }
}
