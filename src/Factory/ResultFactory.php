<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use Psr\Log\LoggerInterface;
use UaResult\Result\Result;

final class ResultFactory
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
            $device = (new DeviceFactory())->fromArray($logger, (array) $data['device']);
        }

        $browser = null;
        if (array_key_exists('browser', $data)) {
            $browser = (new BrowserFactory())->fromArray($logger, (array) $data['browser']);
        }

        $os = null;
        if (array_key_exists('os', $data)) {
            $os = (new PlatformFactory())->fromArray($logger, (array) $data['os']);
        }

        $engine = null;
        if (array_key_exists('engine', $data)) {
            $engine = (new EngineFactory())->fromArray($logger, (array) $data['engine']);
        }

        return new Result($headers, $device, $os, $browser, $engine);
    }
}
