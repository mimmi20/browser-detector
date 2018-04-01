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
use BrowserDetector\Helper;
use BrowserDetector\Loader\DeviceLoaderFactory;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;

class DesktopFactory
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
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $loaderFactory = new DeviceLoaderFactory($this->cache, $this->logger);
        $s             = new Stringy($useragent);

        if ((new Helper\Windows($s))->isWindows()) {
            $loader = $loaderFactory('windows', 'desktop');

            return $loader($useragent);
        }

        if ($s->containsAny(['raspbian', 'eeepc', 'hp-ux 9000'], false)
            || $s->containsAll(['debian', 'rpi'], false)
        ) {
            $loader = $loaderFactory('genericdesktop', 'desktop');

            return $loader($useragent);
        }

        if ((new Helper\Linux($s))->isLinux()) {
            $loader = $loaderFactory('linux', 'desktop');

            return $loader($useragent);
        }

        if ((new Helper\Macintosh($s))->isMacintosh()) {
            $loader = $loaderFactory('apple', 'desktop');

            return $loader($useragent);
        }

        $loader = $loaderFactory('generaldesktop', 'desktop');

        return $loader($useragent);
    }
}
