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
class DigmaFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general digma device';

        if (preg_match('/PS1043MG/', $useragent)) {
            $deviceCode = 'ps1043mg';
        } elseif (preg_match('/TT7026MW/', $useragent)) {
            $deviceCode = 'tt7026mw';
        } elseif (preg_match('/iDxD7/', $useragent)) {
            $deviceCode = 'idxd7 3g';
        } elseif (preg_match('/iDxD4/', $useragent)) {
            $deviceCode = 'idxd4 3g';
        } elseif (preg_match('/iDsD7/', $useragent)) {
            $deviceCode = 'idsd7 3g';
        } elseif (preg_match('/iDnD7/', $useragent)) {
            $deviceCode = 'idnd7';
        } elseif (preg_match('/iDjD7/', $useragent)) {
            $deviceCode = 'idjd7';
        } elseif (preg_match('/iDrQ10/', $useragent)) {
            $deviceCode = 'idrq10 3g';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
