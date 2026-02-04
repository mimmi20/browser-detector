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

use BrowserDetector\Data\Engine;
use Override;
use UaData\EngineInterface;
use UaParser\ClientCodeInterface;
use UaParser\EngineCodeInterface;

final class CrawledByEngineCode implements EngineCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasEngineCode(string $value): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    public function getEngineCode(string $value): EngineInterface
    {
        return Engine::unknown;
    }
}
