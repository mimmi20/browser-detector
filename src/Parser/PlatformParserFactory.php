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
use BrowserDetector\Loader\PlatformLoaderFactory;
use BrowserDetector\Parser\Helper\RulefileParser;
use Psr\Log\LoggerInterface;

final class PlatformParserFactory implements PlatformParserFactoryInterface
{
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
        return new PlatformParser(
            new PlatformLoaderFactory($this->logger, $this->companyLoader),
            new RulefileParser($this->logger),
        );
    }
}
