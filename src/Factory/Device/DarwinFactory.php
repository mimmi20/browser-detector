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

/**
 * Browser detection class
 */
class DarwinFactory implements Factory\FactoryInterface
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

        $mobileCodes = [
            'cfnetwork/808',
            'cfnetwork/758',
            'cfnetwork/757',
            'cfnetwork/711',
            'cfnetwork/709',
            'cfnetwork/672',
            'cfnetwork/609',
            'cfnetwork/602',
            'cfnetwork/548',
            'cfnetwork/485',
            'cfnetwork/467',
            'cfnetwork/459',
        ];

        if ($s->containsAny($mobileCodes, false)) {
            $loader = $loaderFactory('apple', 'mobile');
        } else {
            $loader = $loaderFactory('apple', 'desktop');
        }

        return $loader($useragent);
    }
}
