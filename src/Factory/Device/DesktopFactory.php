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

class DesktopFactory
{
    private $factories = [
        '/raspbian|debian.*rpi/i' => 'raspberry pi foundation',
        '/eeepc|np0[26789]|maau|asjb|asu2/i' => 'asus',
        '/mdd[crs]/i' => 'dell',
        '/mafs/i' => 'fujitsu',
        '/maar/i' => 'acer',
        '/mas[aep]/i' => 'sony',
        '/masm/i' => 'samsung',
        '/mal[cn]|lcjb|len2|lenovog780/i' => 'lenovo',
        '/mat[bmp]|tnjb|tajb/i' => 'toshiba',
        '/mamd/i' => 'medion',
        '/mam[i3]/i' => 'msi',
        '/magw/i' => 'gateway',
        '/cpdtdf|cpntdf|cmntdf/i' => 'compaq',
        '/hpcmhp|hpntdf|hpdtdf|hp\-ux 9000/i' => 'hp',
        '/h9p/i' => 'microsoft',
        '/surfbook w1/i' => 'trekstor',
        '/freebsd/i' => 'unknown',
        '/macintosh|darwin|mac(_powerpc|book|mini|pro)|(for|ppc) mac|mac ?os|integrity|camino|pubsub|(os\=|i|power)mac/i' => 'apple',
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
                $loader = $loaderFactory($company, 'desktop');

                return $loader($useragent);
            }
        }

        $loader = $loaderFactory('unknown', 'desktop');

        return $loader($useragent);
    }
}
