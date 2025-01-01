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

namespace BrowserDetector\Header;

use BrowserDetector\Parser\DeviceParserInterface;
use Override;

use function mb_strtolower;
use function preg_match;
use function str_replace;

final class XUcbrowserUa implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function __construct(string $value, private readonly DeviceParserInterface $deviceParser)
    {
        $this->value = $value;
    }

    /** @throws void */
    #[Override]
    public function hasDeviceCode(): bool
    {
        $matches = [];

        if (!preg_match('/dv\((?P<device>[^)]+)\);/', $this->value, $matches)) {
            return false;
        }

        return $matches['device'] !== 'j2me' && $matches['device'] !== 'Opera';
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(): string | null
    {
        $matches = [];

        if (!preg_match('/dv\((?P<device>[^)]+)\);/', $this->value, $matches)) {
            return null;
        }

        if ($matches['device'] === 'j2me' || $matches['device'] === 'Opera') {
            return null;
        }

        $code = $this->deviceParser->parse($matches['device']);

        if ($code === '') {
            return null;
        }

        return $code;
    }

    /** @throws void */
    #[Override]
    public function hasClientCode(): bool
    {
        return (bool) preg_match('/pr\([^)]+\);/', $this->value);
    }

    /** @throws void */
    #[Override]
    public function getClientCode(): string | null
    {
        $matches = [];

        if (preg_match('/pr\((?P<client>[^\/)]+)(?:\/[\d.]+)?\);/', $this->value, $matches)) {
            $code = mb_strtolower($matches['client']);

            return match ($code) {
                'ucbrowser' => $code,
                default => null,
            };
        }

        return null;
    }

    /** @throws void */
    #[Override]
    public function hasClientVersion(): bool
    {
        return (bool) preg_match('/pr\([^\/]+\/[\d.]+\);/', $this->value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/pr\([^\/]+\/(?P<version>[\d.]+)\);/', $this->value, $matches)) {
            return $matches['version'];
        }

        return null;
    }

    /** @throws void */
    #[Override]
    public function hasPlatformCode(): bool
    {
        if (preg_match('/pf\((?P<platform>[^)]+)\);/', $this->value, $matches)) {
            return match (mb_strtolower($matches['platform'])) {
                'linux', 'symbian', '42', '44', 'windows', 'java' => true,
                default => false,
            };
        }

        return false;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string | null $derivate = null): string | null
    {
        $matches = [];

        if (preg_match('/pf\((?P<platform>[^)]+)\);/', $this->value, $matches)) {
            $code = mb_strtolower($matches['platform']);

            return match ($code) {
                'symbian', 'java' => $code,
                'windows' => 'windows phone',
                '42', '44' => 'ios',
                'linux' => 'android',
                default => null,
            };
        }

        return null;
    }

    /** @throws void */
    #[Override]
    public function hasPlatformVersion(): bool
    {
        return (bool) preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $this->value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $this->value, $matches)) {
            return str_replace('_', '.', $matches['version']);
        }

        return null;
    }

    /** @throws void */
    #[Override]
    public function hasEngineCode(): bool
    {
        return (bool) preg_match('/(?<!o)re\(([^)]+)\)/', $this->value);
    }

    /** @throws void */
    #[Override]
    public function getEngineCode(): string | null
    {
        $matches = [];

        if (preg_match('/(?<!o)re\((?P<engine>[^\/)]+)(?:\/[\d.]+)?/', $this->value, $matches)) {
            $code = mb_strtolower($matches['engine']);

            return match ($code) {
                'applewebkit' => 'webkit',
                default => $code,
            };
        }

        return null;
    }

    /** @throws void */
    #[Override]
    public function hasEngineVersion(): bool
    {
        return (bool) preg_match('/(?<!o)re\([^\/]+\/[\d.]+/', $this->value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getEngineVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/(?<!o)re\([^\/]+\/(?P<version>[\d.]+)/', $this->value, $matches)) {
            return $matches['version'];
        }

        return null;
    }
}
