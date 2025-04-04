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

namespace BrowserDetector\Parser;

use UaParser\EngineParserInterface;

interface EngineParserFactoryInterface
{
    /**
     * Gets the information about the engine by User Agent
     *
     * @throws void
     */
    public function __invoke(): EngineParserInterface;
}
