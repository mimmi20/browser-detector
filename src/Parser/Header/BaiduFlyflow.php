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

use Override;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;

use function preg_match;

final readonly class BaiduFlyflow implements DeviceCodeInterface
{
    /** @throws void */
    public function __construct(private DeviceParserInterface $deviceParser)
    {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        $hasMatch = preg_match('/;htc;htc;/i', $value);

        return !$hasMatch;
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        if (preg_match('/;htc;htc;/i', $value)) {
            return null;
        }

        $code = $this->deviceParser->parse($value);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
