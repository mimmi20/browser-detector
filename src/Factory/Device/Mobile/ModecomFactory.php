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
class ModecomFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general modecom device';

        if (preg_match('/FreeTAB 9702 HD X4/', $useragent)) {
            $deviceCode = 'freetab 9702 hd x4';
        } elseif (preg_match('/FreeTAB 9000 IPS IC/', $useragent)) {
            $deviceCode = 'freetab 9000 ips ic';
        } elseif (preg_match('/FreeTAB 8001 IPS X2 3G\+/', $useragent)) {
            $deviceCode = 'freetab 8001 ips x2 3g+';
        } elseif (preg_match('/FreeTAB 7800 IPS IC/', $useragent)) {
            $deviceCode = 'freetab 7800 ips ic';
        } elseif (preg_match('/FreeTAB 7001 HD IC/', $useragent)) {
            $deviceCode = 'freetab 7001 hd ic';
        } elseif (preg_match('/FreeTAB 1014 IPS X4 3G\+/', $useragent)) {
            $deviceCode = 'freetab 1014 ips x4 3g+';
        } elseif (preg_match('/FreeTAB 1001/', $useragent)) {
            $deviceCode = 'freetab 1001';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
