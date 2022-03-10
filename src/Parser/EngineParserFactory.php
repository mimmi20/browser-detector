<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\EngineLoaderFactory;
use BrowserDetector\Parser\Helper\RulefileParser;
use Psr\Log\LoggerInterface;

final class EngineParserFactory implements EngineParserFactoryInterface
{
    private LoggerInterface $logger;

    private CompanyLoaderInterface $companyLoader;

    public function __construct(
        LoggerInterface $logger,
        CompanyLoaderInterface $companyLoader
    ) {
        $this->logger        = $logger;
        $this->companyLoader = $companyLoader;
    }

    /**
     * Gets the information about the engine by User Agent
     */
    public function __invoke(): EngineParserInterface
    {
        return new EngineParser(
            new EngineLoaderFactory($this->logger, $this->companyLoader),
            new RulefileParser($this->logger)
        );
    }
}
