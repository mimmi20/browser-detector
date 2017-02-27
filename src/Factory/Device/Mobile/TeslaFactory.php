<?php


namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TeslaFactory implements Factory\FactoryInterface
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
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return array
     */
    public function detect($useragent)
    {
        $deviceCode = 'general tesla device';

        if (preg_match('/TTL7/', $useragent)) {
            $deviceCode = 'ttl7';
        } elseif (preg_match('/TTH7/', $useragent)) {
            $deviceCode = 'tth7';
        } elseif (preg_match('/Tablet_785/', $useragent)) {
            $deviceCode = 'tablet 785';
        } elseif (preg_match('/Tablet_L7_3G/', $useragent)) {
            $deviceCode = 'tablet l7 3g';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
