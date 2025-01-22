<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\InitData\Company as DataCompany;
use Laminas\Hydrator\ArraySerializableHydrator;
use Laminas\Hydrator\Exception\InvalidArgumentException;
use Laminas\Hydrator\Strategy\CollectionStrategy;
use Laminas\Hydrator\Strategy\StrategyChain;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;
use RuntimeException;

final class CompanyLoaderFactory implements CompanyLoaderFactoryInterface
{
    private CompanyLoader | null $loader = null;

    /** @throws RuntimeException */
    #[Override]
    public function __invoke(StrategyInterface $strategy): CompanyLoaderInterface
    {
        if ($this->loader === null) {
            try {
                $this->loader = new CompanyLoader(
                    initData: new Data\Company(
                        strategy: new StrategyChain(
                            [
                                new CollectionStrategy(
                                    new ArraySerializableHydrator(),
                                    DataCompany::class,
                                ),
                                $strategy,
                            ],
                        ),
                    ),
                );
            } catch (InvalidArgumentException $e) {
                throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
            }
        }

        return $this->loader;
    }
}
