<?php
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
 * @package   BrowserDetector
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace BrowserDetector\Helper;

use phpbrowscap\Cache\CacheInterface;
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
     *
     * @return
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
