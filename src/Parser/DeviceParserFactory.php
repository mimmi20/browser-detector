<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
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
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use Override;
use UaParser\DeviceParserInterface;

final readonly class DeviceParserFactory implements DeviceParserFactoryInterface
{
    /** @throws void */
    public function __construct(private RulefileParserInterface $rulefileParser)
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
        $darwinParser  = new DarwinParser(rulefileParser: $this->rulefileParser);
        $mobileParser  = new MobileParser(rulefileParser: $this->rulefileParser);
        $tvParser      = new TvParser(rulefileParser: $this->rulefileParser);
        $desktopParser = new DesktopParser(rulefileParser: $this->rulefileParser);

        return new DeviceParser(
            darwinParser: $darwinParser,
            mobileParser: $mobileParser,
            tvParser: $tvParser,
            desktopParser: $desktopParser,
            mobileDevice: new MobileDevice(),
            tv: new Tv(),
            desktop: new Desktop(),
        );
    }
}
