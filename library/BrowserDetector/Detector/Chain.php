<?php
namespace BrowserDetector\Detector;

    /**
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
     * @copyright 2012-2013 Thomas Mueller
     * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
     * @version   SVN: $Id$
     */
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
                    return $handler->detect();
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
