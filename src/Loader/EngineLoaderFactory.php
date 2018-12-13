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
use JsonClass\Json;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;

final class EngineLoaderFactory implements SpecificLoaderFactoryInterface
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
     * @param \Psr\Log\LoggerInterface $logger
     * @param \JsonClass\JsonInterface          $jsonParser
     */
    public function __construct(LoggerInterface $logger, JsonInterface $jsonParser)
    {
        $this->logger     = $logger;
        $this->jsonParser = $jsonParser;
    }

    /**
     * @return SpecificLoaderInterface
     */
    public function __invoke(): SpecificLoaderInterface
    {
        $dataPath  = __DIR__ . '/../../data/engines';

        $finder = new Finder();
        $finder->files();
        $finder->name('*.json');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->ignoreUnreadableDirs();
        $finder->in($dataPath);

        return new EngineLoader(
            $this->logger,
            CompanyLoader::getInstance(),
            new Data($finder, $this->jsonParser)
        );
    }
}
