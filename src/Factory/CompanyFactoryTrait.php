<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use UaResult\Company\CompanyInterface;

trait CompanyFactoryTrait
{
    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @param array  $data
     * @param string $useragent
     * @param string $field
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Company\CompanyInterface
     */
    private function getCompany(array $data, string $useragent, string $field): CompanyInterface
    {
        $companyLoader = $this->companyLoader;
        $manufacturer  = $companyLoader->load('unknown', $useragent);

        if (!array_key_exists($field, $data)) {
            return $manufacturer;
        }

        return $companyLoader->load($data[$field], $useragent);
    }
}
