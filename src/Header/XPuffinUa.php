<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Header;

use function preg_match;

final class XPuffinUa implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        return true;
    }

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return (bool) preg_match('/Android|iPhone OS/', $this->value);
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
        $matches = [];

        if (
            preg_match('/(?P<platform>Android|iPhone OS)/', $this->value, $matches)
            && isset($matches['platform'])
        ) {
            switch ($matches['platform']) {
                case 'iPhone OS':
                    return 'ios';
                case 'Android':
                    return 'android';
            }
        }

        return null;
    }
}
