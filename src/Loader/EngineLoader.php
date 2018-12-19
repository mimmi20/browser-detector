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

use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaResult\Engine\EngineInterface;

final class EngineLoader implements SpecificLoaderInterface
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
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \BrowserDetector\Loader\Helper\DataInterface   $initData
     * @param \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader
     */
    public function __construct(
        LoggerInterface $logger,
        DataInterface $initData,
        CompanyLoaderInterface $companyLoader
    ) {
        $this->logger        = $logger;
        $this->companyLoader = $companyLoader;

        $initData();

        $this->initData = $initData;
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function __invoke(string $key, string $useragent = ''): EngineInterface
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found');
        }

        $engineData = $this->initData->getItem($key);

        if (null === $engineData) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found');
        }

        return (new EngineFactory($this->companyLoader, new VersionFactory()))->fromArray($this->logger, (array) $engineData, $useragent);
    }
}
