<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use BrowserDetector\Loader\NotFoundException;
use Psr\Log\LoggerInterface;
use UaResult\Company\CompanyInterface;

trait CompanyFactoryTrait
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     * @param string                   $field
     *
     * @return \UaResult\Company\CompanyInterface
     */
    private function getCompany(LoggerInterface $logger, array $data, string $field): CompanyInterface
    {
        $companyLoader = $this->companyLoader;
        $manufacturer  = $companyLoader('Unknown');

        if (array_key_exists($field, $data)) {
            try {
                $manufacturer = $companyLoader($data[$field]);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        return $manufacturer;
    }
}
