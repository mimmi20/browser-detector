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
use BrowserDetector\Helper\Tv as TvHelper;
use BrowserDetector\Loader\DeviceLoaderFactory;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;

/**
 * Device detection class
 */
class DeviceFactory implements DeviceFactoryInterface
{
    /**
     * @var \BrowserDetector\Cache\CacheInterface
     */
    private $cache;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $s = new Stringy($useragent);

        if (!$s->containsAny(['freebsd', 'raspbian'], false)
            && $s->containsAny(['darwin', 'cfnetwork'], false)
        ) {
            $factory = new Device\DarwinFactory($this->cache, $this->logger);

            return $factory($useragent);
        }

        if ((new MobileDevice($s))->isMobile()) {
            $factory = new Device\MobileFactory($this->cache, $this->logger);

            return $factory($useragent);
        }

        if ((new TvHelper($s))->isTvDevice()) {
            $factory = new Device\TvFactory($this->cache, $this->logger);

            return $factory($useragent);
        }

        if ((new Desktop($s))->isDesktopDevice()) {
            $factory = new Device\DesktopFactory($this->cache, $this->logger);

            return $factory($useragent);
        }

        $loaderFactory = new DeviceLoaderFactory($this->cache, $this->logger);
        $loader        = $loaderFactory('unknown', 'unknown');

        return $loader($useragent);
    }
}
