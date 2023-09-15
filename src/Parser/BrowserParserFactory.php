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

use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Parser\Helper\RulefileParser;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaBrowserType\TypeLoader;

final class BrowserParserFactory implements BrowserParserFactoryInterface
{
    private BrowserLoader | null $loader = null;

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CompanyLoaderInterface $companyLoader,
    ) {
        // nothing to do
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws void
     */
    public function __invoke(): BrowserParserInterface
    {
        if ($this->loader === null) {
            $this->loader = new BrowserLoader(
                $this->logger,
                new Data(BrowserLoader::DATA_PATH, 'json'),
                $this->companyLoader,
                new TypeLoader(),
                new VersionFactory(),
            );
        }

        return new BrowserParser(
            $this->loader,
            new RulefileParser($this->logger),
        );
    }
}
