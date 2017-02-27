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
use Psr\Cache\CacheItemPoolInterface;

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
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * Gets the information about the platform by User Agent
     *
     * @param string $useragent
     *
     * @return array
     */
    public function detect($useragent)
    {
        $deviceCode   = 'macintosh';
        $appleFactory = new Mobile\AppleFactory($this->cache, $this->loader);

        if (false !== mb_strpos($useragent, 'CFNetwork/808')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/807')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/802')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/798')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/796')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/790')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/760')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/758')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/757')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/720')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/718')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/714')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.5')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.4')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.3')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.2')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.1')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/711.0')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/709')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/708')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/705')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/699')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/696')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/673')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/672.1')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/672.0')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/647')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/609.1')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/609')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/602')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/596')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/595')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/561')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/548.1')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/548.0')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/520')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/515')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/485.13')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/485.12')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/485.10')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/485.2')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/467.12')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/459')) {
            return $appleFactory->detect($useragent);
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/454')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/438')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/433')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/422')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/339')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/330')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/221')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/220')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/217')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/129')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/128')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/4.0')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/1.2')) {
            $deviceCode = 'macintosh';
        }

        if (false !== mb_strpos($useragent, 'CFNetwork/1.1')) {
            $deviceCode = 'macintosh';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
