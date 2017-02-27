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
class TrekStorFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general trekstor device';

        if (preg_match('/SurfTab duo W1 10\.1/', $useragent)) {
            $deviceCode = 'surftab duo w1 10.1';
        } elseif (preg_match('/WP 4\.7/', $useragent)) {
            $deviceCode = 'winphone 4.7 hd';
        } elseif (preg_match('/VT10416\-2/', $useragent)) {
            $deviceCode = 'vt10416-2';
        } elseif (preg_match('/VT10416\-1/', $useragent)) {
            $deviceCode = 'vt10416-1';
        } elseif (preg_match('/(ST701041|SurfTab\_7\.0)/', $useragent)) {
            $deviceCode = 'st701041';
        } elseif (preg_match('/ST10216\-2/', $useragent)) {
            $deviceCode = 'st10216-2';
        } elseif (preg_match('/ST80216/', $useragent)) {
            $deviceCode = 'st80216';
        } elseif (preg_match('/ST80208/', $useragent)) {
            $deviceCode = 'st80208';
        } elseif (preg_match('/ST70104/', $useragent)) {
            $deviceCode = 'st70104';
        } elseif (preg_match('/ST10416\-1/', $useragent)) {
            $deviceCode = 'st10416-1';
        } elseif (preg_match('/ST10216\-1/', $useragent)) {
            $deviceCode = 'st10216-1';
        } elseif (preg_match('/trekstor_liro_color/', $useragent)) {
            $deviceCode = 'liro color';
        } elseif (preg_match('/breeze 10\.1 quad/', $useragent)) {
            $deviceCode = 'surftab breeze 10.1 quad';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
