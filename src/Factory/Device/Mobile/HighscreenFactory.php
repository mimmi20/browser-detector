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
class HighscreenFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general highscreen device';

        if (preg_match('/Zera[ \_]F/', $useragent)) {
            $deviceCode = 'zera f';
        } elseif (preg_match('/prime s/i', $useragent)) {
            $deviceCode = 'omega prime s';
        } elseif (preg_match('/ice2/i', $useragent)) {
            $deviceCode = 'ice 2';
        } elseif (preg_match('/explosion/i', $useragent)) {
            $deviceCode = 'explosion';
        } elseif (preg_match('/boost iise/i', $useragent)) {
            $deviceCode = 'boost ii se';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
