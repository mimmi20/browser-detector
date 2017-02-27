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
class CobyFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general coby device';

        if (preg_match('/MID9742/i', $useragent)) {
            $deviceCode = 'mid9742';
        } elseif (preg_match('/MID8128/i', $useragent)) {
            $deviceCode = 'mid8128';
        } elseif (preg_match('/MID8127/i', $useragent)) {
            $deviceCode = 'mid8127';
        } elseif (preg_match('/MID8024/i', $useragent)) {
            $deviceCode = 'mid8024';
        } elseif (preg_match('/MID7022/i', $useragent)) {
            $deviceCode = 'mid7022';
        } elseif (preg_match('/MID7015/i', $useragent)) {
            $deviceCode = 'mid7015';
        } elseif (preg_match('/MID1126/i', $useragent)) {
            $deviceCode = 'mid1126';
        } elseif (preg_match('/MID1125/i', $useragent)) {
            $deviceCode = 'mid1125';
        } elseif (preg_match('/NBPC724/i', $useragent)) {
            $deviceCode = 'nbpc724';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
