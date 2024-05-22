<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use Psr\Log\LoggerInterface;

use function preg_match;

final class WindowsPhoneOs implements VersionFactoryInterface
{
    public const SEARCHES = ['Windows Phone OS', 'Windows Phone', 'Windows Mobile', 'Windows NT', 'WPOS\:'];

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly VersionBuilderInterface $versionBuilder,
    ) {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws void
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        if (preg_match('/xblwp7|zunewp7/i', $useragent)) {
            try {
                return $this->versionBuilder->set('7.5.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        if (preg_match('/wds (?P<version>[\d.]+)/i', $useragent, $matches)) {
            try {
                return $this->versionBuilder->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        if (preg_match('/wpdesktop/i', $useragent)) {
            if (preg_match('/windows nt 6\.3/i', $useragent)) {
                try {
                    return $this->versionBuilder->set('8.1.0');
                } catch (NotNumericException $e) {
                    $this->logger->info($e);
                }
            }

            if (preg_match('/windows nt 6\.2/i', $useragent)) {
                try {
                    return $this->versionBuilder->set('8.0.0');
                } catch (NotNumericException $e) {
                    $this->logger->info($e);
                }
            }

            return new NullVersion();
        }

        try {
            return $this->versionBuilder->detectVersion($useragent, self::SEARCHES);
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        return new NullVersion();
    }
}
