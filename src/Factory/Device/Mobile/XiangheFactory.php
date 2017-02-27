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
class XiangheFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general xianghe device';

        if (preg_match('/iphone[ ]?6c/i', $useragent)) {
            $deviceCode = 'iphone 6c';
        } elseif (preg_match('/iphone[ ]?5c/i', $useragent)) {
            $deviceCode = 'iphone 5c';
        } elseif (preg_match('/iphone[ ]?5/i', $useragent)) {
            $deviceCode = 'iphone 5';
        } elseif (preg_match('/iphone/i', $useragent)) {
            $deviceCode = 'xianghe iphone';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
