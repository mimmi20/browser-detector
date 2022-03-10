<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

use function preg_match;
use function version_compare;

final class MicrosoftInternetExplorer implements VersionDetectorInterface
{
    private const VERSIONS = [
        '8' => '11.0',
        '7' => '11.0',
        '6' => '10.0',
        '5' => '9.0',
        '4' => '8.0',
    ];

    private LoggerInterface $logger;

    private VersionFactoryInterface $versionFactory;

    private VersionDetectorInterface $trident;

    public function __construct(LoggerInterface $logger, VersionFactoryInterface $versionFactory, VersionDetectorInterface $trident)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
        $this->trident        = $trident;
    }

    /**
     * returns the version of the operating system/platform
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $version = $this->trident->detectVersion($useragent);

        if (null !== $version->getMajor()) {
            foreach (self::VERSIONS as $engineVersion => $ieVersion) {
                if (!version_compare($version->getMajor(), (string) $engineVersion, '>=')) {
                    continue;
                }

                try {
                    return $this->versionFactory->set($ieVersion);
                } catch (NotNumericException $e) {
                    $this->logger->info($e);
                }
            }
        }

        $doMatch = preg_match('/MSIE (?P<version>[\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            try {
                return $this->versionFactory->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
