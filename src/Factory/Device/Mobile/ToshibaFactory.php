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
class ToshibaFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general toshiba device';

        if (preg_match('/Toshiba\/TG01/', $useragent)) {
            $deviceCode = 'tg01';
        } elseif (preg_match('/(FOLIO_AND_A|TOSHIBA_AC_AND_AZ)/', $useragent)) {
            $deviceCode = 'folio 100';
        } elseif (preg_match('/folio100/i', $useragent)) {
            $deviceCode = 'folio 100';
        } elseif (preg_match('/AT300SE/', $useragent)) {
            $deviceCode = 'at300se';
        } elseif (preg_match('/AT300/', $useragent)) {
            $deviceCode = 'at300';
        } elseif (preg_match('/AT200/', $useragent)) {
            $deviceCode = 'at200';
        } elseif (preg_match('/AT100/', $useragent)) {
            $deviceCode = 'at100';
        } elseif (preg_match('/AT10\-A/', $useragent)) {
            $deviceCode = 'at10-a';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
