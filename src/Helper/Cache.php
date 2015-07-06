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

namespace BrowserDetector\Helper;

use WurflCache\Adapter\AdapterInterface;

/**
 * a general helper to work with \Zend\Cache
 *
 * @package   BrowserDetector
 */
class Cache
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @param \WurflCache\Adapter\AdapterInterface $cache
     * @param string                            $userAgent the user agent string
     *
     * @param string                            $cachePrefix
     *
     * @return mixed
     */
    public function getBrowserFromCache(
        AdapterInterface $cache,
        $userAgent = null, $cachePrefix = null
    ) {
        $cacheId = $this->getCacheIdFromAgent($userAgent, $cachePrefix);
        $success = true;

        return $cache->getItem($cacheId, $success);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $userAgent the user agent string
     * @param string $cachePrefix
     *
     * @return string
     */
    public function getCacheIdFromAgent($userAgent = null, $cachePrefix = null)
    {
        return substr(
            $cachePrefix . 'agent_' . preg_replace(
                '/[^a-zA-Z0-9_]/', '_', $userAgent
            ),
            0,
            179
        );
    }
}

