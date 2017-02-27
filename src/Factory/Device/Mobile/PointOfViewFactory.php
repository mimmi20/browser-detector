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
class PointOfViewFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general point of view device';

        if (preg_match('/TAB\-PROTAB25/', $useragent)) {
            $deviceCode = 'protab 25';
        } elseif (preg_match('/TAB\-PROTAB30/', $useragent)) {
            $deviceCode = 'protab 3 xxl';
        } elseif (preg_match('/tab\-protab2xxl/i', $useragent)) {
            $deviceCode = 'protab 2 xxl';
        } elseif (preg_match('/TAB\-PROTAB2XL/', $useragent)) {
            $deviceCode = 'protab 2 xl';
        } elseif (preg_match('/TAB\-PROTAB2\-IPS/', $useragent)) {
            $deviceCode = 'protab 2 ips';
        } elseif (preg_match('/PI1045/', $useragent)) {
            $deviceCode = 'pi1045';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
