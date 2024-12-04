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
use Override;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

use function preg_match;
use function version_compare;

final readonly class MicrosoftInternetExplorer implements VersionFactoryInterface
{
    private const array VERSIONS = [
        '8' => '11.0',
        '7' => '11.0',
        '6' => '10.0',
        '5' => '9.0',
        '4' => '8.0',
    ];

    /** @throws void */
    public function __construct(
        private LoggerInterface $logger,
        private VersionBuilderInterface $versionBuilder,
        private VersionFactoryInterface $trident,
    ) {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws void
     */
    #[Override]
    public function detectVersion(string $useragent): VersionInterface
    {
        try {
            $version = $this->trident->detectVersion($useragent);
        } catch (NotNumericException | UnexpectedValueException $e) {
            $this->logger->info($e);

            $version = null;
        }

        if ($version instanceof VersionInterface && $version->getMajor() !== null) {
            foreach (self::VERSIONS as $engineVersion => $ieVersion) {
                if (!version_compare($version->getMajor(), (string) $engineVersion, '>=')) {
                    continue;
                }

                try {
                    return $this->versionBuilder->set($ieVersion);
                } catch (NotNumericException $e) {
                    $this->logger->info($e);
                }
            }
        }

        $doMatch = preg_match('/MSIE (?P<version>[\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            try {
                return $this->versionBuilder->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
