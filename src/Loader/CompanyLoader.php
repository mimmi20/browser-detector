<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\DataInterface;
use stdClass;
use UaResult\Company\Company;
use UaResult\Company\CompanyInterface;

use function assert;

final class CompanyLoader implements CompanyLoaderInterface
{
    private DataInterface $initData;

    public function __construct(DataInterface $initData)
    {
        $initData();

        $this->initData = $initData;
    }

    /**
     * @throws NotFoundException
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function load(string $key, string $useragent = ''): CompanyInterface
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        $companyData = $this->initData->getItem($key);

        if (null === $companyData) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        assert($companyData instanceof stdClass);

        return new Company(
            $key,
            $companyData->name,
            $companyData->brandname
        );
    }
}
