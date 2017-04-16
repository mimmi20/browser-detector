<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory;
use BrowserDetector\Helper;
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DesktopFactory implements Factory\FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
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
    public function detect($useragent, Stringy $s = null)
    {
        if ((new Helper\Windows($useragent))->isWindows()) {
            return (new Desktop\WindowsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('raspbian', false)) {
            return $this->loader->load('raspberry pi', $useragent);
        }

        if ($s->containsAll(['debian', 'rpi'], false)) {
            return $this->loader->load('raspberry pi', $useragent);
        }

        if ((new Helper\Linux($useragent))->isLinux()) {
            return $this->loader->load('linux desktop', $useragent);
        }

        if ((new Helper\Macintosh($useragent))->isMacintosh()) {
            return (new Desktop\AppleFactory($this->loader))->detect($useragent, $s);
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
