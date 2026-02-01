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

use function array_unshift;
use function mb_strtolower;
use function preg_match;
use function str_contains;

final readonly class SmartisanOs implements VersionFactoryInterface
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
        $regexes = [
            '/SM70[15]/i' => 1.5,
            '/SM801/i' => 2.5,
            '/SM919/i' => 3,
            '/YQ60[1357]/i' => 2,
            '/[DO]E106[ \/;\)]/i' => 6,
            '/OC10[56][ \/;\)]/i' => 6,
            '/DT2002C[ \/;\)]/i' => 6,
            '/DT190[12]A[ \/;\)]/i' => 6,
            '/Smartisan U3 Pro/i' => 3,
        ];

        foreach ($regexes as $regex => $version) {
            if (preg_match($regex, $useragent)) {
                return $this->versionBuilder->set((string) $version);
            }
        }

        return new NullVersion();
    }
}
