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
use stdClass;
use UaLoader\Exception\NotFoundException;
use UaResult\Company\Company;

use function assert;
use function is_string;

final readonly class CompanyLoader implements CompanyLoaderInterface
{
    /** @throws RuntimeException */
    public function __construct(private DataInterface $initData)
    {
        $initData();
    }

    /** @throws NotFoundException */
    #[Override]
    public function load(string $key): Company
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        $companyData = $this->initData->getItem($key);

        if ($companyData === null) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        assert($companyData instanceof stdClass);
        assert(
            is_string($companyData->name) || $companyData->name === null,
            '"name" property is required',
        );
        assert(
            is_string($companyData->brandname) || $companyData->brandname === null,
            '"brandname" property is required',
        );

        return new Company(type: $key, name: $companyData->name, brandname: $companyData->brandname);
    }
}
