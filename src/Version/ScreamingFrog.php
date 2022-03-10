<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

use function preg_match;
use function str_replace;

final class ScreamingFrog implements VersionDetectorInterface
{
    private LoggerInterface $logger;

    private VersionFactoryInterface $versionFactory;

    public function __construct(LoggerInterface $logger, VersionFactoryInterface $versionFactory)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
    }

    /**
     * returns the version of the operating system/platform
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $doMatch = preg_match('/Screaming Frog SEO Spider\/\d+,\d/', $useragent);

        if ($doMatch) {
            $useragent = str_replace(',', '.', $useragent);
        }

        try {
            return $this->versionFactory->detectVersion($useragent, ['Screaming Frog SEO Spider']);
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        return new NullVersion();
    }
}
