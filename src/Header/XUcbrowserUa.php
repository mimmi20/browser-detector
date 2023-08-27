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

final class XUcbrowserUa implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        $matches = [];

        if (!preg_match('/dv\((?P<device>[^)]+)\);/', $this->value, $matches)) {
            return false;
        }

        return $matches['device'] !== 'j2me' && $matches['device'] !== 'Opera';
    }

    /** @throws void */
    public function hasClientCode(): bool
    {
        return (bool) preg_match('/pr\([^)]+\);/', $this->value);
    }

    /** @throws void */
    public function getClientCode(): string | null
    {
        $matches = [];

        if (
            preg_match('/pr\((?P<browser>[^\/)]+)(?:\/[\d.]+)?\);/', $this->value, $matches)
            && isset($matches['browser'])
        ) {
            switch ($matches['browser']) {
                case 'UCBrowser':
                    return 'ucbrowser';
            }
        }

        return null;
    }

    /** @throws void */
    public function hasClientVersion(): bool
    {
        return (bool) preg_match('/pr\([^\/]+\/[\d.]+\);/', $this->value);
    }

    /** @throws void */
    public function getClientVersion(): string | null
    {
        $matches = [];

        if (preg_match('/pr\([^\/]+\/(?P<version>[\d.]+)\);/', $this->value, $matches)) {
            return $matches['version'];
        }

        return null;
    }

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return (bool) preg_match('/ov\([^)]+\);/', $this->value);
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
        $matches = [];

        if (
            preg_match('/ov\((?P<platform>[^)]+)\);/i', $this->value, $matches)
            && isset($matches['platform'])
        ) {
            switch (mb_strtolower($matches['platform'])) {
                case 'midp-2.0':
                    return 'java';
                case 's60v3':
                    return 'symbian';
                case 'wds 8.10':
                    return 'windows phone';
            }
        }

        return null;
    }

    /** @throws void */
    public function hasPlatformVersion(): bool
    {
        return (bool) preg_match('/ov\((?:wds )?[\d_.]+\);/', $this->value);
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
            preg_match('/ov\((?:wds )?(?P<version>[\d_.]+)\);/i', $this->value, $matches)
            && isset($matches['version'])
        ) {
            return str_replace('_', '.', $matches['version']);
        }

        return null;
    }

    /** @throws void */
    public function hasEngineCode(): bool
    {
        return (bool) preg_match('/re\((?P<engine>[^)]+)\)/', $this->value);
    }

    /** @throws void */
    public function hasEngineVersion(): bool
    {
        return (bool) preg_match('/re\((?P<engine>[\d_.]+)\)/', $this->value);
    }
}
