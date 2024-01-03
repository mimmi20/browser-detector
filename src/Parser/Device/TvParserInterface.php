<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Device;

use BrowserDetector\Parser\DeviceParserInterface;

interface TvParserInterface extends DeviceParserInterface
{
    /**
     * Gets the information about the device by User Agent
     *
     * @return non-empty-string
     *
     * @throws void
     */
    public function parse(string $useragent): string;
}
