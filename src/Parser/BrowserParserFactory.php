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

use BrowserDetector\Parser\Helper\RulefileParser;
use Override;
use Psr\Log\LoggerInterface;
use UaParser\BrowserParserInterface;

final readonly class BrowserParserFactory implements BrowserParserFactoryInterface
{
    /** @throws void */
    public function __construct(private LoggerInterface $logger)
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
        return new BrowserParser(
            fileParser: new RulefileParser(logger: $this->logger),
        );
    }
}
