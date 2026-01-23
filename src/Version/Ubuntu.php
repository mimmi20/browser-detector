<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use Override;

use function array_key_exists;
use function preg_match;

final readonly class Ubuntu implements VersionFactoryInterface
{
    /** @throws void */
    public function __construct(private VersionBuilderInterface $versionBuilder)
    {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws NotNumericException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[Override]
    public function detectVersion(string $useragent): VersionInterface
    {
        if (
            preg_match('/Ubuntu[\/ ](?<version>\d{1,2}\.\d+)/i', $useragent, $matches)
            && array_key_exists('version', $matches)
        ) {
            return $this->versionBuilder->set($matches['version']);
        }

        return new NullVersion();
    }
}
