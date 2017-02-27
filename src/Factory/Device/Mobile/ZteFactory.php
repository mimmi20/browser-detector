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
class ZteFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general zte device';

        if (preg_match('/blade v6/i', $useragent)) {
            $deviceCode = 'blade v6';
        } elseif (preg_match('/blade l6/i', $useragent)) {
            $deviceCode = 'blade l6';
        } elseif (preg_match('/blade l5 plus/i', $useragent)) {
            $deviceCode = 'blade l5 plus';
        } elseif (preg_match('/blade l3/i', $useragent)) {
            $deviceCode = 'blade l3';
        } elseif (preg_match('/blade l2/i', $useragent)) {
            $deviceCode = 'blade l2';
        } elseif (preg_match('/n919/i', $useragent)) {
            $deviceCode = 'n919';
        } elseif (preg_match('/x920/i', $useragent)) {
            $deviceCode = 'x920';
        } elseif (preg_match('/w713/i', $useragent)) {
            $deviceCode = 'w713';
        } elseif (preg_match('/z221/i', $useragent)) {
            $deviceCode = 'z221';
        } elseif (preg_match('/(v975|geek)/i', $useragent)) {
            $deviceCode = 'v975';
        } elseif (preg_match('/v970/i', $useragent)) {
            $deviceCode = 'v970';
        } elseif (preg_match('/v967s/i', $useragent)) {
            $deviceCode = 'v967s';
        } elseif (preg_match('/v880/i', $useragent)) {
            $deviceCode = 'v880';
        } elseif (preg_match('/v829/i', $useragent)) {
            $deviceCode = 'v829';
        } elseif (preg_match('/v808/i', $useragent)) {
            $deviceCode = 'v808';
        } elseif (preg_match('/v788d/i', $useragent)) {
            $deviceCode = 'zte v788d';
        } elseif (preg_match('/v9/i', $useragent)) {
            $deviceCode = 'v9';
        } elseif (preg_match('/u930hd/i', $useragent)) {
            $deviceCode = 'u930hd';
        } elseif (preg_match('/smarttab10/i', $useragent)) {
            $deviceCode = 'smart tab 10';
        } elseif (preg_match('/smarttab7/i', $useragent)) {
            $deviceCode = 'smarttab7';
        } elseif (preg_match('/vodafone smart 4g/i', $useragent)) {
            $deviceCode = 'smart 4g';
        } elseif (preg_match('/zte[ \-]skate/i', $useragent)) {
            $deviceCode = 'skate';
        } elseif (preg_match('/racerii/i', $useragent)) {
            $deviceCode = 'racer ii';
        } elseif (preg_match('/racer/i', $useragent)) {
            $deviceCode = 'racer';
        } elseif (preg_match('/zteopen/i', $useragent)) {
            $deviceCode = 'open';
        } elseif (preg_match('/nx501/i', $useragent)) {
            $deviceCode = 'nx501';
        } elseif (preg_match('/nx402/i', $useragent)) {
            $deviceCode = 'nx402';
        } elseif (preg_match('/n918st/i', $useragent)) {
            $deviceCode = 'n918st';
        } elseif (preg_match('/ n600 /i', $useragent)) {
            $deviceCode = 'n600';
        } elseif (preg_match('/leo q2/i', $useragent)) {
            $deviceCode = 'v769m';
        } elseif (preg_match('/kis plus/i', $useragent)) {
            $deviceCode = 'zte v788d';
        } elseif (preg_match('/blade q maxi/i', $useragent)) {
            $deviceCode = 'blade q maxi';
        } elseif (preg_match('/blade iii\_il/i', $useragent)) {
            $deviceCode = 'blade iii';
        } elseif (preg_match('/blade/i', $useragent)) {
            $deviceCode = 'zte blade';
        } elseif (preg_match('/base tab/i', $useragent)) {
            $deviceCode = 'base tab';
        } elseif (preg_match('/base_lutea_3/i', $useragent)) {
            $deviceCode = 'lutea 3';
        } elseif (preg_match('/base lutea 2/i', $useragent)) {
            $deviceCode = 'lutea 2';
        } elseif (preg_match('/base lutea/i', $useragent)) {
            $deviceCode = 'zte blade';
        } elseif (preg_match('/atlas\_w/i', $useragent)) {
            $deviceCode = 'atlas w';
        } elseif (preg_match('/tania/i', $useragent)) {
            $deviceCode = 'tania';
        } elseif (preg_match('/g\-x991\-rio\-orange/i', $useragent)) {
            $deviceCode = 'g-x991';
        } elseif (preg_match('/beeline pro/i', $useragent)) {
            $deviceCode = 'beeline pro';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
