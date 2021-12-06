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

namespace BrowserDetector\Factory;

use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionDetectorInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use Psr\Log\LoggerInterface;
use stdClass;
use UnexpectedValueException;

use function assert;
use function is_array;
use function is_callable;
use function is_string;

trait VersionFactoryTrait
{
    private VersionFactoryInterface $versionFactory;

    /**
     * @param stdClass|string|null $version
     */
    private function getVersion($version, string $useragent, LoggerInterface $logger): VersionInterface
    {
        $versionClass = new NullVersion();

        if (is_string($version)) {
            try {
                return $this->versionFactory->set($version);
            } catch (NotNumericException $e) {
                $this->logger->error($e);

                return $versionClass;
            }
        }

        if (null === $version) {
            return $versionClass;
        }

        $value = $version->value ?? null;

        if (null !== $value) {
            try {
                return $this->versionFactory->set((string) $value);
            } catch (NotNumericException $e) {
                $this->logger->error($e);

                return $versionClass;
            }
        }

        $className   = $version->class ?? null;
        $factoryName = $version->factory ?? null;

        if (!is_string($className) && !is_string($factoryName)) {
            return $versionClass;
        }

        if (is_string($factoryName)) {
            $factory = new $factoryName();
            assert(is_callable($factory));
            $versionDetector = $factory($logger);
            assert($versionDetector instanceof VersionDetectorInterface);

            try {
                return $versionDetector->detectVersion($useragent);
            } catch (UnexpectedValueException $e) {
                $this->logger->error($e);
            }

            return $versionClass;
        }

        if ('VersionFactory' !== $className) {
            $versionDetector = new $className();
            assert($versionDetector instanceof VersionDetectorInterface);

            try {
                return $versionDetector->detectVersion($useragent);
            } catch (UnexpectedValueException $e) {
                $this->logger->error($e);
            }

            return $versionClass;
        }

        if (!is_array($version->search ?? null)) {
            return $versionClass;
        }

        try {
            return $this->versionFactory->detectVersion($useragent, $version->search);
        } catch (NotNumericException $e) {
            $this->logger->error($e);
        }

        return $versionClass;
    }
}
