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
namespace BrowserDetector\Factory;

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\NotFoundException;
use Psr\Log\LoggerInterface;
use UaDeviceType\TypeLoader;
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
     * @var \BrowserDetector\Loader\CompanyLoader
     */
    private $companyLoader;

    /**
     * BrowserFactory constructor.
     *
     * @param \BrowserDetector\Loader\CompanyLoader $companyLoader
     */
    public function __construct(CompanyLoader $companyLoader)
    {
        $this->companyLoader = $companyLoader;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function fromArray(LoggerInterface $logger, array $data): DeviceInterface
    {
        $deviceName      = array_key_exists('deviceName', $data) && !empty($data['deviceName']) ? (string) $data['deviceName'] : null;
        $marketingName   = array_key_exists('marketingName', $data) && !empty($data['marketingName']) ? (string) $data['marketingName'] : null;
        $dualOrientation = array_key_exists('dualOrientation', $data) ? (bool) $data['dualOrientation'] : false;
        $simCount        = array_key_exists('simCount', $data) ? (int) $data['simCount'] : 0;
        $connections     = array_key_exists('connections', $data) ? (array) $data['connections'] : [];

        $type = new Unknown();
        if (array_key_exists('type', $data)) {
            try {
                $type = (new TypeLoader())->load((string) $data['type']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $companyLoader = $this->companyLoader;

        $manufacturer = $companyLoader('Unknown');
        if (array_key_exists('manufacturer', $data)) {
            try {
                $manufacturer = $companyLoader((string) $data['manufacturer']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $brand = $companyLoader('Unknown');
        if (array_key_exists('brand', $data)) {
            try {
                $brand = $companyLoader((string) $data['brand']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $display = new Display(null, null, null, new \UaDisplaySize\Unknown(), null);
        if (array_key_exists('display', $data)) {
            try {
                $display = (new DisplayFactory())->fromArray($logger, (array) $data['display']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $market = new Market([], [], []);
        if (array_key_exists('market', $data)) {
            try {
                $market = (new MarketFactory())->fromArray($logger, (array) $data['market']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        return new Device($deviceName, $marketingName, $manufacturer, $brand, $type, $display, $dualOrientation, $simCount, $market, $connections);
    }
}
