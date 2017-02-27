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
class OvermaxFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general overmax device';

        if (preg_match('/SteelCore\-B/', $useragent)) {
            $deviceCode = 'steelcore';
        } elseif (preg_match('/Solution 10II/', $useragent)) {
            $deviceCode = 'solution 10 ii 3g';
        } elseif (preg_match('/Solution 7III/', $useragent)) {
            $deviceCode = 'solution 7 iii';
        } elseif (preg_match('/Quattor 10\+/', $useragent)) {
            $deviceCode = 'quattor 10+';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
