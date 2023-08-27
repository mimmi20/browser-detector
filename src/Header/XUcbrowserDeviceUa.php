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

final class XUcbrowserDeviceUa implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        return $this->value !== '?';
    }

    /** @throws void */
    public function hasClientCode(): bool
    {
        return (bool) preg_match(
            '/msie|dorado|safari|obigo|netfront|s40ovibrowser|dolfin|(?<!browser\/)opera(?!\/9\.80| mobi)|blackberry/i',
            $this->value,
        );
    }

    /** @throws void */
    public function getClientCode(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return (bool) preg_match(
            '/bada|android|blackberry|brew|iphone|mre|windows|mtk|symbian/i',
            $this->value,
        );
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
        return null;
    }
}
