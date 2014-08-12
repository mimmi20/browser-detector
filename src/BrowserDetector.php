<?php
/**
 * Browser Detection class
 *
 * PHP version 5.3
 *
 * LICENSE:
 *
 * Copyright (c) 2013, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * * Neither the name of the authors nor the names of its contributors may be
 *   used to endorse or promote products derived from this software without
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 */

namespace BrowserDetector;

use BrowserDetector\Input\Browscap;
use BrowserDetector\Input\BrowscapDetector;
use BrowserDetector\Input\Uaparser;
use BrowserDetector\Input\Uasparser;
use BrowserDetector\Input\UserAgent;
use BrowserDetector\Input\Wurfl;
use phpbrowscap\Cache\CacheInterface;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;
use WurflCache\Adapter\AdapterInterface;

/**
 * Browser Detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class BrowserDetector
{
    const INTERFACE_INTERNAL     = 1;
    const INTERFACE_BROWSCAP_INI = 2;
    const INTERFACE_WURFL_FILE   = 3;
    const INTERFACE_WURFL_CLOUD  = 4;
    const INTERFACE_UAPARSER     = 5;
    const INTERFACE_UASPARSER    = 6;
    const INTERFACE_BROWSCAP_DETECTOR = 7;

    /**
     * a \WurflCache\Adapter\AdapterInterface object
     *
     * @var \WurflCache\Adapter\AdapterInterface
     */
    private $cache = null;

    /**
     * an logger instance
     *
     * @var LoggerInterface
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
     * the interface for the detection
     *
     * @var \BrowserDetector\Input\Core
     */
    private $interface = null;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return BrowserDetector
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
     * @throws \UnexpectedValueException
     * @return BrowserDetector
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
     * @return BrowserDetector
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
        return $this->logger;
    }

    /**
     * sets the user agent who should be detected
     *
     * @param string
     *
     * @return BrowserDetector
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
     * sets the the detection interface
     *
     * @param integer $interface the new Interface to use
     *
     * @throws \UnexpectedValueException
     * @return BrowserDetector
     */
    public function setInterface($interface)
    {
        $allowedInterfaces = array(
            self::INTERFACE_INTERNAL,
            self::INTERFACE_BROWSCAP_INI,
            self::INTERFACE_WURFL_FILE,
            self::INTERFACE_WURFL_CLOUD,
            self::INTERFACE_UAPARSER,
            self::INTERFACE_UASPARSER,
            self::INTERFACE_BROWSCAP_DETECTOR
        );

        if (!is_int($interface) || !in_array($interface, $allowedInterfaces)) {
            throw new UnexpectedValueException(
                'the interface is unknown'
            );
        }

        switch ($interface) {
        case self::INTERFACE_BROWSCAP_INI:
            $this->interface = new Browscap();
            break;
        case self::INTERFACE_INTERNAL:
            $this->interface = new UserAgent();
            break;
        case self::INTERFACE_WURFL_FILE:
            $this->interface = new Wurfl();
            break;
        case self::INTERFACE_UAPARSER:
            $this->interface = new Uaparser();
            break;
        case self::INTERFACE_UASPARSER:
            $this->interface = new Uasparser();
            break;
        case self::INTERFACE_BROWSCAP_DETECTOR:
            $this->interface = new BrowscapDetector();
            break;
        default:
            throw new UnexpectedValueException(
                'an unsupported interface was set'
            );
            break;
        }

        return $this;
    }

    /**
     * returns the actual interface, the actual cache and the user agent are
     * pushed to the interface
     *
     * @return \BrowserDetector\Input\Core
     */
    public function getInterface()
    {
        if (null === $this->interface) {
            // set the internal interface as default
            $this->setInterface(self::INTERFACE_INTERNAL);
        }

        if (null !== $this->getCache()) {
            $this->interface->setCache($this->getCache())
                ->setCachePrefix($this->getCachePrefix());
        }

        if (null !== $this->getLogger()) {
            $this->interface->setLogger($this->getLogger());
        }

        $this->interface->setAgent($this->agent);

        return $this->interface;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param boolean $forceDetect if TRUE a possible cache hit is ignored
     *
     * @throws Input\Exception
     * @throws \UnexpectedValueException
     * @return \BrowserDetector\Detector\Result
     */
    public function getBrowser($forceDetect = false)
    {
        if (null === $this->interface) {
            throw new UnexpectedValueException(
                'You have to define the Interface before calling this function'
            );
        }

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
            $result = $this->getInterface()->getBrowser();

            if (!($result instanceof Detector\Result)) {
                throw new Input\Exception(
                    'the getBrowser Function has to return an instance of \\BrowserDetector\\Detector\\Result',
                    Input\Exception::NO_RESULT_CLASS_RETURNED
                );
            }

            if (!$forceDetect && null !== $this->getCache()) {
                $this->getCache()->setItem($cacheId, $result);
            }
        }

        return $result;
    }
}
