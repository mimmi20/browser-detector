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
class ViewSonicFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general viewsonic device';

        if (preg_match('/viewpad 10s/i', $useragent)) {
            $deviceCode = 'viewpad 10s';
        } elseif (preg_match('/viewpad 10e/i', $useragent)) {
            $deviceCode = 'viewpad 10e';
        } elseif (preg_match('/viewpad7e/i', $useragent)) {
            $deviceCode = 'viewpad 7e';
        } elseif (preg_match('/(viewpad7|viewpad\-7)/i', $useragent)) {
            $deviceCode = 'viewpad7';
        } elseif (preg_match('/viewsonic\-v350/i', $useragent)) {
            $deviceCode = 'v350';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
