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
class ExplayFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general explay device';

        if (preg_match('/surfer 7\.34/i', $useragent)) {
            $deviceCode = 'surfer 7.34 3g';
        } elseif (preg_match('/m1\_plus/i', $useragent)) {
            $deviceCode = 'm1 plus';
        } elseif (preg_match('/d7\.2 3g/i', $useragent)) {
            $deviceCode = 'd7.2 3g';
        } elseif (preg_match('/art 3g/i', $useragent)) {
            $deviceCode = 'art 3g';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
