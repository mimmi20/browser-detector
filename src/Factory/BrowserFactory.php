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

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactoryInterface;
use Psr\Log\LoggerInterface;
use UaBrowserType\TypeLoaderInterface;
use UaBrowserType\Unknown;
use UaResult\Browser\Browser;
use UaResult\Browser\BrowserInterface;

final class BrowserFactory
{
    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @var \UaBrowserType\TypeLoaderInterface
     */
    private $typeLoader;

    /**
     * BrowserFactory constructor.
     *
     * @param \BrowserDetector\Loader\CompanyLoaderInterface   $companyLoader
     * @param \BrowserDetector\Version\VersionFactoryInterface $versionFactory
     * @param \UaBrowserType\TypeLoaderInterface               $typeLoader
     */
    public function __construct(
        CompanyLoaderInterface $companyLoader,
        VersionFactoryInterface $versionFactory,
        TypeLoaderInterface $typeLoader
    ) {
        $this->companyLoader  = $companyLoader;
        $this->versionFactory = $versionFactory;
        $this->typeLoader     = $typeLoader;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     * @param string                   $useragent
     *
     * @return \UaResult\Browser\BrowserInterface
     */
    public function fromArray(LoggerInterface $logger, array $data, string $useragent): BrowserInterface
    {
        $name  = array_key_exists('name', $data) ? $data['name'] : null;
        $modus = array_key_exists('modus', $data) ? $data['modus'] : null;
        $bits  = (new \BrowserDetector\Bits\Browser())->getBits($useragent);

        $type = new Unknown();
        if (array_key_exists('type', $data)) {
            try {
                $type = $this->typeLoader->load((string) $data['type']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $version      = $this->getVersion($data, $useragent);
        $manufacturer = $this->getCompany($logger, $data, $useragent, 'manufacturer');

        return new Browser($name, $manufacturer, $version, $type, $bits, $modus);
    }

    use VersionFactoryTrait;
    use CompanyFactoryTrait;
}
