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

namespace BrowserDetector\Parser\Header;

use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\VersionInterface;
use Override;
use UaData\OsInterface;
use UaParser\PlatformVersionInterface;

use function preg_match;
use function str_replace;

final class XUcbrowserUaPlatformVersion implements PlatformVersionInterface
{
    use SetVersionTrait;

    /** @throws void */
    #[Override]
    public function hasPlatformVersion(string $value): bool
    {
        return (bool) preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $value);
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformVersionWithOs(string $value, OsInterface $os): VersionInterface
    {
        return $this->getVersion($value);
    }

    /** @throws void */
    private function getVersion(string $value): VersionInterface
    {
        $matches = [];

        if (preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $value, $matches)) {
            return $this->setVersion(str_replace('_', '.', $matches['version']));
        }

        return new ForcedNullVersion();
    }
}
