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

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\EngineLoaderFactory;
use BrowserDetector\Loader\Helper\Filter;
use BrowserDetector\Parser\Helper\RulefileParser;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

final class EngineParserFactory implements EngineParserFactoryInterface
{
    private LoggerInterface $logger;

    private JsonInterface $jsonParser;

    private CompanyLoaderInterface $companyLoader;

    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoaderInterface $companyLoader
    ) {
        $this->logger        = $logger;
        $this->jsonParser    = $jsonParser;
        $this->companyLoader = $companyLoader;
    }

    /**
     * Gets the information about the engine by User Agent
     */
    public function __invoke(): EngineParserInterface
    {
        return new EngineParser(
            new EngineLoaderFactory($this->logger, $this->jsonParser, $this->companyLoader, new Filter()),
            new RulefileParser($this->jsonParser, $this->logger)
        );
    }
}
