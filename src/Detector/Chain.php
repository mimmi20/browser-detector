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

namespace BrowserDetector\Detector;

use BrowserDetector\Helper\Classname;
use DirectoryIterator;

/**
 * a general chain used for detecting devices, browsers, platforms and engines
 *
 * @package   BrowserDetector
 */
class Chain
{
    /** @var array */
    private $_handlersToUse = array();

    /** @var mixed */
    private $_defaultHandler = null;

    /** @var string */
    private $_directory = '';

    /** @var string */
    private $_namespace = '';

    /** @var string */
    private $_userAgent = '';

    /**
     * sets the cache used to make the detection faster
     *
     * @param mixed $handler
     *
     * @return Chain
     */
    public function setDefaultHandler($handler)
    {
        $this->_defaultHandler = $handler;

        return $this;
    }

    /**
     * sets the cache used to make the detection faster
     *
     * @param array $handlersToUse
     *
     * @return Chain
     */
    public function setHandlers(array $handlersToUse)
    {
        $this->_handlersToUse = $handlersToUse;

        return $this;
    }

    /**
     * sets the actual directory where the chain is searching
     *
     * @param string $directory
     *
     * @return Chain
     */
    public function setDirectory($directory)
    {
        $this->_directory = $directory;

        return $this;
    }

    /**
     * sets the actual directory where the chain is searching
     *
     * @param string $namespace
     *
     * @return Chain
     */
    public function setNamespace($namespace)
    {
        $this->_namespace = $namespace;

        return $this;
    }

    /**
     * sets the UserAgent
     *
     * @param string $agent
     *
     * @return Chain
     */
    public function setUserAgent($agent)
    {
        $this->_userAgent = $agent;

        return $this;
    }

    /**
     * detect the user agent
     *
     * @return string
     */
    public function detect()
    {
        $chain = new \SplPriorityQueue();

        if (!empty($this->_handlersToUse)) {
            foreach ($this->_handlersToUse as $handler) {
                $chain->insert($handler, $handler->getWeight());
            }
        }

        if (!empty($this->_directory)) {
            // get all Handlers from the directory
            $iterator = new DirectoryIterator($this->_directory);
            $utils    = new Classname();

            foreach ($iterator as $fileinfo) {
                /** @var $fileinfo \SplFileInfo */
                if (!$fileinfo->isFile() || !$fileinfo->isReadable()) {
                    continue;
                }

                $filename = $fileinfo->getBasename('.php');

                $className = $utils->getClassNameFromFile(
                    $filename, $this->_namespace, true
                );

                try {
                    $handler = new $className();
                } catch (\Exception $e) {
                    continue;
                }

                $chain->insert($handler, $handler->getWeight());
            }
        }

        if ($chain->count()) {
            $chain->top();

            while ($chain->valid()) {
                $handler = $chain->current();
                $handler->setUserAgent($this->_userAgent);

                if ($handler->canHandle()) {
                    return $handler;
                }

                $chain->next();
            }
        }

        if (null !== $this->_defaultHandler
            && is_object($this->_defaultHandler)
        ) {
            $handler = $this->_defaultHandler;
        } else {
            $utils     = new Classname();
            $className = $utils->getClassNameFromFile(
                'Unknown', $this->_namespace, true
            );
            $handler   = new $className();
        }

        $handler->setUserAgent($this->_userAgent);

        return $handler;
    }
}

