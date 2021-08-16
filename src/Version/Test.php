<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

final class Test implements VersionDetectorInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        try {
            return new Version('1', '11', '111', '1111', '11111');
        } catch (NotNumericException $e) {
            $this->logger->info($e);

            return new NullVersion();
        }
    }
}
