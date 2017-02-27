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
class IconBitFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general iconbit device';

        if (preg_match('/nt\-3710s/i', $useragent)) {
            $deviceCode = 'nt-3710s';
        } elseif (preg_match('/nt\-3702m/i', $useragent)) {
            $deviceCode = 'nt-3702m';
        } elseif (preg_match('/nt\-3601p/i', $useragent)) {
            $deviceCode = 'nettab pocket 3g';
        } elseif (preg_match('/nt\-1009t/i', $useragent)) {
            $deviceCode = 'nt-1009t';
        } elseif (preg_match('/nt\-1002t/i', $useragent)) {
            $deviceCode = 'nt-1002t';
        } elseif (preg_match('/nt\-1001t/i', $useragent)) {
            $deviceCode = 'nt-1001t';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
