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

use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv;
use BrowserDetector\Parser\Device\DarwinParser;
use BrowserDetector\Parser\Device\DesktopParser;
use BrowserDetector\Parser\Device\MobileParser;
use BrowserDetector\Parser\Device\TvParser;
use BrowserDetector\Parser\Helper\RulefileParser;
use Psr\Log\LoggerInterface;

final class DeviceParserFactory implements DeviceParserFactoryInterface
{
    /** @throws void */
    public function __construct(private readonly LoggerInterface $logger)
    {
        // nothing to do
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @throws void
     */
    public function __invoke(): DeviceParserInterface
    {
        $fileParser    = new RulefileParser($this->logger);
        $darwinParser  = new DarwinParser($fileParser);
        $mobileParser  = new MobileParser($fileParser);
        $tvParser      = new TvParser($fileParser);
        $desktopParser = new DesktopParser($fileParser);

        return new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            new MobileDevice(),
            new Tv(),
            new Desktop(),
        );
    }
}
