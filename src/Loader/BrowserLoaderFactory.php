<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Parser\EngineParserInterface;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;

final class BrowserLoaderFactory implements BrowserLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/browsers';

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    /**
     * @var \BrowserDetector\Parser\EngineParserInterface
     */
    private $engineParser;

    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @var \Symfony\Component\Finder\Finder
     */
    private $finder;

    /**
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \JsonClass\JsonInterface                       $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader
     * @param \BrowserDetector\Parser\EngineParserInterface  $engineParser
     * @param \Symfony\Component\Finder\Finder               $finder
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoaderInterface $companyLoader,
        EngineParserInterface $engineParser,
        Finder $finder
    ) {
        $this->logger        = $logger;
        $this->jsonParser    = $jsonParser;
        $this->companyLoader = $companyLoader;
        $this->engineParser  = $engineParser;
        $this->finder        = $finder;
    }

    /**
     * @return BrowserLoaderInterface
     */
    public function __invoke(): BrowserLoaderInterface
    {
        /** @var BrowserLoader $loader */
        static $loader = null;

        if (null !== $loader) {
            return $loader;
        }

        $this->finder->files();
        $this->finder->name('*.json');
        $this->finder->ignoreDotFiles(true);
        $this->finder->ignoreVCS(true);
        $this->finder->ignoreUnreadableDirs();
        $this->finder->in(self::DATA_PATH);

        $loader = new BrowserLoader(
            $this->logger,
            new Data($this->finder, $this->jsonParser),
            $this->companyLoader,
            $this->engineParser
        );

        return $loader;
    }
}
