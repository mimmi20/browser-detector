<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
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
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\Device\DarwinParserInterface;
use BrowserDetector\Parser\Device\DesktopParserInterface;
use BrowserDetector\Parser\Device\MobileParserInterface;
use BrowserDetector\Parser\Device\TvParserInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function preg_match;

final class DeviceParser implements DeviceParserInterface
{
    private const UNKNOWN = 'unknown';
    private DarwinParserInterface $darwinParser;

    private MobileParserInterface $mobileParser;

    private TvParserInterface $tvParser;

    private DesktopParserInterface $desktopParser;

    private DeviceLoaderFactoryInterface $loaderFactory;

    private MobileDeviceInterface $mobileDevice;
    private TvInterface $tvDevice;
    private DesktopInterface $desktopDevice;

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
     * @return array<int, (OsInterface|DeviceInterface|null)>
     * @phpstan-return array(0:DeviceInterface, 1:OsInterface|null)
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function parse(string $useragent): array
    {
        if (preg_match('/new-sogou-spider|zollard|socialradarbot|microsoft office protocol discovery|powermarks|archivebot|marketwirebot|microsoft-cryptoapi|pad-bot|james bot|winhttp|jobboerse|<|>|online-versicherungsportal\.info|versicherungssuchmaschine\.net|microsearch|microsoft data access|microsoft url control|infegyatlas|msie or firefox mutant|semantic-visions\.com crawler|labs\.topsy\.com\/butterfly|dolphin http client|google wireless transcoder|commoncrawler|ipodder|tripadvisor|nokia wap gateway|outclicksbot/i', $useragent)) {
            return $this->load(self::UNKNOWN, self::UNKNOWN, $useragent);
        }

        if (
            !preg_match('/freebsd|raspbian/i', $useragent)
            && preg_match('/darwin|cfnetwork/i', $useragent)
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

        return $this->load(self::UNKNOWN, self::UNKNOWN, $useragent);
    }

    /**
     * @return array<int, (OsInterface|DeviceInterface|null)>
     * @phpstan-return array(0:DeviceInterface, 1:OsInterface|null)
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $company, string $key, string $useragent = ''): array
    {
        $loaderFactory = $this->loaderFactory;
        $loader        = $loaderFactory($company);

        return $loader->load($key, $useragent);
    }
}
