<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser;

use BrowserDetector\Loader\BrowserLoaderFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Parser\Helper\RulefileParser;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

final class BrowserParserFactory implements BrowserParserFactoryInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @var \BrowserDetector\Parser\EngineParserInterface
     */
    private $engineParser;

    /**
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \JsonClass\JsonInterface                       $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader
     * @param \BrowserDetector\Parser\EngineParserInterface  $engineParser
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoaderInterface $companyLoader,
        EngineParserInterface $engineParser
    ) {
        $this->logger        = $logger;
        $this->jsonParser    = $jsonParser;
        $this->companyLoader = $companyLoader;
        $this->engineParser  = $engineParser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return BrowserParserInterface
     */
    public function __invoke(): BrowserParserInterface
    {
        return new BrowserParser(
            new BrowserLoaderFactory($this->logger, $this->jsonParser, $this->companyLoader, $this->engineParser),
            new RulefileParser($this->jsonParser, $this->logger)
        );
    }
}
