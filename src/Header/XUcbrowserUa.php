<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Header;

use BrowserDetector\Parser\DeviceParserInterface;

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
    public function hasDeviceCode(): bool
    {
        $matches = [];

        if (!preg_match('/dv\((?P<device>[^)]+)\);/', $this->value, $matches)) {
            return false;
        }

        return $matches['device'] !== 'j2me' && $matches['device'] !== 'Opera';
    }

    /** @throws void */
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
    public function hasClientCode(): bool
    {
        return (bool) preg_match('/pr\([^)]+\);/', $this->value);
    }

    /** @throws void */
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
    public function hasClientVersion(): bool
    {
        return (bool) preg_match('/pr\([^\/]+\/[\d.]+\);/', $this->value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getClientVersion(string | null $code = null): string | null
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
        if (preg_match('/pf\((?P<platform>[^)]+)\);/', $this->value, $matches)) {
            return match (mb_strtolower($matches['platform'])) {
                'linux', 'symbian', '42', '44', 'windows', 'java' => true,
                default => false,
            };
        }

        return false;
    }

    /** @throws void */
    public function getPlatformCode(): string | null
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
    public function hasPlatformVersion(): bool
    {
        return (bool) preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $this->value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getPlatformVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $this->value, $matches)) {
            return str_replace('_', '.', $matches['version']);
        }

        return null;
    }

    /** @throws void */
    public function hasEngineCode(): bool
    {
        return (bool) preg_match('/re\(([^)]+)\)/', $this->value);
    }

    /** @throws void */
    public function getEngineCode(): string | null
    {
        $matches = [];

        if (preg_match('/re\((?P<engine>[^\/)]+)(?:\/[\d.]+)?/', $this->value, $matches)) {
            $code = mb_strtolower($matches['engine']);

            return match ($code) {
                'applewebkit' => 'webkit',
                default => $code,
            };
        }

        return null;
    }

    /** @throws void */
    public function hasEngineVersion(): bool
    {
        return (bool) preg_match('/re\([^\/]+\/[\d.]+/', $this->value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getEngineVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/re\([^\/]+\/(?P<version>[\d.]+)/', $this->value, $matches)) {
            return $matches['version'];
        }

        return null;
    }
}
