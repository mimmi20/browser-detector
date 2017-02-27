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
class PipoFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general pipo device';

        if (preg_match('/TPC\-PA10\.1M/', $useragent)) {
            $deviceCode = 'pipo pa10.1m';
        } elseif (preg_match('/p93g/i', $useragent)) {
            $deviceCode = 'p9 3g';
        } elseif (preg_match('/m9pro/i', $useragent)) {
            $deviceCode = 'q107';
        } elseif (preg_match('/m7t/i', $useragent)) {
            $deviceCode = 'm7t';
        } elseif (preg_match('/m6pro/i', $useragent)) {
            $deviceCode = 'q977';
        } elseif (preg_match('/i75/', $useragent)) {
            $deviceCode = 'i75';
        } elseif (preg_match('/m83g/i', $useragent)) {
            $deviceCode = 'm8 3g';
        } elseif (preg_match('/ M6 /', $useragent)) {
            $deviceCode = 'm6';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
