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
class FlyFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general fly device';

        if (preg_match('/IQ4504/', $useragent)) {
            $deviceCode = 'iq4504';
        } elseif (preg_match('/IQ4502/', $useragent)) {
            $deviceCode = 'iq4502';
        } elseif (preg_match('/IQ4415/', $useragent)) {
            $deviceCode = 'iq4415';
        } elseif (preg_match('/IQ4411/', $useragent)) {
            $deviceCode = 'iq4411 quad energie2';
        } elseif (preg_match('/phoenix 2/i', $useragent)) {
            $deviceCode = 'iq4410i';
        } elseif (preg_match('/IQ4490/', $useragent)) {
            $deviceCode = 'iq4490';
        } elseif (preg_match('/IQ4410/', $useragent)) {
            $deviceCode = 'iq4410 quad phoenix';
        } elseif (preg_match('/IQ4409/', $useragent)) {
            $deviceCode = 'iq4409 quad';
        } elseif (preg_match('/IQ4404/', $useragent)) {
            $deviceCode = 'iq4404';
        } elseif (preg_match('/IQ4403/', $useragent)) {
            $deviceCode = 'iq4403';
        } elseif (preg_match('/IQ456/', $useragent)) {
            $deviceCode = 'iq456';
        } elseif (preg_match('/IQ452/', $useragent)) {
            $deviceCode = 'iq452';
        } elseif (preg_match('/IQ450/', $useragent)) {
            $deviceCode = 'iq450';
        } elseif (preg_match('/IQ449/', $useragent)) {
            $deviceCode = 'iq449';
        } elseif (preg_match('/IQ448/', $useragent)) {
            $deviceCode = 'iq448';
        } elseif (preg_match('/IQ444/', $useragent)) {
            $deviceCode = 'iq444';
        } elseif (preg_match('/IQ442/', $useragent)) {
            $deviceCode = 'iq442';
        } elseif (preg_match('/IQ436i/', $useragent)) {
            $deviceCode = 'iq436i';
        } elseif (preg_match('/IQ434/', $useragent)) {
            $deviceCode = 'iq434';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
