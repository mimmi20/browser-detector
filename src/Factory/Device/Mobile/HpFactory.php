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
class HpFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general hp device';

        if (preg_match('/ipaqhw6900/i', $useragent)) {
            $deviceCode = 'ipaq 6900';
        } elseif (preg_match('/slate 17/i', $useragent)) {
            $deviceCode = 'slate 17';
        } elseif (preg_match('/slate 10 hd/i', $useragent)) {
            $deviceCode = 'slate 10';
        } elseif (preg_match('/(touchpad|cm\_tenderloin)/i', $useragent)) {
            $deviceCode = 'touchpad';
        } elseif (preg_match('/palm\-d050/i', $useragent)) {
            $deviceCode = 'tx';
        } elseif (preg_match('/pre\//i', $useragent)) {
            $deviceCode = 'pre';
        } elseif (preg_match('/pixi\//i', $useragent)) {
            $deviceCode = 'pixi';
        } elseif (preg_match('/blazer/i', $useragent)) {
            $deviceCode = 'blazer';
        } elseif (preg_match('/p160u/i', $useragent)) {
            $deviceCode = 'p160u';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
