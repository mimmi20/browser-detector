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
namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Parser\EngineParser;
use BrowserDetector\Parser\EngineParserInterface;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;

final class BrowserLoaderFactory implements SpecificLoaderFactoryInterface
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
     * @var \BrowserDetector\Parser\EngineParserInterface
     */
    private $engineParser;

    /**
     * @var \BrowserDetector\Loader\CompanyLoader
     */
    private $companyLoader;

    /**
     * @param \Psr\Log\LoggerInterface                      $logger
     * @param \JsonClass\JsonInterface                      $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoader         $companyLoader
     * @param \BrowserDetector\Parser\EngineParserInterface $engineParser
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoader $companyLoader,
        EngineParserInterface $engineParser
    ) {
        $this->logger        = $logger;
        $this->jsonParser    = $jsonParser;
        $this->companyLoader = $companyLoader;
        $this->engineParser  = $engineParser;
    }

    /**
     * @return SpecificLoaderInterface
     */
    public function __invoke(): SpecificLoaderInterface
    {
        /** @var BrowserLoader $loader */
        static $loader = null;

        if (null !== $loader) {
            return $loader;
        }

        $dataPath = __DIR__ . '/../../data/browsers';

        $finder = new Finder();
        $finder->files();
        $finder->name('*.json');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->ignoreUnreadableDirs();
        $finder->in($dataPath);

        $loader = new BrowserLoader(
            $this->logger,
            new Data($finder, $this->jsonParser),
            $this->companyLoader,
            $this->engineParser
        );

        return $loader;
    }
}
