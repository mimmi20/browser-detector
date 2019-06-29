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

use BrowserDetector\Version\Helper\SafariInterface;
use Psr\Log\LoggerInterface;

final class Safari implements VersionDetectorInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Version\VersionFactoryInterface
     */
    private $versionFactory;

    /**
     * @var \BrowserDetector\Version\Helper\SafariInterface
     */
    private $safariHelper;

    /**
     * ChromeOs constructor.
     *
     * @param \Psr\Log\LoggerInterface                         $logger
     * @param \BrowserDetector\Version\VersionFactoryInterface $versionFactory
     * @param \BrowserDetector\Version\Helper\SafariInterface  $safariHelper
     */
    public function __construct(LoggerInterface $logger, VersionFactoryInterface $versionFactory, SafariInterface $safariHelper)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
        $this->safariHelper   = $safariHelper;
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

        $doMatch = preg_match('/(?:Version|Safari)\/(?P<version>[\d\.]+)/', $useragent, $matches);

        if (0 < $doMatch) {
            try {
                $version = $this->versionFactory->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);

                return new NullVersion();
            }

            $mappedVersion = $this->safariHelper->mapSafariVersion($version);

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
