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
use Psr\Log\LoggerInterface;

use function is_string;
use function preg_match;

final class Friendica implements VersionFactoryInterface
{
    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly VersionBuilderInterface $versionBuilder,
    ) {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws void
     */
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
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
