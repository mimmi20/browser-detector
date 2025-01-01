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

use Override;

use function trim;

final class SecChUaFullVersion implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    #[Override]
    public function hasClientVersion(): bool
    {
        $value = trim($this->value, '"\\\'');

        return $value !== '';
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientVersion(string | null $code = null): string | null
    {
        $value = trim($this->value, '"\\\'');

        if ($value === '') {
            return null;
        }

        return $value;
    }
}
