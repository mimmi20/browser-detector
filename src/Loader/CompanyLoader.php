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
namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\DataInterface;
use Psr\Log\LoggerInterface;
use UaResult\Company\Company;
use UaResult\Company\CompanyInterface;

final class CompanyLoader implements SpecificLoaderInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Loader\Helper\DataInterface
     */
    private $initData;

    /**
     * @param \Psr\Log\LoggerInterface                     $logger
     * @param \BrowserDetector\Loader\Helper\DataInterface $initData
     */
    public function __construct(
        LoggerInterface $logger,
        DataInterface $initData
    ) {
        $this->logger = $logger;

        $initData();

        $this->initData = $initData;
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Company\CompanyInterface
     */
    public function __invoke(string $key, string $useragent = ''): CompanyInterface
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        $companyData = $this->initData->getItem($key);

        if (null === $companyData) {
            throw new NotFoundException('the company with key "' . $key . '" was not found');
        }

        return new Company(
            $key,
            $companyData->name,
            $companyData->brandname
        );
    }
}
