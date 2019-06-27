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

final class Maxthon implements VersionDetectorInterface
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
        if (false !== mb_strpos($useragent, 'MyIE2')) {
            try {
                return $this->versionFactory->set('2.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        if (false !== mb_strpos($useragent, 'MyIE')) {
            $versionFactory = new VersionFactory('/^v?(?<major>\d+)(?:[-|\.](?<minor>\d+))?(?:[-|\.](?<micro>\d+))?(?:[-|\.](?<patch>\d+))?(?:[-|\.](?<micropatch>\d+))?(?:[-_.+ ]?(?<stability>rc|alpha|a|beta|b|patch|pl?|stable|dev|d)[-_.+ ]?(?<build>\d*))?.*$/i');

            try {
                return $versionFactory->detectVersion($useragent, ['MyIE']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);

                return new NullVersion();
            }
        }

        try {
            return $this->versionFactory->detectVersion($useragent, ['MxBrowser\\-iPhone', 'Maxthon', 'MxBrowser', 'Version']);
        } catch (NotNumericException $e) {
            $this->logger->info($e);

            return new NullVersion();
        }
    }
}
