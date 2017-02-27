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
class PhilipsFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general philips device';

        if (preg_match('/W8510/', $useragent)) {
            $deviceCode = 'w8510';
        } elseif (preg_match('/W8500/', $useragent)) {
            $deviceCode = 'w8500';
        } elseif (preg_match('/W3509/', $useragent)) {
            $deviceCode = 'w3509';
        } elseif (preg_match('/W336/', $useragent)) {
            $deviceCode = 'w336';
        } elseif (preg_match('/PI3210G/', $useragent)) {
            $deviceCode = 'pi3210g';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
