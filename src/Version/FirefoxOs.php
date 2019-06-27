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

final class FirefoxOs implements VersionDetectorInterface
{
    private const SEARCHES = [
        '44.0' => '2.5',
        '37.0' => '2.2',
        '34.0' => '2.1',
        '32.0' => '2.0',
        '30.0' => '1.4',
        '28.0' => '1.3',
        '26.0' => '1.2',
        '18.1' => '1.1',
        '18.0' => '1.0',
    ];

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
        if (0 === preg_match('/rv:(?P<version>\d+\.\d+)/', $useragent, $matches)) {
            return new NullVersion();
        }

        foreach (self::SEARCHES as $engineVersion => $osVersion) {
            if (version_compare($matches['version'], $engineVersion, '>=')) {
                return $this->versionFactory->set($osVersion);
            }
        }

        return new NullVersion();
    }
}
