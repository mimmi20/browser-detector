<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Bits;

final class Browser implements BitsInterface
{
    /**
     * @param string $useragent
     *
     * @return int|null
     */
    public function getBits(string $useragent): ?int
    {
        // 32 bits on 64 bit system
        if (preg_match('/i686 on x86_64|i686 \(x86_64\)/i', $useragent)) {
            return 32;
        }

        // 64 bits
        if (preg_match('/x64|win64|x86_64|amd64|ppc64|sparc64|osf1/i', $useragent)) {
            return 64;
        }

        // old deprecated 16 bit windows systems
        if (preg_match('/win3\.1|windows 3\.1/i', $useragent)) {
            return 16;
        }

        // old deprecated 8 bit systems
        if (preg_match('/cp\/m|8-bit/i', $useragent)) {
            return 8;
        }

        return 32;
    }
}
