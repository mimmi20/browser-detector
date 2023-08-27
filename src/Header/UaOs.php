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

final class UaOs implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return (bool) preg_match('/Windows CE \(Pocket PC\) - Version \d+\.\d+/', $this->value);
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
        $matches = [];

        if (
            preg_match(
                '/(?P<name>Windows CE) \(Pocket PC\) - Version \d+\.\d+/',
                $this->value,
                $matches,
            )
            && $matches['name'] === 'Windows CE'
        ) {
            return 'windows ce';
        }

        return null;
    }

    /** @throws void */
    public function hasPlatformVersion(): bool
    {
        return (bool) preg_match('/Windows CE \(Pocket PC\) - Version \d+\.\d+/', $this->value);
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
                '/Windows CE \(Pocket PC\) - Version (?P<version>\d+\.\d+)/',
                $this->value,
                $matches,
            )
        ) {
            return $matches['version'];
        }

        return null;
    }
}
