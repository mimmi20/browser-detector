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

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

final class EngineLoader implements SpecificLoaderInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Loader\CompanyLoader
     */
    private $companyLoader;

    /**
     * @var \BrowserDetector\Loader\Helper\Data
     */
    private $initData;

    /**
     * @param \Psr\Log\LoggerInterface              $logger
     * @param \BrowserDetector\Loader\CompanyLoader $companyLoader
     * @param \BrowserDetector\Loader\Helper\Data   $initData
     */
    public function __construct(
        LoggerInterface $logger,
        CompanyLoader $companyLoader,
        Data $initData
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

        $engineVersionClass = $engineData->version->class;
        $manufacturer       = $this->companyLoader->load($engineData->manufacturer);

        if (!is_string($engineVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $engineVersionClass) {
            $version = (new VersionFactory())->detectVersion($useragent, $engineData->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionDetectorInterface $versionClass */
            $versionClass = new $engineVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        return new Engine(
            $engineData->name,
            $manufacturer,
            $version
        );
    }
}
