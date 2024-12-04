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

use BrowserDetector\Version\Exception\NotNumericException;
use Override;
use Psr\Log\LoggerInterface;

use function preg_match;
use function str_replace;

final readonly class ScreamingFrog implements VersionFactoryInterface
{
    /** @throws void */
    public function __construct(private LoggerInterface $logger, private VersionBuilderInterface $versionBuilder)
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
        $doMatch = preg_match('/Screaming Frog SEO Spider\/\d+,\d/', $useragent);

        if ($doMatch) {
            $useragent = str_replace(',', '.', $useragent);
        }

        try {
            return $this->versionBuilder->detectVersion($useragent, ['Screaming Frog SEO Spider']);
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        return new NullVersion();
    }
}
