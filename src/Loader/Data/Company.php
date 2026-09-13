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

namespace BrowserDetector\Loader\Data;

use BrowserDetector\Loader\InitData\Company as DataCompany;
use Override;
use RuntimeException;
use Symfony\Component\Yaml\Yaml;
use UnexpectedValueException;

use function array_key_exists;

final class Company implements DataInterface
{
    private const string DATA_PATH = __DIR__ . '/../../../data/companies/companies.yaml';

    /** @var array<string, DataCompany> */
    private array $items      = [];
    private bool $initialized = false;

    /** @throws void */
    public function __construct()
    {
        // nothing to do
    }

    /** @throws RuntimeException */
    #[Override]
    public function init(): void
    {
        if ($this->initialized) {
            return;
        }

        $fileData = Yaml::parseFile(self::DATA_PATH);

        foreach ($fileData as $key => $data) {
            $stringKey = (string) $key;

            if (array_key_exists($stringKey, $this->items)) {
                continue;
            }

            $this->items[$stringKey] = new DataCompany(
                name: $data['name'],
                brandname: $data['brandname'],
            );
        }

        $this->initialized = true;
    }

    /** @throws void */
    #[Override]
    public function getItem(string $stringKey): DataCompany | null
    {
        if (array_key_exists($stringKey, $this->items)) {
            return $this->items[$stringKey];
        }

        try {
            $company = \BrowserDetector\Data\Company::fromName($stringKey);

            $data = new DataCompany(
                name: $company->getName(),
                brandname: $company->getBrandname(),
            );

            $this->items[$stringKey] = $data;
        } catch (UnexpectedValueException) {
            // do nothing
        }

        return $this->items[$stringKey] ?? null;
    }
}
