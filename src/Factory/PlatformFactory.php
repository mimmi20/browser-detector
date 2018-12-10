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

use BrowserDetector\Helper;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoaderFactory;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

final class PlatformFactory
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Os\OsInterface
     */
    public function fromArray(LoggerInterface $logger, array $data): OsInterface
    {
        $name          = array_key_exists('name', $data) ? $data['name'] : null;
        $marketingName = array_key_exists('marketingName', $data) ? $data['marketingName'] : null;
        $bits          = array_key_exists('bits', $data) ? $data['bits'] : null;

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

        return new Os($name, $marketingName, $manufacturer, $version, $bits);
    }
}
