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
class DellFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general dell device';

        if (preg_match('/venue pro/i', $useragent)) {
            $deviceCode = 'venue pro';
        } elseif (preg_match('/venue 8 hspa\+/i', $useragent)) {
            $deviceCode = 'venue 8 hspa+';
        } elseif (preg_match('/venue 8 3830/i', $useragent)) {
            $deviceCode = 'venue 8 3830';
        } elseif (preg_match('/venue 7 hspa\+/i', $useragent)) {
            $deviceCode = 'venue 7 hspa+';
        } elseif (preg_match('/venue 7 3730/i', $useragent)) {
            $deviceCode = 'venue 7 3730';
        } elseif (preg_match('/venue/i', $useragent)) {
            $deviceCode = 'venue';
        } elseif (preg_match('/streak 10 pro/i', $useragent)) {
            $deviceCode = 'streak 10 pro';
        } elseif (preg_match('/streak 7/i', $useragent)) {
            $deviceCode = 'streak 7';
        } elseif (preg_match('/streak/i', $useragent)) {
            $deviceCode = 'streak';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
