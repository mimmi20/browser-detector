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
use BrowserDetector\Loader\Helper\Rules;
use Psr\Log\LoggerInterface;
use Seld\JsonLint\JsonParser;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use UaResult\Company\CompanyLoader;

class EngineLoaderFactory
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return GenericLoaderInterface
     */
    public function __invoke(): GenericLoaderInterface
    {
        static $loader = null;

        if (null === $loader) {
            $dataPath  = __DIR__ . '/../../data/engines';
            $rulesPath = __DIR__ . '/../../data/factories/engines.json';

            $finder = new Finder();
            $finder->files();
            $finder->name('*.json');
            $finder->ignoreDotFiles(true);
            $finder->ignoreVCS(true);
            $finder->ignoreUnreadableDirs();
            $finder->in($dataPath);

            $jsonParser = new JsonParser();
            $file       = new SplFileInfo($rulesPath, '', '');
            $initRules  = new Rules($jsonParser, $file);
            $initData   = new Data(
                $finder,
                $jsonParser
            );

            $loader = new EngineLoader(
                $this->logger,
                CompanyLoader::getInstance(),
                $initData
            );

            $loader = new GenericLoader(
                $this->logger,
                $initRules,
                $initData,
                $loader
            );
        }

        return $loader;
    }
}
