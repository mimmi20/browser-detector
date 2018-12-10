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

use BrowserDetector\Bits\Os as OsBits;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionInterface;
use Psr\Log\LoggerInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

final class PlatformLoader implements SpecificLoaderInterface
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
        $this->initData      = $initData;
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Os\OsInterface
     */
    public function __invoke(string $key, string $useragent = ''): OsInterface
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found');
        }

        $platformData = $this->initData->getItem($key);

        if (null === $platformData) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found');
        }

        $platformVersionClass = $platformData->version->class;

        if (!is_string($platformVersionClass) && isset($platformData->version->value) && is_numeric($platformData->version->value)) {
            $version = (new VersionFactory())->set((string) $platformData->version->value);
        } elseif (!is_string($platformVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $platformVersionClass) {
            $version = (new VersionFactory())->detectVersion($useragent, $platformData->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionDetectorInterface $versionClass */
            $versionClass = new $platformVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        $name          = $platformData->name;
        $marketingName = $platformData->marketingName;
        $manufacturer  = $this->companyLoader->load($platformData->manufacturer);

        if ('Mac OS X' === $name
            && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '10.12', '>=')
        ) {
            $name          = 'macOS';
            $marketingName = 'macOS';
        }

        $bits = (new OsBits($useragent))->getBits();

        return new Os($name, $marketingName, $manufacturer, $version, $bits);
    }
}
