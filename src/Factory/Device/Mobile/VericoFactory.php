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
class VericoFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general verico device';

        if (preg_match('/KM\-UQM11A/', $useragent)) {
            $deviceCode = 'uqm11a';
        } elseif (preg_match('/RP\-UDM02A/', $useragent)) {
            $deviceCode = 'rp-udm02a';
        } elseif (preg_match('/RP\-UDM01A/', $useragent)) {
            $deviceCode = 'rp-udm01a';
        } elseif (preg_match('/UQ785\-M1BGV/', $useragent)) {
            $deviceCode = 'm1bgv';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
