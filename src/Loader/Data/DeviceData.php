<?php

declare(strict_types = 1);

namespace BrowserDetector\Loader\Data;

use UaLoader\Data\DeviceDataInterface;
use UaResult\Device\DeviceInterface;

class DeviceData implements DeviceDataInterface
{
    private DeviceInterface $device;
    private string|null $os;

    /**
     * @param DeviceInterface $device
     * @param string|null $os
     * @throws void
     */
    public function __construct(DeviceInterface $device, ?string $os)
    {
        $this->device = $device;
        $this->os = $os;
    }

    /**
     * @return DeviceInterface
     * @throws void
     */
    public function getDevice(): DeviceInterface
    {
        return $this->device;
    }

    /**
     * @return string|null
     * @throws void
     */
    public function getOs(): string|null
    {
        return $this->os;
    }

}