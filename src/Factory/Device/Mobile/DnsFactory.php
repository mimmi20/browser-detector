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
class DnsFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general dns device';

        if (preg_match('/s5701/i', $useragent)) {
            $deviceCode = 's5701';
        } elseif (preg_match('/s4505m/i', $useragent)) {
            $deviceCode = 's4505m';
        } elseif (preg_match('/s4505/i', $useragent)) {
            $deviceCode = 's4505';
        } elseif (preg_match('/s4503q/i', $useragent)) {
            $deviceCode = 's4503q';
        } elseif (preg_match('/s4502m/i', $useragent)) {
            $deviceCode = 's4502m';
        } elseif (preg_match('/s4502/i', $useragent)) {
            $deviceCode = 's4502';
        } elseif (preg_match('/s4501m/i', $useragent)) {
            $deviceCode = 's4501m';
        } elseif (preg_match('/S4008/', $useragent)) {
            $deviceCode = 's4008';
        } elseif (preg_match('/MB40II1/', $useragent)) {
            $deviceCode = 'mb40ii1';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
