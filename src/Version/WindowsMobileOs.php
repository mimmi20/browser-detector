<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

use function mb_stripos;
use function preg_match;

final class WindowsMobileOs implements VersionDetectorInterface
{
    public const SEARCHES = ['Windows Mobile', 'Windows Phone'];

    private LoggerInterface $logger;

    private VersionFactoryInterface $versionFactory;

    public function __construct(LoggerInterface $logger, VersionFactoryInterface $versionFactory)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
    }

    /**
     * returns the version of the operating system/platform
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        if (false !== mb_stripos($useragent, 'windows nt 5.1') && !preg_match('/windows mobile|windows phone/i', $useragent)) {
            try {
                return $this->versionFactory->set('6.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        try {
            return $this->versionFactory->detectVersion($useragent, self::SEARCHES);
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        return new NullVersion();
    }
}
