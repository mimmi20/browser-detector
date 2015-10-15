<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector;

use BrowserDetector\Helper\Classname;
use DirectoryIterator;
use UaMatcher\MatcherInterface;

/**
 * a general chain used for detecting devices, browsers, platforms and engines
 *
 * @package   BrowserDetector
 */
class Chain
{
    /** @var array */
    private $handlersToUse = array();

    /** @var mixed */
    private $defaultHandler = null;

    /** @var string */
    private $directory = '';

    /** @var string */
    private $namespace = '';

    /** @var string */
    private $useragent = '';

    /**
     * sets the cache used to make the detection faster
     *
     * @param \UaMatcher\MatcherInterface $handler
     *
     * @return \BrowserDetector\Detector\Chain
     */
    public function setDefaultHandler(MatcherInterface $handler)
    {
        $this->defaultHandler = $handler;

        return $this;
    }

    /**
     * sets the cache used to make the detection faster
     *
     * @param \UaMatcher\MatcherInterface[] $handlersToUse
     *
     * @return \BrowserDetector\Detector\Chain
     */
    public function setHandlers(array $handlersToUse)
    {
        $this->handlersToUse = $handlersToUse;

        return $this;
    }

    /**
     * sets the actual directory where the chain is searching
     *
     * @param string $directory
     *
     * @return \BrowserDetector\Detector\Chain
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * sets the actual directory where the chain is searching
     *
     * @param string $namespace
     *
     * @return \BrowserDetector\Detector\Chain
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * sets the UserAgent
     *
     * @param string $agent
     *
     * @return \BrowserDetector\Detector\Chain
     */
    public function setUserAgent($agent)
    {
        $this->useragent = $agent;

        return $this;
    }

    /**
     * detect the user agent
     *
     * @return \UaMatcher\MatcherInterface
     */
    public function detect()
    {
        $chain = new \SplPriorityQueue();

        if (!empty($this->handlersToUse)) {
            foreach ($this->handlersToUse as $handler) {
                $chain->insert($handler, $handler->getWeight());
            }
        }

        if (!empty($this->directory)) {
            // get all Handlers from the directory
            $iterator = new DirectoryIterator($this->directory);
            $utils    = new Classname();

            foreach ($iterator as $fileinfo) {
                /** @var $fileinfo \SplFileInfo */
                if (!$fileinfo->isFile() || !$fileinfo->isReadable()) {
                    continue;
                }

                $filename = $fileinfo->getBasename('.php');

                $className = $utils->getClassNameFromFile(
                    $filename,
                    $this->namespace,
                    true
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
                $handler->setUserAgent($this->useragent);

                if ($handler->canHandle()) {
                    return $handler;
                }

                $chain->next();
            }
        }

        if (null !== $this->defaultHandler && is_object($this->defaultHandler)
        ) {
            $handler = $this->defaultHandler;
        } else {
            $utils     = new Classname();
            $className = $utils->getClassNameFromFile(
                'Unknown',
                $this->namespace,
                true
            );
            $handler   = new $className();
        }

        $handler->setUserAgent($this->useragent);

        return $handler;
    }
}
