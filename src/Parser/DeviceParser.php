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
namespace BrowserDetector\Parser;

use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Parser\Device\DarwinParser;
use BrowserDetector\Parser\Device\DesktopParser;
use BrowserDetector\Parser\Device\MobileParser;
use BrowserDetector\Parser\Device\TvParser;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;

final class DeviceParser implements DeviceParserInterface
{
    /**
     * @var \BrowserDetector\Parser\Device\DarwinParser
     */
    private $darwinFactory;

    /**
     * @var \BrowserDetector\Parser\Device\MobileParser
     */
    private $mobileFactory;

    /**
     * @var \BrowserDetector\Parser\Device\TvParser
     */
    private $tvFactory;

    /**
     * @var \BrowserDetector\Parser\Device\DesktopParser
     */
    private $desktopFactory;

    /**
     * @var DeviceLoaderFactory
     */
    private $loaderFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    /**
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \JsonClass\JsonInterface                        $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoader           $companyLoader
     * @param \BrowserDetector\Parser\PlatformParserInterface $platformParser
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoader $companyLoader,
        PlatformParserInterface $platformParser
    ) {
        $this->loaderFactory = new DeviceLoaderFactory($logger, $jsonParser, $companyLoader, $platformParser);

        $this->darwinFactory  = new DarwinParser($jsonParser, $this->loaderFactory);
        $this->mobileFactory  = new MobileParser($jsonParser, $this->loaderFactory);
        $this->tvFactory      = new TvParser($jsonParser, $this->loaderFactory);
        $this->desktopFactory = new DesktopParser($jsonParser, $this->loaderFactory);

        $this->logger     = $logger;
        $this->jsonParser = $jsonParser;
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
    public function __invoke(string $useragent): array
    {
        $s = new Stringy($useragent);

        $unknownDevices = [
            'new-sogou-spider',
            'zollard',
            'socialradarbot',
            'microsoft office protocol discovery',
            'powermarks',
            'archivebot',
            'marketwirebot',
            'microsoft-cryptoapi',
            'pad-bot',
            'james bot',
            'winhttp',
            'jobboerse',
            '<',
            '>',
            'online-versicherungsportal.info',
            'versicherungssuchmaschine.net',
            'microsearch',
            'microsoft data access',
            'microsoft url control',
            'infegyatlas',
            'msie or firefox mutant',
            'semantic-visions.com crawler',
            'labs.topsy.com/butterfly',
            'dolphin http client',
            'google wireless transcoder',
            'commoncrawler',
            'ipodder',
            'tripadvisor',
            'nokia wap gateway',
        ];

        if ($s->containsAny($unknownDevices, false)) {
            return $this->load('unknown', 'unknown', $useragent);
        }

        if (!preg_match('/freebsd|raspbian/i', $useragent)
            && preg_match('/darwin|cfnetwork/i', $useragent)
        ) {
            $factory = $this->darwinFactory;

            return $factory($useragent);
        }

        if ((new MobileDevice($s))->isMobile()) {
            $factory = $this->mobileFactory;

            return $factory($useragent);
        }

        if ((new Tv($s))->isTvDevice()) {
            $factory = $this->tvFactory;

            return $factory($useragent);
        }

        if ((new Desktop($s))->isDesktopDevice()) {
            $factory = $this->desktopFactory;

            return $factory($useragent);
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

        return $loader($key, $useragent);
    }
}
