<?php
namespace BrowserDetector\Input;

/**
 * Browscap.ini parsing class with caching and update capabilities
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

use BrowserDetector\Detector\Bits as BitsDetector;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Result;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\InputMapper;
use phpbrowscap\Detector;
use WurflCache\Adapter\AdapterInterface;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class BrowscapDetector extends AbstractBrowscapInput
{
    /**
     * the UAParser class
     *
     * @var \phpbrowscap\Detector
     */
    protected $parser = null;

    /**
     * sets the UA Parser detector
     *
     * @param \phpbrowscap\Detector $parser
     *
     * @internal param \phpbrowscap\Browscap $parser
     *
     * @return BrowscapDetector
     */
    public function setParser(Detector $parser)
    {
        $this->parser = $parser;

        return $this;
    }

    /**
     * sets the main parameters to the parser
     *
     * @throws \UnexpectedValueException
     * @return \phpbrowscap\Detector
     */
    protected function initParser()
    {
        if (!($this->parser instanceof Detector)) {
            throw new \UnexpectedValueException(
                'the parser object has to be an instance of \\phpbrowscap\\Detector'
            );
        }

        if (null !== $this->cache) {
            $cache = $this->parser->getCache();

            if (!($cache instanceof AdapterInterface)) {
                $this->parser->setCache($this->cache);
            }

            $this->parser->setCachePrefix($this->cachePrefix);
        }

        if (null !== $this->localFile) {
            $this->parser->setLocaleFile($this->localFile);
        }

        if (null !== $this->logger) {
            $this->setLogger($this->logger);
        }

        return $this->parser;
    }
}