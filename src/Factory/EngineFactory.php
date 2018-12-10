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

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\EngineLoaderFactory;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

final class EngineFactory
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function fromArray(LoggerInterface $logger, array $data): EngineInterface
    {
        $name = array_key_exists('name', $data) ? $data['name'] : null;

        $version = (new VersionFactory())->set('0');
        if (array_key_exists('version', $data)) {
            $version = (new VersionFactory())->set($data['version']);
        }

        $manufacturer = CompanyLoader::getInstance()->load('Unknown');
        if (array_key_exists('manufacturer', $data)) {
            try {
                $manufacturer = CompanyLoader::getInstance()->load($data['manufacturer']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        return new Engine($name, $manufacturer, $version);
    }
}
