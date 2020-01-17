<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionInterface;
use Psr\Log\LoggerInterface;

trait VersionFactoryTrait
{
    /**
     * @var \BrowserDetector\Version\VersionFactoryInterface
     */
    private $versionFactory;

    /**
     * @param array                    $data
     * @param string                   $useragent
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @throws \UnexpectedValueException
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    private function getVersion(array $data, string $useragent, LoggerInterface $logger): VersionInterface
    {
        assert(is_string($data['version']) || $data['version'] instanceof \stdClass || null === $data['version']);

        if (is_string($data['version'])) {
            return $this->versionFactory->set($data['version']);
        }

        $version = new NullVersion();

        if (null === $data['version']) {
            return $version;
        }

        $value = $data['version']->value ?? null;

        if (null !== $value) {
            return $this->versionFactory->set((string) $value);
        }

        $className   = $data['version']->class ?? null;
        $factoryName = $data['version']->factory ?? null;

        if (!is_string($className) && !is_string($factoryName)) {
            return $version;
        }

        if (is_string($factoryName)) {
            $factory = new $factoryName();

            /** @var \BrowserDetector\Version\VersionDetectorInterface $versionDetector */
            $versionDetector = $factory($logger);

            return $versionDetector->detectVersion($useragent);
        }

        if ('VersionFactory' !== $className) {
            /** @var \BrowserDetector\Version\VersionDetectorInterface $versionDetector */
            $versionDetector = new $className();

            return $versionDetector->detectVersion($useragent);
        }

        if (!is_array($data['version']->search ?? null)) {
            return $version;
        }

        return $this->versionFactory->detectVersion($useragent, $data['version']->search);
    }
}
