<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
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
class TmobileFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general t-mobile device';

        if (preg_match('/Pulse/', $useragent)) {
            $deviceCode = 'pulse';
        } elseif (preg_match('/myTouch4G/', $useragent)) {
            $deviceCode = 'mytouch4g';
        } elseif (preg_match('/myTouch 3G Slide/', $useragent)) {
            $deviceCode = 'mytouch3g';
        } elseif (preg_match('/T\-Mobile(\_G2\_Touch| G2)/', $useragent)) {
            $deviceCode = 'g2 touch';
        } elseif (preg_match('/T\-Mobile G1/', $useragent)) {
            $deviceCode = 'g1';
        } elseif (preg_match('/mda compact\/3/i', $useragent)) {
            $deviceCode = 'mda compact iii';
        } elseif (preg_match('/mda compact/i', $useragent)) {
            $deviceCode = 'mda compact';
        } elseif (preg_match('/Ameo/', $useragent)) {
            $deviceCode = 'ameo';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
