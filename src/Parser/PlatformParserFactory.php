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

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\PlatformLoaderFactory;
use BrowserDetector\Parser\Helper\RulefileParser;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;

final class PlatformParserFactory implements PlatformParserFactoryInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var JsonInterface
     */
    private $jsonParser;

    /**
     * @var CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \JsonClass\JsonInterface                       $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader
     */
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
     * @return PlatformParserInterface
     */
    public function __invoke(): PlatformParserInterface
    {
        return new PlatformParser(
            new PlatformLoaderFactory($this->logger, $this->jsonParser, $this->companyLoader, new Finder()),
            new RulefileParser($this->jsonParser, $this->logger)
        );
    }
}
