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

namespace BrowserDetector\Parser;

use Override;
use UaParser\PlatformParserInterface;

final readonly class PlatformParserFactory implements PlatformParserFactoryInterface
{
    /** @throws void */
    public function __construct()
    {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function __invoke(): PlatformParserInterface
    {
        return new PlatformParser();
    }
}
