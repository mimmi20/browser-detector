<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
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
use UnexpectedValueException;

use function preg_match;

final class DeviceParser implements DeviceParserInterface
{
    /** @throws void */
    public function __construct(
        private readonly DarwinParserInterface $darwinParser,
        private readonly MobileParserInterface $mobileParser,
        private readonly TvParserInterface $tvParser,
        private readonly DesktopParserInterface $desktopParser,
        private readonly DeviceLoaderFactoryInterface $loaderFactory,
        private readonly MobileDeviceInterface $mobileDevice,
        private readonly TvInterface $tvDevice,
        private readonly DesktopInterface $desktopDevice,
    ) {
        // nothing to do
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @throws void
     */
    public function parse(string $useragent): string
    {
        if (
            preg_match(
                '/new-sogou-spider|zollard|socialradarbot|microsoft office protocol discovery|powermarks|archivebot|marketwirebot|microsoft-cryptoapi|pad-bot|james bot|winhttp|jobboerse|<|>|online-versicherungsportal\.info|versicherungssuchmaschine\.net|microsearch|microsoft data access|microsoft url control|infegyatlas|msie or firefox mutant|semantic-visions\.com crawler|labs\.topsy\.com\/butterfly|dolphin http client|google wireless transcoder|commoncrawler|ipodder|tripadvisor|nokia wap gateway|outclicksbot/i',
                $useragent,
            )
        ) {
            return 'unknown=unknown';
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

        return 'unknown=unknown';
    }

    /**
     * @return array<int, (array<mixed>|string|null)>
     * @phpstan-return array{0:array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, dualOrientation: bool|null, simCount: int|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, type: string}, 1:string|null}
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $company, string $key): array
    {
        $loaderFactory = $this->loaderFactory;
        $loader        = $loaderFactory($company);

        return $loader->load($key);
    }
}
