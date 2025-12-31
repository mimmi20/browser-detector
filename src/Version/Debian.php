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

use function preg_match;

final readonly class Debian implements VersionFactoryInterface
{
    /** @api */
    public const array SEARCHES = ['kFreeBSD', 'Debian', 'Debian Linux', 'Debian\-'];

    /** @throws void */
    public function __construct(private VersionBuilderInterface $versionBuilder)
    {
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
        if (preg_match('/squeeze/i', $useragent)) {
            try {
                return $this->versionBuilder->set('6.0');
            } catch (NotNumericException) {
                // nothing to do
            }

            return new NullVersion();
        }

        try {
            return $this->versionBuilder->detectVersion($useragent, self::SEARCHES);
        } catch (NotNumericException) {
            // nothing to do
        }

        return new NullVersion();
    }
}
