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

final class WindowsMobileOs implements VersionDetectorInterface
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
        if (false !== mb_stripos($useragent, 'windows nt 5.1') && 0 === preg_match('/windows mobile|windows phone/i', $useragent)) {
            try {
                return $this->versionFactory->set('6.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        try {
            return $this->versionFactory->detectVersion($useragent, ['Windows Mobile', 'Windows Phone']);
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        return new NullVersion();
    }
}
