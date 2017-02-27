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
class ZopoFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general zopo device';

        if (preg_match('/ZP980/', $useragent)) {
            $deviceCode = 'zp980';
        } elseif (preg_match('/ZP950\+/', $useragent)) {
            $deviceCode = 'zp950+';
        } elseif (preg_match('/ZP950/', $useragent)) {
            $deviceCode = 'zp950';
        } elseif (preg_match('/ZP9(10|00H)/', $useragent)) {
            $deviceCode = 'zp910';
        } elseif (preg_match('/ZP900/', $useragent)) {
            $deviceCode = 'zp900';
        } elseif (preg_match('/ZP8(10|00H)/', $useragent)) {
            $deviceCode = 'zp810';
        } elseif (preg_match('/ZP500/', $useragent)) {
            $deviceCode = 'zp500';
        } elseif (preg_match('/ZP300/', $useragent)) {
            $deviceCode = 'zp300';
        } elseif (preg_match('/ZP200/', $useragent)) {
            $deviceCode = 'zp200';
        } elseif (preg_match('/ZP100/', $useragent)) {
            $deviceCode = 'zp100';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
