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
class BluFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general blu device';

        if (preg_match('/VIVO IV/', $useragent)) {
            $deviceCode = 'vivo iv';
        } elseif (preg_match('/studio 5\.5/i', $useragent)) {
            $deviceCode = 'studio 5.5';
        } elseif (preg_match('/Studio 5\.0 S II/', $useragent)) {
            $deviceCode = 'studio 5.0 s ii';
        } elseif (preg_match('/WIN HD W510u/', $useragent)) {
            $deviceCode = 'win hd w510u';
        } elseif (preg_match('/WIN HD LTE/', $useragent)) {
            $deviceCode = 'win hd lte';
        } elseif (preg_match('/WIN JR W410a/', $useragent)) {
            $deviceCode = 'win jr w410a';
        } elseif (preg_match('/WIN JR LTE/', $useragent)) {
            $deviceCode = 'win jr lte';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
