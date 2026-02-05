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
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionInterface;
use Override;
use UaData\EngineInterface;
use UaParser\EngineVersionInterface;

use function array_first;
use function array_key_first;
use function mb_strtolower;

final class SecChUaEngineVersion implements EngineVersionInterface
{
    use SetVersionTrait;
    use SortTrait;

    /** @throws void */
    #[Override]
    public function hasEngineVersion(string $value): bool
    {
        return $this->sortForEngine($value) !== [];
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getEngineVersionWithEngine(string $value, EngineInterface $engine): VersionInterface
    {
        $list = $this->sortForEngine($value);

        $version = array_first($list);

        if ($version === null) {
            return new ForcedNullVersion();
        }

        $key  = array_key_first($list);
        $code = mb_strtolower($key);

        return match ($code) {
            'total browser', 'wavebrowser' => new NullVersion(),
            default => $this->setVersion($version),
        };
    }
}
