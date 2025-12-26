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

use Override;
use RuntimeException;
use UaData\CompanyInterface;
use UaLoader\Exception\NotFoundException;
use UaResult\Company\Company;

final readonly class CompanyLoader implements CompanyLoaderInterface
{
    /**
     * @phpstan-param Data\DataInterface&Data\Company $initData
     *
     * @throws void
     */
    public function __construct(private Data\DataInterface $initData)
    {
        // nothing to do
    }

    /** @throws NotFoundException */
    #[Override]
    public function load(string $key): CompanyInterface
    {
        try {
            $this->initData->init();
        } catch (RuntimeException $e) {
            throw new NotFoundException('the company with key "' . $key . '" was not found', 0, $e);
        }

        $companyData = $this->initData->getItem($key);

        if ($companyData === null) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        return new Company(
            type: $key,
            name: $companyData->getName(),
            brandname: $companyData->getBrandname(),
        );
    }
}
