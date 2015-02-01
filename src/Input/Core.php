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

namespace BrowserDetector\Input;

use Psr\Log\LoggerInterface;
use WurflCache\Adapter\AdapterInterface;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
abstract class Core implements InputInterface
{
    /**
     * a \WurflCache\Adapter\AdapterInterface object
     *
     * @var \WurflCache\Adapter\AdapterInterface
     */
    protected $cache = null;

    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
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
     * @return \BrowserDetector\Input\Core
     */
    public function setCache(AdapterInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * sets the logger
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\Input\Core
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
     * @return \BrowserDetector\Input\Core
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
     * @return \BrowserDetector\Input\Core
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
     * @return mixed
     */
    abstract public function getBrowser();

    /**
     * returns the stored user agent
     *
     * @param string $userAgent
     *
     * @return \BrowserDetector\Input\Core
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
