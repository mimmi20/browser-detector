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
namespace BrowserDetector\Parser\Device;

use BrowserDetector\Parser\DeviceParserInterface;

interface MobileParserInterface extends DeviceParserInterface
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $useragent
     *
     * @return array
     */
    public function parse(string $useragent): array;

    /**
     * @param string $company
     * @param string $key
     * @param string $useragent
     *
     * @return array
     */
    public function load(string $company, string $key, string $useragent = ''): array;
}
