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
use Psr\Log\LoggerInterface;

use function mb_strpos;

final readonly class Maxthon implements VersionFactoryInterface
{
    /** @api */
    public const array SEARCHES = ['MxBrowser\-iPhone', 'Maxthon', 'MxBrowser', 'Version'];

    /** @api */
    public const array SEARCH_OLD = ['MyIE'];

    /** @api */
    public const string REGEX = '/^v?(?<major>\d+)(?:[-|\.](?<minor>\d+))?(?:[-|\.](?<micro>\d+))?(?:[-|\.](?<patch>\d+))?(?:[-|\.](?<micropatch>\d+))?(?:[-_.+ ]?(?<stability>rc|alpha|a|beta|b|patch|pl?|stable|dev|d)[-_.+ ]?(?<build>\d*))?.*$/i';

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
        if (mb_strpos($useragent, 'MyIE2') !== false) {
            try {
                return $this->versionBuilder->set('2.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        if (mb_strpos($useragent, 'MyIE') !== false) {
            $this->versionBuilder->setRegex(self::REGEX);

            try {
                return $this->versionBuilder->detectVersion($useragent, self::SEARCH_OLD);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        try {
            return $this->versionBuilder->detectVersion($useragent, self::SEARCHES);
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        return new NullVersion();
    }
}
