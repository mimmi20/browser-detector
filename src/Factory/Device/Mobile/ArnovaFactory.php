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
class ArnovaFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general arnova device';

        if (preg_match('/101 g4/i', $useragent)) {
            $deviceCode = '101 g4';
        } elseif (preg_match('/AN10DG3/i', $useragent)) {
            $deviceCode = '10d g3';
        } elseif (preg_match('/AN10BG3/i', $useragent)) {
            $deviceCode = 'an10bg3';
        } elseif (preg_match('/AN9G2I/i', $useragent)) {
            $deviceCode = '9 g2';
        } elseif (preg_match('/AN7FG3/i', $useragent)) {
            $deviceCode = '7f g3';
        } elseif (preg_match('/AN7EG3/i', $useragent)) {
            $deviceCode = '7e g3';
        } elseif (preg_match('/AN7DG3/i', $useragent)) {
            $deviceCode = '7d g3';
        } elseif (preg_match('/AN7CG2/i', $useragent)) {
            $deviceCode = '7c g2';
        } elseif (preg_match('/AN7BG2DT/i', $useragent)) {
            $deviceCode = '7b g2 dt';
        } elseif (preg_match('/ARCHM901/i', $useragent)) {
            $deviceCode = 'archm901';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
