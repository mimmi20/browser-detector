<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
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

    private BrowserLoader | null $loader = null;

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CompanyLoaderInterface $companyLoader,
        private readonly EngineParserInterface $engineParser,
    ) {
        // nothing to do
    }

    /** @throws void */
    public function __invoke(): BrowserLoaderInterface
    {
        if ($this->loader === null) {
            $this->loader = new BrowserLoader(
                $this->logger,
                new Data(self::DATA_PATH, 'json'),
                $this->companyLoader,
                $this->engineParser,
            );
        }

        return $this->loader;
    }
}
