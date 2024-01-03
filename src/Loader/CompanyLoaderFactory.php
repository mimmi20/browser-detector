<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use RuntimeException;

final class CompanyLoaderFactory implements CompanyLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/companies';

    private CompanyLoader | null $loader = null;

    /** @throws RuntimeException */
    public function __invoke(): CompanyLoaderInterface
    {
        if ($this->loader === null) {
            $this->loader = new CompanyLoader(
                initData: new Data(self::DATA_PATH, 'json'),
            );
        }

        return $this->loader;
    }
}
