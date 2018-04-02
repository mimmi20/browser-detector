<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Loader\DeviceLoaderFactory;
use Psr\Log\LoggerInterface;

class TvFactory
{
    private $factories = [
        '/kdl\d{2}|nsz\-gs7\/gx70|sonydtv|netbox/i' => 'sony',
        '/THOMSON|LF1V/' => 'thomson',
        '/philips|avm\-/i' => 'philips',
        '/xbox/i' => 'microsoft',
        '/crkey/i' => 'google',
        '/dlink\.dsm380/i' => 'dlink',
        '/sl150|sl32x|sl121/i' => 'loewe',
        '/digio i33\-hd\+/i' => 'telestar',
        '/aldinord/i' => 'aldi-nord',
        '/cx919|gxt_dongle_3188/i' => 'andoer',
        '/technisat/i' => 'technisat',
        '/;metz;/i' => 'metz',
        '/;tcl;/i' => 'tcl',
        '/;aston;/i' => 'aston',
        '/;arcelik;/i' => 'arcelik',
        '/;mstar;/i' => 'mstar',
        '/mxl661l32|smart\-tv/i' => 'samsung',
        '/viera/i' => 'panasonic',
        '/apple tv/i' => 'apple',
        '/netrangemmh/i' => 'netrange',
    ];

    /**
     * @var \BrowserDetector\Cache\CacheInterface
     */
    private $cache;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $loaderFactory = new DeviceLoaderFactory($this->cache, $this->logger);

        foreach ($this->factories as $rule => $company) {
            if (preg_match($rule, $useragent)) {
                $loader = $loaderFactory($company, 'tv');

                return $loader($useragent);
            }
        }

        $loader = $loaderFactory('unknown', 'tv');

        return $loader($useragent);
    }
}
