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
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DarwinFactory implements Factory\FactoryInterface
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
        $appleMobileFactory  = new Mobile\AppleFactory($this->loader);
        $appleDesktopFactory = new Desktop\AppleFactory($this->loader);

        if (false !== mb_strpos($useragent, 'CFNetwork/808')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/807')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/802')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/798')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/796')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/790')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/760')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/758')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/757')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/720')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/718')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/714')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.5')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.4')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.3')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.2')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.1')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.0')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/709')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/708')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/705')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/699')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/696')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/673')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/672.1')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/672.0')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/647')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/609.1')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/609')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/602')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/596')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/595')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/561')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/548.1')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/548.0')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/520')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/515')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/485.13')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/485.12')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/485.10')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/485.2')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/467.12')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/459')) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/454')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/438')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/433')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/422')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/339')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/330')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/221')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/220')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/217')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/129')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/128')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/4.0')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/1.2')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/1.1')) {
            return $appleDesktopFactory->detect($useragent, $s);
        }

        return $appleDesktopFactory->detect($useragent, $s);
    }
}
