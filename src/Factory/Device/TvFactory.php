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
use BrowserDetector\Factory;
use BrowserDetector\Loader\DeviceLoaderFactory;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;

class TvFactory implements Factory\FactoryInterface
{
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
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function detect(string $useragent, Stringy $s): array
    {
        $loaderFactory = new DeviceLoaderFactory($this->cache, $this->logger);

        if (preg_match('/KDL\d{2}/', $useragent)) {
            $loader = $loaderFactory('sony', 'tv');
            return $loader($useragent);
        }

        if ($s->containsAny(['nsz-gs7/gx70', 'sonydtv'], false)) {
            $loader = $loaderFactory('sony', 'tv');
            return $loader($useragent);
        }

        if ($s->containsAny(['THOMSON', 'LF1V'], true)) {
            $loader = $loaderFactory('thomson', 'tv');
            return $loader($useragent);
        }

        if ($s->containsAny(['philips', 'avm-'], false)) {
            $loader = $loaderFactory('philips', 'tv');
            return $loader($useragent);
        }

        $loader = $loaderFactory('generictv', 'tv');
        return $loader($useragent);
    }
}
