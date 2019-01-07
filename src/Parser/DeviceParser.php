<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser;

use BrowserDetector\Helper\DesktopInterface;
use BrowserDetector\Helper\MobileDeviceInterface;
use BrowserDetector\Helper\TvInterface;
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use Stringy\Stringy;

final class DeviceParser implements DeviceParserInterface
{
    /**
     * @var \BrowserDetector\Parser\DeviceParserInterface
     */
    private $darwinParser;

    /**
     * @var \BrowserDetector\Parser\DeviceParserInterface
     */
    private $mobileParser;

    /**
     * @var \BrowserDetector\Parser\DeviceParserInterface
     */
    private $tvParser;

    /**
     * @var \BrowserDetector\Parser\DeviceParserInterface
     */
    private $desktopParser;

    /**
     * @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface
     */
    private $loaderFactory;

    /**
     * @var \BrowserDetector\Helper\MobileDeviceInterface
     */
    private $mobileDevice;
    /**
     * @var \BrowserDetector\Helper\TvInterface
     */
    private $tvDevice;
    /**
     * @var \BrowserDetector\Helper\DesktopInterface
     */
    private $desktopDevice;

    /**
     * DeviceParser constructor.
     *
     * @param \BrowserDetector\Parser\DeviceParserInterface        $darwinParser
     * @param \BrowserDetector\Parser\DeviceParserInterface        $mobileParser
     * @param \BrowserDetector\Parser\DeviceParserInterface        $tvParser
     * @param \BrowserDetector\Parser\DeviceParserInterface        $desktopParser
     * @param \BrowserDetector\Loader\DeviceLoaderFactoryInterface $loaderFactory
     * @param \BrowserDetector\Helper\MobileDeviceInterface        $mobileDevice
     * @param \BrowserDetector\Helper\TvInterface                  $tvDevice
     * @param \BrowserDetector\Helper\DesktopInterface             $desktopDevice
     */
    public function __construct(
        DeviceParserInterface $darwinParser,
        DeviceParserInterface $mobileParser,
        DeviceParserInterface $tvParser,
        DeviceParserInterface $desktopParser,
        DeviceLoaderFactoryInterface $loaderFactory,
        MobileDeviceInterface $mobileDevice,
        TvInterface $tvDevice,
        DesktopInterface $desktopDevice
    ) {
        $this->darwinParser  = $darwinParser;
        $this->mobileParser  = $mobileParser;
        $this->tvParser      = $tvParser;
        $this->desktopParser = $desktopParser;
        $this->loaderFactory = $loaderFactory;
        $this->mobileDevice  = $mobileDevice;
        $this->tvDevice      = $tvDevice;
        $this->desktopDevice = $desktopDevice;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function parse(string $useragent): array
    {
        if (preg_match('/new-sogou-spider|zollard|socialradarbot|microsoft office protocol discovery|powermarks|archivebot|marketwirebot|microsoft-cryptoapi|pad-bot|james bot|winhttp|jobboerse|<|>|online-versicherungsportal\.info|versicherungssuchmaschine\.net|microsearch|microsoft data access|microsoft url control|infegyatlas|msie or firefox mutant|semantic-visions\.com crawler|labs\.topsy\.com\/butterfly|dolphin http client|google wireless transcoder|commoncrawler|ipodder|tripadvisor|nokia wap gateway/i', $useragent)) {
            return $this->load('unknown', 'unknown', $useragent);
        }

        if (!preg_match('/freebsd|raspbian/i', $useragent)
            && preg_match('/darwin|cfnetwork/i', $useragent)
        ) {
            $factory = $this->darwinParser;

            return $factory->parse($useragent);
        }

        $s = new Stringy($useragent);

        if ($this->mobileDevice->isMobile($s)) {
            $factory = $this->mobileParser;

            return $factory->parse($useragent);
        }

        if ($this->tvDevice->isTvDevice($s)) {
            $factory = $this->tvParser;

            return $factory->parse($useragent);
        }

        if ($this->desktopDevice->isDesktopDevice($s)) {
            $factory = $this->desktopParser;

            return $factory->parse($useragent);
        }

        return $this->load('unknown', 'unknown', $useragent);
    }

    /**
     * @param string $company
     * @param string $key
     * @param string $useragent
     *
     * @return array
     */
    public function load(string $company, string $key, string $useragent = ''): array
    {
        $loaderFactory = $this->loaderFactory;

        /** @var \BrowserDetector\Loader\DeviceLoader $loader */
        $loader = $loaderFactory($company);

        return $loader->load($key, $useragent);
    }
}
