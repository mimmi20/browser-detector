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
class CatSoundFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general catsound device';

        if (preg_match('/CatNova8/i', $useragent)) {
            $deviceCode = 'cat nova 8';
        } elseif (preg_match('/nova/i', $useragent)) {
            $deviceCode = 'nova';
        } elseif (preg_match('/Cat Tablet Galactica X/i', $useragent)) {
            $deviceCode = 'galactica x';
        } elseif (preg_match('/StarGate/i', $useragent)) {
            $deviceCode = 'stargate';
        } elseif (preg_match('/Cat Tablet PHOENIX/i', $useragent)) {
            $deviceCode = 'phoenix';
        } elseif (preg_match('/Cat Tablet/i', $useragent)) {
            $deviceCode = 'catsound tablet';
        } elseif (preg_match('/Tablet\-PC\-4/i', $useragent)) {
            $deviceCode = 'tablet pc 4';
        } elseif (preg_match('/Kinder\-Tablet/i', $useragent)) {
            $deviceCode = 'kinder-tablet';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
