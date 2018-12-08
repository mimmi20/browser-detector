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

use BrowserDetector\Factory\Device\DarwinFactory;
use BrowserDetector\Factory\Device\DesktopFactory;
use BrowserDetector\Factory\Device\MobileFactory;
use BrowserDetector\Factory\Device\TvFactory;
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
class DeviceFactory implements DeviceFactoryInterface
{
    /**
     * @var \BrowserDetector\Factory\Device\DarwinFactory
     */
    private $darwinFactory;

    /**
     * @var \BrowserDetector\Factory\Device\MobileFactory
     */
    private $mobileFactory;

    /**
     * @var \BrowserDetector\Factory\Device\TvFactory
     */
    private $tvFactory;

    /**
     * @var \BrowserDetector\Factory\Device\DesktopFactory
     */
    private $desktopFactory;

    /**
     * @var DeviceLoaderFactory
     */
    private $loaderFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->darwinFactory  = new DarwinFactory($logger);
        $this->mobileFactory  = new MobileFactory($logger);
        $this->tvFactory      = new TvFactory($logger);
        $this->desktopFactory = new DesktopFactory($logger);
        $this->loaderFactory  = new DeviceLoaderFactory($logger);

        $this->logger = $logger;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $s = new Stringy($useragent);

        $unknownDevices = [
            'new-sogou-spider',
            'zollard',
            'socialradarbot',
            'microsoft office protocol discovery',
            'powermarks',
            'archivebot',
            'marketwirebot',
            'microsoft-cryptoapi',
            'pad-bot',
            'james bot',
            'winhttp',
            'jobboerse',
            '<',
            '>',
            'online-versicherungsportal.info',
            'versicherungssuchmaschine.net',
            'microsearch',
            'microsoft data access',
            'microsoft url control',
            'infegyatlas',
            'msie or firefox mutant',
            'semantic-visions.com crawler',
            'labs.topsy.com/butterfly',
            'dolphin http client',
            'google wireless transcoder',
            'commoncrawler',
            'ipodder',
            'tripadvisor',
            'nokia wap gateway',
        ];

        if ($s->containsAny($unknownDevices, false)) {
            $loaderFactory = $this->loaderFactory;
            $loader        = $loaderFactory('unknown', 'unknown');

            return $loader($useragent);
        }

        if (!preg_match('/freebsd|raspbian/i', $useragent)
            && preg_match('/darwin|cfnetwork/i', $useragent)
        ) {
            $factory = $this->darwinFactory;

            return $factory($useragent);
        }

        if ((new MobileDevice($s))->isMobile()) {
            $factory = $this->mobileFactory;

            return $factory($useragent);
        }

        if ((new Tv($s))->isTvDevice()) {
            $factory = $this->tvFactory;

            return $factory($useragent);
        }

        if ((new Desktop($s))->isDesktopDevice()) {
            $factory = $this->desktopFactory;

            return $factory($useragent);
        }

        $loaderFactory = $this->loaderFactory;
        $loader        = $loaderFactory('unknown', 'unknown');

        return $loader($useragent);
    }

    /**
     * @param array                    $data
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function fromArray(array $data): DeviceInterface
    {
        $deviceName       = array_key_exists('deviceName', $data) ? (string) $data['deviceName'] : null;
        $marketingName    = array_key_exists('marketingName', $data) ? (string) $data['marketingName'] : null;
        $dualOrientation  = array_key_exists('dualOrientation', $data) ? (bool) $data['dualOrientation'] : false;
        $simCount         = array_key_exists('simCount', $data) ? (int) $data['simCount'] : 0;

        $type = new Unknown();
        if (array_key_exists('type', $data)) {
            try {
                $type = (new TypeLoader())->load((string) $data['type']);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $manufacturer = CompanyLoader::getInstance()->load('Unknown');
        if (array_key_exists('manufacturer', $data)) {
            try {
                $manufacturer = CompanyLoader::getInstance()->load((string) $data['manufacturer']);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $brand = CompanyLoader::getInstance()->load('Unknown');
        if (array_key_exists('brand', $data)) {
            try {
                $brand = CompanyLoader::getInstance()->load((string) $data['brand']);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $display = new Display(null, null, null, new \UaDisplaySize\Unknown(), null);
        if (array_key_exists('display', $data)) {
            try {
                $display = (new DisplayFactory())->fromArray($this->logger, (array) $data['display']);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        return new Device($deviceName, $marketingName, $manufacturer, $brand, $type, $display, $dualOrientation, $simCount);
    }
}
