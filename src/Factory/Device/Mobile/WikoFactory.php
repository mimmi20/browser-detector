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
class WikoFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general wiko device';

        if (preg_match('/SLIDE2/', $useragent)) {
            $deviceCode = 'slide 2';
        } elseif (preg_match('/JERRY/', $useragent)) {
            $deviceCode = 'jerry';
        } elseif (preg_match('/BLOOM/', $useragent)) {
            $deviceCode = 'bloom';
        } elseif (preg_match('/RAINBOW/', $useragent)) {
            $deviceCode = 'rainbow';
        } elseif (preg_match('/LENNY/', $useragent)) {
            $deviceCode = 'lenny';
        } elseif (preg_match('/GETAWAY/', $useragent)) {
            $deviceCode = 'getaway';
        } elseif (preg_match('/DARKMOON/', $useragent)) {
            $deviceCode = 'darkmoon';
        } elseif (preg_match('/DARKSIDE/', $useragent)) {
            $deviceCode = 'darkside';
        } elseif (preg_match('/CINK PEAX 2/', $useragent)) {
            $deviceCode = 'cink peax 2';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
