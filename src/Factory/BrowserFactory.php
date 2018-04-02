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
namespace BrowserDetector\Factory;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Loader\BrowserLoaderFactory;
use Psr\Log\LoggerInterface;

class BrowserFactory implements BrowserFactoryInterface
{
    private $factories = [
        '/edge/i' => 'edge',
        '/chrome|crmo/i' => 'blink',
        '/webkit|safari|cfnetwork|dalvik|ipad|ipod|iphone|khtml/i' => 'webkit',
        '/iOS/' => 'webkit',
        '/presto|opera/i' => 'presto',
        '/trident|msie|like gecko/i' => 'trident',
        '/gecko|firefox|minefield|shiretoko|bonecho|namoroka/i' => 'gecko',
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
     * Gets the information about the browser by User Agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $loaderFactory = new BrowserLoaderFactory($this->cache, $this->logger);

        foreach ($this->factories as $rule => $mode) {
            if (preg_match($rule, $useragent)) {
                $loader = $loaderFactory($mode);

                return $loader($useragent);
            }
        }

        $loader = $loaderFactory('genericbrowser');

        return $loader($useragent);
    }
}
