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
namespace BrowserDetector\Factory\Device\Desktop;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class GenericDesktopFactory implements Factory\FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @var string
     */
    private $genericDevice = 'general desktop';

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
        if ($s->contains('raspbian', false)) {
            return $this->loader->load('raspberry pi', $useragent);
        }

        if ($s->containsAll(['debian', 'rpi'], false)) {
            return $this->loader->load('raspberry pi', $useragent);
        }

        if ($s->contains('eeepc', false)) {
            return $this->loader->load('eee pc', $useragent);
        }

        if ($s->contains('hp-ux 9000', false)) {
            return $this->loader->load('9000', $useragent);
        }

        return $this->loader->load('general desktop', $useragent);
    }
}
