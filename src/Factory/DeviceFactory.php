<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv as TvHelper;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;

/**
 * Device detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DeviceFactory implements FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @return array
     */
    public function detect($useragent)
    {
        $s = new Stringy($useragent);

        if (!$s->containsAny(['freebsd', 'raspbian'], false)
            && $s->containsAny(['darwin', 'cfnetwork'], false)
        ) {
            return (new Device\DarwinFactory($this->cache, $this->loader))->detect($useragent);
        }

        if ((new MobileDevice($useragent))->isMobile()) {
            return (new Device\MobileFactory($this->cache, $this->loader))->detect($useragent);
        }

        if ((new TvHelper($useragent))->isTvDevice()) {
            return (new Device\TvFactory($this->cache, $this->loader))->detect($useragent);
        }

        if ((new Desktop($useragent))->isDesktopDevice()) {
            return (new Device\DesktopFactory($this->cache, $this->loader))->detect($useragent);
        }

        return $this->loader->load('unknown', $useragent);
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function fromArray(LoggerInterface $logger, array $data)
    {
        return (new \UaResult\Device\DeviceFactory())->fromArray($this->cache, $logger, $data);
    }
}
