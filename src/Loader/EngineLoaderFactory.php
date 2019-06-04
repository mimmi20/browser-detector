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
use BrowserDetector\Loader\Helper\FilterInterface;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

final class EngineLoaderFactory implements EngineLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/engines';

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
     * @var \BrowserDetector\Loader\Helper\FilterInterface
     */
    private $filter;

    /**
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \JsonClass\JsonInterface                       $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader
     * @param \BrowserDetector\Loader\Helper\FilterInterface $filter
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoaderInterface $companyLoader,
        FilterInterface $filter
    ) {
        $this->logger        = $logger;
        $this->jsonParser    = $jsonParser;
        $this->companyLoader = $companyLoader;
        $this->filter        = $filter;
    }

    /**
     * @return EngineLoaderInterface
     */
    public function __invoke(): EngineLoaderInterface
    {
        /** @var EngineLoaderInterface|null $loader */
        static $loader = null;

        if (null !== $loader) {
            return $loader;
        }

        $filter = $this->filter;
        $loader = new EngineLoader(
            $this->logger,
            new Data($filter(self::DATA_PATH, 'json'), $this->jsonParser),
            $this->companyLoader
        );

        return $loader;
    }
}
