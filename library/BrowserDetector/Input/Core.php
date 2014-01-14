<?php
namespace BrowserDetector\Input;

    /**
     * BrowserDetector.ini parsing class with caching and update capabilities
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
     * @version   SVN: $Id$
     */
use BrowserDetector\BrowserDetector;
use phpbrowscap\Cache\CacheInterface;
use Psr\Log\LoggerInterface;
use WurflCache\Adapter\AdapterInterface;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
abstract class Core
{
    /**
     * a \WurflCache\Adapter\AdapterInterface object
     *
     * @var CacheInterface
     */
    protected $cache = null;

    /**
     * an logger instance
     *
     * @var LoggerInterface
     */
    protected $logger = null;

    /*
     * @var string
     */
    protected $cachePrefix = '';

    /**
     * the user agent sent from the browser
     *
     * @var string
     */
    protected $_agent = '';

    /**
     * sets the cache used to make the detection faster
     *
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return Core
     */
    public function setCache(AdapterInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * sets the logger
     *
     * @param LoggerInterface $logger
     *
     * @return BrowserDetector
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Adds a log record at an arbitrary level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  mixed  $level   The log level
     * @param  string $message The log message
     * @param  array  $context The log context
     *
     * @return BrowserDetector
     */
    protected function log($level, $message, array $context = array())
    {
        if (null !== $this->logger) {
            $this->logger->log($level, $message, $context);
        }

        return $this;
    }

    /**
     * sets the the cache prefix
     *
     * @param string $prefix the new prefix
     *
     * @throws \UnexpectedValueException
     * @return Core
     */
    public function setCachePrefix($prefix)
    {
        if (!is_string($prefix)) {
            throw new \UnexpectedValueException(
                'the cache prefix has to be a string'
            );
        }

        $this->cachePrefix = $prefix;

        return $this;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return
     */
    abstract public function getBrowser();

    /**
     * returns the stored user agent
     *
     * @return UserAgent
     */
    public function setAgent($userAgent)
    {
        $this->_agent = $userAgent;

        return $this;
    }

    /**
     * returns the stored user agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->_agent;
    }

    /**
     * returns the stored user agent
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getAgent();
    }
}