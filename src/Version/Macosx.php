<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Version;

use peterkahl\OSXbuild\OSXbuild;
use Psr\Log\LoggerInterface;

/**
 * @author Thomas Müller <mimmi20@live.de>
 */
class Macosx implements VersionCacheFactoryInterface
{
    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return self
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $matches = [];

        $doMatch = preg_match('/\((build )?(\d+[A-Z]\d+(?:[a-z])?)\)/i', $useragent, $matches);

        if ($doMatch && isset($matches[2])) {
            $buildVersion = OSXbuild::getVersion($matches[2]);

            if (false !== $buildVersion) {
                return VersionFactory::set($buildVersion);
            }

            $this->logger->warning(
                'build version "' . $matches[2] . '" not found in "peterkahl/apple-os-x-build-version" from UA "' . $useragent . '"'
            );
        }

        $searches = ['Mac OS X Version', 'Mac OS X v', 'Mac OS X', 'OS X', 'os=mac '];

        return VersionFactory::detectVersion($useragent, $searches);
    }
}
