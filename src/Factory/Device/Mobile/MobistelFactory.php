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
class MobistelFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general mobistel device';

        if (preg_match('/cynus t6/i', $useragent)) {
            $deviceCode = 'cynus t6';
        } elseif (preg_match('/cynus t5/i', $useragent)) {
            $deviceCode = 'cynus t5';
        } elseif (preg_match('/cynus t2/i', $useragent)) {
            $deviceCode = 'cynus t2';
        } elseif (preg_match('/cynus t1/i', $useragent)) {
            $deviceCode = 'cynus t1';
        } elseif (preg_match('/cynus f5/i', $useragent)) {
            $deviceCode = 'cynus f5';
        } elseif (preg_match('/cynus f4/i', $useragent)) {
            $deviceCode = 'mt-7521s';
        } elseif (preg_match('/cynus f3/i', $useragent)) {
            $deviceCode = 'cynus f3';
        } elseif (preg_match('/cynus e1/i', $useragent)) {
            $deviceCode = 'cynus e1';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
