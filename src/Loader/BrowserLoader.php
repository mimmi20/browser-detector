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

use BrowserDetector\Bits\Browser as BrowserBits;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaBrowserType\TypeLoader;
use UaResult\Browser\Browser;

final class BrowserLoader implements SpecificLoaderInterface
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
     * @var \UaBrowserType\TypeLoader
     */
    private $typeLoader;

    /**
     * @var \BrowserDetector\Loader\GenericLoaderInterface
     */
    private $engineLoader;

    /**
     * @var \BrowserDetector\Loader\Helper\Data
     */
    private $initData;

    /**
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \BrowserDetector\Loader\CompanyLoader          $companyLoader
     * @param \UaBrowserType\TypeLoader                      $typeLoader
     * @param \BrowserDetector\Loader\GenericLoaderInterface $engineLoader
     * @param \BrowserDetector\Loader\Helper\Data            $initData
     */
    public function __construct(
        LoggerInterface $logger,
        CompanyLoader $companyLoader,
        TypeLoader $typeLoader,
        GenericLoaderInterface $engineLoader,
        Data $initData
    ) {
        $this->logger        = $logger;
        $this->companyLoader = $companyLoader;
        $this->typeLoader    = $typeLoader;
        $this->engineLoader  = $engineLoader;
        $this->initData      = $initData;
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function __invoke(string $key, string $useragent = ''): array
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $browserData = $this->initData->getItem($key);

        if (null === $browserData) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $browserVersionClass = $browserData->version->class;
        $manufacturer        = $this->companyLoader->load($browserData->manufacturer);
        $type                = $this->typeLoader->load($browserData->type);

        if (!is_string($browserVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $browserVersionClass) {
            $version = (new VersionFactory())->detectVersion($useragent, $browserData->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionDetectorInterface $versionClass */
            $versionClass = new $browserVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        $bits      = (new BrowserBits($useragent))->getBits();
        $engineKey = $browserData->engine;
        $engine    = null;

        if (null !== $engineKey) {
            try {
                $this->engineLoader->init();
                $engine = $this->engineLoader->load($engineKey, $useragent);
            } catch (NotFoundException $e) {
                $this->logger->warning($e);
            }
        }

        $browser = new Browser($browserData->name, $manufacturer, $version, $type, $bits, $browserData->modus);

        return [$browser, $engine];
    }
}
