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

namespace BrowserDetector\Loader;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use Psr\Log\LoggerInterface;
use stdClass;
use UnexpectedValueException;

use function assert;
use function is_array;
use function is_callable;
use function is_scalar;
use function is_string;

trait VersionFactoryTrait
{
    private VersionBuilderInterface $versionBuilder;

    /** @throws void */
    private function getVersion(
        stdClass | string | null $version,
        string $useragent,
        LoggerInterface $logger,
    ): VersionInterface {
        $versionClass = new NullVersion();

        if (is_string($version)) {
            try {
                return $this->versionBuilder->set($version);
            } catch (NotNumericException $e) {
                $this->logger->error($e);

                return $versionClass;
            }
        }

        if ($version === null) {
            return $versionClass;
        }

        $value = $version->value ?? null;

        if ($value !== null && is_scalar($value)) {
            try {
                return $this->versionBuilder->set((string) $value);
            } catch (NotNumericException $e) {
                $this->logger->error($e);

                return $versionClass;
            }
        }

        $factoryName = $version->factory ?? null;

        if (!is_string($factoryName)) {
            return $versionClass;
        }

        $factory = new $factoryName();
        assert(is_callable($factory));
        $versionDetector = $factory($logger);
        assert($versionDetector instanceof VersionFactoryInterface);

        try {
            if ($versionDetector instanceof VersionBuilderInterface) {
                $searches = $version->search ?? [];

                if (!is_array($searches)) {
                    $searches = [];
                }

                return $versionDetector->detectVersion($useragent, $searches);
            }

            return $versionDetector->detectVersion($useragent);
        } catch (UnexpectedValueException | NotNumericException $e) {
            $this->logger->error($e);
        }

        return $versionClass;
    }
}
