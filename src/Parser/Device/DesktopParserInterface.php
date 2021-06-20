<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Device;

use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\DeviceParserInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

interface DesktopParserInterface extends DeviceParserInterface
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @return array<int, (OsInterface|DeviceInterface|null)>
     * @phpstan-return array(0:DeviceInterface, 1:OsInterface|null)
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function parse(string $useragent): array;

    /**
     * @return array<int, (OsInterface|DeviceInterface|null)>
     * @phpstan-return array(0:DeviceInterface, 1:OsInterface|null)
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $company, string $key, string $useragent = ''): array;
}
