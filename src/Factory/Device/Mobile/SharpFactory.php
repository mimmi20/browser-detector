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
class SharpFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general sharp device';

        if (preg_match('/SHARP\-TQ\-GX30i/', $useragent)) {
            $deviceCode = 'tq-gx30i';
        } elseif (preg_match('/SH\-10D/', $useragent)) {
            $deviceCode = 'sh-10d';
        } elseif (preg_match('/SH\-01F/', $useragent)) {
            $deviceCode = 'sh-01f';
        } elseif (preg_match('/SH8128U/', $useragent)) {
            $deviceCode = 'sh8128u';
        } elseif (preg_match('/SH7228U/', $useragent)) {
            $deviceCode = 'sh7228u';
        } elseif (preg_match('/306SH/', $useragent)) {
            $deviceCode = '306sh';
        } elseif (preg_match('/304SH/', $useragent)) {
            $deviceCode = '304sh';
        } elseif (preg_match('/SH80F/', $useragent)) {
            $deviceCode = 'sh80f';
        } elseif (preg_match('/SH05C/', $useragent)) {
            $deviceCode = 'sh-05c';
        } elseif (preg_match('/IS05/', $useragent)) {
            $deviceCode = 'is05';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
