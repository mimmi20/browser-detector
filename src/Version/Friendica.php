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

use function is_string;
use function preg_match;

final readonly class Friendica implements VersionFactoryInterface
{
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
        $matches = [];
        $doMatch = preg_match(
            '/Friendica \'[^\']*\' (?P<version>\d+[\d\.\_\-\+abcdehlprstv]*).*/',
            $useragent,
            $matches,
        );

        if ($doMatch && is_string($matches['version'])) {
            try {
                return $this->versionBuilder->set($matches['version']);
            } catch (NotNumericException) {
                // nothing to do
            }
        }

        return new NullVersion();
    }
}
