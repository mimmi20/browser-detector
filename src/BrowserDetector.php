<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector;

use BrowserDetector\Detector\Factory\BrowserFactory;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\EngineFactory;
use BrowserDetector\Detector\Factory\PlatformFactory;
use BrowserDetector\Detector\Result;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use UnexpectedValueException;
use WurflCache\Adapter\AdapterInterface;

/**
 * Browser Detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserDetector
{
    const INTERFACE_INTERNAL     = 1;
    const INTERFACE_BROWSCAP_INI = 2;
    const INTERFACE_WURFL_FILE   = 3;
    const INTERFACE_WURFL_CLOUD  = 4;
    const INTERFACE_UAPARSER     = 5;
    const INTERFACE_UASPARSER    = 6;
    const INTERFACE_BROWSCAP_CROSSJOIN = 7;

    /**
     * a \WurflCache\Adapter\AdapterInterface object
     *
     * @var \WurflCache\Adapter\AdapterInterface
     */
    private $cache = null;

    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * @var string
     */
    private $cachePrefix = '';

    /**
     * the user agent sent from the browser
     *
     * @var string
     */
    private $agent = null;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return \BrowserDetector\BrowserDetector
     */
    public function setCache(AdapterInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * returns the actual Cache Adapter
     *
     * @return \WurflCache\Adapter\AdapterInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * sets the the cache prefix
     *
     * @param string $prefix the new prefix
     *
     * @throws UnexpectedValueException
     * @return \BrowserDetector\BrowserDetector
     */
    public function setCachePrefix($prefix)
    {
        if (!is_string($prefix)) {
            throw new UnexpectedValueException(
                'the cache prefix has to be a string'
            );
        }

        $this->cachePrefix = $prefix;

        return $this;
    }

    /**
     * returns the actual cache prefix
     *
     * @return string
     */
    public function getCachePrefix()
    {
        return $this->cachePrefix;
    }

    /**
     * sets the logger
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\BrowserDetector
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * returns the logger
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        if (null === $this->logger) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }

    /**
     * sets the user agent who should be detected
     *
     * @param string
     *
     * @return \BrowserDetector\BrowserDetector
     */
    public function setAgent($userAgent)
    {
        $this->agent = $userAgent;

        return $this;
    }

    /**
     * returns the stored user agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param boolean $forceDetect if TRUE a possible cache hit is ignored
     *
     * @throws UnexpectedValueException
     * @return \BrowserDetector\Detector\Result
     */
    public function getBrowser($forceDetect = false)
    {
        if (null === $this->agent) {
            throw new UnexpectedValueException(
                'You have to set the useragent before calling this function'
            );
        }

        $cacheId = $this->getCachePrefix() . $this->agent; //hash('sha512', $this->getCachePrefix() . $this->agent);
        $result  = null;
        $success = false;

        if (!$forceDetect && null !== $this->getCache()) {
            $result = $this->getCache()->getItem($cacheId, $success);
        }

        if ($forceDetect || null === $this->getCache() || !$success || !($result instanceof Detector\Result)) {
            $device = DeviceFactory::detect($this->agent);

            if (null !== $this->getLogger()) {
                $device->setLogger($this->getLogger());
            }

            // @todo: define an interface for this function, add a special function if the device has a version
            $device->detectSpecialProperties();

            // detect the os which runs on the device
            $platform = PlatformFactory::detect($this->agent);

            // detect the browser which is used
            $browser = BrowserFactory::detect($this->agent);

            // detect the engine which is used in the browser
            $engine = EngineFactory::detect($this->agent, $platform);

            // @todo: set engine related properties to the browser, define an interface for that
            // @todo: set browser related properties to the device, define an interface for that

            $result = new Result();

            if (null !== $this->getLogger()) {
                $result->setLogger($this->getLogger());
            }

            $result->setCapability('useragent', $this->agent);

            $result->setDetectionResult(
                $device,
                $platform,
                $browser,
                $engine
            );

            if (!$forceDetect && null !== $this->getCache()) {
                $this->getCache()->setItem($cacheId, $result);
            }
        }

        return $result;
    }
}

