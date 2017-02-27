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
class MicromaxFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general micromax device';

        if (preg_match('/X650/i', $useragent)) {
            $deviceCode = 'x650';
        } elseif (preg_match('/A120/i', $useragent)) {
            $deviceCode = 'a120';
        } elseif (preg_match('/A116/i', $useragent)) {
            $deviceCode = 'a116';
        } elseif (preg_match('/A114/i', $useragent)) {
            $deviceCode = 'a114';
        } elseif (preg_match('/A101/i', $useragent)) {
            $deviceCode = 'micromax a101';
        } elseif (preg_match('/A093/i', $useragent)) {
            $deviceCode = 'a093';
        } elseif (preg_match('/A065/i', $useragent)) {
            $deviceCode = 'a065';
        } elseif (preg_match('/A59/i', $useragent)) {
            $deviceCode = 'a59';
        } elseif (preg_match('/A40/i', $useragent)) {
            $deviceCode = 'a40';
        } elseif (preg_match('/A35/i', $useragent)) {
            $deviceCode = 'a35';
        } elseif (preg_match('/A27/i', $useragent)) {
            $deviceCode = 'a27';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
