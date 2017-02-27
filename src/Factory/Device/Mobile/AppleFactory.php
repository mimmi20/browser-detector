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
class AppleFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general apple device';

        if (preg_match('/ipod/i', $useragent)) {
            $deviceCode = 'ipod touch';
        } elseif (preg_match('/ipad/i', $useragent)) {
            $deviceCode = 'ipad';
        } elseif (preg_match('/iph/i', $useragent)) {
            $deviceCode = 'iphone';
        } elseif (preg_match('/Puffin\/[\d\.]+IT/', $useragent)) {
            $deviceCode = 'ipad';
        } elseif (preg_match('/Puffin\/[\d\.]+IP/', $useragent)) {
            $deviceCode = 'iphone';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
