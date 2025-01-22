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

namespace BrowserDetector\Parser\Header;

use Override;
use UaParser\DeviceCodeInterface;

use function mb_strtolower;
use function preg_match;

final class XOperaminiPhone implements DeviceCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        return preg_match(
            '/^(?:rim|htc|samsung|apple|casio|motorola|pantech|lg|zte|blackberry) # .*/i',
            $value,
        ) === 1;
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        $matches = [];

        if (
            preg_match(
                '/^(?P<company>rim|htc|samsung|apple|casio|motorola|pantech|lg|zte|blackberry) # (?P<device>.*)/i',
                $value,
                $matches,
            )
        ) {
            $code = mb_strtolower($matches['company'] . ' ' . $matches['device']);

            return match ($code) {
                'rim blackberry 8520' => 'rim=blackberry 8520',
                'rim blackberry 8900' => 'rim=blackberry 8900',
                'blackberry 9700' => 'rim=blackberry 9700',
                'blackberry 9300' => 'rim=blackberry 9300',
                'samsung gt-s8500' => 'samsung=samsung gt-s8500',
                'samsung gt-i8000' => 'samsung=samsung gt-i8000',
                'samsung sch-u380' => 'samsung=samsung sch-u380',
                'samsung sch-u485' => 'samsung=samsung sch-u485',
                'samsung sch-u680' => 'samsung=samsung sch-u680',
                'htc touch pro/t7272/tytn iii' => 'htc=htc t7272',
                'htc hd2' => 'htc=htc t8585',
                'pantech txt8045' => 'pantech=pantech txt8045',
                'pantech cdm8999' => 'pantech=pantech cdm8999',
                'pantech cdm8992' => 'pantech=pantech cdm8992',
                'zte f-450' => 'zte=zte f-450',
                'lg vn271' => 'lg=lg vn271',
                'lg vn530' => 'lg=lg vn530',
                'motorola a1000' => 'motorola=motorola a1000',
                'casio c781' => 'casio=casio c781',
                'apple iphone' => 'apple=apple iphone',
                default => null,
            };
        }

        return null;
    }
}
