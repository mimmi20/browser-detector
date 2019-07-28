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

final class AndroidOs implements VersionDetectorInterface
{
    public const SEARCHES = [
        'android android',
        'android androidhouse team',
        'android wildpuzzlerom v8 froyo',
        'juc ?\(linux;',
        'linux; googletv',
        'android ouya',
        'android os',
        'andr[0o]id[;_ ]',
        'andr[0o]id\/',
        'andr[0o]id',
        'adr ',
        '\(os: ',
    ];

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var VersionFactoryInterface
     */
    private $versionFactory;

    /**
     * ChromeOs constructor.
     *
     * @param \Psr\Log\LoggerInterface                         $logger
     * @param \BrowserDetector\Version\VersionFactoryInterface $versionFactory
     */
    public function __construct(LoggerInterface $logger, VersionFactoryInterface $versionFactory)
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
        if (false !== mb_stripos($useragent, 'android 2.1-update1')) {
            return $this->versionFactory->set('2.1.1');
        }

        if (false !== mb_stripos($useragent, 'android m;')) {
            return $this->versionFactory->set('6.0');
        }

        try {
            $detectedVersion = $this->versionFactory->detectVersion($useragent, self::SEARCHES);
        } catch (NotNumericException $e) {
            $this->logger->info($e);

            return new NullVersion();
        }

        if (null !== $detectedVersion->getVersion()) {
            return $detectedVersion;
        }

        if (0 < preg_match('/Linux; (?P<version>\d+[\d\.]+)/', $useragent, $matches)) {
            try {
                return $this->versionFactory->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        if (false !== mb_stripos($useragent, 'gingerbread')) {
            try {
                return $this->versionFactory->set('2.3.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        if (false !== mb_stripos($useragent, 'android eclair')) {
            try {
                return $this->versionFactory->set('2.1.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
