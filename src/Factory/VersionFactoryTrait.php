<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use BrowserDetector\Version\VersionInterface;

trait VersionFactoryTrait
{
    /**
     * @var \BrowserDetector\Version\VersionFactoryInterface
     */
    private $versionFactory;

    /**
     * @param array  $data
     * @param string $useragent
     *
     * @throws \UnexpectedValueException
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    private function getVersion(array $data, string $useragent): VersionInterface
    {
        $version = $this->versionFactory->set('0');

        if (!array_key_exists('version', $data)) {
            return $version;
        }

        if (is_string($data['version'])) {
            return $this->versionFactory->set($data['version']);
        }

        if (!$data['version'] instanceof \stdClass) {
            return $version;
        }

        $value = $data['version']->value ?? null;

        if (null !== $value) {
            return $this->versionFactory->set((string) $value);
        }

        $className = $data['version']->class ?? null;

        if (!is_string($className)) {
            return $version;
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
