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

namespace BrowserDetector\Parser;

use BrowserDetector\Parser\Helper\RulefileParser;
use Override;
use Psr\Log\LoggerInterface;

final readonly class EngineParserFactory implements EngineParserFactoryInterface
{
    /** @throws void */
    public function __construct(private LoggerInterface $logger)
    {
        // nothing to do
    }

    /**
     * Gets the information about the engine by User Agent
     *
     * @throws void
     */
    #[Override]
    public function __invoke(): EngineParserInterface
    {
        return new EngineParser(
            fileParser: new RulefileParser(logger: $this->logger),
        );
    }
}
