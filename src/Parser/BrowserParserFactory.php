<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser;

use BrowserDetector\Loader\BrowserLoaderFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Parser\Helper\RulefileParser;
use Psr\Log\LoggerInterface;

final class BrowserParserFactory implements BrowserParserFactoryInterface
{
    private LoggerInterface $logger;

    private CompanyLoaderInterface $companyLoader;

    private EngineParserInterface $engineParser;

    public function __construct(
        LoggerInterface $logger,
        CompanyLoaderInterface $companyLoader,
        EngineParserInterface $engineParser
    ) {
        $this->logger        = $logger;
        $this->companyLoader = $companyLoader;
        $this->engineParser  = $engineParser;
    }

    /**
     * Gets the information about the browser by User Agent
     */
    public function __invoke(): BrowserParserInterface
    {
        return new BrowserParser(
            new BrowserLoaderFactory($this->logger, $this->companyLoader, $this->engineParser),
            new RulefileParser($this->logger)
        );
    }
}
