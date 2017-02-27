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
class ThlFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general thl device';

        if (preg_match('/W200/', $useragent)) {
            $deviceCode = 'w200';
        } elseif (preg_match('/W100/', $useragent)) {
            $deviceCode = 'w100';
        } elseif (preg_match('/W8\_beyond/', $useragent)) {
            $deviceCode = 'thl w8';
        } elseif (preg_match('/ThL W8/', $useragent)) {
            $deviceCode = 'thl w8';
        } elseif (preg_match('/ThL W7/', $useragent)) {
            $deviceCode = 'w7';
        } elseif (preg_match('/T6S/', $useragent)) {
            $deviceCode = 't6s';
        } elseif (preg_match('/4400/', $useragent)) {
            $deviceCode = '4400';
        } elseif (preg_match('/thl 2015/i', $useragent)) {
            $deviceCode = '2015';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
