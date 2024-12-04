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
use Override;

use function preg_match;

final class BaiduFlyflow implements HeaderInterface
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
        $hasMatch = preg_match('/;htc;htc;/i', $this->value);

        return !$hasMatch;
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(): string | null
    {
        if (preg_match('/;htc;htc;/i', $this->value)) {
            return null;
        }

        $code = $this->deviceParser->parse($this->value);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
