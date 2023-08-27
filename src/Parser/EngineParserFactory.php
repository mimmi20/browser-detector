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

namespace BrowserDetector\Parser;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Parser\Helper\RulefileParser;
use Psr\Log\LoggerInterface;

final class EngineParserFactory implements EngineParserFactoryInterface
{
    private EngineLoaderInterface | null $loader = null;

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CompanyLoaderInterface $companyLoader,
    ) {
        // nothing to do
    }

    /**
     * Gets the information about the engine by User Agent
     *
     * @throws void
     */
    public function __invoke(): EngineParserInterface
    {
        if ($this->loader === null) {
            $this->loader = new EngineLoader(
                $this->logger,
                new Data(EngineLoader::DATA_PATH, 'json'),
                $this->companyLoader,
            );
        }

        return new EngineParser(
            $this->loader,
            new RulefileParser($this->logger),
        );
    }
}
