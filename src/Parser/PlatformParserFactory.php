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
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\Parser\Helper\RulefileParser;
use BrowserDetector\Version\VersionBuilder;
use Psr\Log\LoggerInterface;

final class PlatformParserFactory implements PlatformParserFactoryInterface
{
    private PlatformLoaderInterface | null $loader = null;

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CompanyLoaderInterface $companyLoader,
    ) {
        // nothing to do
    }

    /** @throws void */
    public function __invoke(): PlatformParserInterface
    {
        if ($this->loader === null) {
            $this->loader = new PlatformLoader(
                $this->logger,
                new Data(PlatformLoader::DATA_PATH, 'json'),
                $this->companyLoader,
                new VersionBuilder($this->logger),
            );
        }

        return new PlatformParser(
            $this->loader,
            new RulefileParser($this->logger),
        );
    }
}
