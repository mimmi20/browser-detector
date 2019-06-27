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

use Psr\Log\LoggerInterface;

final class Goanna implements VersionDetectorInterface
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
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        // lastest version: version on "Goanna" token
        $doMatch = preg_match('/Goanna\/(?P<version>\d{1,3}\.[\d\.]*)/', $useragent, $matchesFirst);

        if (0 < $doMatch) {
            try {
                return $this->versionFactory->set($matchesFirst['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        // second version: version on "rv:" token
        $doMatch = preg_match('/rv\:(?P<version>\d\.[\d\.]*)/', $useragent, $matchesSecond);

        if (0 < $doMatch && false !== mb_stripos($useragent, 'goanna')) {
            try {
                return $this->versionFactory->set($matchesSecond['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        try {
            // first version: uses gecko version
            return $this->versionFactory->set('1.0');
        } catch (NotNumericException $e) {
            return new NullVersion();
        }
    }
}
