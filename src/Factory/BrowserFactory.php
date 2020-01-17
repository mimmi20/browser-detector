<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
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
use UaResult\Company\Company;

final class BrowserFactory
{
    /**
     * @var \UaBrowserType\TypeLoaderInterface
     */
    private $typeLoader;

    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

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
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return \UaResult\Browser\BrowserInterface
     */
    public function fromArray(LoggerInterface $logger, array $data, string $useragent): BrowserInterface
    {
        assert(array_key_exists('name', $data), '"name" property is required');
        assert(array_key_exists('manufacturer', $data), '"manufacturer" property is required');
        assert(array_key_exists('version', $data), '"version" property is required');
        assert(array_key_exists('type', $data), '"type" property is required');
        assert(array_key_exists('bits', $data), '"bits" property is required');
        assert(array_key_exists('modus', $data), '"modus" property is required');

        $name  = $data['name'];
        $modus = $data['modus'];
        $bits  = $data['bits'];

        $type = new Unknown();
        try {
            $type = $this->typeLoader->load((string) $data['type']);
        } catch (NotFoundException $e) {
            $logger->info($e);
        }

        $version = $this->getVersion($data, $useragent, $logger);

        try {
            $manufacturer = $this->companyLoader->load($data['manufacturer'], $useragent);
        } catch (NotFoundException $e) {
            $logger->info($e);

            $manufacturer = new Company(
                'unknown',
                null,
                null
            );
        }

        return new Browser($name, $manufacturer, $version, $type, $bits, $modus);
    }

    use VersionFactoryTrait;
}
