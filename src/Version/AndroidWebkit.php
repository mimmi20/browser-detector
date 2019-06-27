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
namespace BrowserDetector\Version;

use BrowserDetector\Version\Helper\Safari as SafariHelper;
use Psr\Log\LoggerInterface;

final class AndroidWebkit implements VersionDetectorInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var VersionFactory
     */
    private $versionFactory;

    /**
     * ChromeOs constructor.
     *
     * @param \Psr\Log\LoggerInterface                $logger
     * @param \BrowserDetector\Version\VersionFactory $versionFactory
     */
    public function __construct(LoggerInterface $logger, VersionFactory $versionFactory)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @throws \UnexpectedValueException
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $matches = [];

        $found = preg_match('/(?:Version|Safari)\/(?P<version>[\d\.]+)/', $useragent, $matches);

        if ((bool) $found) {
            try {
                $version = $this->versionFactory->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);

                return new NullVersion();
            }

            $safariHelper  = new SafariHelper();
            $mappedVersion = $safariHelper->mapSafariVersion($version);

            if (null === $mappedVersion) {
                return new NullVersion();
            }

            try {
                return $this->versionFactory->set($mappedVersion);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
