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

final class Test implements VersionFactoryInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @throws NotNumericException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function detectVersion(string $useragent): VersionInterface
    {
        return new Version('1', '11', '111', '1111', '11111');
    }
}
