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

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Parser\EngineParserInterface;
use Psr\Log\LoggerInterface;

final class BrowserLoaderFactory implements BrowserLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/browsers';

    private LoggerInterface $logger;

    private EngineParserInterface $engineParser;

    private CompanyLoaderInterface $companyLoader;

    private ?BrowserLoader $loader = null;

    public function __construct(
        LoggerInterface $logger,
        CompanyLoaderInterface $companyLoader,
        EngineParserInterface $engineParser
    ) {
        $this->logger        = $logger;
        $this->companyLoader = $companyLoader;
        $this->engineParser  = $engineParser;
    }

    public function __invoke(): BrowserLoaderInterface
    {
        if (null === $this->loader) {
            $this->loader = new BrowserLoader(
                $this->logger,
                new Data(self::DATA_PATH, 'json'),
                $this->companyLoader,
                $this->engineParser
            );
        }

        return $this->loader;
    }
}
