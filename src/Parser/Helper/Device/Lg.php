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
final class Lg implements DeviceInterface
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
            'lm-g710' => 'lg=lg lm-g710',
            'lm-g910' => 'lg=lg lm-g910',
            'lm-g900' => 'lg=lg lm-g900',
            'lm-g850' => 'lg=lg lm-g850',
            'lm-q630' => 'lg=lg lm-q630',
            'lg-m700' => 'lg=lg m700',
            'lm-v405', 'lge lm-v405' => 'lg=lg lm-v405',
            'lm-v405ebw', 'lge lm-v405ebw' => 'lg=lg lm-v405ebw',
            'lg-h870' => 'lg=lg h870',
            'lg-h850' => 'lg=lg h850',
            'lm-k410' => 'lg=lg lm-k410',
            'lg-m200' => 'lg=lg m200',
            'lm-q617.fgn' => 'lg=lg lm-q617.fgn',
            'lm-k420' => 'lg=lg lm-k420',
            'lm-x210' => 'lg=lg lm-x210',
            'lm-k510' => 'lg=lg lm-k510',
            'lg-h815' => 'lg=lg h815',
            'lm-g810' => 'lg=lg lm-g810',
            'lm-x520' => 'lg=lg lm-x520',
            'lm-x420' => 'lg=lg lm-x420',
            'lg-h930' => 'lg=lg h930',
            'lg-m250' => 'lg=lg m250',
            'lg-k100' => 'lg=lg k100',
            'lm-x430' => 'lg=lg lm-x430',
            'lm-x510.fg' => 'lg=lg lm-x510.fg',
            'lg-k500n' => 'lg=lg k500n',
            'lm-q610.fgn' => 'lg=lg lm-q610.fgn',
            'lm-q610.fg' => 'lg=lg lm-q610.fg',
            'lm-x120' => 'lg=lg lm-x120',
            'lm-x540' => 'lg=lg lm-x540',
            'lg-h840' => 'lg=lg h840',
            'lm-q850' => 'lg=lg lm-q850',
            'lm-k200' => 'lg=lg lm-k200',
            'lg-k520' => 'lg=lg k520',
            'lm-k520' => 'lg=lg lm-k520',
            'lm-g710n' => 'lg=lg lm-g710n',
            'lg-m320' => 'lg=lg m320',
            'lm-x525' => 'lg=lg lm-x525',
            'lg-k220' => 'lg=lg k220',
            'lg-h410' => 'lg=lg h410',
            'lg-d486' => 'lg=lg d486',
            'lg-f480' => 'lg=lg f480',
            'lm-q710.fgn' => 'lg=lg lm-q710.fgn',
            'lm-x320' => 'lg=lg lm-x320',
            'lg-k430' => 'lg=lg k430',
            'lg-k350' => 'lg=lg k350',
            'lm-f100' => 'lg=lg lm-f100',
            'lg-h860' => 'lg=lg h860',
            'lg-h870ds' => 'lg=lg h870ds',
            'lm-v409n' => 'lg=lg lm-v409n',
            'lg-m160' => 'lg=lg m160',
            'lg-d722' => 'lg=lg d722',
            'lm-x410.fn' => 'lg=lg lm-x410.fn',
            'lg-k580' => 'lg=lg k580',
            'lmk920' => 'lg=lg lmk920',
            'lgl164vl' => 'lg=lg l164vl',
            'lgl163bl' => 'lg=lg l163bl',
            'lm-x600im' => 'lg=lg lm-x600im',
            'lm-t605' => 'lg=lg lm-t605',
            '10a30q' => 'lg=lg 10a30q',
            'lglk430' => 'lg=lg lk430',
            'lg-d726' => 'lg=lg d726',
            'lg-h920' => 'lg=lg h920',
            'lg-d727' => 'lg=lg d727',
            'lg v60' => 'lg=lg v60',
            'lg-d333' => 'lg=lg d333',
            'lg-d295' => 'lg=lg d295',
            'lg spirit 4g lte' => 'lg=lg spirit 4g lte',
            'a001lg' => 'lg=lg a001lg',
            'lm-v600' => 'lg=lg lm-v600',
            'lm-v600v' => 'lg=lg lm-v600v',
            'lm-q310n' => 'lg=lg lm-q310n',
            'lm-k310im' => 'lg=lg lm-k310im',
            'lm-k610im' => 'lg=lg lm-k610im',
            'lgl355dl' => 'lg=lg lgl355dl',
            'lm-k300' => 'lg=lg lm-k300',
            'lm-q520n' => 'lg=lg lm-q520n',
            'lm-k526' => 'lg=lg lm-k526',
            'lm-k525' => 'lg=lg lm-k525',
            'lm-k315im' => 'lg=lg lm-k315im',
            'lm-q620' => 'lg=lg lm-q620',
            'lgl555dl' => 'lg=lg lgl555dl',
            'lgl455dl' => 'lg=lg lgl455dl',
            'lgv35' => 'lg=lg lgv35',
            'lm-v350n' => 'lg=lg lm-v350n',
            'lm-v350' => 'lg=lg lm-v350',
            'lmx130im' => 'lg=lg lmx130im',
            'lm-q510n' => 'lg=lg lm-q510n',
            'lm-q920n' => 'lg=lg lm-q920n',
            'lm-q927l' => 'lg=lg lm-q927l',
            'lg g2' => 'lg=lg g2',
            // other
            default => null,
        };
    }
}
