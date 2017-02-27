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
class AcerFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general acer device';

        if (preg_match('/V989/i', $useragent)) {
            $deviceCode = 'v989';
        } elseif (preg_match('/V370/i', $useragent)) {
            $deviceCode = 'v370';
        } elseif (preg_match('/Stream\-S110/i', $useragent)) {
            $deviceCode = 'stream s110';
        } elseif (preg_match('/S500/i', $useragent)) {
            $deviceCode = 's500';
        } elseif (preg_match('/Liquid (MT|Metal)/i', $useragent)) {
            $deviceCode = 's120';
        } elseif (preg_match('/Z150/i', $useragent)) {
            $deviceCode = 'z150';
        } elseif (preg_match('/Liquid/i', $useragent)) {
            $deviceCode = 's100';
        } elseif (preg_match('/b1\-770/i', $useragent)) {
            $deviceCode = 'b1-770';
        } elseif (preg_match('/b1\-730hd/i', $useragent)) {
            $deviceCode = 'b1-730hd';
        } elseif (preg_match('/b1\-721/i', $useragent)) {
            $deviceCode = 'b1-721';
        } elseif (preg_match('/b1\-711/i', $useragent)) {
            $deviceCode = 'b1-711';
        } elseif (preg_match('/b1\-710/i', $useragent)) {
            $deviceCode = 'b1-710';
        } elseif (preg_match('/b1\-a71/i', $useragent)) {
            $deviceCode = 'b1-a71';
        } elseif (preg_match('/a1\-830/i', $useragent)) {
            $deviceCode = 'a1-830';
        } elseif (preg_match('/a1\-811/i', $useragent)) {
            $deviceCode = 'a1-811';
        } elseif (preg_match('/a1\-810/i', $useragent)) {
            $deviceCode = 'a1-810';
        } elseif (preg_match('/A742/i', $useragent)) {
            $deviceCode = 'tab a742';
        } elseif (preg_match('/A701/i', $useragent)) {
            $deviceCode = 'a701';
        } elseif (preg_match('/A700/i', $useragent)) {
            $deviceCode = 'a700';
        } elseif (preg_match('/A511/i', $useragent)) {
            $deviceCode = 'a511';
        } elseif (preg_match('/A510/i', $useragent)) {
            $deviceCode = 'a510';
        } elseif (preg_match('/A501/i', $useragent)) {
            $deviceCode = 'a501';
        } elseif (preg_match('/A500/i', $useragent)) {
            $deviceCode = 'a500';
        } elseif (preg_match('/A211/i', $useragent)) {
            $deviceCode = 'a211';
        } elseif (preg_match('/A210/i', $useragent)) {
            $deviceCode = 'a210';
        } elseif (preg_match('/A200/i', $useragent)) {
            $deviceCode = 'a200';
        } elseif (preg_match('/A101C/i', $useragent)) {
            $deviceCode = 'a101c';
        } elseif (preg_match('/A101/i', $useragent)) {
            $deviceCode = 'a101';
        } elseif (preg_match('/A100/i', $useragent)) {
            $deviceCode = 'a100';
        } elseif (preg_match('/a3\-a20/i', $useragent)) {
            $deviceCode = 'a3-a20';
        } elseif (preg_match('/a3\-a11/i', $useragent)) {
            $deviceCode = 'a3-a11';
        } elseif (preg_match('/a3\-a10/i', $useragent)) {
            $deviceCode = 'a3-a10';
        } elseif (preg_match('/Iconia/i', $useragent)) {
            $deviceCode = 'iconia';
        } elseif (preg_match('/G100W/i', $useragent)) {
            $deviceCode = 'g100w';
        } elseif (preg_match('/E320/i', $useragent)) {
            $deviceCode = 'e320';
        } elseif (preg_match('/E310/i', $useragent)) {
            $deviceCode = 'e310';
        } elseif (preg_match('/E140/i', $useragent)) {
            $deviceCode = 'e140';
        } elseif (preg_match('/DA241HL/i', $useragent)) {
            $deviceCode = 'da241hl';
        } elseif (preg_match('/allegro/i', $useragent)) {
            $deviceCode = 'allegro';
        } elseif (preg_match('/TM01/', $useragent)) {
            $deviceCode = 'tm01';
        } elseif (preg_match('/M220/', $useragent)) {
            $deviceCode = 'm220';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
