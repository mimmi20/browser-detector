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
class XiaomiFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general xiaomi device';

        if (preg_match('/MI MAX/', $useragent)) {
            $deviceCode = 'mi max';
        } elseif (preg_match('/MI 4W/', $useragent)) {
            $deviceCode = 'mi 4w';
        } elseif (preg_match('/MI 4LTE/', $useragent)) {
            $deviceCode = 'mi 4 lte';
        } elseif (preg_match('/MI 3W/', $useragent)) {
            $deviceCode = 'mi 3w';
        } elseif (preg_match('/(MI PAD|MiPad)/', $useragent)) {
            $deviceCode = 'mi pad';
        } elseif (preg_match('/MI 2A/', $useragent)) {
            $deviceCode = 'mi 2a';
        } elseif (preg_match('/MI 2/', $useragent)) {
            $deviceCode = 'mi 2';
        } elseif (preg_match('/Redmi 3S/', $useragent)) {
            $deviceCode = 'redmi 3s';
        } elseif (preg_match('/Redmi 3/', $useragent)) {
            $deviceCode = 'redmi 3';
        } elseif (preg_match('/Redmi_Note_3/', $useragent)) {
            $deviceCode = 'redmi note 3';
        } elseif (preg_match('/Redmi Note 2/', $useragent)) {
            $deviceCode = 'redmi note 2';
        } elseif (preg_match('/HM NOTE 1W/', $useragent)) {
            $deviceCode = 'hm note 1w';
        } elseif (preg_match('/HM NOTE 1S/', $useragent)) {
            $deviceCode = 'hm note 1s';
        } elseif (preg_match('/HM NOTE 1LTETD/', $useragent)) {
            $deviceCode = 'hm note 1lte td';
        } elseif (preg_match('/HM NOTE 1LTE/', $useragent)) {
            $deviceCode = 'hm note 1lte';
        } elseif (preg_match('/HM\_1SW/', $useragent)) {
            $deviceCode = 'hm 1sw';
        } elseif (preg_match('/HM 1SC/', $useragent)) {
            $deviceCode = 'hm 1sc';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
