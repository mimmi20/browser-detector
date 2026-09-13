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

use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;

final class CompanyLoaderFactory implements CompanyLoaderFactoryInterface
{
    private CompanyLoader | null $companyLoader = null;

    /** @throws void */
    #[Override]
    public function __invoke(): CompanyLoaderInterface
    {
        if (!$this->companyLoader instanceof CompanyLoader) {
            $this->companyLoader = new CompanyLoader(
                initData: new Data\Company(),
            );
        }

        return $this->companyLoader;
    }
}
