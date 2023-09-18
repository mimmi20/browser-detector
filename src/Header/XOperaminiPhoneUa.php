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

use function in_array;
use function mb_strtolower;
use function preg_match;

final class XOperaminiPhoneUa implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        if (in_array(mb_strtolower($this->value), ['mozilla/5.0 (bada 2.0.0)', 'motorola'], true)) {
            return false;
        }

        return (bool) preg_match(
            '/samsung|nokia|blackberry|smartfren|sprint|iphone|lava|gionee|philips|htc|pantech|lg|casio|zte|mi 2sc/i',
            $this->value,
        );
    }

    /** @throws void */
    public function hasClientCode(): bool
    {
        return (bool) preg_match('/opera mini/i', $this->value);
    }

    /** @throws void */
    public function getClientCode(): string
    {
        return 'opera mini';
    }

    /** @throws void */
    public function hasClientVersion(): bool
    {
        return (bool) preg_match('/opera mini\/[\d\.]+/i', $this->value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getClientVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/opera mini\/(?P<version>[\d\.]+)/i', $this->value, $matches)) {
            return $matches['version'];
        }

        return null;
    }

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return (bool) preg_match(
            '/bada|android|blackberry|brew|iphone|mre|windows|mtk/i',
            $this->value,
        );
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasEngineCode(): bool
    {
        return (bool) preg_match('/trident|presto|webkit|gecko/i', $this->value);
    }
}
