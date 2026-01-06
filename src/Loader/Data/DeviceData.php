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

namespace BrowserDetector\Loader\Data;

use Override;
use UaLoader\Data\DeviceDataInterface;
use UaResult\Device\DeviceInterface;

final readonly class DeviceData implements DeviceDataInterface
{
    /** @throws void */
    public function __construct(private DeviceInterface $device, private string | null $os)
    {
    }

    /** @throws void */
    #[Override]
    public function getDevice(): DeviceInterface
    {
        return $this->device;
    }

    /** @throws void */
    #[Override]
    public function getOs(): string | null
    {
        return $this->os;
    }
}
