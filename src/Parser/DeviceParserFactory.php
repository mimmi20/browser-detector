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
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Parser\Device\DarwinParser;
use BrowserDetector\Parser\Device\DesktopParser;
use BrowserDetector\Parser\Device\MobileParser;
use BrowserDetector\Parser\Device\TvParser;
use BrowserDetector\Parser\Helper\RulefileParser;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

final class DeviceParserFactory implements DeviceParserFactoryInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @var \BrowserDetector\Parser\PlatformParserInterface
     */
    private $platformParser;

    /**
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \JsonClass\JsonInterface                        $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoaderInterface  $companyLoader
     * @param \BrowserDetector\Parser\PlatformParserInterface $platformParser
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoaderInterface $companyLoader,
        PlatformParserInterface $platformParser
    ) {
        $this->logger         = $logger;
        $this->jsonParser     = $jsonParser;
        $this->companyLoader  = $companyLoader;
        $this->platformParser = $platformParser;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @return \BrowserDetector\Parser\DeviceParserInterface
     */
    public function __invoke(): DeviceParserInterface
    {
        $loaderFactory = new DeviceLoaderFactory($this->logger, $this->jsonParser, $this->companyLoader, $this->platformParser);
        $fileParser    = new RulefileParser($this->jsonParser, $this->logger);
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
