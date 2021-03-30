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

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\FilterInterface;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

final class EngineLoaderFactory implements EngineLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/engines';

    private LoggerInterface $logger;

    private JsonInterface $jsonParser;

    private CompanyLoaderInterface $companyLoader;

    private FilterInterface $filter;

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
