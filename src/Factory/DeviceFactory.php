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
use UaResult\Device\Display;

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
        $deviceName    = array_key_exists('deviceName', $data) && !empty($data['deviceName']) ? $data['deviceName'] : null;
        $marketingName = array_key_exists('marketingName', $data) && !empty($data['marketingName']) ? $data['marketingName'] : null;

        $type = new Unknown();
        if (array_key_exists('type', $data)) {
            try {
                $type = $this->typeLoader->load((string) $data['type']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        try {
            $manufacturer = $this->getCompany($data, $useragent, 'manufacturer');
        } catch (NotFoundException $e) {
            $logger->info($e);

            $manufacturer = new Company(
                'unknown',
                null,
                null
            );
        }

        try {
            $brand = $this->getCompany($data, $useragent, 'brand');
        } catch (NotFoundException $e) {
            $logger->info($e);

            $brand = new Company(
                'unknown',
                null,
                null
            );
        }

        $display = new Display(null, new \UaDisplaySize\Unknown(), null);
        if (array_key_exists('display', $data)) {
            $display = $this->displayFactory->fromArray($logger, (array) $data['display']);
        }

        return new Device($deviceName, $marketingName, $manufacturer, $brand, $type, $display);
    }

    use CompanyFactoryTrait;
}
