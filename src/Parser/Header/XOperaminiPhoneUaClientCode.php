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

namespace BrowserDetector\Parser\Header;

use Override;
use UaParser\ClientCodeInterface;

use function preg_match;

final class XOperaminiPhoneUaClientCode implements ClientCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasClientCode(string $value): bool
    {
        return (bool) preg_match('/opera mini/i', $value);
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientCode(string $value): string
    {
        return 'opera mini';
    }
}
