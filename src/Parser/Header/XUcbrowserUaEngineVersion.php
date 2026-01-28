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
use Deprecated;
use Override;
use UaData\EngineInterface;
use UaParser\EngineVersionInterface;

use function preg_match;

final class XUcbrowserUaEngineVersion implements EngineVersionInterface
{
    use SetVersionTrait;

    /** @throws void */
    #[Override]
    public function hasEngineVersion(string $value): bool
    {
        return (bool) preg_match('/(?<!o)re\([^\/]+\/[\d.]+/', $value);
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    #[Deprecated(message: 'use getEngineVersionWithEngine() instead', since: '10.0.27')]
    public function getEngineVersion(string $value, string | null $code = null): VersionInterface
    {
        return $this->getVersion($value);
    }

    /** @throws void */
    #[Override]
    public function getEngineVersionWithEngine(string $value, EngineInterface $engine): VersionInterface
    {
        return $this->getVersion($value);
    }

    /** @throws void */
    private function getVersion(string $value): VersionInterface
    {
        $matches = [];

        if (preg_match('/(?<!o)re\([^\/]+\/(?P<version>[\d.]+)/', $value, $matches)) {
            return $this->setVersion($matches['version']);
        }

        return new ForcedNullVersion();
    }
}
