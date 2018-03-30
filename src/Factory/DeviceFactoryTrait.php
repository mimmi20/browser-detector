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

use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

trait DeviceFactoryTrait
{
    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s): array
    {
        return $this->detectInArray($this->devices, $useragent, $s);
    }

    /**
     * @param array            $devices
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    private function detectInArray(array $devices, string $useragent, Stringy $s): array
    {
        foreach ($devices as $search => $key) {
            if (!$s->contains($search, false)) {
                continue;
            }

            if (is_array($key)) {
                return $this->detectInArray($key, $useragent, $s);
            }

            return $this->loader->load($key, $useragent);
        }

        return $this->loader->load($this->genericDevice, $useragent);
    }
}
