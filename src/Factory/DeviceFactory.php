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
use UaResult\Device\Device;
use UaResult\Device\DeviceInterface;
use UaResult\Device\Display;
use UaResult\Device\Market;

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
     * @var \BrowserDetector\Factory\MarketFactoryInterface
     */
    private $marketFactory;

    /**
     * BrowserFactory constructor.
     *
     * @param \BrowserDetector\Loader\CompanyLoaderInterface   $companyLoader
     * @param \UaDeviceType\TypeLoaderInterface                $typeLoader
     * @param \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory
     * @param \BrowserDetector\Factory\MarketFactoryInterface  $marketFactory
     */
    public function __construct(
        CompanyLoaderInterface $companyLoader,
        TypeLoaderInterface $typeLoader,
        DisplayFactoryInterface $displayFactory,
        MarketFactoryInterface $marketFactory
    ) {
        $this->companyLoader  = $companyLoader;
        $this->typeLoader     = $typeLoader;
        $this->displayFactory = $displayFactory;
        $this->marketFactory  = $marketFactory;
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
        $deviceName      = array_key_exists('deviceName', $data) && !empty($data['deviceName']) ? $data['deviceName'] : null;
        $marketingName   = array_key_exists('marketingName', $data) && !empty($data['marketingName']) ? $data['marketingName'] : null;
        $dualOrientation = array_key_exists('dualOrientation', $data) ? (bool) $data['dualOrientation'] : false;
        $simCount        = array_key_exists('simCount', $data) ? (int) $data['simCount'] : 0;
        $connections     = array_key_exists('connections', $data) ? (array) $data['connections'] : [];

        $type = new Unknown();
        if (array_key_exists('type', $data)) {
            try {
                $type = $this->typeLoader->load((string) $data['type']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $manufacturer = $this->getCompany($logger, $data, $useragent, 'manufacturer');
        $brand        = $this->getCompany($logger, $data, $useragent, 'brand');

        $display = new Display(null, null, null, new \UaDisplaySize\Unknown(), null);
        if (array_key_exists('display', $data)) {
            try {
                $display = $this->displayFactory->fromArray($logger, (array) $data['display']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $market = new Market([], [], []);
        if (array_key_exists('market', $data)) {
            try {
                $market = $this->marketFactory->fromArray((array) $data['market']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        return new Device($deviceName, $marketingName, $manufacturer, $brand, $type, $display, $dualOrientation, $simCount, $market, $connections);
    }

    use CompanyFactoryTrait;
}
