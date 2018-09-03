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

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv;
use BrowserDetector\Loader\DeviceLoaderFactory;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;

/**
 * Device detection class
 */
class DeviceFactory implements DeviceFactoryInterface
{
    /**
     * @var Device\DarwinFactory
     */
    private $darwinFactory;

    /**
     * @var Device\MobileFactory
     */
    private $mobileFactory;

    /**
     * @var Device\TvFactory
     */
    private $tvFactory;

    /**
     * @var Device\DesktopFactory
     */
    private $desktopFactory;

    /**
     * @var DeviceLoaderFactory
     */
    private $loaderFactory;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->darwinFactory  = new Device\DarwinFactory($cache, $logger);
        $this->mobileFactory  = new Device\MobileFactory($cache, $logger);
        $this->tvFactory      = new Device\TvFactory($cache, $logger);
        $this->desktopFactory = new Device\DesktopFactory($cache, $logger);
        $this->loaderFactory  = new DeviceLoaderFactory($cache, $logger);
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $s = new Stringy($useragent);

        if (!$s->containsAny(['freebsd', 'raspbian'], false)
            && $s->containsAny(['darwin', 'cfnetwork'], false)
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
}
