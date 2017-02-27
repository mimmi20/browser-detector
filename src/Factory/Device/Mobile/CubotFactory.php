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
class CubotFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general cubot device';

        if (preg_match('/S208/', $useragent)) {
            $deviceCode = 's208';
        } elseif (preg_match('/P9/i', $useragent)) {
            $deviceCode = 'cubot u30gt';
        } elseif (preg_match('/MT6572\_TD/i', $useragent)) {
            $deviceCode = 'gt 95 3g';
        } elseif (preg_match('/GT99/i', $useragent)) {
            $deviceCode = 'gt99';
        } elseif (preg_match('/C11/i', $useragent)) {
            $deviceCode = 'c11';
        } elseif (preg_match('/C7/i', $useragent)) {
            $deviceCode = 'c7';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
