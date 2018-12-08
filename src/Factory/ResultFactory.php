<?php

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use Psr\Log\LoggerInterface;
use UaResult\Result\Result;

class ResultFactory
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Result\Result
     */
    public function fromArray(LoggerInterface $logger, array $data): Result
    {
        $headers = [];
        if (array_key_exists('headers', $data)) {
            $headers = (array) $data['headers'];
        }

        $device = null;
        if (array_key_exists('device', $data)) {
            $device = (new DeviceFactory($logger))->fromArray((array) $data['device']);
        }

        $browser = null;
        if (array_key_exists('browser', $data)) {
            $browser = (new BrowserFactory($logger))->fromArray($logger, (array)$data['browser']);
        }

        $os = null;
        if (array_key_exists('os', $data)) {
            $os = (new PlatformFactory($logger))->fromArray($logger, (array)$data['os']);
        }

        $engine = null;
        if (array_key_exists('engine', $data)) {
            $engine = (new EngineFactory($logger))->fromArray($logger, (array)$data['engine']);
        }

        return new Result($headers, $device, $os, $browser, $engine);
    }
}
