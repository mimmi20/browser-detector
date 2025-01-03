<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
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
use Override;
use Psr\Log\LoggerInterface;
use UaParser\DeviceParserInterface;

final readonly class DeviceParserFactory implements DeviceParserFactoryInterface
{
    /** @throws void */
    public function __construct(private LoggerInterface $logger)
    {
        // nothing to do
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @throws void
     */
    #[Override]
    public function __invoke(): DeviceParserInterface
    {
        $fileParser    = new RulefileParser(logger: $this->logger);
        $darwinParser  = new DarwinParser(fileParser: $fileParser);
        $mobileParser  = new MobileParser(fileParser: $fileParser);
        $tvParser      = new TvParser(fileParser: $fileParser);
        $desktopParser = new DesktopParser(fileParser: $fileParser);

        return new DeviceParser(
            darwinParser: $darwinParser,
            mobileParser: $mobileParser,
            tvParser: $tvParser,
            desktopParser: $desktopParser,
            mobileDevice: new MobileDevice(),
            tvDevice: new Tv(),
            desktopDevice: new Desktop(),
        );
    }
}
