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
use BrowserDetector\Parser\Device\DarwinParserInterface;
use BrowserDetector\Parser\Device\DesktopParserInterface;
use BrowserDetector\Parser\Device\MobileParserInterface;
use BrowserDetector\Parser\Device\TvParserInterface;

final class DeviceParser implements DeviceParserInterface
{
    /**
     * @var \BrowserDetector\Parser\Device\DarwinParserInterface
     */
    private $darwinParser;

    /**
     * @var \BrowserDetector\Parser\Device\MobileParserInterface
     */
    private $mobileParser;

    /**
     * @var \BrowserDetector\Parser\Device\TvParserInterface
     */
    private $tvParser;

    /**
     * @var \BrowserDetector\Parser\Device\DesktopParserInterface
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
     * @param \BrowserDetector\Parser\Device\DarwinParserInterface  $darwinParser
     * @param \BrowserDetector\Parser\Device\MobileParserInterface  $mobileParser
     * @param \BrowserDetector\Parser\Device\TvParserInterface      $tvParser
     * @param \BrowserDetector\Parser\Device\DesktopParserInterface $desktopParser
     * @param \BrowserDetector\Loader\DeviceLoaderFactoryInterface  $loaderFactory
     * @param \BrowserDetector\Helper\MobileDeviceInterface         $mobileDevice
     * @param \BrowserDetector\Helper\TvInterface                   $tvDevice
     * @param \BrowserDetector\Helper\DesktopInterface              $desktopDevice
     */
    public function __construct(
        DarwinParserInterface $darwinParser,
        MobileParserInterface $mobileParser,
        TvParserInterface $tvParser,
        DesktopParserInterface $desktopParser,
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
     * @return array
     */
    public function parse(string $useragent): array
    {
        if ((bool) preg_match('/new-sogou-spider|zollard|socialradarbot|microsoft office protocol discovery|powermarks|archivebot|marketwirebot|microsoft-cryptoapi|pad-bot|james bot|winhttp|jobboerse|<|>|online-versicherungsportal\.info|versicherungssuchmaschine\.net|microsearch|microsoft data access|microsoft url control|infegyatlas|msie or firefox mutant|semantic-visions\.com crawler|labs\.topsy\.com\/butterfly|dolphin http client|google wireless transcoder|commoncrawler|ipodder|tripadvisor|nokia wap gateway|outclicksbot/i', $useragent)) {
            return $this->load('unknown', 'unknown', $useragent);
        }

        if (!(bool) preg_match('/freebsd|raspbian/i', $useragent)
            && (bool) preg_match('/darwin|cfnetwork/i', $useragent)
        ) {
            return $this->darwinParser->parse($useragent);
        }

        if ($this->mobileDevice->isMobile($useragent)) {
            return $this->mobileParser->parse($useragent);
        }

        if ($this->tvDevice->isTvDevice($useragent)) {
            return $this->tvParser->parse($useragent);
        }

        if ($this->desktopDevice->isDesktopDevice($useragent)) {
            return $this->desktopParser->parse($useragent);
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
