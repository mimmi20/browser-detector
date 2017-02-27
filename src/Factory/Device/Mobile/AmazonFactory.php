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
class AmazonFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general amazon device';

        if (preg_match('/kftt/i', $useragent)) {
            $deviceCode = 'kftt';
        } elseif (preg_match('/kfthwi/i', $useragent)) {
            $deviceCode = 'kfthwi';
        } elseif (preg_match('/kfsowi/i', $useragent)) {
            $deviceCode = 'kfsowi';
        } elseif (preg_match('/kfot/i', $useragent)) {
            $deviceCode = 'kfot';
        } elseif (preg_match('/kfjwi/i', $useragent)) {
            $deviceCode = 'kfjwi';
        } elseif (preg_match('/kfjwa/i', $useragent)) {
            $deviceCode = 'kfjwa';
        } elseif (preg_match('/kfaswi/i', $useragent)) {
            $deviceCode = 'kfaswi';
        } elseif (preg_match('/kfapwi/i', $useragent)) {
            $deviceCode = 'kfapwi';
        } elseif (preg_match('/kfapwa/i', $useragent)) {
            $deviceCode = 'kfapwa';
        } elseif (preg_match('/sd4930ur/i', $useragent)) {
            $deviceCode = 'sd4930ur';
        } elseif (preg_match('/kindle fire/i', $useragent)) {
            $deviceCode = 'd01400';
        } elseif (preg_match('/(kindle|silk)/i', $useragent)) {
            $deviceCode = 'kindle';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
