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

use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Loader\NotFoundException;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;
use UaDeviceType\TypeLoader;
use UaDeviceType\Unknown;
use UaResult\Device\Device;
use UaResult\Device\DeviceInterface;
use UaResult\Device\Display;

/**
 * Device detection class
 */
final class DeviceFactory
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array $data
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function fromArray(LoggerInterface $logger, array $data): DeviceInterface
    {
        $deviceName      = array_key_exists('deviceName', $data) ? (string) $data['deviceName'] : null;
        $marketingName   = array_key_exists('marketingName', $data) ? (string) $data['marketingName'] : null;
        $dualOrientation = array_key_exists('dualOrientation', $data) ? (bool) $data['dualOrientation'] : false;
        $simCount        = array_key_exists('simCount', $data) ? (int) $data['simCount'] : 0;

        $type = new Unknown();
        if (array_key_exists('type', $data)) {
            try {
                $type = (new TypeLoader())->load((string) $data['type']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $manufacturer = CompanyLoader::getInstance()->load('Unknown');
        if (array_key_exists('manufacturer', $data)) {
            try {
                $manufacturer = CompanyLoader::getInstance()->load((string) $data['manufacturer']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $brand = CompanyLoader::getInstance()->load('Unknown');
        if (array_key_exists('brand', $data)) {
            try {
                $brand = CompanyLoader::getInstance()->load((string) $data['brand']);
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

        return new Device($deviceName, $marketingName, $manufacturer, $brand, $type, $display, $dualOrientation, $simCount);
    }
}
