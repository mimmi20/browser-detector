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

/**
 * Browser detection class
 */
class DarwinFactory
{
    private $factories = [
        '/cfnetwork\/(?:808|75[78]|711|709|672|60[29]|548|485|467|459)/i' => 'mobile',
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

        foreach ($this->factories as $rule => $mode) {
            if (preg_match($rule, $useragent)) {
                $loader = $loaderFactory('apple', $mode);

                return $loader($useragent);
            }
        }

        $loader = $loaderFactory('apple', 'desktop');

        return $loader($useragent);
    }
}
