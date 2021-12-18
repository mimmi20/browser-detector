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

final class CompanyLoaderFactory implements CompanyLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/companies';

    private ?CompanyLoader $loader = null;

    public function __invoke(): CompanyLoaderInterface
    {
        if (null === $this->loader) {
            $this->loader = new CompanyLoader(
                new Data(self::DATA_PATH, 'json')
            );
        }

        return $this->loader;
    }
}
