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

use function mb_strtolower;
use function preg_match;
use function str_replace;

final class DeviceStockUa implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        return (bool) preg_match(
            '/samsung|nokia|blackberry|smartfren|sprint|iphone|lava|gionee|philips|htc|mi 2sc/i',
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

    /** @throws void */
    public function getClientVersion(): string | null
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
            '/bada|android|blackberry|brew|iphone os|mre|windows phone(?: os)?|mtk/i',
            $this->value,
        );
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
        $matches = [];

        if (
            preg_match(
                '/(?P<platform>bada|android|blackberry|brew|iphone os|mre|windows phone(?: os)?|mtk)/i',
                $this->value,
                $matches,
            )
            && isset($matches['platform'])
        ) {
            switch (mb_strtolower($matches['platform'])) {
                case 'bada':
                    return 'bada';
                case 'android':
                    return 'android';
                case 'blackberry':
                    return 'rim os';
                case 'brew':
                    return 'brew';
                case 'iphone os':
                    return 'ios';
                case 'mre':
                    return 'mre';
                case 'mtk':
                    return 'nucleus os';
                case 'windows phone os':
                case 'windows phone':
                    return 'windows phone';
            }
        }

        return null;
    }

    /** @throws void */
    public function hasPlatformVersion(): bool
    {
        return (bool) preg_match(
            '/(bada|android|blackberry\d{4}|brew|iphone os|windows phone(?: os)?)[\/ ][\d._]+/i',
            $this->value,
        );
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getPlatformVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (
            preg_match(
                '/(?:bada|android|blackberry\d{4}|brew|iphone os|windows phone(?: os)?)[\/ ](?P<version>[\d._]+)/i',
                $this->value,
                $matches,
            )
            && isset($matches['version'])
        ) {
            return str_replace('_', '.', $matches['version']);
        }

        return null;
    }

    /** @throws void */
    public function hasEngineCode(): bool
    {
        return (bool) preg_match('/trident|presto|webkit|gecko/i', $this->value);
    }
}
