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

use Override;
use UnexpectedValueException;

final class TestUnexpectedError implements VersionFactoryInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @throws UnexpectedValueException
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function detectVersion(string $useragent): VersionInterface
    {
        throw new UnexpectedValueException('error');
    }
}
