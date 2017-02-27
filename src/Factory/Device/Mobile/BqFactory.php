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
class BqFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general bq device';

        if (preg_match('/Aquaris E5 HD/', $useragent)) {
            $deviceCode = 'aquaris e5 hd';
        } elseif (preg_match('/Aquaris M10/', $useragent)) {
            $deviceCode = 'aquaris m10';
        } elseif (preg_match('/Aquaris M5/', $useragent)) {
            $deviceCode = 'aquaris m5';
        } elseif (preg_match('/Aquaris[ _]M4\.5/', $useragent)) {
            $deviceCode = 'aquaris m4.5';
        } elseif (preg_match('/Aquaris 5 HD/', $useragent)) {
            $deviceCode = 'aquaris e5';
        } elseif (preg_match('/7056G/', $useragent)) {
            $deviceCode = '7056g';
        } elseif (preg_match('/BQS\-4007/', $useragent)) {
            $deviceCode = 'bqs-4007';
        } elseif (preg_match('/BQS\-4005/', $useragent)) {
            $deviceCode = 'bqs-4005';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
