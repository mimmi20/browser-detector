<?php
/**
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Factory\Platform;

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
     * @return \UaResult\Os\OsInterface
     */
    public function detect($useragent)
    {
        if (false !== strpos($useragent, 'CFNetwork/808.2')) {
            return $this->loader->load('ios', $useragent, '10.2');
        }

        if (false !== strpos($useragent, 'CFNetwork/808.1')) {
            return $this->loader->load('ios', $useragent, '10.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/808')) {
            return $this->loader->load('ios', $useragent, '10.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/807')) {
            return $this->loader->load('mac os x', $useragent, '10.12');
        }

        if (false !== strpos($useragent, 'CFNetwork/802')) {
            return $this->loader->load('mac os x', $useragent, '10.12');
        }

        if (false !== strpos($useragent, 'CFNetwork/798')) {
            return $this->loader->load('mac os x', $useragent, '10.12');
        }

        if (false !== strpos($useragent, 'CFNetwork/796')) {
            return $this->loader->load('mac os x', $useragent, '10.12');
        }

        if (false !== strpos($useragent, 'CFNetwork/790')) {
            return $this->loader->load('ios', $useragent, '10.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/760')) {
            return $this->loader->load('mac os x', $useragent, '10.11');
        }

        if (false !== strpos($useragent, 'CFNetwork/758')) {
            return $this->loader->load('ios', $useragent, '9.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/757')) {
            return $this->loader->load('ios', $useragent, '9.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/720')) {
            return $this->loader->load('mac os x', $useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/718')) {
            return $this->loader->load('mac os x', $useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/714')) {
            return $this->loader->load('mac os x', $useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.5')) {
            return $this->loader->load('ios', $useragent, '8.4');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.4')) {
            return $this->loader->load('ios', $useragent, '8.4');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.3')) {
            return $this->loader->load('ios', $useragent, '8.3');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.2')) {
            return $this->loader->load('ios', $useragent, '8.2');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.1')) {
            return $this->loader->load('ios', $useragent, '8.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.0')) {
            return $this->loader->load('ios', $useragent, '8.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/709')) {
            return $this->loader->load('mac os x', $useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/708')) {
            return $this->loader->load('mac os x', $useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/705')) {
            return $this->loader->load('mac os x', $useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/699')) {
            return $this->loader->load('mac os x', $useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/696')) {
            return $this->loader->load('mac os x', $useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/673')) {
            return $this->loader->load('mac os x', $useragent, '10.9');
        }

        if (false !== strpos($useragent, 'CFNetwork/672.1')) {
            return $this->loader->load('ios', $useragent, '7.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/672.0')) {
            return $this->loader->load('ios', $useragent, '7.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/647')) {
            return $this->loader->load('mac os x', $useragent, '10.9');
        }

        if (false !== strpos($useragent, 'CFNetwork/609.1')) {
            return $this->loader->load('ios', $useragent, '6.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/609')) {
            return $this->loader->load('ios', $useragent, '6.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/602')) {
            return $this->loader->load('ios', $useragent, '6.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/596')) {
            return $this->loader->load('mac os x', $useragent, '10.8');
        }

        if (false !== strpos($useragent, 'CFNetwork/595')) {
            return $this->loader->load('mac os x', $useragent, '10.8');
        }

        if (false !== strpos($useragent, 'CFNetwork/561')) {
            return $this->loader->load('mac os x', $useragent, '10.8');
        }

        if (false !== strpos($useragent, 'CFNetwork/548.1')) {
            return $this->loader->load('ios', $useragent, '5.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/548.0')) {
            return $this->loader->load('ios', $useragent, '5.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/520')) {
            return $this->loader->load('mac os x', $useragent, '10.7');
        }

        if (false !== strpos($useragent, 'CFNetwork/515')) {
            return $this->loader->load('mac os x', $useragent, '10.7');
        }

        if (false !== strpos($useragent, 'CFNetwork/485.13')) {
            return $this->loader->load('ios', $useragent, '4.3');
        }

        if (false !== strpos($useragent, 'CFNetwork/485.12')) {
            return $this->loader->load('ios', $useragent, '4.2');
        }

        if (false !== strpos($useragent, 'CFNetwork/485.10')) {
            return $this->loader->load('ios', $useragent, '4.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/485.2')) {
            return $this->loader->load('ios', $useragent, '4.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/467.12')) {
            return $this->loader->load('ios', $useragent, '3.2');
        }

        if (false !== strpos($useragent, 'CFNetwork/459')) {
            return $this->loader->load('ios', $useragent, '3.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/454')) {
            return $this->loader->load('mac os x', $useragent, '10.6');
        }

        if (false !== strpos($useragent, 'CFNetwork/438')) {
            return $this->loader->load('mac os x', $useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/433')) {
            return $this->loader->load('mac os x', $useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/422')) {
            return $this->loader->load('mac os x', $useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/339')) {
            return $this->loader->load('mac os x', $useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/330')) {
            return $this->loader->load('mac os x', $useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/221')) {
            return $this->loader->load('mac os x', $useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/220')) {
            return $this->loader->load('mac os x', $useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/217')) {
            return $this->loader->load('mac os x', $useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/129')) {
            return $this->loader->load('mac os x', $useragent, '10.4');
        }

        if (false !== strpos($useragent, 'CFNetwork/128')) {
            return $this->loader->load('mac os x', $useragent, '10.4');
        }

        if (false !== strpos($useragent, 'CFNetwork/4.0')) {
            return $this->loader->load('mac os x', $useragent, '10.3');
        }

        if (false !== strpos($useragent, 'CFNetwork/1.2')) {
            return $this->loader->load('mac os x', $useragent, '10.3');
        }

        if (false !== strpos($useragent, 'CFNetwork/1.1')) {
            return $this->loader->load('mac os x', $useragent, '10.3');
        }

        return $this->loader->load('darwin', $useragent);
    }
}
