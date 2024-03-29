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

use BrowserDetector\Loader\Helper\DataInterface;
use RuntimeException;
use stdClass;

use function assert;
use function is_string;

final class CompanyLoader implements CompanyLoaderInterface
{
    /** @throws RuntimeException */
    public function __construct(private readonly DataInterface $initData)
    {
        $initData();
    }

    /**
     * @return array{type: string, name: string|null, brandname: string|null}
     *
     * @throws NotFoundException
     */
    public function load(string $key): array
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        $companyData = $this->initData->getItem($key);

        if ($companyData === null) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        assert($companyData instanceof stdClass);
        assert(is_string($companyData->name) || $companyData->name === null);
        assert(is_string($companyData->brandname) || $companyData->brandname === null);

        return [
            'type' => $key,
            'name' => $companyData->name,
            'brandname' => $companyData->brandname,
        ];
    }
}
