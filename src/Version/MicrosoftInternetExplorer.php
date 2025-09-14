<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use Override;
use UnexpectedValueException;
use ValueError;

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
        } catch (NotNumericException | UnexpectedValueException) {
            $version = null;
        }

        if ($version instanceof VersionInterface && $version->getMajor() !== null) {
            foreach (self::VERSIONS as $engineVersion => $ieVersion) {
                try {
                    if (!version_compare($version->getMajor(), (string) $engineVersion, '>=')) {
                        continue;
                    }
                } catch (ValueError) {
                    // do nothing
                }

                try {
                    return $this->versionBuilder->set($ieVersion);
                } catch (NotNumericException) {
                    // nothing to do
                }
            }
        }

        $doMatch = preg_match('/MSIE (?P<version>[\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            try {
                return $this->versionBuilder->set($matches['version']);
            } catch (NotNumericException) {
                // nothing to do
            }
        }

        return new NullVersion();
    }
}
