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
use Psr\Log\LoggerInterface;
use UaDeviceType\TypeLoaderInterface;
use UaDeviceType\Unknown;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\DeviceInterface;

/**
 * Device detection class
 */
final class DeviceFactory
{
    /**
     * @var \UaDeviceType\TypeLoaderInterface
     */
    private $typeLoader;

    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @var \BrowserDetector\Factory\DisplayFactoryInterface
     */
    private $displayFactory;

    /**
     * BrowserFactory constructor.
     *
     * @param \BrowserDetector\Loader\CompanyLoaderInterface   $companyLoader
     * @param \UaDeviceType\TypeLoaderInterface                $typeLoader
     * @param \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory
     */
    public function __construct(
        CompanyLoaderInterface $companyLoader,
        TypeLoaderInterface $typeLoader,
        DisplayFactoryInterface $displayFactory
    ) {
        $this->companyLoader  = $companyLoader;
        $this->typeLoader     = $typeLoader;
        $this->displayFactory = $displayFactory;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     * @param string                   $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function fromArray(LoggerInterface $logger, array $data, string $useragent): DeviceInterface
    {
        assert(array_key_exists('deviceName', $data), '"deviceName" property is required');
        assert(array_key_exists('marketingName', $data), '"marketingName" property is required');
        assert(array_key_exists('manufacturer', $data), '"manufacturer" property is required');
        assert(array_key_exists('brand', $data), '"brand" property is required');
        assert(array_key_exists('type', $data), '"type" property is required');
        assert(array_key_exists('display', $data), '"display" property is required');

        $deviceName    = null !== $data['deviceName'] && '' !== $data['deviceName'] ? $data['deviceName'] : null;
        $marketingName = null !== $data['marketingName'] && '' !== $data['marketingName'] ? $data['marketingName'] : null;

        $type = new Unknown();
        try {
            $type = $this->typeLoader->load((string) $data['type']);
        } catch (NotFoundException $e) {
            $logger->info($e);
        }

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

        try {
            $brand = $this->companyLoader->load($data['brand'], $useragent);
        } catch (NotFoundException $e) {
            $logger->info($e);

            $brand = new Company(
                'unknown',
                null,
                null
            );
        }

        $display = $this->displayFactory->fromArray($logger, (array) $data['display']);

        return new Device($deviceName, $marketingName, $manufacturer, $brand, $type, $display);
    }
}
