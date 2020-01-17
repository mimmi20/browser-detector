<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser;

interface DeviceParserFactoryInterface
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @return \BrowserDetector\Parser\DeviceParserInterface
     */
    public function __invoke(): DeviceParserInterface;
}
