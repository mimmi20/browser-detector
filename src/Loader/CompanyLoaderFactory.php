<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader;

use Override;
use Psr\Log\LoggerInterface;

final class CompanyLoaderFactory implements CompanyLoaderFactoryInterface
{
    private CompanyLoader | null $companyLoader = null;

    /** @throws void */
    public function __construct(private readonly LoggerInterface $logger)
    {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function __invoke(): CompanyLoaderInterface
    {
        if (!$this->companyLoader instanceof CompanyLoader) {
            $this->companyLoader = new CompanyLoader(
                initData: new Data\Company(logger: $this->logger),
            );
        }

        return $this->companyLoader;
    }
}
