<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser;

use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Parser\Device\DarwinParser;
use BrowserDetector\Parser\Device\DesktopParser;
use BrowserDetector\Parser\Device\MobileParser;
use BrowserDetector\Parser\Device\TvParser;
use BrowserDetector\Parser\Helper\RulefileParser;
use Psr\Log\LoggerInterface;

final class DeviceParserFactory implements DeviceParserFactoryInterface
{
    private LoggerInterface $logger;

    private CompanyLoaderInterface $companyLoader;

    private PlatformParserInterface $platformParser;

    public function __construct(
        LoggerInterface $logger,
        CompanyLoaderInterface $companyLoader,
        PlatformParserInterface $platformParser
    ) {
        $this->logger         = $logger;
        $this->companyLoader  = $companyLoader;
        $this->platformParser = $platformParser;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     */
    public function __invoke(): DeviceParserInterface
    {
        $loaderFactory = new DeviceLoaderFactory($this->logger, $this->companyLoader, $this->platformParser);
        $fileParser    = new RulefileParser($this->logger);
        $darwinParser  = new DarwinParser($fileParser, $loaderFactory);
        $mobileParser  = new MobileParser($fileParser, $loaderFactory);
        $tvParser      = new TvParser($fileParser, $loaderFactory);
        $desktopParser = new DesktopParser($fileParser, $loaderFactory);

        return new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $loaderFactory,
            new MobileDevice(),
            new Tv(),
            new Desktop()
        );
    }
}
