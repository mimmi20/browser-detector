<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionInterface;

trait VersionFactoryTrait
{
    /**
     * @param array  $data
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    private function getVersion(array $data, string $useragent): VersionInterface
    {
        $version = (new VersionFactory())->set('0');

        if (array_key_exists('version', $data)) {
            $versionFactory = new VersionFactory();

            if ($data['version'] instanceof \stdClass) {
                $className = $data['version']->class ?? null;
                $value     = $data['version']->value ?? null;

                if (null !== $className) {
                    if ('VersionFactory' !== $className) {
                        $versionFactory = new $className();
                    }

                    $version = $versionFactory->detectVersion($useragent, $data['version']->search ?? null);
                } elseif (null !== $value) {
                    $version = $versionFactory->set((string) $value);
                }
            } elseif (is_string($data['version'])) {
                $version = $versionFactory->set((string) $data['version']);
            }
        }

        return $version;
    }
}
