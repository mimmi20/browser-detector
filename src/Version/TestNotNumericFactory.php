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

use Psr\Log\LoggerInterface;

final class TestNotNumericFactory implements TestErrorFactoryInterface
{
    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function __invoke(LoggerInterface $logger): TestNotNumericError
    {
        return new TestNotNumericError();
    }
}
