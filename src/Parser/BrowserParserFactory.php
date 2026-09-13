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

use BrowserDetector\Parser\Helper\RulefileParserInterface;
use Override;
use UaParser\BrowserParserInterface;

final readonly class BrowserParserFactory implements BrowserParserFactoryInterface
{
    /** @throws void */
    public function __construct(private RulefileParserInterface $rulefileParser)
    {
        // nothing to do
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws void
     */
    #[Override]
    public function __invoke(): BrowserParserInterface
    {
        return new BrowserParser(rulefileParser: $this->rulefileParser);
    }
}
